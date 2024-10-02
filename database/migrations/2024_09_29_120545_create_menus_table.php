<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Menu name
            $table->unsignedBigInteger('parent_id')->nullable(); // For submenus
            $table->unsignedBigInteger('page_id')->nullable(); // Link to a page
            $table->string('url')->nullable(); // Optional external link
            $table->integer('order')->default(0); // To order menu items
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
