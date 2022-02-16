<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "todo");

if(isset($_SESSION["user_id"])){
    $session_user_id = $_SESSION["user_id"];
}
?>