<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * 文章表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categorie_id')->constrained('categories')->onDelete('cascade');
            $table->string('title', 60)->comment('文章標題');
            $table->text('content')->comment('文章內容');
            $table->string('author', 60)->comment('文章作者');
            $table->string('thumb', 255)->nullable()->comment('文章縮略圖');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('article_detils', function (Blueprint $table) {
            $table->id();
            $table->foreignId('article_id')->constrained('articles')->onDelete('cascade');
            $table->string('tag', 60)->nullable()->comment('文章標籤');
            $table->string('description', 255)->nullable()->comment('文章描述');
            $table->integer('view')->default(0)->comment('文章瀏覽次數');
            $table->integer('recommend')->default(0)->comment('文章推薦狀態: 0:未推薦 1:加入推薦');
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
        Schema::dropIfExists('article_detils');
        Schema::dropIfExists('articles');
    }
}
