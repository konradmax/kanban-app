<?php
declare(strict_types=1);

namespace App\Authenticate\Service;

interface AuthServiceInterface
{
    public function login(int $id): User;
    public function authenticate(int $id): User;
    public function isLoggedIn(): bool;
    public function getCurrentUserData(): bool;
    public function getCurrentUserUid(): bool;
}
