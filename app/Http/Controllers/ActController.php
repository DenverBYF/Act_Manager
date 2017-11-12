<?php

namespace App\Http\Controllers;

use App\Act;
use App\Jobs\sendActMail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class ActController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		$act = Act::paginate(12);
		return view('admin.act.index',['act' => $act]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
		$group = Role::all();
		return view('admin.act.create',['group' => $group]);
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
		$act = Act::create([			//创建活动
			'name' => $request->name,
			'desc' => $request->desc,
			'time' => $request->time,
			'bz' => $request->bz,
			'address' => $request->address,
			'content' => NULL
		]);
		if($act){
			foreach ($request->groups as $eachGroup){		//循环分组
				$roleName = Role::find($eachGroup);
				$users = User::Role($roleName)->get();		//获取分组内人员
				$data = [];
				foreach ($users as $user){
					$data[] = ['act_id' => $act->id, "user_id" => $user->id];		//生成对应数据
				}
				DB::table('act_user')->insert($data);		//填充
			}
			sendActMail::dispatch($act);		//添加至邮件发送队列,异步执行
			return response("ok",200);
		}else{
			return response("error",400);
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
		$act = Act::findOrFail($id);
		return view('admin.act.edit',['act' => $act]);
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
		$act = Act::findOrFail($id);
		$act->content = $request->input('content');
		$act->save();
		return view('admin.act.edit',['act' => $act]);
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
		if(Act::destroy($id) == 1){
			return response($id,200);
		}
    }

    public function sign(Request $request)
	{
		$actId = $request->act;
		foreach ($request->user_id as $eachUser){
			DB::table('act_user')->where('act_id',$actId)->where('user_id',$eachUser)->update(['join'=>1]);
		}
		return response("ok",200);
	}
}
