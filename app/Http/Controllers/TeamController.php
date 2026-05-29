<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeamRequest;
use App\Http\Requests\UpdateTeamRequest;
use App\Domain\Team\Actions\CreateAction;
use App\Domain\Team\Actions\UpdateAction;
use App\Domain\Team\Actions\DeleteAction;
use App\Domain\Team\Queries\TeamQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{
    public function __construct(
        protected TeamQuery $teamQuery,
        protected CreateAction $createAction,
        protected UpdateAction $updateAction,
        protected DeleteAction $deleteAction
    ) {}

    /**
     * Menampilkan daftar semua workspace yang diikuti oleh user aktif.
     */
    public function index()
    {
        // Mengambil hanya team yang aktif dan bisa diakses oleh user saat ini
        $teams = $this->teamQuery->getByUser(Auth::id());

        return view('team.index', compact('teams')); // Sesuai spesifikasi view team/index.blade
    }

    /**
     * Menampilkan form untuk membuat workspace baru.
     */
    public function create()
    {
        return view('team.create'); // Sesuai spesifikasi view team/create.blade
    }

    /**
     * Menyimpan workspace baru hasil inputan user.
     */
    public function store(StoreTeamRequest $request)
    {
        // Menjalankan business logic penyimpanan lewat CreateAction
        $team = $this->createAction->execute(Auth::id(), $request->validated());

        return redirect()->route('teams.show', $team->slug)
            ->with('success', "Workspace '{$team->name}' berhasil dibuat!");
    }

    /**
     * Menampilkan detail satu workspace spesifik beserta member dan task di dalamnya.
     */
    /**
     * Menampilkan detail satu workspace spesifik beserta member, task, dan aktivitas.
     */
    public function show(string $slug)
    {
        $team = $this->teamQuery->getBySlug($slug);

        // Validasi pengaman internal
        if ($team->owner_id !== Auth::id() && !$team->users()->where('users.id', Auth::id())->exists()) {
            abort(403, 'Anda tidak memiliki akses ke workspace ini.');
        }

        $members = $this->teamQuery->getMembers($team->id);
        $tasks = $this->teamQuery->getTasks($team->id);
        
        
        $activities = $this->teamQuery->getActivities($team->id); 

        
        return view('team.show', compact('team', 'members', 'tasks', 'activities')); 
    }

    /**
     * Menampilkan halaman edit konfigurasi workspace.
     */
    public function edit(string $slug)
    {
        $team = $this->teamQuery->getBySlug($slug);

        // Aturan Bisnis: Hanya Owner yang boleh masuk ke form pengubahan data utama
        if ($team->owner_id !== Auth::id()) {
            abort(403, 'Hanya pemilik workspace yang dapat mengubah pengaturan.');
        }

        return view('team.edit', compact('team')); // Sesuai spesifikasi view team/edit.blade
    }

    /**
     * Memperbarui data konfigurasi workspace.
     */
    public function update(UpdateTeamRequest $request, int $id)
    {
        // Menjalankan eksekusi perubahan data lewat UpdateAction
        $team = $this->updateAction->execute($id, Auth::id(), $request->validated());

        return redirect()->route('teams.show', $team->slug)
            ->with('success', 'Pengaturan workspace berhasil diperbarui.');
    }

    /**
     * Melakukan soft delete terhadap workspace.
     */
    public function destroy(int $id)
    {
        $team = $this->teamQuery->getById($id);

        if ($team->owner_id !== Auth::id()) {
            abort(403, 'Hanya pemilik utama yang dapat menghapus workspace ini.');
        }

        $this->deleteAction->execute($id, Auth::id());

        return redirect()->route('teams.index')
            ->with('success', 'Workspace berhasil dihapus.');
    }
}