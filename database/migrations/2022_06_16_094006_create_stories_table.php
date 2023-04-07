<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoriesTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->integer('filter_code')->nullable();
            $table->integer('file_id')->nullable();
            $table->string('link')->nullable();
            $table->string('button_name')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamp('publish_at')->nullable();
            $table->timestamp('unpublished')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('stories');
    }
}
