<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface
{
    public function all();
    public function find($id);
    public function findByEmail($email);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function active();
    public function inactive();
    public function search($keyword);
    public function updateLastLogin($id);
    public function verifyPassword($user, $password);
    public function isMemberOfTeam($userId, $teamId);
}