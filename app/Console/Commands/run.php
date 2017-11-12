<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;
use Spatie\Permission\Exceptions\RoleAlreadyExists;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class run extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dzb:run {name} {password} {email} {stuId} {tel} {sex}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
		$name = $this->argument('name');
		$password = $this->argument('password');
		$email = $this->argument('email');
		$stuId = $this->argument('stuId');
		$tel = $this->argument('tel');
		$sex = ($this->argument('sex') == 1)?"男":"女";
		$user = User::create([
			'name' => $name,
			'password' => bcrypt($password),
			'email' => $email,
			'tel' => $tel,
			'stuId' => $stuId,
			'sex' => $sex
		]);
		if($user){
			try {
				$role = Role::create(['name' => 'admin']);
			} catch (RoleAlreadyExists $e) {
				$role = Role::findByName('admin');
				$user->assignRole($role);
				$this->info("管理员创建成功");
				die();
			}
			$createActPermission = Permission::create(['name' => 'create_act']);
			$createUserPermission = Permission::create(['name' => 'create_user']);
			$role->givePermissionTo([$createActPermission,$createUserPermission]);
			$user->assignRole($role);
			$this->info("管理员创建成功");
		}else{
			$this->error("创建失败");
		}
    }
}
