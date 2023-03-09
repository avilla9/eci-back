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
            $table->text('groups');
            $table->text('quartiles');
            $table->text('delegations');
            $table->text('roles');
            $table->text('users');
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
