<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
</head>
<body>
  <h2>Register User</h2>
  <form method="POST" action="register.php">

    <input type="number" name="edp_number" placeholder="EDP number" required />
    <input type="text" name="full_name" placeholder="Full name"  required/>
    <input type="password" name="user_password" placeholder="Password" required/>
    <input type="password" name="confirm_password" placeholder="Confirm password" required />
    <input type="text" name="department" placeholder="Department" required/>
    <button type="submit">Register</button>
    <div>
    <?php

    require __DIR__ . "/../src/database/MySQLConnection.php";
    require __DIR__ . "/../src/users/UserService.php";

    use DatabaseConnection\MySQLConnectionConfiguration;
    use User\MySQLUserService;
    use User\User;
    use User\UserException;

    if(
      !empty($EDPNumber = $_POST["edp_number"]) &&
      !empty($fullName = $_POST["full_name"]) &&
      !empty($password = $_POST["user_password"]) &&
      !empty($confirmPassword = $_POST["confirm_password"]) &&
      !empty($department = $_POST["department"])
    )
    {
     
      if($confirmPassword != $password) 
      {
        echo "Passwords don't match!";
        exit();
      }

      $connection = MySQLConnectionConfiguration::getInstance()->getConnection();
      $userService = new MySQLUserService($connection);

      try 
      {
        $user = new User($EDPNumber, $fullName, $password, $department);
        $userService->createUser($user);
        echo "User successfully registered";
      }
      catch(UserException $e)
      {
        echo $e->getMessage();
      }
    }
        
    ?>
    </form>

    </div>
   
</body>
</html>
