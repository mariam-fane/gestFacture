<?php
$page = $_SERVER['PHP_SELF'];
//echo $page;
$active = 'active';
$show = 'show'; 
?>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/soft.png" rel="icon">
  <title>G-FACTURE | <?php echo $nom ?></title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

  <!-- Select2 -->
  <link href="vendor/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css">
  <!-- Bootstrap DatePicker -->  
  <link href="vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet" >
  <!-- Bootstrap Touchspin -->
  <link href="vendor/bootstrap-touchspin/css/jquery.bootstrap-touchspin.css" rel="stylesheet" >
  <!-- ClockPicker -->
  <link href="vendor/clock-picker/clockpicker.css" rel="stylesheet">
  <!-- RuangAdmin CSS -->
  <link href="css/ruang-admin.min.css" rel="stylesheet">
</head>

<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon">
          <img src="img/soft.png">
        </div>
        <div class="sidebar-brand-text mx-3">G-FACTURE</div>
      </a>
      <hr class="sidebar-divider my-0">
      <li class="nav-item <?php if($page=="/mariam/index.php"){ echo $active; }?>">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Accueil</span></a>
      </li>
      
       <li class="nav-item <?php if($page=="/mariam/article.php"){ echo $active; }?>">
        <a class="nav-link" href="article.php">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Articles</span>
        </a>
      </li>
       <li class="nav-item <?php if($page=="/mariam/client.php"){ echo $active; }?>">
        <a class="nav-link" href="client.php">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Clients</span>
        </a>
      </li>

      
      <li class="nav-item <?php if($page=="/mariam/service.php" || $page=="/mariam/facture.php" || $page=="/mariam/panier.php"){ echo $active; }?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTable" aria-expanded="true"
          aria-controls="collapseTable">
          <i class="fas fa-fw fa-table"></i>
          <span>Facture</span>
        </a>
        <div id="collapseTable" class="collapse <?php if($page=="/mariam/service.php" || $page=="/mariam/facture.php" || $page=="/mariam/panier.php"){ echo $show; }?>" aria-labelledby="headingTable" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item <?php if($page=="/mariam/facture.php"){ echo $active; }?>" href="facture.php">Liste des factures</a>
            <a class="collapse-item <?php if($page=="/mariam/service.php"){ echo $active; }?>" href="service.php">Services</a>
            <a class="collapse-item <?php if($page=="/mariam/panier.php"){ echo $active; }?>" href="panier.php">Panier  <span class="badge badge-danger badge-counter"><?php if(isset($_SESSION['cart']) && count($_SESSION['cart'])>0){ echo count($_SESSION['cart']); }else{echo "0";}?></span></a>
          </div>
        </div>
      </li>
      
    <?php if ($_SESSION['droit_user']=="Admin") { ?>
      <li class="nav-item <?php if($page=="/mariam/register.php" || $page=="/mariam/user.php"){ echo $active; }?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePage" aria-expanded="true"
          aria-controls="collapsePage">
          <i class="fas fa-fw fa-columns"></i>
          <span>Configuration</span>
        </a>
        <div id="collapsePage" class="collapse <?php if($page=="/mariam/register.php" || $page=="/mariam/user.php"){ echo $show; }?>" aria-labelledby="headingPage" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="collapse-item <?php if($page=="/mariam/user.php"){ echo $active; }?>" href="user.php">Liste des utilisateurs</a>
            <a class="collapse-item <?php if($page=="/mariam/register.php"){ echo $active; }?>" href="register.php">Créer utilisateur</a>
          </div>
        </div>
      </li>
    <?php } ?>
    
    </ul>