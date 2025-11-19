<?php

namespace App\Repositories;

use App\Models\Address;
use App\Repositories\Contracts\AddressRepositoryInterface;
use Illuminate\Support\Collection;

class AddressRepository implements AddressRepositoryInterface
{
    public function getAll(): Collection
    {
        return Address::with(['city', 'users'])->get();
    }

    public function getById(int $id): ?Address
    {
        return Address::with(['city', 'users'])->find($id);
    }

    public function create(array $data): Address
    {
        return Address::create($data);
    }

    public function update(Address $address, array $data): Address
    {
        $address->update($data);
        return $address;
    }

    public function delete(Address $address): bool
    {
        return $address->delete();
    }
}
