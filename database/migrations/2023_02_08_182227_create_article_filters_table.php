<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_filters', function (Blueprint $table) {
            $table->id();
            $table->integer('article_id');
            $table->json('groups');
            $table->json('quartiles');
            $table->json('delegations');
            $table->json('roles');
            $table->json('users');
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
        Schema::dropIfExists('article_filters');
    }
}
