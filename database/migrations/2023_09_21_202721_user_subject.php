<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('user_subject', function (Blueprint $table) {
            $table->id();
            $table->unsignedBiginteger('user_id')->unsigned();
            $table->unsignedBiginteger('subject_id')->unsigned();

            $table->foreign('user_id')->references('id')
                ->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('subject_id')->references('id')
                ->on('subjects')->onUpdate('cascade')->onDelete('cascade');

            $table->string('mark')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('');
    }
};
