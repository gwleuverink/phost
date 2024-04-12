<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->longText('content')->charset('binary');
            $table->boolean('bookmarked')->default(false);
            $table->dateTime('read_at')->nullable();
            $table->timestamps();
        });
    }
};
