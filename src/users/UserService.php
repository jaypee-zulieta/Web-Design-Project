<?php
namespace User;

require __DIR__ . "/../passwords/PasswordService.php";
require "User.php";


use Exception;
use User\User;
use mysqli;
use PasswordService\BcryptPasswordService;
use PasswordService\PasswordService;

interface UserService 
{
  public function getUserByEDPNumber(string $EDPNumber): User | null;
  public function userExistsByEDPNumber(string $EDPNumber): bool;
  public function createUser(User $user): User;
}

class UserException extends Exception {}

class MySQLUserService implements UserService 
{

  private mysqli $connection;
  private PasswordService $passwordService;

  public function __construct(mysqli $connection)
  {
    $this->passwordService = new BcryptPasswordService();
    $this->connection = $connection;
  }

  public function setPasswordService(PasswordService $passwordService): void
  {
    $this->passwordService = $passwordService;
  }

  public function getUserByEDPNumber(string $EDPNumber): User | null
  {
    if(!($this->userExistsByEDPNumber($EDPNumber)))
      return null;

    $sql = "SELECT edp_number, user_password, full_name, department FROM users WHERE edp_number = ?";
    $statement = $this->connection->prepare($sql);
    $statement->bind_param("s", $EDPNumber);
    $statement->execute();

    $result = $statement->get_result();

    if($row = $result->fetch_assoc()) 
    {
      return new User(
        $row["edp_number"],
        $row["full_name"],
        $row["user_password"],
        $row["department"]
      );
    }
    else return null;
  }

  public function userExistsByEDPNumber(string $EDPNumber): bool 
  {
    $sql = "SELECT COUNT(user_id) AS count FROM users WHERE edp_number = ?";
    $statement = $this->connection->prepare($sql);
    $statement->bind_param("s", $EDPNumber);
    $statement->execute();

    $result = $statement->get_result();

    if($row = $result->fetch_assoc()) 
    {
      $count = $row["count"];
      return $count > 0;
    }
    else return false;
  }

  public function createUser(User $user): User 
  {
    $edpNumber = $user->getEDPNumber();

    if($this->userExistsByEDPNumber($edpNumber))
      throw new UserException("User with EDP number " . $edpNumber . " already exists.");

    $fullName = $user->getFullName();
    $password = $this->passwordService->hash($user->getPassword());
    $department = $user->getDepartment();

    $sql = "INSERT INTO users (edp_number, user_password, full_name, department) VALUES (?, ?, ? ,?)";
    $statement = $this->connection->prepare($sql);
    $statement->bind_param("ssss", $edpNumber, $password, $fullName, $department);
    $statement->execute();

    return new User(
      $edpNumber,
      $fullName,
      $password,
      $department
    );
  }
}

?>