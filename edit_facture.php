<?php 
session_start();
$nom="Facture"; 
if (!isset($_SESSION['id_user']) AND !isset($_SESSION['email_user'])) {
  header('Location:login.php');
} 
  if (isset($_GET['num_facture'])) {
   require_once('db.php');
   $facture = $bdd->prepare("SELECT * FROM facture WHERE num_facture=?");
   $facture->execute(array($_GET['num_facture']));
   $fact=$facture->fetch();

   

   $sql = "SELECT * FROM client ORDER BY num_clt DESC";
    $stmt = $bdd->prepare($sql);
    $stmt->execute();
    $Client = $stmt->fetchAll(PDO::FETCH_OBJ);

    $sql1 = "SELECT * FROM client WHERE num_clt=?";
    $stmt1 = $bdd->prepare($sql1);
    $stmt1->execute(array($fact['num_clt']));
    $Clientfact = $stmt1->fetch();

    $reqContentFacture = $bdd->prepare("SELECT * FROM contenir INNER JOIN produit ON produit.refProduit=contenir.id_article WHERE id_fact=?");
    $reqContentFacture->execute(array($_GET['num_facture']));
   

     
        if (isset($_POST['valider'])) {

              $date_fact = $_POST['date_fact'];
              $type_fact = $_POST['type_fact'];
              $client = $_POST['client'];

              $prix_ht = $_POST['prix_ht'];
              $taux_tva = $_POST['taux_tva'];
              $prix_ttc = $_POST['prix_ttc'];

              $miseenjourConge=$bdd->prepare("UPDATE facture SET 
                date_fact=:date_fact,
                type_fact=:type_fact,
                num_clt=:num_clt,
                ht=:ht,
                tva=:tva,
                ttc=:ttc
                WHERE num_facture=:id");

              $miseenjourConge->bindValue(':id',$_GET['num_facture'] );
              $miseenjourConge->bindValue(':date_fact',$_POST['date_fact'] );
              $miseenjourConge->bindValue(':type_fact',$_POST['type_fact'] );
              $miseenjourConge->bindValue(':num_clt',$_POST['client'] );
              $miseenjourConge->bindValue(':ht',$_POST['prix_ht'] );
              $miseenjourConge->bindValue(':tva',$_POST['taux_tva'] );
              $miseenjourConge->bindValue(':ttc',$_POST['prix_ttc'] );

              $miseenjourConge->execute();
              
              $sql2  = "UPDATE contenir SET qte=? WHERE id=?";
              $stmt2 = $bdd->prepare($sql2);

              $count = count($_POST['id_contenir']);
              for ($i=0; $i < $count ; $i++) { 
                $stmt2 = $bdd->prepare("UPDATE contenir SET qte=?,prix=?,montant=? WHERE id=?");
                $stmt2->execute(array($_POST['qte'][$i],$_POST['prix'][$i],$_POST['montant'][$i],$_POST['id_contenir'][$i]));
              }
              if ($miseenjourConge==true) {
                  $message="La facture a été modifiée avec succès";
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
            <h1 class="h3 mb-0 text-gray-800">Gestion des factures</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Accueil</a></li>
              <li class="breadcrumb-item">Facture</li>
              <li class="breadcrumb-item active" aria-current="page">Contenu d'une facture</li>
            </ol>
          </div>
            <?php if (isset($message)) { ?>
                  <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                   <?php  echo $message; ?> <a href="facture_pdf.php?num_facture=<?=$_GET['num_facture'] ?>" target="_blank"> Imprimer la facture</a>
                
                </div>
          <?php } ?>
            <div class="">
                <form class="myForm" method="post" action="">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                  <h6 class="m-0 font-weight-bold text-primary">Contenu de la facture N° : <?php if($fact['num_facture']<10){echo '0'.$fact['num_facture'];}else { echo $fact['num_facture']; } ?></h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                       <table class="table align-items-center">
                                          <thead class="thead-light">
                                            <tr>
                                             
                                              <th>Désignation</th>
                                              <th class="col-lg-1">Quantité</th>
                                              <th>Prix</th>
                                              <th>Montant</th>
                                              
                                            </tr>
                                          </thead>
                                          <tbody>
                                            
                                            <?php while($content = $reqContentFacture->fetch()){?>

                                            <tr>
                                              <td><?= $content['designation']?><input type="hidden" name="id_contenir[]" value="<?= $content['id']?>"></td>
                                              <td><input type="number" name="qte[]" value="<?= $content['qte']?>" class="qte" required></td>
                                              <td align="right"><input type="number" name="prix[]" value="<?= $content['prix']?>" class="prix" required></td>
                                              <td><input type="number" name="montant[]" value="<?= $content['montant']?>" class="montant" readonly></td>
                                            </tr>
                                            <?php } ?>
                                            <tr>
                                                <td></td>
                                                <td>HT</td>
                                                <td></td>
                                                <td><input name="prix_ht" type="number" class="total" value="<?= $fact['ht']?>" readonly></td>
                                                
                                            </tr>
                                           
                                            <tr>
                                                <td></td>
                                                <td>TVA</td>
                                                <td></td>
                                                <td><input name="taux_tva" type="number" class="" value="<?= $fact['tva']?>" ></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>TTC</td>
                                                <td></td>
                                                <td><input name="prix_ttc" type="number" class="" value="<?= $fact['ttc']?>" readonly></td>
                                                <td></td>
                                            </tr>
                                          
                                          </tbody>
                                       </table>
                                         
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card mb-4">
                              <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary">Info facture</h6>
                              </div>
                             
                              <div class="card-body">
                                 <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                          <label for="">Type de facture :</label>
                                          <select class="form-control" name="type_fact">
                                            <option value="<?php echo $fact['type_fact'] ?>"><?php echo $fact['type_fact'] ?></option>
                                            <option value="Facture">Facture</option>
                                            <option value="Facture Proforma">Facture Proforma</option>
                                          </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                          <label for="">Date : </label>
                                          <input type="date" class="form-control" name="date_fact" value="<?php echo $fact['date_fact'] ?>" id="">
                                        </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                      <div class="col-lg-12">
                                          <div class="form-group">
                                            <label for="select2Single">Doit :</label>
                                            <select class="select2-single form-control" name="client" id="select2Single" required>
                                              <option value="<?= $Clientfact['num_clt'] ?>"><?= $Clientfact['nomclt'].' '.$Clientfact['prenomclt'].', Contact '.$Clientfact['contactclt'] ?></option>
                                               <?php foreach ($Client as $clt) : ?>
                                                  <option value="<?php echo $clt->num_clt; ?>"><?php echo $clt->nomclt.' '.$clt->prenomclt.', contact :'.$clt->contactclt?></option>
                                                <?php  endforeach; ?> 
                                            </select>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                            </div>
                          
                           <button type="submit" name="valider" class="btn btn-primary">Valider</button>
                           <a href="facture.php" class="btn btn-primary">Liste des facture</a>
                      
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

<?php } ?>