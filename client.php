<?php
session_start(); 
$nom="client";
if (!isset($_SESSION['id_user']) AND !isset($_SESSION['email_user'])) {
  header('Location:login.php');
} 
require_once('db.php');
  $sql = "SELECT * FROM client ORDER BY num_clt DESC ";
  $stmt = $bdd->prepare($sql);
  $stmt->execute();
  $clients = $stmt->fetchAll(PDO::FETCH_OBJ);

         if (isset($_POST['delete'])) {
            $id = $_POST['id']; 

            $facture = $bdd->prepare("SELECT * FROM facture WHERE num_clt=?");
            $facture->execute(array($id));
            $clientExiste=$facture->rowCount();
            if ($clientExiste==0) {
                $delete_client = $bdd->prepare("DELETE FROM client WHERE num_clt=?");
                $delete_client->execute(array($id));

                $message="Le client a bien été supprimer avec succès";
                $sql = "SELECT * FROM client ORDER BY num_clt DESC ";
                $stmt = $bdd->prepare($sql);
                $stmt->execute();
                $clients = $stmt->fetchAll(PDO::FETCH_OBJ);
            }else{
                $message_er="Ce client est déjà rattaché au moin une facture";
            }
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
            <h1 class="h3 mb-0 text-gray-800">Gestion des clients</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Accueil</a></li>
              <li class="breadcrumb-item">Client</li>
              <li class="breadcrumb-item active" aria-current="page">Liste des clients</li>
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
              <?php if (isset($message_er)) { ?>
                  <div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                   <?php  echo $message_er; ?> 
                
                </div>
              <?php } ?>
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Liste des clients</h6>
                  <h6><a class="btn btn-primary" href="ajouter_client.php">Ajouter</a></h6>
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th>Date d'ajout</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Addresse</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    
                    <tbody>
                      <?php foreach ($clients as $client) : ?>
                            <tr>
                                <td class="col-md-2"><?php echo date('d/m/Y', strtotime($client->date_ajout)); ?></td>  
                                <td><?php echo $client->nomclt; ?></td> 
                                <td class="col-md-2"><?php echo $client->prenomclt; ?></td> 
                                <td class="col-md-2"><?php echo $client->adresseclt; ?></td>
                                <td class="col-md-2"><?php echo $client->contactclt; ?></td>
                                <td class="col-md-2"><?php echo $client->emailclt; ?></td> 
                                <td class="col-md-1">
                                    <a href="edit_client.php?num_clt=<?php echo $client->num_clt; ?>" class=""><i class="fas fa-edit"></i></a>
                                    <a href="#deleteProd.php?num_clt=<?php echo $client->num_clt; ?>"class="" data-toggle="modal"
                                        data-target="#exampleModalCenter<?php echo  $client->num_clt; ?>"><i class="fas fa-trash text-danger"></i></a>
                                   
                                </td> 
                            </tr>
                             <div class="modal fade" id="exampleModalCenter<?php echo $client->num_clt; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                      <div class="modal-content">
                                        <form method="POST" action="#">
                                          <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle"><i class="fas fa-trash text-danger"></i> Suppression d'un client</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                              <span aria-hidden="true">&times;</span>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                           Voulez-vous supprimer ce client : <?php echo $client->nomclt.' '.$client->prenomclt; ?> ?
                                            <input type="hidden" name="id" value="<?php echo $client->num_clt; ?>">
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn btn-primary" name="delete">Confirmer</button>
                                          </div>
                                        </form>
                                      </div>
                                    </div>
                                  </div>
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
    $(document).ready(function () {
      $('#dataTable').DataTable(); // ID From dataTable 
      $('#dataTableHover').DataTable(); // ID From dataTable with Hover
    });
  </script>

</body>

</html>