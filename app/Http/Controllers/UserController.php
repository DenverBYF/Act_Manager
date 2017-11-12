<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		$user = User::paginate(12);
		return view('admin.user.index',['user' => $user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
		if($request->hasFile('file') and $request->file('file')->isValid()){
			$file = $request->file;
			$extensionName = $file->getMimeType();
			$extensionArray = ['application/vnd.ms-excel','application/vnd.ms-office','application/x-xls','application/octet-stream'];
			//判断文件类型
			if(in_array($extensionName,$extensionArray)){
				$name = base64_encode(time()).".xls";
				$file = $file->storeAS('',$name);	//储存文件
				if($file){
					$filPath = storage_path('app/'.$file);
					Excel::load($filPath,function ($reader){	//处理文件,添加成员数据
						$reader->each(function($sheet) {
							$sheet->each(function($row) {
								$user = \App\User::create([
									'name'=>$row->name, 'sex'=>$row->sex, 'email'=>$row->email, 'tel'=>$row->tel,
									'password'=>bcrypt($row->stuid), 'stuId'=>$row->stuid
								]);
								if(!$user){
									die("创建{$row->name}失败");
								}
							});
						});
					},'UTF-8');
					unlink($filPath);		//删除文件
					return response("ok",200);
				}
			}else{
				return response("only xls",400);
			}
		}else{
			return response("no file",400);
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
		if(User::destroy($id) == 1){
			return response("ok",200);
		}else{
			return response("fail",400);
		}
    }
}
