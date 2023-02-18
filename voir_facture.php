<?php 
session_start();
  if (isset($_GET['num_facture'])) {
   require_once('db.php');
   $facture = $bdd->prepare("SELECT * FROM facture WHERE num_facture=?");
   $facture->execute(array($_GET['num_facture']));
   $fact=$facture->fetch();

   

   // $sql = "SELECT * FROM client ORDER BY num_clt DESC";
   //  $stmt = $bdd->prepare($sql);
   //  $stmt->execute();
   //  $Client = $stmt->fetchAll(PDO::FETCH_OBJ);

    $sql1 = "SELECT * FROM client WHERE num_clt=?";
    $stmt1 = $bdd->prepare($sql1);
    $stmt1->execute(array($fact['num_clt']));
    $Clientfact = $stmt1->fetch();

    $reqContentFacture = $bdd->prepare("SELECT * FROM contenir INNER JOIN produit ON produit.refProduit=contenir.id_article WHERE id_fact=?");
    $reqContentFacture->execute(array($_GET['num_facture']));
   

   // $c=$reqContentFacture->fetch();

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
                   <?php  echo $message; ?> <a href="" target="_blank"></a>
                
                </div>
          <?php } ?>
            <div class="">
                <form class="myForm" method="post" action="#">
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
                                              <td><?= $content['designation']?><input type="hidden" name="id_article[]" value="<?= $content['id']?>"></td>
                                              <td><input type="number" name="qte[]" value="<?= $content['qte']?>" class="qte" readonly></td>
                                              <td align="right"><input type="number" name="prix[]" value="<?= $content['prix']?>" class="prix" readonly></td>
                                              <td><input type="number" name="montant[]" value="<?= $content['montant']?>" class="montant" readonly></td>
                                            </tr>
                                            <?php } ?>
                                            <tr>
                                                <td></td>
                                                <td>HT</td>
                                                <td></td>
                                                <td><input name="prix_ht" type="number" class="total" value="<?= $fact['ht']?>" readonly></td>
                                                
                                            </tr>
                                            <?php if($fact['tva']>0){ ?>
                                            <tr>
                                                <td></td>
                                                <td>TVA</td>
                                                <td></td>
                                                <td><input name="taux_tva" type="number" class="" value="<?= $fact['tva']?>" readonly></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>TTC</td>
                                                <td></td>
                                                <td><input name="prix_ttc" type="number" class="" value="<?= $fact['ttc']?>" readonly></td>
                                                <td></td>
                                            </tr>
                                          <?php } ?>
                                          </tbody>
                                       </table>
                                         
                                    </div>
                                </div>
                            </div>
                           
                             
                            <!-- <?php 
                              // $number=3002;
                              //   $hyphen      = '-';
                              //   $conjunction = '  ';
                              //   $separator   = ' ';
                              //   $negative    = 'negative ';
                              //   $decimal     = ' point ';
                              //    $dictionary  = array(
                              //           0                   => 'Zero',
                              //           1                   => 'un',
                              //           2                   => 'deux',
                              //           3                   => 'trois',
                              //           4                   => 'quatre',
                              //           5                   => 'cinq',
                              //           6                   => 'Six',
                              //           7                   => 'sept',
                              //           8                   => 'huit',
                              //           9                   => 'neuf',
                              //           10                  => 'dix',
                              //           11                  => 'onze',
                              //           12                  => 'douze',
                              //           13                  => 'treize',
                              //           14                  => 'quatorze',
                              //           15                  => 'quinze',
                              //           16                  => 'seize',
                              //           17                  => 'dix sept',
                              //           18                  => 'dix huit',
                              //           19                  => 'dix neuf',
                              //           20                  => 'vingt',
                              //           21                  => 'vingt-un',
                              //           22                  => 'vingt-deux',
                              //           23                  => 'vingt-trois',
                              //           24                  => 'vingt-quatre',
                              //           25                  => 'vingt-cinq',
                              //           26                  => 'vingt-Six',
                              //           27                  => 'vingt-sept',
                              //           28                  => 'vingt-huit',
                              //           29                  => 'vingt-neuf',
                              //           30                  => 'trante',
                              //           31                  => 'trante-un',
                              //           32                  => 'trante-deux',
                              //           33                  => 'trante-trois',
                              //           34                  => 'trante-quatre',
                              //           35                  => 'trante-cinq',
                              //           36                  => 'trante-Six',
                              //           37                  => 'trante-sept',
                              //           38                  => 'trante-huit',
                              //           39                  => 'trante-neuf',
                              //           40                  => 'quarante',
                              //           41                  => 'quarante-un',
                              //           42                  => 'quarante-deux',
                              //           43                  => 'quarante-trois',
                              //           44                  => 'quarante-quatre',
                              //           45                  => 'quarante-cinq',
                              //           46                  => 'quarante-Six',
                              //           47                  => 'quarante-sept',
                              //           48                  => 'quarante-huit',
                              //           49                  => 'quarante-neuf',
                              //           50                  => 'cinquante',
                              //           51                  => 'cinquante-un',
                              //           52                  => 'cinquante-deux',
                              //           53                  => 'cinquante-trois',
                              //           54                  => 'cinquante-quatre',
                              //           55                  => 'cinquante-cinq',
                              //           56                  => 'cinquante-Six',
                              //           57                  => 'cinquante-sept',
                              //           58                  => 'cinquante-huit',
                              //           59                  => 'cinquante-neuf',
                              //           60                  => 'soixante',
                              //           61                  => 'soixante-un',
                              //           62                  => 'soixante-deux',
                              //           63                  => 'soixante-trois',
                              //           64                  => 'soixante-quatre',
                              //           65                  => 'soixante-cinq',
                              //           66                  => 'soixante-Six',
                              //           67                  => 'soixante-sept',
                              //           68                  => 'soixante-huit',
                              //           69                  => 'soixante-neuf',
                              //           70                  => 'soixante-dix',
                              //           71                  => 'soixante-onze',
                              //           72                  => 'soixante-douze',
                              //           73                  => 'soixante-treize',
                              //           74                  => 'soixante-quatorze',
                              //           75                  => 'soixante-quinze',
                              //           76                  => 'soixante-seize',
                              //           77                  => 'soixante-dix-sept',
                              //           78                  => 'soixante-dix-huit',
                              //           79                  => 'soixante-dix-neuf',
                              //           80                  => 'quartre-vingt',
                              //           81                  => 'quartre-vingt-un',
                              //           82                  => 'quartre-vingt-deux',
                              //           83                  => 'quartre-vingt-trois',
                              //           84                  => 'quartre-vingt-quatre',
                              //           85                  => 'quartre-vingt-cinq',
                              //           86                  => 'quartre-vingt-Six',
                              //           87                  => 'quartre-vingt-sept',
                              //           88                  => 'quartre-vingt-huit',
                              //           89                  => 'quartre-vingt-neuf',
                              //           90                  => 'quatre-vingt-dix',
                              //           91                  => 'quatre-vingt-onze',
                              //           92                  => 'quatre-vingt-douze',
                              //           93                  => 'quatre-vingt-treize',
                              //           94                  => 'quatre-vingt-quatorze',
                              //           95                  => 'quatre-vingt-quinze',
                              //           96                  => 'quatre-vingt-seize',
                              //           97                  => 'quatre-vingt-dix-sept',
                              //           98                  => 'quatre-vingt-dix-huit',
                              //           99                  => 'quatre-vingt-dix-neuf',
                              //           100                 => 'cent',
                              //           1000                => 'mille',
                              //           1000000             => 'million',
                              //           1000000000          => 'milliard',
                              //           1000000000000       => 'mille milliard',
                              //           1000000000000000    => 'Quadrillion',
                              //           1000000000000000000 => 'Quintillion'
                              //     );
                                
                              //       switch (true) {
                              //           case $number < 21:
                              //               $string = $dictionary[$number];
                              //               break;
                              //           case $number < 100:
                              //               $tens   = ((int) ($number / 10)) * 10;
                              //               $units  = $number;
                              //               $string = $dictionary[$tens];
                              //               if ($units) {
                              //                   $string = $dictionary[$units];
                              //               }
                              //               break;

                              //           case $number < 1000:
                              //               $hundreds  = $number / 100;
                              //               $remainder = $number % 100;
                                           
                              //               if($number==100){
                              //                   $string =  $dictionary[100];
                              //                   if ($remainder) 
                              //                   {
                              //                       $string = $dictionary[$number];
                              //                   }
                              //                }else if($number>=200){
                              //                   $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                              //                   if ($remainder) {
                              //                   $string .= $conjunction.$dictionary[$remainder];
                                                
                              //                   }
                              //                 }else{
                              //                   $string =$dictionary[100];
                              //                   if ($remainder) {
                              //                     $string .= $conjunction . $dictionary[$remainder];
                              //                   }
                              //               }
                              //                break;
                                            
                              //            default:
                              //           if($number==1000){
                              //               $baseUnit = pow(1000, floor(log($number, 1000)));
                              //               $numBaseUnits = (int) ($number / $baseUnit);
                              //               $remainder = $number % $baseUnit;
                              //               $string = $dictionary[$baseUnit];
                              //               if ($remainder) {
                              //                   $string .= $remainder < 100 ? $conjunction : $separator;
                              //                   $string .= $dictionary[$remainder];
                              //               }
                              //            }else if($number>=2000){
                              //               $baseUnit = pow(1000, floor(log($number, 1000)));
                              //               $baseUnit2 = pow(100, floor(log($number, 100)));
                              //               $baseUnit3 = pow(100, floor(log($number, 10000)));
                              //               $numBaseUnits = (int) ($number / $baseUnit);
                              //               $remainder = $number % $baseUnit;
                              //               $string = $dictionary[$numBaseUnits] . ' ' . $dictionary[$baseUnit];
                              //               if ($remainder) {
                              //                if($remainder<10){
                              //                   if(substr($remainder,1,2)<10){
                              //                     if(substr($remainder,1,1)!=1){
                              //                       $string .= $remainder < 100 ? $conjunction : $separator;
                              //                         $string .=$dictionary[substr($remainder,0,1)].' '.$dictionary[$baseUnit2].' '.$dictionary[substr($remainder,2,1)];
                              //                     }else{
                              //                        $string .= $remainder < 100 ? $conjunction : $separator;
                              //                        $string .=$dictionary[$baseUnit2].' '.$dictionary[substr($remainder,2,1)];
                              //                     }
                              //                   }else{
                              //                      if(substr($remainder,1,1)!=1){
                              //                         $string .= $remainder < 100 ? $conjunction : $separator;
                              //                         $string .=$dictionary[substr($remainder,0,1)].' '.$dictionary[$baseUnit2].' '.$dictionary[substr($remainder,1,2)];
                              //                     }else{
                              //                        $string .= $remainder < 100 ? $conjunction : $separator;
                              //                        $string .=$dictionary[$baseUnit2].' '.$dictionary[substr($remainder,1,2)];
                              //                     }
                              //                   }
                              //                 }else{
                              //                   if($remainder <100){
                              //                     $string .= $remainder < 100 ? $conjunction : $separator;
                              //                     $string .=$dictionary[substr($remainder,0,2)];
                              //                   }else if($remainder<1000){
                              //                       if(substr($remainder,0,1) >1){
                              //                            $string .= $remainder < 100 ? $conjunction : $separator;
                              //                            $string .=$dictionary[substr($remainder,0,1)].' '.$dictionary[$baseUnit3].' '.$dictionary[substr($remainder,0,2)];
                              //                       }else{
                              //                        $string .= $remainder < 100 ? $conjunction : $separator;
                              //                        $string .=$dictionary[$baseUnit3].' '.$dictionary[substr($remainder,0,2)];
                              //                       }
                              //                   }
                              //                 }
                              //             }
                              //            }
                              //            // else{
                              //            //      $baseUnit = pow(1000, floor(log($number, 1000)));
                              //            //    $numBaseUnits = (int) ($number / $baseUnit);
                              //            //    $remainder = $number % $baseUnit;
                              //            //    $string = $dictionary[$baseUnit];
                              //            //    if ($remainder) {
                              //            //        $string .= $remainder < 100 ? $conjunction : $separator;
                              //            //        $string .= $dictionary($remainder);
                              //            //    }
                              //            // }

                              //            // else if($number>=2000){
                              //            //    $hundreds  = $number / 1000;
                              //            //    $baseUnit = pow(1000, floor(log($number, 1000)));
                              //            //     $baseUnit2 = pow(100, floor(log($number, 100)));
                              //            //    $numBaseUnits = (int) ($number / $baseUnit);
                              //            //    $remainder = $number % $baseUnit;
                              //            //    $string = $dictionary[$numBaseUnits] . ' ' . $dictionary[$baseUnit];
                              //            //    if($number<2100){
                                               
                              //            //            $string .= $remainder < 100 ? $conjunction : $separator;
                              //            //            $string .= $dictionary[$remainder];
                                                    
                              //            //    }else if ($number<=2999) {
                              //            //          if(substr($number,1,1)==1){
                              //            //              $string = $dictionary[substr($number,0,1)].' '.$dictionary[$baseUnit].' '.$dictionary[$baseUnit2].' '.$dictionary[substr($number,2,2)];
                              //            //          }else{
                              //            //          $string = $dictionary[substr($number,0,1)].' '.$dictionary[$baseUnit].' '.$dictionary[substr($number,1,1)].' '.$dictionary[$baseUnit2].' '.$dictionary[substr($number,2,2)];
                              //            //    }
                              //            //  }
                              //            // }else{
                              //            //    $baseUnit2 = pow(100, floor(log($number, 100)));
                              //            //    $baseUnit = pow(1000, floor(log($number, 1000)));
                              //            //    $numBaseUnits = (int) ($number / $baseUnit);
                              //            //    $remainder = $number % $baseUnit;
                              //            //    $string = $dictionary[$baseUnit];
                              //            //    if ($remainder) {
                              //            //        $string .= $remainder < 100 ? $conjunction : $hyphen;
                              //            //        // $string .= $remainder < 100 ? $conjunction : $separator;
                              //            //        $string .= $dictionary[$remainder].;
                              //            //        // $string .= $dictionary[substr($number,1,1)].' '.$dictionary[$baseUnit2].' '.$dictionary[substr($number,2,2)];

                              //            //    }
                              //            // }
                              //               break;
                                       
                              //       }
                                
                              //      echo $string;
                              //      //echo $numBaseUnits.' m'.$baseUnit.' d '.$remainder;
                              //       // echo $string;

                                
                            ?> -->
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
                                            <option value=""><?php echo $fact['type_fact'] ?></option>
                                           <!--  <option value="Facture">Facture</option>
                                            <option value="Facture Proforma">Facture Proforma</option> -->
                                          </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                          <label for="">Date : </label>
                                          <input type="date" class="form-control" name="date_fact" value="<?php echo $fact['date_fact'] ?>" id="" readonly>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="row">
                                      <div class="col-lg-12">
                                          <div class="form-group">
                                            <label for="select2Single">Doit :</label>
                                            <select class="select2-single form-control" name="client" id="select2Single" required>
                                              <option value=""><?= $Clientfact['nomclt'].' '.$Clientfact['prenomclt'].', Contact '.$Clientfact['contactclt'] ?></option>
                                               <!--  <?php foreach ($Client as $clt) : ?>
                                                  <option value="<?php echo $clt->num_clt; ?>"><?php echo $clt->nomclt.' '.$clt->prenomclt.', contact :'.$clt->contactclt?></option>
                                                <?php  endforeach; ?>  -->
                                            </select>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                            </div>
                          
                          <a href="facture.php" name="valider" class="btn btn-primary">Liste des factures</a>
                      
                        </div>
                    </div>
                </form>
            </div>
             
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