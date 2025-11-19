<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserService
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAll()
    {
        return $this->userRepository->getAll();
    }

    public function getById(int $id)
    {
        return $this->userRepository->getById($id);
    }

    public function create(array $data)
    {
        return $this->userRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        $user = $this->userRepository->getById($id);
        if (!$user) return null;

        return $this->userRepository->update($user, $data);
    }

    public function delete(int $id)
    {
        $user = $this->userRepository->getById($id);
        if (!$user) return false;

        return $this->userRepository->delete($user);
    }
}
