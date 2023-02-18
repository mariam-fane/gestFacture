<?php
session_start(); 
if (!isset($_SESSION['id']) AND !isset($_SESSION['pseudo'])) {
	header('Location:./pages/examples/login.php');
}
else{
	header('Location:../desbord.php');
}



?>