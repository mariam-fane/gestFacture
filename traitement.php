<?php 
session_start(); 
if (!isset($_SESSION['id_user']) AND !isset($_SESSION['email_user'])) {
  header('Location:login.php');
}
   require_once('db.php');
	

 ?>