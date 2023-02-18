<?php
session_start();
if (!isset($_SESSION['id_user']) AND !isset($_SESSION['email_user'])) {
  header('Location:login.php');
}
require_once('db.php');

if (isset($_POST['add_shoping'])) {
   if (isset($_SESSION['cart'])) {
     $session_array_id = array_column($_SESSION['cart'], "id");

       if (!in_array($_GET['id'], $session_array_id)) {
         $session_array = array(
            'id' => $_GET['id'],
            'designation' => $_POST['designation'],
            'prix' => $_POST['prix']
          );
          $_SESSION['cart'][] = $session_array;
       }
   }else{
      $session_array = array(
        'id' => $_GET['id'],
        'designation' => $_POST['designation'],
        'prix' => $_POST['prix']
      );
      $_SESSION['cart'][] = $session_array;
   }
}
  $sql = "SELECT *
        FROM produit ORDER BY refProduit DESC
        ";

        $stmt = $bdd->prepare($sql);
        $stmt->execute();
        $produit = $stmt->fetchAll(PDO::FETCH_OBJ);

 ?>
<!DOCTYPE html>
<html lang="en">
<body id="page-top">

  <div id="wrapper">
    <!-- Sidebar -->
    <?php include('menu.php') ?>
    <!-- Sidebar -->

    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <?php include('nave.php') ?>
        <!-- Topbar -->
        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Service</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item">Service</li>
              <li class="breadcrumb-item active" aria-current="page">Liste des services</li>
            </ol>
          </div>

          <!-- Row -->
          <div class="row">
           
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Liste des services</h6>
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light"> 
                      <tr>
                        <th>#</th>
                        <th>Désignation</th>
                        <th>Prix</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    
                    <tbody>
                      <?php foreach ($produit as $prodt) : ?>
                            <tr>
                                <td class="col-md-1"><?php echo $prodt->refProduit; ?></td>  
                                <td><?php echo $prodt->designation; ?></td> 
                                <td class="col-md-2"><?php echo number_format($prodt->prix_intial, 2, ',', ' '); ?> F CFA</td>  
                                <td class="col-md-1">
                                   <!--  <a href="editProdt.php?refProduit=<?php echo $prodt->refProduit; ?>" class=""><i class="fas fa-edit"></i></a>
                                    <a href="deleteProd.php?refProduit=<?php echo $prodt->refProduit; ?>"class=""><i class="fas fa-trash"></i></a> -->
                                    <form action="service.php?id=<?= $prodt->refProduit ?>" method="post">
                                            <input type="hidden" name="designation" value="<?= $prodt->designation;?>">
                                            <input type="hidden" name="prix" value="<?= $prodt->prix_intial;?>">
                                           <button type="submit" name="add_shoping" class="btn btn-primary" value="Add" title="Ajouter au panier"> <i class="fas fa-shopping-cart"></i></button>
                                          
                                    </form>

                                 
                                </td> 
                            </tr>
                         <?php  endforeach; ?> 
                      
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
           <!--  <div class="col-lg-6" >
                <p>panier</p>
                <p><?php 
                  var_dump($_SESSION['cart']);
                  //unset($_SESSION['cart']);
                  ?>        
                </p>
            </div> -->
          </div>
          <!--Row-->

         

          <!-- Modal Logout -->
          <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>Are you sure you want to logout?</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                  <a href="login.html" class="btn btn-primary">Logout</a>
                </div>
              </div>
            </div>
          </div>

        </div>
        <!---Container Fluid-->
      </div>

      <!-- Footer -->
       <?php include('footer.php') ?>
      <!-- Footer -->
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script>
    $(document).ready(function () {
      $('#dataTable').DataTable(); // ID From dataTable 
      $('#dataTableHover').DataTable(); // ID From dataTable with Hover
    });
  </script>

</body>

</html>