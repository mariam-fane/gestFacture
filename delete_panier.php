 <?php 
 session_start();
 if (isset($_GET['action'])) {
    if ($_GET['action']=="removeAll") {
      unset($_SESSION['cart']);

      header('Location:panier.php');

    }
    if ($_GET["action"]=="remove") {
        foreach ($_SESSION['cart'] as $key => $value) {
          if ($value['id']==$_GET['id']) {
            unset($_SESSION['cart'][$key]);
             header('Location:panier.php');
          }
        }
    }
} ?> 