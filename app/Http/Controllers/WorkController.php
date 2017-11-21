<?php

namespace App\Http\Controllers;

use App\Jobs\sendWorkMail;
use App\work;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Whoops\Exception\ErrorException;

class WorkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		$user = Auth::user();
		$publicWork = work::where('hidden', 0)->where('status', 0)->get();
		$finishWork = work::where('hidden', 0)->where('status', 1)->get();
		return view('admin.work.index',['publicWork' => $publicWork, 'user' => $user, 'finishWork' => $finishWork]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
		$role = Role::all();
		return view('admin.work.create',['group' => $role]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
		$userId = Auth::id();
		if($request->hasFile('uploadfile')){
			if($request->file('uploadfile')->isValid()){
				$file = $request->file('uploadfile');
				$extensionName = $file->extension();	//获取后缀名
				$mimeType = $file->getMimeType();		//获取mimetype
				$mimeTypeArray = [
					'application/pdf',
					'application/zip',
					'application/vnd.ms-excel',
					'application/vnd.ms-office',
					'application/x-xls',
					'application/octet-stream',
					'application/msword',
					'application/vnd.openxmlformats-officedocument.presentationml.presentation',
					'application/vnd.ms-powerpoint',
					'image/png',
					'image/jpeg',
				];									//白名单
				$extensionArray = [
					'jpg','png','jpeg','pdf','doc','bin','xls','xlsx','docx','zip','rar','ppt','pptx'
				];
				if(in_array($mimeType, $mimeTypeArray) and in_array($extensionName, $extensionArray)){
					$fileName = base64_encode(time()).".".$extensionName;
					$file->storeAs('work', $fileName);		//储存文件
					$work = work::create([					//创建工作
						'name' => $request->name,
						'user_id' => $userId,
						'content' => $request->desc,
						'file_url' => $fileName,
						'hidden' => $request->hidden,
						'tip' => $request->tip,
						'start_time' => $request->start_time,
						'end_time' => $request->end_time,
					]);
					if($work){
						if (empty($request->groups)){
							$data = ['work_id' => $work->id, 'user_id' => $userId];
							DB::table('work_user')->insert($data);
						}else{
							$this->addUser($request->groups, $work->id);
						}
						sendWorkMail::dispatch($work);
						return response("ok", 200);
					}else{
						unlink(storage_path('/app/work/'.$fileName));
						return response("error", 500);
					}
				}else{
					return response("type error", 400);
				}
			}else{
				return response("file is not valid ", 400);
			}
		}else{
			$work = work::create([					//创建工作
				'name' => $request->name,
				'user_id' => $userId,
				'content' => $request->desc,
				'hidden' => $request->hidden,
				'tip' => $request->tip,
				'start_time' => $request->start_time,
				'end_time' => $request->end_time,
			]);
			if($work){
				if (empty($request->groups)){
					$data = ['work_id' => $work->id, 'user_id' => $userId];
					DB::table('work_user')->insert($data);
				}else{
					$this->addUser($request->groups, $work->id);
				}
				sendWorkMail::dispatch($work);
				return response("ok", 200);
			}else{
				return response("error", 500);
			}
		}
		//var_dump($request->tip);
    }


    public function addUser($groups,$workId)
	{
		foreach ($groups as $eachGroup) {
			$roleName = Role::find($eachGroup);
			$users = User::Role($roleName)->get();        //获取分组内人员
			$data = [];
			foreach ($users as $user) {
				$data[] = ['work_id' => $workId, "user_id" => $user->id];        //生成对应数据
			}
			DB::table('work_user')->insert($data);        //填充
		}
	}


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

	public function finish(Request $request)
	{
		$workId = $request->id;
		$work = work::findOrFail($workId);
		if($work->user_id != Auth::id()){			//检查是否为发布者
			return response("not manager", 403);
		}
		$work->status = 1;
		$work->save();			//设为完成
		DB::table('work_user')->where('work_id', $workId)->update(['status' => 1]);		//修改工作-用户表
		return response("ok", 200);
	}
}
