<?php
namespace App\User;

interface UserService 
{
  public function getUserByEDPNumber(string $EDPNumber): User | null;
  public function userExistsByEDPNumber(string $EDPNumber): bool;
  public function createUser(User $user): User;
}
