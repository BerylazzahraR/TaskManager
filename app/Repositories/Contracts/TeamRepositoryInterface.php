<?php

namespace App\Repositories\Contracts;

interface TeamRepositoryInterface
{
    public function all();
    public function find($id);
    public function findBySlug($slug);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function archive($id);
    public function restore($id);
    public function byOwner($ownerId);
    public function byUser($userId);
    public function activeByUser($userId);
    public function members($teamId);
    public function tasks($teamId);
    public function dashboard($teamId);
    public function isAccessibleByUser($teamId, $userId);
}