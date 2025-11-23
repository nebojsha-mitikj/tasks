<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('label_task', function (Blueprint $table) {
            $table->foreignId('task_id')
                ->constrained('tasks')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignId('label_id')
                ->constrained('labels')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->primary(['task_id', 'label_id']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('label_task');
    }
};
