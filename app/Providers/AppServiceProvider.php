<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Import semua Interface (Contracts)
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\TeamRepositoryInterface;
use App\Repositories\Contracts\TeamMemberRepositoryInterface;
use App\Repositories\Contracts\TaskRepositoryInterface;
use App\Repositories\Contracts\WorkspaceActivityRepositoryInterface;

// Import semua Implementasi (Eloquent)
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Eloquent\TeamRepository;
use App\Repositories\Eloquent\TeamMemberRepository;
use App\Repositories\Eloquent\TaskRepository;
use App\Repositories\Eloquent\WorkspaceActivityRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Daftarkan semua binding dari Interface ke Eloquent Class di sini
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(TeamRepositoryInterface::class, TeamRepository::class);
        $this->app->bind(TeamMemberRepositoryInterface::class, TeamMemberRepository::class);
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
        $this->app->bind(WorkspaceActivityRepositoryInterface::class, WorkspaceActivityRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}