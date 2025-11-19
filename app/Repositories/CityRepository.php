<?php

namespace App\Repositories;

use App\Models\City;
use App\Repositories\Contracts\CityRepositoryInterface;
use Illuminate\Support\Collection;

class CityRepository implements CityRepositoryInterface
{
    public function getAll(): Collection
    {
        return City::with(['country', 'Address'])->get();
    }

    public function getById(int $id): ?City
    {
        return City::with(['country', 'Address'])->find($id);
    }

    public function create(array $data): City
    {
        return City::create($data);
    }

    public function update(City $city, array $data): City
    {
        $city->update($data);
        return $city;
    }

    public function delete(City $city): bool
    {
        return $city->delete();
    }
}
