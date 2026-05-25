<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dashboard_metrics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained('teams')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->enum('scope', ['workspace', 'personal']);
            $table->integer('total_tasks')->default(0);
            $table->integer('todo_tasks')->default(0);
            $table->integer('in_progress_tasks')->default(0);
            $table->integer('done_tasks')->default(0);
            $table->integer('pending_tasks')->default(0);
            $table->integer('overdue_tasks')->default(0);
            $table->integer('unassigned_tasks')->default(0);
            $table->timestamp('last_calculated_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dashboard_metrics');
    }
};