<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * 創建「用戶」並賦予 admin 「角色」和 AdminMenusSeeder 「權限」
     *
     * @return void
     */
    public function run()
    {
        $this->permissions($this->roles($this->users()));
    }

    public function permissions(role $role)
    {
        // 詳情請看 AdminMenusSeeder::class
        foreach (Permission::all() as $permission) {
            $role->givePermissionTo($permission);
        }
    }

    public function users()
    {
        $createData = [
            'user'=>[
                'name'     => 'Derrick',
                'email'    => 'as55518010@yahoo.com.tw',
                'password' => bcrypt('as555180', ['rounds' => 12]),
            ],
            'user_detail'=>[
                'avatar_path'=>'/temporary/0Fu0o814Gfk07i4qXx4cBZfGidmjQRHK9L2u51kL.jpg',
                'description'=>'我是一個小廢物'
            ]
        ];
        return tap(User::create($createData['user']),function($userModel) use($createData){
            $userModel->detail()->create($createData['user_detail']);
        });
    }

    public function roles(User $user)
    {
        $roles = [
            'name'                  => 'admin',
        ];
        return tap(Role::create($roles), fn ($roleBuild) => $user->assignRole($roleBuild));
    }
}
