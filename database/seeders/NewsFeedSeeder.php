<?php

namespace Database\Seeders;

use App\Models\NewsFeed;
use Illuminate\Database\Seeder;

class NewsFeedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $create = [
            [
                'user_id' => 1,
                'title' => '五一爬山崴着脚了',
                'content' => '五一爬山崴着脚了。。。在家休养中，惨惨惨。。',
                'image' => ['https://fuss10.elemecdn.com/e/5d/4a731a90594a4af544c0c25941171jpeg.jpeg','https://cdntwrunning.biji.co/800_2cc67724c2842a6c3adad0a57558c9f7.jpg'],
                'place' => '發自Windows 10',
            ]
        ];
        foreach ($create as  $value) {
            NewsFeed::create($value);
        }
    }
}
