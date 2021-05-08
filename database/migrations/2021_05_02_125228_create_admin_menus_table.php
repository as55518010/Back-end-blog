<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminMenusTable extends Migration
{
    /**
     * 菜單模塊
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_menus', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->comment('名稱');
            $table->string('url', 255)->comment('路徑');
            $table->integer('sort')->default(0)->comment('排序');
            $table->string('icon', 60)->default('')->comment('圖標');
            $table->tinyInteger('keep_alive')->default(0)->comment('狀態保持');
            $table->foreignId('pid')->default(0)->comment('父ID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_menus');
    }
}
