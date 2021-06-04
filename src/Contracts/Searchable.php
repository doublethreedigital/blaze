<?php

namespace DoubleThreeDigital\Blaze\Contracts;

use Illuminate\Support\Collection;
use Statamic\Contracts\Auth\User;

interface Searchable
{
    public function search(string $query): Collection;

    public function transform($result): array;

    public function authorize(User $user, $result): bool;
}
