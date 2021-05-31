<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminMenu;

class AdminMenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $AdminMenu =
            [
                  [
                    "url"        => "system",
                    "sort"       => 2,
                    "icon"       => "icon-wenjian-zeng",
                    "keep_alive" => 1,
                    "pid"        => 0,
                    "name"       => "系統管理"
                  ],
                  [
                    "url"        => "system/role",
                    "sort"       => 2,
                    "icon"       => "icon-zhuxingtu",
                    "keep_alive" => 1,
                    "pid"        => 1,
                    "name"       => "角色管理"
                  ],
                  [
                    "url"        => "system/account",
                    "sort"       => 3,
                    "icon"       => "icon-zhuzhuangtu",
                    "keep_alive" => 1,
                    "pid"        => 1,
                    "name"       => "賬號管理"
                  ],
                  [
                    "url"        => "system/dict",
                    "sort"       => 4,
                    "icon"       => "icon-BUG",
                    "keep_alive" => 0,
                    "pid"        => 1,
                    "name"       => "字典管理"
                  ],
                  [
                    "url"        => "system/access",
                    "sort"       => 6,
                    "icon"       => "icon-yun",
                    "keep_alive" => 1,
                    "pid"        => 1,
                    "name"       => "後台模塊管理"
                  ],
                ];
        foreach ($AdminMenu as $value) {
            AdminMenu::create($value);
        }
    }
}
