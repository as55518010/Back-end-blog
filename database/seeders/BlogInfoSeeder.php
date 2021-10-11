<?php

namespace Database\Seeders;

use App\Models\BlogInfo;
use Illuminate\Database\Seeder;

class BlogInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BlogInfo::create([
            'user_id'             => 1,
            'blog_bottom_narrate' => 'Vue2 構建',
            'blog_theme_style'    => 'style0',
            'blog_big_back_img'   => 'https://cjunn.gitee.io/blog_theme_atum/img/body/background.jpg',
            'blog_create_time'    => '2021-06-30 00:00:00',
        ]);
    }
}
