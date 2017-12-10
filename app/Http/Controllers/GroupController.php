<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		$group = Role::all();
		return view('admin.group.index',['groups' => $group]);
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
		$name = $request->name;
		$createUser = $request->create_user;
		$createAct = $request->create_act;
		$role = Role::create(['name' => $name]);
		DB::table('role_manager')->insert(['user_id' => Auth::id(), 'role_id' => $role->id]);
		if(!empty($createUser)){
			$createUserPermission = Permission::findByName('create_user');
			$role->givePermissionTo($createUserPermission);
		}
		if(!empty($createAct)){
			$createActPermission = Permission::findByName('create_act');
			$role->givePermissionTo($createActPermission);
		}
		return response("ok",200);
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
		$managerId = DB::table('role_manager')->where('role_id', $id)->value('user_id');
		$userId = Auth::id();
		if( $userId != $managerId){
			return response("not manager", 403);
		}
		$group = Role::findByName($id);
		$users = User::role($id)->paginate(12);
		$members = User::all();
		return view('admin.group.edit', ['group' => $group, 'user' => $users, 'member' => $members]);
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
		if($request->hasFile('file')){
			$file = $request->file;
			$extensionName = $file->getMimeType();
			$extensionArray = ['application/vnd.ms-excel','application/vnd.ms-office','application/x-xls','application/octet-stream'];
			//判断文件类型
			if(in_array($extensionName, $extensionArray)){
				$name = base64_encode(time()).".xls";
				$file = $file->storeAS('', $name);	//储存文件
				if($file){
					$filPath = storage_path('app/'.$file);
					Excel::load($filPath,function ($reader) use ($id){	//处理文件,添加成员数据
						$reader->each(function($sheet) use ($id) {
							$sheet->each(function($row) use ($id) {
								if(empty($row->name) and empty($row->stuid)){
									return;
								}
								$user = User::where('stuId','=',$row->stuid)->first();	//判断该成员是否存在
								if(empty($user)){			//若不存在,新建一个成员
									$user = \App\User::create([
										'name'=>$row->name, 'sex'=>$row->sex, 'email'=>$row->email, 'tel'=>$row->tel,
										'password'=>bcrypt($row->stuid), 'stuId'=>$row->stuid
									]);
								}
								$role = Role::find($id);
								try {
									$user->assignRole($role);        //加入该分组
								} catch (QueryException $e) {

								}
							});
						});
					},'UTF-8');
					unlink($filPath);		//删除文件
					return response("ok", 200);
				}
			}else{
				return response("only xls", 400);
			}
		}else{
			$role = Role::find($id);
			foreach ($request->user_id as $userId){
				$user = User::findOrFail($userId);
				try {
					$user->assignRole($role);
				} catch (QueryException $e) {		//成员已在分组内,跳过

				}
			}
			return response("ok", 200);
		}
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
		$userId = DB::table('role_manager')->where('role_id',$id)->value('user_id');	//创建者id
		if(Auth::id() == $userId ){														//判断权限
			if(Role::destroy($id) == 1){
				DB::table('role_manager')->where('role_id',$id)->delete();		//删除关联数据
				return response("ok", 200);
			}else{
				return response("error", 400);
			}
		}else{
			return response("not manager", 403);
		}

    }
}
