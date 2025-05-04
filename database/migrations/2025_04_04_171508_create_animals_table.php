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
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('species', 100);
            $table->boolean('is_predator')->default(false);
            $table->timestamp('born_at');
            $table->string('imagename')->nullable();
            $table->string('imagename_hash')->nullable();

            $table->unsignedBigInteger('enclosure_id')->nullable();
            $table->foreign('enclosure_id')->references('id')->on('enclosures')->onDelete('cascade');

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
