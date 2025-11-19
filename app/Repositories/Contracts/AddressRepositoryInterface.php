<?php

namespace App\Repositories\Contracts;

use App\Models\Address;
use Illuminate\Support\Collection;

interface AddressRepositoryInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?Address;
    public function create(array $data): Address;
    public function update(Address $address, array $data): Address;
    public function delete(Address $address): bool;
}
