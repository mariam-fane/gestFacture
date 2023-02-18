<?php 
session_start();
require_once('db.php');
if (isset($_POST['valider'])) {
    echo $_POST['state'];
}

$sql = "SELECT * FROM client ORDER BY num_clt DESC";
    $stmt = $bdd->prepare($sql);
    $stmt->execute();
    $Client = $stmt->fetchAll(PDO::FETCH_OBJ);
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
              <li class="breadcrumb-item active" aria-current="page">Formulaire facture</li>
            </ol>
          </div>
          <form action="traitement.php" method="post">
            <div class="row">
                  <div class="col-lg-8">
                    <!-- Select2 -->
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
                                        <td><?= $value['designation']?></td>
                                        <td><input type="number" name="qte[]" value="1" class="qte"></td>
                                        <td align="right"><input type="number" name="prix[]" value="<?= $value['prix']?>" class="prix"></td>
                                         <td><input type="number" name="montant[]" value="<?= $value['prix']?>" class="montant" readonly></td>
                                          <td><a href="facture_create.php?action=remove&id=<?= $value['id']?>" class="btn btn-danger btn-sm"><i class="fas fa-minus"></i></a></td>
                                      </tr>
                                  <?php }} ?>
                                  <tr>
                                    <td></td>
                                    <td>HT</td>
                                    <td></td>
                                    <td><input type="number" name="total" value="<?= $total?>" class="total" readonly></td>
                                    <td></td>
                                  </tr>
                                   <tr>
                                    <td></td>
                                    <td>TVA</td>
                                    <td align="right"><input type="" name="tv" class="col-lg-5 qte"></td>
                                    <td><input type="number" name="tva" value="" class="tva" readonly></td>
                                    <td></td>
                                  </tr>
                                   <tr>
                                    <td></td>
                                    <td>TOTAL</td>
                                    <td></td>
                                    <td><input type="number" name="total" value="<?= $total?>" class="total" readonly></td>
                                    <td><a href="facture_create.php?action=removeAll" class="btn btn-warning btn-sm">Vider tout</a></td>
                                  </tr>
                                </tbody>
                              </table>  

                              <?php if (isset($_GET['action'])) {
                                  if ($_GET['action']=="removeAll") {
                                    unset($_SESSION['cart']);

                                  }
                                  if ($_GET["action"]=="remove") {
                                      foreach ($_SESSION['cart'] as $key => $value) {
                                        if ($value['id']==$_GET['id']) {
                                          unset($_SESSION['cart'][$key]);
                                        }
                                      }
                                  }
                              } ?>      
                          </div>
                      </div>
                    </div>

                  </div>
                  <div class="col-lg-4">
                    <!-- Select2 -->
                    <div class="card mb-4">
                      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Info facture</h6>
                      </div>
                     
                      <div class="card-body">
                         <div class="row">
                          <div class="col-lg-12">
                            <div class="form-group">
                            <label for="">Type de facture :</label>
                            <select class="form-control" name="state">
                              <option value="">--Type facture--</option>
                              <option value="2">Facture</option>
                              <option value="Sumatra Utara">Facture Proforma</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-lg-12">
                          <div class="form-group">
                          <label for="">Date : </label>
                          <input type="date" class="form-control" name="date_fact" id="">
                        </div>
                        </div>
                      </div>
                        
                      <div class="row">
                          <div class="col-lg-12">
                            <div class="form-group">
                            <label for="select2Single">Doit :</label>
                            <select class="select2-single form-control" name="state" id="select2Single">
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
                    <button type="submit" name="valider" class="btn btn-primary">Valider</button>
                  </div>
              
            </div>
          </form>
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
</body>

</html>
