<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddMemberRequest;
use App\Http\Requests\ChangeRoleRequest;
use App\Domain\TeamMember\Actions\AddMemberAction;
use App\Domain\TeamMember\Actions\ChangeRoleAction;
use App\Domain\TeamMember\Actions\RemoveMemberAction;
use App\Repositories\Contracts\TeamMemberRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class TeamMemberController extends Controller
{
    public function __construct(
        protected TeamMemberRepositoryInterface $teamMemberRepo,
        protected AddMemberAction $addMemberAction,
        protected ChangeRoleAction $changeRoleAction,
        protected RemoveMemberAction $removeMemberAction
    ) {}

    /**
     * Menambahkan member baru ke dalam workspace
     */
    public function store(AddMemberRequest $request, int $teamId)
    {
        // Validasi Otorisasi: Cek apakah user yang login adalah Owner atau Admin di tim ini
        if (!$this->teamMemberRepo->isAdminOrOwner($teamId, Auth::id())) {
            abort(403, 'Hanya Owner atau Admin yang dapat menambahkan anggota.');
        }

        try {
            $this->addMemberAction->execute($teamId, Auth::id(), $request->validated());
            return back()->with('success', 'Anggota berhasil ditambahkan ke workspace!');
        } catch (Exception $e) {
            // Menangkap error dari Action (misal: user sudah ada di tim)
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Mengubah role member (misal dari member ke admin)
     */
    public function update(ChangeRoleRequest $request, int $teamId, int $userId)
    {
        if (!$this->teamMemberRepo->isAdminOrOwner($teamId, Auth::id())) {
            abort(403, 'Hanya Owner atau Admin yang dapat mengubah role.');
        }

        $this->changeRoleAction->execute($teamId, Auth::id(), $userId, $request->role);

        return back()->with('success', 'Role anggota berhasil diperbarui!');
    }

    /**
     * Menghapus (mengeluarkan) member dari workspace
     */
    public function destroy(int $teamId, int $userId)
    {
        if (!$this->teamMemberRepo->isAdminOrOwner($teamId, Auth::id())) {
            abort(403, 'Hanya Owner atau Admin yang dapat mengeluarkan anggota.');
        }

        $this->removeMemberAction->execute($teamId, Auth::id(), $userId);

        return back()->with('success', 'Anggota berhasil dikeluarkan dari workspace.');
    }
}