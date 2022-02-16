<?php 
require_once "config.php";
if(isset($_POST["login"])){
  $username = mysqli_real_escape_string($conn, $_POST["username"]);
  $password = mysqli_real_escape_string($conn, $_POST["password"]);

  if(empty($username) || empty($password)){
    $error = "All fields are required.";
  }else{
    $login_sql = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    if(mysqli_num_rows($login_sql) > 0){
      $login = mysqli_fetch_array($login_sql);
      $hashed_pwd = $login["password"];
      if(password_verify($password, $hashed_pwd)){
        $_SESSION["user_id"] = $login["id"];
        header("Location: index.php");
      }else{
        $error = "Username/Password are incorrect.";
      }
    }else{
      $error = "Username/Password are incorrect.";
    }
  }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Login</title>
  </head>
  <body>
    
    <div class="container">
      <div class="d-flex align-items-center justify-content-center" style="min-height: 100vh;">
          <div class="row w-100">
              <div class="col-lg-4 mx-auto">
                  <div class="card py-4 w-100 p-3 text-center shadow" style="border-radius: 15px;">
                      <h3 class="">Login</h3>
                      <?php if(isset($error)){echo "<p class='text-danger'>$error</p>";} ?>
                      <form action="" method="post" class="mt-4">
                          <input type="text" class="form-control mb-3" placeholder="Username" name="username" required>
                          <input type="password" class="form-control mb-3" placeholder="Password" name="password" required>
                          <input type="submit" class="btn btn-primary w-100" value="Login" name="login">
                          <p class="mb-0">Don't an account? <a href="register.php">Register</a></p>
                      </form>
                  </div>
              </div>
          </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>