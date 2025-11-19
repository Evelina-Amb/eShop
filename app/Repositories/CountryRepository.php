<?php

namespace App\Repositories;

use App\Models\Country;
use App\Repositories\Contracts\CountryRepositoryInterface;
use Illuminate\Support\Collection;

class CountryRepository implements CountryRepositoryInterface
{
    public function getAll(): Collection
    {
        return Country::with('City')->get();
    }

    public function getById(int $id): ?Country
    {
        return Country::with('City')->find($id);
    }

    public function create(array $data): Country
    {
        return Country::create($data);
    }

    public function update(Country $country, array $data): Country
    {
        $country->update($data);
        return $country;
    }

    public function delete(Country $country): bool
    {
        return $country->delete();
    }
}
