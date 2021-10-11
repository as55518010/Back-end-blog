<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlogInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('blog_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('blog_bottom_narrate')->nullable()->comment('下方資訊');
            $table->string('blog_theme_style')->nullable()->comment('主題樣式');
            $table->text('blog_big_back_img')->nullable()->comment('底圖');
            $table->timestamp('blog_create_time')->comment('部落格創建日期');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `blog_infos` comment 'Blog 相關資訊'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_infos');
    }
}
