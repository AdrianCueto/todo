<?php 
require_once "config.php";
if(!isset($_SESSION["user_id"])){
  header("Location: login.php");
}
if(isset($_POST["add"])){
  $text = mysqli_real_escape_string($conn, $_POST["text"]);
  $date = mysqli_real_escape_string($conn, $_POST["date"]);
  $priority = mysqli_real_escape_string($conn, $_POST["priority"]);

  if(empty($text)){
    $error = "Text is required";
  }else{
    $insert_sql = mysqli_query($conn, "INSERT INTO `todo` (`id`, `user_id`, `text`, `priority`, `date`, `is_completed`) VALUES (NULL, '$session_user_id', '$text', '$priority', '$date', '0');");
    if($insert_sql){
      header("Location: index.php");
    }
  }
}

if(isset($_GET["complete"])){
  $id = mysqli_real_escape_string($conn, $_GET["complete"]);

  $del_sql = mysqli_query($conn, "UPDATE `todo` SET `is_completed` = '1' WHERE `todo`.`id` = $id;");
  if($del_sql){
    header("Location: index.php");
  }else{
    $error = "Something went wrong";
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Login</title>

    <style>
      .item{
        position: relative;
        padding-left: 10px;
        text-align: left !important;
      }
      .item::before{
        content: " ";
        width: 5px;
        height: 100%;
        display: block;
        position: absolute;
        z-index: 1;
        left: 0;
        top: 0;
        bottom: 0;
      }
      .item-0::before{
        background: #198754;
      }
      .item-1::before{
        background: #0d6efd;
      }
      .item-2::before{
        background: #fd7e14;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="d-flex align-items-center justify-content-center" style="min-height: 100vh;">
          <div class="row w-100">
              <div class="col-lg-5 col-xl-5 mx-auto">
                  <div class="card w-100 text-center shadow">
                      <div class="card-header bg-primary border-0 text-white">
                        <div class="d-flex">
                          <div>
                            <h4 class="my-2 text-start">ToDo</h4>
                          </div>
                          <div class="ms-auto pt-2">
                            <a href="logout.php" class="btn btn-sm btn-danger"> Logout <i class="fas fa-right-from-bracket"></i></a>
                          </div>
                        </div>
                      </div>
                      <div class="card-body m-4">
                      <?php if(isset($error)){echo "<p class='text-danger'>$error</p>";} ?>
                        <form action="" method="post">
                          <div class="row">
                            <div class="col-lg-12 mb-2">
                              <input type="text" class="form-control" name="text" placeholder="Write something">
                            </div>
                            <div class="col-lg-6 mb-2">
                              <input type="date" class="form-control" name="date">
                            </div>
                            <div class="col-lg-6 mb-2">
                              <select name="priority" id="" class="form-select">
                                <option value="0" class="text-success">Low</option>
                                <option value="1" class="text-primary">Medium</option>
                                <option value="2" class="text-warning">High</option>
                              </select>
                            </div>
                            <div class="col-lg-12">
                              <button class="btn btn-primary w-100" name="add">Add</button>
                            </div>
                          </div>
                        </form>
                        <hr>
                        <div>
                          <?php
                            $sql = mysqli_query($conn, "SELECT * FROM todo WHERE user_id = '$session_user_id' ORDER BY id DESC");
                            if(mysqli_num_rows($sql) > 0){
                              while($row= mysqli_fetch_array($sql)){
                          ?>
                          <div class="item item-<?php echo $row["priority"]; ?> <?php if($row["is_completed"] == "1"){echo "alert-success";} ?> p-2">
                              <div class="d-flex">
                                <div class="ps-2">
                                  <p class="mb-0"><?php echo $row["text"]; ?></p>
                                  <p class="text-muted mb-0"><i class="fa-solid fa-calendar-days"></i> <?php echo $row["date"]; ?></p>
                                </div>
                                <div class="ms-auto d-flex align-items-center justify-content-center">
                                  <?php if($row["is_completed"] == "0"){ ?><a href="?complete=<?php echo $row["id"]; ?>" class="btn btn-sm btn-success"><i class="fas fa-check"></i></a> <?php } ?>
                                </div>
                              </div>
                          </div>
                          <?php } } ?>
                        </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>
