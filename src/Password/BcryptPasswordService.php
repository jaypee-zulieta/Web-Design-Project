<?php
namespace App\Password;

class BcryptPasswordService implements PasswordService
{
  public function compare(string $plainTextPassword, string $hashedPassword): bool 
  {
    return password_verify($plainTextPassword, $hashedPassword);
  }

  public function hash(string $plainTextPassword): string
  {
    return password_hash($plainTextPassword, PASSWORD_BCRYPT);
  }
}
