<?php
session_start();
$nom="Facture"; 
if (!isset($_SESSION['id_user']) AND !isset($_SESSION['email_user'])) {
  header('Location:login.php');
} 
require_once('db.php');
  $sql = "SELECT * FROM facture INNER JOIN client ON Client.num_clt=facture.num_clt ORDER BY num_facture DESC";

        $stmt = $bdd->prepare($sql);
        $stmt->execute();
        $facture = $stmt->fetchAll(PDO::FETCH_OBJ);
        // Suppression d'une ligne de la facture
        if (isset($_POST['delete'])) {
            $id = $_POST['id'];
            $delete_facture = $bdd->prepare("DELETE FROM facture WHERE num_facture=?");
            $delete_facture->execute(array($id));

            $message="Facture a bien été supprimer avec succès";
        }
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
            <h1 class="h3 mb-0 text-gray-800">Gestion des factures</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Accueil</a></li>
              <li class="breadcrumb-item">Facture</li>
              <li class="breadcrumb-item active" aria-current="page">Liste des factures</li>
            </ol>
          </div>

          <!-- Row -->
          <div class="row">
           
            <div class="col-lg-12">
                <?php if (isset($message)) { ?>
                  <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                   <?php  echo $message; ?> 
                </div>
            <?php } ?>
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Liste des factures</h6>
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>N° Fact</th>
                        <th>Type facture</th>
                        <th>Date</th>
                        <th>Doit</th>
                        <th>Montant</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    
                    <tbody>
                      <?php foreach ($facture as $item) : ?>
                            <tr>
                                <td class="col-md-1"><?php if($item->num_facture<10){echo '0'.$item->num_facture;}else { echo $item->num_facture; } ?></td> 
                                <td class="col-md-2"><?php echo $item->type_fact; ?></td>
                                <td class="col-md-1"><?php echo date('d/m/Y', strtotime($item->date_fact)); ?></td>
                                <td class="col-md-4"><?php echo $item->nomclt.' '.$item->prenomclt.', Tél : '.$item->contactclt; ?></td> 
                                <td class="col-md-2">
                                   <?php 
                                      if($item->tva==0){
                                        echo number_format($item->ht, 2, ',', ' ');
                                      }else{ echo number_format($item->ttc, 2, ',', ' '); } ?>
                                        
                                     F CFA </td> 
                                  <td class="col-md-1">
                                      <a href="voir_facture.php?num_facture=<?php echo $item->num_facture ; ?>" class=""><i class="fas fa-eye text-success"></i></a>
                                      <a href="edit_facture.php?num_facture=<?php echo $item->num_facture ; ?>" class=""><i class="fas fa-edit text-primary"></i></a>
                                      <a href="facture_pdf.php?num_facture=<?php echo $item->num_facture ; ?>" class="" target="_blank"><i class="fas fa-file-pdf text-danger" ></i></a>
                                      <a href="#deleteProd.php?num_facture=<?php echo $item->num_facture ; ?>"class="" data-toggle="modal" data-target="#exampleModalCenter<?php echo $item->num_facture ; ?>"><i class="fas fa-trash text-danger"></i></a>
                                  </td> 
                                  <!-- Modal -->
                                  <div class="modal fade" id="exampleModalCenter<?php echo $item->num_facture ; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                      <div class="modal-content">
                                        <form method="POST" action="#">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle"><i class="fas fa-trash text-danger"></i> Suppression d'une facture de : <?php echo $item->nomclt.' '.$item->prenomclt; ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                           Voulez-vous supprimer la facture numéro : <?php if($item->num_facture<10){echo '0'.$item->num_facture;}else { echo $item->num_facture; } ?> ?
                                            <input type="hidden" name="id" value="<?php echo $item->num_facture ; ?>">
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-primary" name="delete">Confirmer</button>
                                          </div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
                            </tr>
                         <?php  endforeach; ?> 
                      
                    </tbody>
                  </table>

                </div>
              </div>
            </div>
         
          </div>
          <!--Row-->

          <!-- Documentation Link -->
        

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
    // $(document).ready(function () {
    //   $('#dataTable').DataTable(); // ID From dataTable 
      
    // });
     $(document).ready(function() {
     
      var oTable = $('#dataTableHover').dataTable({
        "aoColumnDefs": [{
          "bSortable": false,
          "aTargets": [0]
        }],
        "aaSorting": [
          [0, 'desc']
        ]
      });
      // $('#dataTableHover').DataTable(); // ID From dataTable with Hover
     
    });
  </script>

</body>

</html>