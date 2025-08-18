<?php
namespace App\Auth;

use App\User\User;

interface AuthenticationService
{
  public function login(string $EDPNumber, string $password): User;
}


