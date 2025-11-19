<?php

namespace App\Repositories\Contracts;

use App\Models\City;
use Illuminate\Support\Collection;

interface CityRepositoryInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?City;
    public function create(array $data): City;
    public function update(City $city, array $data): City;
    public function delete(City $city): bool;
}
