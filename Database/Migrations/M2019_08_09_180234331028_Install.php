<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class M2019_08_09_180234331028_Install extends Migration
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

        Schema::create('block_providers', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('system');
            $table->string('name');
            $table->string('class');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('blocks', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('system');
            $table->integer('instance_id')->unsigned()->index();
            $table->string('instance_type');
            $table->integer('provider_id')->unsigned()->index();
            $table->foreign('provider_id')->references('id')->on('block_providers');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('page_regions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->float('width', 8, 1);
            $table->integer('height')->unsigned();
            $table->integer('page_layout_id')->unsigned()->index();
            $table->foreign('page_layout_id')->references('id')->on('page_layouts');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('block_page_region', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('weight')->unsigned();
            $table->integer('page_region_id')->unsigned()->index();
            $table->foreign('page_region_id')->references('id')->on('page_regions');
            $table->integer('block_id')->unsigned()->index();
            $table->foreign('block_id')->references('id')->on('blocks');
            $table->timestamps();
        });

        Schema::create('block_texts', function (Blueprint $table) {
            $table->increments('id');
            $table->text('text');
            $table->text('name');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('block_texts');
        Schema::dropIfExists('block_page_region');
        Schema::dropIfExists('blocks');
        Schema::dropIfExists('block_providers');
        Schema::dropIfExists('pages');
        Schema::dropIfExists('page_regions');
        Schema::dropIfExists('page_layouts');
    }
}
