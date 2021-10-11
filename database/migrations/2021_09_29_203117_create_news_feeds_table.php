<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news_feeds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('title')->comment('標題');
            $table->text('content')->nullable()->comment('內容');
            $table->json('image')->default(new Expression('(JSON_ARRAY())'))->comment('分享圖片');
            $table->string('place')->nullable()->comment('地點');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `news_feeds` comment '動態時報表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news_feeds');
    }
}


