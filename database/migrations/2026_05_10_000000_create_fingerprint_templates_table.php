<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('fingerprint_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->text('template_b64');
            $table->enum('template_type', ['1:1', '1:N'])->default('1:1');
            $table->string('engine_version')->default('9');
            $table->integer('quality_score')->nullable();
            $table->timestamps();
            $table->index('user_id');
        });
    }
};
