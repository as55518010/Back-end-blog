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
            $table->foreignId('pid')->default(0)->comment('父菜單ID');
            $table->string('name')->comment('名稱');
            $table->string('path')->nullable()->comment('路由地址');
            $table->string('component')->nullable()->comment('組件地址');
            $table->string('redirect')->nullable()->comment('重定向');
            $table->integer('order')->default(0)->comment('排序');
            $table->timestamps();
        });
        Schema::create('admin_menu_metas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_menus_id')->default(0)->comment('關聯 admin_menus');
            $table->string('title')->comment('路由title');
            $table->boolean('ignore_keep_alive')->default(false)->comment('是否忽略KeepAlive緩存');
            $table->boolean('affix')->default(false)->comment('是否固定標籤');
            $table->string('icon')->nullable()->comment('圖標');
            $table->string('frame_src')->nullable()->comment('內嵌iframe的地址');
            $table->string('transition_name')->nullable()->comment('指定該路由切換的動畫名');
            $table->boolean('hide_breadcrumb')->default(false)->comment('隱藏該路由在麵包屑上面的顯示');
            $table->boolean('carry_param')->default(false)->comment('如果該路由會攜帶參數，且需要在tab頁上面顯示。則需要設置為true');
            $table->boolean('hide_children_in_menu')->default(false)->comment('隱藏所有子菜單');
            $table->string('current_active_menu')->nullable()->comment('當前激活的菜單。用於配置詳情頁時左側激活的菜單路徑');
            $table->boolean('hide_tab')->default(false)->comment('當前路由不再標籤頁顯示');
            $table->boolean('hide_menu')->default(false)->comment('當前路由不再菜單顯示');
            $table->boolean('ignore_route')->default(false)->comment('忽略路由');
            $table->boolean('hide_path_for_children')->default(false)->comment('是否在子級菜單的完整path中忽略本級path');
            $table->timestamps();

            $table->foreign('admin_menus_id')
                ->references('id')
                ->on('admin_menus')
                ->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_menu_metas');
        Schema::dropIfExists('admin_menus');
    }
}
