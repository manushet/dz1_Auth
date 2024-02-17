<?php 

declare(strict_types=1);

namespace Repositories;

interface CredentialsRepositoryInterface
{
    public function getCredentials(): array;

    public function saveCredentials(string $login, string $password): bool;
}