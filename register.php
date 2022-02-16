<?php 
require_once "config.php";
if(isset($_POST["register"])){
    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    if(empty($name) || empty($username) || empty($password)){
        $error = "All fields are required";
    }else{
        $check_sql = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
        if(mysqli_num_rows($check_sql) > 0){
            $error = "Username already exists";
        }else{
            $hashed_pwd = password_hash($password, PASSWORD_DEFAULT);
            $insert_sql = mysqli_query($conn, "INSERT INTO `users` (`id`, `full_name`, `username`, `password`, `joined_on`) VALUES (NULL, '$name', '$username', '$hashed_pwd', current_timestamp());");
            if($insert_sql){
                $_SESSION["user_id"] = mysqli_insert_id($conn);
                header("Location: index.php");
            }else{
                $error = "Something went wrong with SQL";
            }
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

    <title>Register</title>
  </head>
  <body>
    
    <div class="container">
        <div class="d-flex align-items-center justify-content-center" style="min-height: 100vh;">
            <div class="row w-100">
                <div class="col-lg-4 col-xl-4 mx-auto">
                    <div class="card py-4 w-100 p-3 text-center shadow" style="border-radius: 15px;">
                        <h3>Register</h3>
                        <?php if(isset($error)){echo "<p class='text-danger'>$error</p>";} ?>
                        <form action="" method="post" class="mt-4">
                            <input type="text" class="form-control mb-3" placeholder="Full Name" name="name" required>
                            <input type="text" class="form-control mb-3" placeholder="Username" name="username" required>
                            <input type="password" class="form-control mb-3" placeholder="Password" name="password" required>
                            <input type="submit" class="btn btn-primary w-100" value="Sign Up" name="register">
                            <p class="mb-0">Already an account? <a href="login.php">Login</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>