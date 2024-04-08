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
        Schema::create('types', function (Blueprint $table) {
            $table->id();
            $table->string('component')
                ->nullable()
                ->index();
            $table->string('category')
                ->nullable()
                ->index();
            $table->string('label', 1023);
            $table->text('description')
                ->nullable();
            $table->unsignedSmallInteger('order')
                ->nullable();
            $table->boolean('required')
                ->nullable()
                ->default(false);
            $table->text('value')
                ->nullable();
            $table->json('values')
                ->nullable();
            $table->json('options')
                ->nullable();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignId('main_type_id')
                ->nullable()
                ->constrained('types')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('components');
    }
};
