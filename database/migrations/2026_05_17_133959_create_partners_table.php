<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->id(); // id (Primary Key, Auto-increment) [cite: 22]
            $table->string('name'); // name (String) [cite: 23]
            $table->string('logo_url'); // logo_url (String) [cite: 24]
            $table->timestamps(); // timestamps [cite: 26]
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partners');
    }
};
