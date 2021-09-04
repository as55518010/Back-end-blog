<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * 文章類別表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 60)->comment('分類名');
            $table->integer('order')->default(0)->comment('分類排序');
            $table->foreignId('pid')->default(0)->comment('父ID');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `categories` comment '文章類別表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
