<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class M2019_08_09_180234331028_InstallPage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'pages', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->string('layout');
                $table->string('machineName');
                $table->booolean('published');
                $table->string('slug')->unique();
                $table->unsignedInteger('permission_id')->nullable();
                $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('set null');
                $table->timestamps();
                $table->softDeletes();
            }
        );

        Schema::create(
            'block_page', function (Blueprint $table) {
                $table->increments('id');
                $table->published();
                $table->unsignedInteger('page_id')->index();
                $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
                $table->unsignedInteger('block_id')->index();
                $table->foreign('block_id')->references('id')->on('blocks')->onDelete('cascade');
                $table->unsignedInteger('weight')->unsigned();
                $table->timestamps();
            }
        );

        // Schema::create('page_regions', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->string('name');
        //     $table->float('width', 8, 1);
        //     $table->integer('height')->unsigned();
        //     $table->integer('page_id')->unsigned()->index();
        //     $table->foreign('page_id')->references('id')->on('pages');
        //     $table->timestamps();
        //     $table->softDeletes();
        // });

        // Schema::create('block_page_region', function (Blueprint $table) {
        //     $table->increments('id');
        //     $table->unsignedInteger('weight');
        //     $table->unsignedInteger('page_region_id')->index();
        //     $table->foreign('page_region_id')->references('id')->on('page_regions');
        //     $table->unsignedInteger('block_id')->index();
        //     $table->foreign('block_id')->references('id')->on('blocks');
        //     $table->timestamps();
        // });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('block_page');
        Schema::dropIfExists('pages');
        // Schema::dropIfExists('page_regions');
    }
}
