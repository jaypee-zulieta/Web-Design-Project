<?php
namespace Auth;

require __DIR__ . "/../users/UserService.php";

use PasswordService\PasswordService;
use User\User;
use User\UserException;
use User\UserService;

interface AuthenticationService
{
  public function login(string $EDPNumber, string $password): User;
}

class StandardAuthenticationService implements AuthenticationService 
{
  private UserService $userService;
  private PasswordService $passwordService;

  public function __construct(UserService $userService, PasswordService $passwordService)
  {
    $this->userService = $userService;
    $this->passwordService = $passwordService;
  }


  public function login(string $EDPNumber, string $password): User
  {
    $user = $this->userService->getUserByEDPNumber($EDPNumber);
    $message = "Incorrect EDP number or password!";
    if($user == null) throw new UserException($message);

    if(!$this->passwordService->compare($password, $user->getPassword())) 
      throw new UserException($message);;
    return $user;
  }
}


?>