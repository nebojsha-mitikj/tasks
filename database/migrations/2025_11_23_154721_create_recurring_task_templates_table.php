<?php

declare (strict_types = 1);

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskRecurEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('recurring_task_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('recur', TaskRecurEnum::values());
            $table->enum('priority', TaskPriorityEnum::values())->default(TaskPriorityEnum::NONE->value);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recurring_task_templates');
    }
};
