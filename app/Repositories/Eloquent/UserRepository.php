<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Support\Constants\UserConstants;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function findByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function active()
    {
        return $this->model->where('status', UserConstants::STATUS_ACTIVE)->get();
    }

    public function inactive()
    {
        return $this->model->where('status', UserConstants::STATUS_INACTIVE)->get();
    }

    public function search($keyword)
    {
        return $this->model->where('name', 'like', "%{$keyword}%")
            ->orWhere('email', 'like', "%{$keyword}%")
            ->get();
    }

    public function updateLastLogin($id)
    {
        return $this->update($id, ['last_login_at' => now()]);
    }

    public function verifyPassword($user, $password)
    {
        return Hash::check($password, $user->password);
    }

    public function isMemberOfTeam($userId, $teamId)
    {
        $user = $this->find($userId);
        return $user->teams()->where('teams.id', $teamId)->exists() ||
            $user->ownedTeams()->where('id', $teamId)->exists();
    }
}