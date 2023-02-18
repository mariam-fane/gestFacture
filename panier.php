<?php 
session_start();
$nom="Panier"; 
if (!isset($_SESSION['id_user']) AND !isset($_SESSION['email_user'])) {
  header('Location:login.php');
} 
require_once('db.php');

$sql = "SELECT * FROM client ORDER BY num_clt DESC";
    $stmt = $bdd->prepare($sql);
    $stmt->execute();
    $Client = $stmt->fetchAll(PDO::FETCH_OBJ);

    if (isset($_POST['valider'])) {

        $date_fact = $_POST['date_fact'];
        $type_fact = $_POST['type_fact'];
        $client = $_POST['client'];

        $prix_ht = $_POST['prix_ht'];
        $taux_tva = $_POST['taux_tva'];
        $prix_ttc = $_POST['prix_ttc'];

        $insertFacture = $bdd->prepare("INSERT INTO facture(date_fact,type_fact,num_clt,ht,tva,ttc) VALUES(?,?,?,?,?,?)");
            $insertFacture->execute(array($date_fact,$type_fact,$client,$prix_ht,$taux_tva,$prix_ttc));

            $facture = $bdd->query("SELECT num_facture FROM facture ORDER BY num_facture DESC LIMIT 1");
            //var_dump($facture);
            $fact=$facture->fetch();

            $idfact=$fact['num_facture'];

            $count = count($_POST['qte']);

            for ($i=0; $i < $count ; $i++) { 
                $contenir = $bdd->prepare("INSERT INTO contenir(id_fact,id_article,prix,qte,montant) VALUES(?,?,?,?,?)");
                $contenir->execute(array($idfact,$_POST['id_article'][$i],$_POST['prix'][$i],$_POST['qte'][$i],$_POST['montant'][$i],));
            }
             unset($_SESSION['cart']);
             $message= 'Facture crée avec succès'.'<a href="facture_pdf.php?num_facture='.$idfact.'" target="_blank"> Imprimer la facture</a>';
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
        <div class="container-fluid" id="container-wrapper" style="">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Gestion des factures</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Accueil</a></li>
              <li class="breadcrumb-item">Facture</li>
              <li class="breadcrumb-item active" aria-current="page">Formulaire facture</li>
            </ol>
          </div>
           <?php if (isset($message)) { ?>
                  <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                   <?php  echo $message; ?> <a href="facture_pdf.php?num_facture=<?=$idfact ?>" target="_blank"> Imprimer la facture</a>
                
                </div>
          <?php } ?>
            <div class="">
                <form class="myForm" method="post" action="#">
                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                  <h6 class="m-0 font-weight-bold text-primary">Article</h6>
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
                                              <th>Action</th>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <?php 
                                            $total=0;
                                                if(isset($_SESSION['cart'])){ 
                                                  foreach ($_SESSION['cart'] as $key => $value) {  
                                                  $total += $value['prix'] ;
                                            ?>

                                            <tr>
                                              <td><?= $value['designation']?><input type="hidden" name="id_article[]" value="<?= $value['id']?>"></td>
                                              <td><input type="number" name="qte[]" value="1" class="qte"></td>
                                              <td align="right"><input type="number" name="prix[]" value="<?= $value['prix']?>" class="prix"></td>
                                               <td><input type="number" name="montant[]" value="<?= $value['prix']?>" class="montant" readonly></td>
                                                <td><a href="delete_panier.php?action=remove&id=<?= $value['id']?>" class="btn btn-danger btn-sm"><i class="fas fa-minus"></i></a></td>
                                            </tr>
                                            <?php }} ?>
                                            <tr>
                                                <td></td>
                                                <td>HT</td>
                                                <td></td>
                                                <td><input name="prix_ht" type="number" class="total" value="<?= $total?>" readonly></td>
                                                <td><a href="delete_panier.php?action=removeAll" class="btn btn-warning btn-sm">Vider tout</a></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>TVA</td>
                                                <td></td>
                                                <td><input name="taux_tva" type="number" class="" value="0"></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>TTC</td>
                                                <td></td>
                                                <td><input name="prix_ttc" type="number" class="" readonly></td>
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
                                            <option value="Facture">Facture</option>
                                            <option value="Facture Proforma">Facture Proforma</option>
                                          </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                          <label for="">Date : </label>
                                          <input type="date" class="form-control" name="date_fact" value="<?= date('Y-m-d') ?>" id="">
                                        </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                      <div class="col-lg-12">
                                          <div class="form-group">
                                            <label for="select2Single">Doit :</label>
                                            <select class="select2-single form-control" name="client" id="select2Single" required>
                                              <option value="">--Selection client --</option>
                                                <?php foreach ($Client as $clt) : ?>
                                                  <option value="<?php echo $clt->num_clt; ?>"><?php echo $clt->nomclt.' '.$clt->prenomclt.', contact :'.$clt->contactclt?></option>
                                                <?php  endforeach; ?> 
                                            </select>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                            </div>
                            <?php if(isset($_SESSION['cart'])){  ?>
                          <button type="submit" name="valider" class="btn btn-primary">Valider</button>
                        <?php } ?>
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
  <script>
    $(document).ready(function () {


      $('.select2-single').select2();

      // Select2 Single  with Placeholder
      $('.select2-single-placeholder').select2({
        placeholder: "Select a Province",
        allowClear: true
      });      

      // Select2 Multiple
      $('.select2-multiple').select2();

      // Bootstrap Date Picker
      $('#simple-date1 .input-group.date').datepicker({
        format: 'dd/mm/yyyy',
        todayBtn: 'linked',
        todayHighlight: true,
        autoclose: true,        
      });

      $('#simple-date2 .input-group.date').datepicker({
        startView: 1,
        format: 'dd/mm/yyyy',        
        autoclose: true,     
        todayHighlight: true,   
        todayBtn: 'linked',
      });

      $('#simple-date3 .input-group.date').datepicker({
        startView: 2,
        format: 'dd/mm/yyyy',        
        autoclose: true,     
        todayHighlight: true,   
        todayBtn: 'linked',
      });

      $('#simple-date4 .input-daterange').datepicker({        
        format: 'dd/mm/yyyy',        
        autoclose: true,     
        todayHighlight: true,   
        todayBtn: 'linked',
      });    

      // TouchSpin

      $('#touchSpin1').TouchSpin({
        min: 0,
        max: 100,                
        boostat: 5,
        maxboostedstep: 10,        
        initval: 0
      });

      $('#touchSpin2').TouchSpin({
        min:0,
        max: 100,
        decimals: 2,
        step: 0.1,
        postfix: '%',
        initval: 0,
        boostat: 5,
        maxboostedstep: 10
      });

      $('#touchSpin3').TouchSpin({
        min: 0,
        max: 100,
        initval: 0,
        boostat: 5,
        maxboostedstep: 10,
        verticalbuttons: true,
      });

      $('#clockPicker1').clockpicker({
        donetext: 'Done'
      });

      $('#clockPicker2').clockpicker({
        autoclose: true
      });

      let input = $('#clockPicker3').clockpicker({
        autoclose: true,
        'default': 'now',
        placement: 'top',
        align: 'left',
      });

      $('#check-minutes').click(function(e){        
        e.stopPropagation();
        input.clockpicker('show').clockpicker('toggleView', 'minutes');
      });

    });
  </script>
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
      if(taux_tva!=0){
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
  }


    $(function() // jQuery
    {
      $('.myForm input').bind('keyup mouseup', calcule_ht_ttc); // appel de la fonction de calcul lors d'un événement 'keyup' ou 'mouseup'
    });
</script>
</body>

