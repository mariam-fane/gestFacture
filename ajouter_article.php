<?php 
session_start(); 
$nom="Article";
if (!isset($_SESSION['id_user']) AND !isset($_SESSION['email_user'])) {
  header('Location:login.php');
} 
  
   require_once('db.php');
   
            
        if (isset($_POST['valider'])) {

              $designation = $_POST['designation'];
              $prix = $_POST['prix']; 
              
              $article = $bdd->prepare("SELECT * FROM produit WHERE designation=?");
              $article->execute(array($designation));
              $ArticleExiste=$article->rowCount();

              if ($ArticleExiste==0) {
                $isert_article=$bdd->prepare("INSERT INTO produit(designation,prix_intial) VALUES(?,?)");

                $isert_article->execute(array($designation,$prix));
                
                
                if ($isert_article==true) {
                    $message="La facture a été modifiée avec succès";
                }
              }else{
                 $message_er="Cet article existe déjà";
              }
          }

?>
<!DOCTYPE html>
<html lang="fr">
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
            <h1 class="h3 mb-0 text-gray-800">Gestion des articles</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Accueil</a></li>
              <li class="breadcrumb-item">Article</li>
              <li class="breadcrumb-item active" aria-current="page">Formulaire d'ajout</li>
            </ol>
          </div>
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
            <div class="">
                <form class="myForm" method="post" action="">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card mb-4">
                              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Création d'un article</h6>
                              </div>
                             
                              <div class="card-body">
                                 <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                          <label for="">Désignation</label>
                                          <input type="text" name="designation" value="" class="form-control" placeholder="Désignation" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                          <label for="">Prix </label>
                                          <input type="number" class="form-control" value="" name="prix" value="" placeholder="Prix" id="" required>
                                        </div>
                                    </div>
                                  </div>
                                
                              </div>
                            </div>
                          
                           <button type="submit" name="valider" class="btn btn-primary">Valider</button>
                           <a href="article.php" class="btn btn-primary">Liste des articles</a>
                      
                        </div>
                    </div>
                </form>
            </div>
          <!--Row-->
        </div>
        <!---Container Fluid-->
      </div>
     <?php include('footer.php') ?>
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <!-- Select2 -->
  <script src="vendor/select2/dist/js/select2.min.js"></script>
  <!-- Bootstrap Datepicker -->
  <script src="vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
  <!-- Bootstrap Touchspin -->
  <script src="vendor/bootstrap-touchspin/js/jquery.bootstrap-touchspin.js"></script>
  <!-- ClockPicker -->
  <script src="vendor/clock-picker/clockpicker.js"></script>
  <!-- RuangAdmin Javascript -->
  <script src="js/ruang-admin.min.js"></script>
  <!-- Javascript for this page -->
 
<script type="text/javascript">
    $('tbody').delegate('.qte,.prix,.tv','keyup',function(){
          var tr=$(this).parent().parent();
          var quantity=tr.find('.qte').val();
          var budget=tr.find('.prix').val();
          var amount=(quantity*budget);
          var tv=tr.find('.tv');
          tr.find('.montant').val(amount);
          tr.find('.tva').val(tv);
          total();  
          });
            function total(){
                var total=0;
                $('.montant').each(function(i,e){
                    var amount=$(this).val()-0;
                total +=amount;
            });
            $('.total').val(total);
          }
</script>
<script>
    function calcule_ht_ttc(event) // fonction de calcul
    {
      var prix_ht = $('input[name="prix_ht"]').val();
      var taux_tva  = $('input[name="taux_tva"]').val();
      var prix_ttc = $('input[name="prix_ttc"]').val();
      
      if(event.target.name=='prix_ttc')
      {
        var new_prix_ht = (prix_ttc/(1+taux_tva/100)).toFixed(0);   
        $('input[name="prix_ht"]').val(new_prix_ht);
      }
      else
      {
        if(taux_tva==0){
          $('input[name="prix_ttc"]').val("");
        }else{
            var new_prix_ttc = (prix_ht*(1+taux_tva/100)).toFixed(0);   
            $('input[name="prix_ttc"]').val(new_prix_ttc);
        }
       
      } 
    }


    $(function() // jQuery
    {
      $('.myForm input').bind('keyup mouseup', calcule_ht_ttc); // appel de la fonction de calcul lors d'un événement 'keyup' ou 'mouseup'
    });
</script>
</body>

