<?php

namespace Database\Seeders;

use App\Models\{AdminMenu, Permission};
use Illuminate\Support\Arr;
use Illuminate\Database\Seeder;

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
                    "pid"             => 0,
                    "name"            => "Welcome",
                    "path"            => '/dashboard',
                    "component"       => "/dashboard/analysis/index",
                    // "ignore_keep_alive" => 'icon-menu',
                    "order"           => 1,
                    'meta' => [
                        "title"           => 'Welcome',
                        "icon"            => 'bx:bx-home',
                    ],
                    'permission'      => [
                        [
                            "name"       => "儀錶盤-新增",
                            'permission_name' => 'dashboard-create',
                        ],
                        [
                            "name"       => "儀錶盤-讀取",
                            'permission_name' => 'dashboard-retrieve',
                        ],
                        [
                            "name"       => "儀錶盤-刪除",
                            'permission_name' => 'dashboard-delete',
                        ],
                        [
                            "name"       => "儀錶盤-修改",
                            'permission_name' => 'dashboard-update',
                        ]
                    ]
                ],
                [
                    "pid"             => 0,
                    "name"            => "系統管理",
                    "path"            => '/system',
                    "component"       => "LAYOUT",
                    "redirect"       => "/system/account",
                    // "ignore_keep_alive" => 'icon-menu',
                    "order"           => 2,
                    'meta' => [
                        "title"           => '系統管理',
                        "icon"            => 'ion:settings-outline',
                    ]
                ],
                [
                    "pid"             => 2,
                    "name"            => "帳號管理",
                    "path"            => 'account',
                    "component"       => "/system/account/index",
                    "order"           => 1,
                    'meta' => [
                        "title"           => '帳號管理',
                        "ignore_keep_alive" => true,
                    ],
                    'permission'      => [
                        [
                            "name"       => "帳號管理-新增",
                            'permission_name' => 'account-create',
                        ],
                        [
                            "name"       => "帳號管理-讀取",
                            'permission_name' => 'account-retrieve',
                        ],
                        [
                            "name"       => "帳號管理-刪除",
                            'permission_name' => 'account-delete',
                        ],
                        [
                            "name"       => "帳號管理-修改",
                            'permission_name' => 'account-update',
                        ]
                    ]
                ],
                [
                    "pid"             => 2,
                    "name"            => "角色管理",
                    "path"            => 'role',
                    "component"       => "/system/role/index",
                    "order"           => 2,
                    'meta' => [
                        "title"           => '角色管理',
                        "ignore_keep_alive" => true,
                    ],
                    'permission'      => [
                        [
                            "name"       => "角色管理-新增",
                            'permission_name' => 'role-create',
                        ],
                        [
                            "name"       => "角色管理-讀取",
                            'permission_name' => 'role-retrieve',
                        ],
                        [
                            "name"       => "角色管理-刪除",
                            'permission_name' => 'role-delete',
                        ],
                        [
                            "name"       => "角色管理-修改",
                            'permission_name' => 'role-update',
                        ]
                    ]
                ],
                [
                    "pid"             => 2,
                    "name"            => "菜單管理",
                    "path"            => 'menu',
                    "component"       => "/system/menu/index",
                    "order"           => 2,
                    'meta' => [
                        "title"           => '菜單管理',
                        "ignore_keep_alive" => true,
                    ],
                    'permission'      => [
                        [
                            "name"       => "菜單管理-新增",
                            'permission_name' => 'menu-create',
                        ],
                        [
                            "name"       => "菜單管理-讀取",
                            'permission_name' => 'menu-retrieve',
                        ],
                        [
                            "name"       => "菜單管理-刪除",
                            'permission_name' => 'menu-delete',
                        ],
                        [
                            "name"       => "菜單管理-修改",
                            'permission_name' => 'menu-update',
                        ]
                    ]
                ],
                [
                    "pid"             => 2,
                    "name"            => "權限管理",
                    "path"            => 'permissions',
                    "component"       => "/system/permissions/index",
                    "order"           => 2,
                    'meta' => [
                        "title"           => '權限管理',
                        "ignore_keep_alive" => true,
                    ],
                    'permission'      => [
                        [
                            "name"       => "權限管理-新增",
                            'permission_name' => 'permissions-create',
                        ],
                        [
                            "name"       => "權限管理-讀取",
                            'permission_name' => 'permissions-retrieve',
                        ],
                        [
                            "name"       => "權限管理-刪除",
                            'permission_name' => 'permissions-delete',
                        ],
                        [
                            "name"       => "權限管理-修改",
                            'permission_name' => 'permissions-update',
                        ]
                    ]
                ],
                [
                    "pid"             => 2,
                    "name"            => "修改密碼",
                    "path"            => 'changePassword',
                    "component"       => "/system/changePassword/index",
                    "order"           => 2,
                    'meta' => [
                        "title"           => '修改密碼',
                        "ignore_keep_alive" => true,
                    ],
                    'permission'      => [
                        [
                            "name"       => "修改密碼-新增",
                            'permission_name' => 'changePassword-create',
                        ],
                        [
                            "name"       => "修改密碼-讀取",
                            'permission_name' => 'changePassword-retrieve',
                        ],
                        [
                            "name"       => "修改密碼-刪除",
                            'permission_name' => 'changePassword-delete',
                        ],
                        [
                            "name"       => "修改密碼-修改",
                            'permission_name' => 'changePassword-update',
                        ]
                    ]
                ],
            ];

        foreach ($AdminMenu as $value) {
            $AdminMenu = AdminMenu::create(Arr::only($value, ['pid', 'name', 'path', 'component', 'redirect', 'order']));
            if (isset($value['meta'])) {
                $AdminMenu->meta()->create($value['meta']);
            }
            if (isset($value['permission'])) {
                foreach ((array)$value['permission'] as  $value) {
                    $AdminMenu->permission()->save(Permission::create([
                        'name' => $value['permission_name'],
                        'tw_name' => $value['name']
                    ]));
                }
            }
        }
    }
}
