<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeriesTable extends Migration
{
    /**
     * 文章系列表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categorie_id')->constrained('categories')->onDelete('cascade');
            $table->string('name', 60)->comment('系列名');
            $table->string('description', 255)->nullable()->comment('系列描述');
            $table->timestamps();
        });
        DB::statement("ALTER TABLE `series` comment '文章系列表'");
        Schema::create('serie_on_article', function (Blueprint $table) {
            $table->foreignId('serie_id')->constrained('series')->onDelete('cascade');
            $table->foreignId('article_id')->constrained('articles')->onDelete('cascade');
        });
        DB::statement("ALTER TABLE `serie_on_article` comment '系列關聯文章表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('serie_on_article');
        Schema::dropIfExists('series');
    }
}
