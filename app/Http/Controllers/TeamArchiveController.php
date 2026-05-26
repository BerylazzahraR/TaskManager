<?php

namespace App\Http\Controllers;

use App\Domain\Team\Actions\ArchiveAction;
use App\Domain\Team\Queries\TeamQuery;
use App\Repositories\Contracts\TeamRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamArchiveController extends Controller
{
    public function __construct(
        protected TeamQuery $teamQuery,
        protected ArchiveAction $archiveAction,
        protected TeamRepositoryInterface $teamRepository
    ) {}

    /**
     * Mengarsipkan workspace (Ubah status jadi archived).
     */
    public function store(Request $request, int $id)
    {
        $team = $this->teamQuery->getById($id);

        if ($team->owner_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengarsipkan workspace ini.');
        }

        $this->archiveAction->execute($id, Auth::id());

        return redirect()->route('teams.show', $team->slug)
            ->with('success', 'Workspace berhasil diarsipkan. Task baru tidak dapat ditambahkan.');
    }

    /**
     * Memulihkan kembali workspace dari arsip/soft delete.
     */
    public function restore(int $id)
    {
        // Memanggil fungsi restore pada repository layer langsung untuk mengembalikan soft-delete
        $team = $this->teamRepository->restore($id);

        return redirect()->route('teams.show', $team->slug)
            ->with('success', "Workspace '{$team->name}' berhasil diaktifkan kembali!");
    }
}