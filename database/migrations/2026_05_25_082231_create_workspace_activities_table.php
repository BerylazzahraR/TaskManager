<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workspace_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained('teams')->cascadeOnDelete();
            $table->foreignId('task_id')->nullable()->constrained('tasks')->nullOnDelete();
            $table->foreignId('actor_id')->constrained('users')->cascadeOnDelete();
            $table->enum('action', [
                'team_created', 'member_added', 'member_removed', 'role_changed', 
                'task_created', 'task_updated', 'task_deleted', 'task_assigned', 
                'comment_added', 'status_changed', 'deadline_changed', 'attachment_uploaded'
            ]);
            $table->string('subject_type')->nullable();
            $table->integer('subject_id')->nullable();
            $table->text('description');
            $table->json('before_data')->nullable();
            $table->json('after_data')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workspace_activities');
    }
};