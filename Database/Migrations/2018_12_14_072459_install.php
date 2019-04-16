<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Install extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_layouts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->integer('page_layout_id')->unsigned()->index();
            $table->foreign('page_layout_id')->references('id')->on('page_layouts');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('page_blocks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('class')->unique();
            $table->integer('object_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('page_regions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('page_layout_id')->unsigned()->index();
            $table->foreign('page_layout_id')->references('id')->on('page_layouts');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('view_modes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('view_mode_model', function (Blueprint $table) {
            $table->increments('id');
            $table->string('model');
            $table->integer('view_mode_id')->unsigned()->index();
            $table->foreign('view_mode_id')->references('id')->on('view_modes')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('page_block_page_region', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('page_region_id')->unsigned()->index();
            $table->foreign('page_region_id')->references('id')->on('page_regions');
            $table->integer('page_block_id')->unsigned()->index();
            $table->foreign('page_block_id')->references('id')->on('page_blocks');
            $table->integer('view_mode_id')->unsigned()->index();
            $table->foreign('view_mode_id')->references('id')->on('view_modes');
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
        Schema::dropIfExists('page_block_page_region');
        Schema::dropIfExists('page_blocks');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('page_regions');
        Schema::dropIfExists('page_layouts');
        Schema::dropIfExists('view_mode_model');
        Schema::dropIfExists('view_modes');
    }
}
