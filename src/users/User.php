<?php
namespace User;

class User 
{

  private string $EDPnumber;
  private string $fullName;
  private string $password;
  private string $department;

  public function __construct(string $EDPnumber, string $fullName, string $password, string $department)
  {
    $this->EDPnumber = $EDPnumber;
    $this->fullName = $fullName;
    $this->password = $password;
    $this->department = $department;
  }

  public function getEDPNumber(): string 
  {
    return $this->EDPnumber;
  }

  public function getFullName(): string 
  {
    return $this->fullName;
  }

  public function getPassword(): string 
  {
    return $this->password;
  }

  public function getDepartment(): string 
  {
    return $this->department;
  }
}
?>