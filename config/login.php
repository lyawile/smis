<?php
session_start();
if(isset($_SESSION['loggedIn'])){
$loginInfo = '<p class="loginInfo">Logged in as: '.$_SESSION['loggedIn']. '| <a href="./config/logout.php">Logout</a></p>';
}
else      {   header('location: index.php');}

