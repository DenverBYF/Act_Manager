<?php

namespace App\Http\Controllers;

use App\Jobs\sendWorkMail;
use App\work;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

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
		/*$user = Auth::user();
		$publicWorks = work::where('status','0')->where('hidden',1)->get();
		$privateWorks = $user->worksNotFinish();
		return view('admin.work.index',['publicWorks' => $publicWorks,'privateWorks' => $privateWorks]);*/
		$work = work::find(16);
		$user = User::find(1);
		var_dump($user->workManager);
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
					'image/png',
					'image/jpeg',
				];									//白名单
				$extensionArray = [
					'jpg','png','jpeg','pdf','doc','xls','xlsx','docx','zip','rar'
				];
				if(in_array($mimeType, $mimeTypeArray) and in_array($extensionName, $extensionArray)){
					$fileName = base64_encode(time()).".".$extensionName;
					$file->storeAs('work',$fileName);		//储存文件
					$work = work::create([					//创建工作
						'name' => $request->name,
						'user_id' => $userId,
						'content' => $request->desc,
						'file_url' => $fileName,
						'hidden' => $request->hidden,
						'start_time' => $request->start_time,
						'end_time' => $request->end_time,
					]);
					if($work){
						$this->addUser($request->groups, $work->id);
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
				'start_time' => $request->start_time,
				'end_time' => $request->end_time,
			]);
			if($work){
				$this->addUser($request->groups, $work->id);	//添加工作人员
				sendWorkMail::dispatch($work);
				return response("ok",200);
			}else{
				return response("error", 500);
			}
		}
    }


    public function addUser($groups,$workId)
	{
		foreach ($groups as $eachGroup){
			$roleName = Role::find($eachGroup);
			$users = User::Role($roleName)->get();		//获取分组内人员
			$data = [];
			foreach ($users as $user){
				$data[] = ['work_id' => $workId, "user_id" => $user->id];		//生成对应数据
			}
			DB::table('work_user')->insert($data);		//填充
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
}
