<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->json('files');
            $table->string('name', 255);
            $table->enum('type', ['image', 'video', 'audio', 'zip', 'doc']);
            $table->boolean('isPrivate');
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
            $table->uuidMorphs('mediaable');
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
        Schema::dropIfExists('media');
    }
}
