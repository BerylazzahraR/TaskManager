<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->foreignId('default_team_id')->nullable()->constrained('teams')->nullOnDelete();
            $table->enum('theme', ['light', 'dark', 'system'])->default('system');
            $table->enum('task_view', ['list', 'board'])->default('list');
            $table->boolean('email_notification')->default(true);
            $table->boolean('in_app_notification')->default(true);
            $table->string('timezone')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_preferences');
    }
};