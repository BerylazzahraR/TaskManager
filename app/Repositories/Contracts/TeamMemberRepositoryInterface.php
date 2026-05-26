<?php

namespace App\Repositories\Contracts;

interface TeamMemberRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function byTeam($teamId);
    public function byUser($userId);
    public function active($teamId);
    public function findMember($teamId, $userId);
    public function isActiveMember($teamId, $userId);
    public function isOwner($teamId, $userId);
    public function isAdminOrOwner($teamId, $userId);
    public function changeRole($teamId, $userId, $role);
    public function removeMember($teamId, $userId);
    public function countOwners($teamId);
}