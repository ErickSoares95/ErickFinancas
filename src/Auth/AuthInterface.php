<?php
declare(strict_types=1);

namespace ErickFinancas\Auth;

use ErickFinancas\Models\UserInterface;

interface AuthInterface
{
    public function login(array $credentials): bool;
    public function check(): bool;
    public function logout(): void;

    public function hashPassword(string $password): string;

    public function user(): ?UserInterface;
}