<?php
namespace App\Password;

interface PasswordService
{
  public function compare(string $plainTextPassword, string $hashedPassword): bool;
  public function hash(string $plainTextPassword): string;
}


