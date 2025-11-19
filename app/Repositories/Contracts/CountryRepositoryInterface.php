<?php

namespace App\Repositories\Contracts;

use App\Models\Country;
use Illuminate\Support\Collection;

interface CountryRepositoryInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?Country;
    public function create(array $data): Country;
    public function update(Country $country, array $data): Country;
    public function delete(Country $country): bool;
}
