<?php
session_start(); 
if (!isset($_SESSION['id_user']) AND !isset($_SESSION['email_user'])) {
  header('Location:login.php');
} 
  require('fpdf181/fpdf.php');
  require_once('db.php');
   $facture = $bdd->prepare("SELECT * FROM facture WHERE num_facture=?");
    $facture->execute(array($_GET['num_facture']));
    $fact=$facture->fetch(PDO::FETCH_OBJ);
    function convert_number_to_words($number) {
              $hyphen      = '-';
              $conjunction = '  ';
              $separator   = ' ';
              $negative    = 'negative ';
              $decimal     = ' point ';
              $dictionary  = array(
                  0                   => 'Zero',
                  1                   => 'un',
                  2                   => 'deux',
                  3                   => 'trois',
                  4                   => 'quatre',
                  5                   => 'cinq',
                  6                   => 'Six',
                  7                   => 'sept',
                  8                   => 'huit',
                  9                   => 'neuf',
                  10                  => 'dix',
                  11                  => 'onze',
                  12                  => 'douze',
                  13                  => 'treize',
                  14                  => 'quatorze',
                  15                  => 'quinze',
                  16                  => 'seize',
                  17                  => 'dix sept',
                  18                  => 'dix huit',
                  19                  => 'dix neuf',
                  20                  => 'vingt',
                  21                  => 'vingt-un',
                  22                  => 'vingt-deux',
                  23                  => 'vingt-trois',
                  24                  => 'vingt-quatre',
                  25                  => 'vingt-cinq',
                  26                  => 'vingt-Six',
                  27                  => 'vingt-sept',
                  28                  => 'vingt-huit',
                  29                  => 'vingt-neuf',
                  30                  => 'trante',
                  31                  => 'trante-un',
                  32                  => 'trante-deux',
                  33                  => 'trante-trois',
                  34                  => 'trante-quatre',
                  35                  => 'trante-cinq',
                  36                  => 'trante-Six',
                  37                  => 'trante-sept',
                  38                  => 'trante-huit',
                  39                  => 'trante-neuf',
                  40                  => 'quarante',
                  41                  => 'quarante-un',
                  42                  => 'quarante-deux',
                  43                  => 'quarante-trois',
                  44                  => 'quarante-quatre',
                  45                  => 'quarante-cinq',
                  46                  => 'quarante-Six',
                  47                  => 'quarante-sept',
                  48                  => 'quarante-huit',
                  49                  => 'quarante-neuf',
                  50                  => 'cinquante',
                  51                  => 'cinquante-un',
                  52                  => 'cinquante-deux',
                  53                  => 'cinquante-trois',
                  54                  => 'cinquante-quatre',
                  55                  => 'cinquante-cinq',
                  56                  => 'cinquante-Six',
                  57                  => 'cinquante-sept',
                  58                  => 'cinquante-huit',
                  59                  => 'cinquante-neuf',
                  60                  => 'soixante',
                  61                  => 'soixante-un',
                  62                  => 'soixante-deux',
                  63                  => 'soixante-trois',
                  64                  => 'soixante-quatre',
                  65                  => 'soixante-cinq',
                  66                  => 'soixante-Six',
                  67                  => 'soixante-sept',
                  68                  => 'soixante-huit',
                  69                  => 'soixante-neuf',
                  70                  => 'soixante-dix',
                  71                  => 'soixante-onze',
                  72                  => 'soixante-douze',
                  73                  => 'soixante-treize',
                  74                  => 'soixante-quatorze',
                  75                  => 'soixante-quinze',
                  76                  => 'soixante-seize',
                  77                  => 'soixante-dix-sept',
                  78                  => 'soixante-dix-huit',
                  79                  => 'soixante-dix-neuf',
                  80                  => 'quartre-vingt',
                  81                  => 'quartre-vingt-un',
                  82                  => 'quartre-vingt-deux',
                  83                  => 'quartre-vingt-trois',
                  84                  => 'quartre-vingt-quatre',
                  85                  => 'quartre-vingt-cinq',
                  86                  => 'quartre-vingt-Six',
                  87                  => 'quartre-vingt-sept',
                  88                  => 'quartre-vingt-huit',
                  89                  => 'quartre-vingt-neuf',
                  90                  => 'quatre-vingt-dix',
                  91                  => 'quatre-vingt-onze',
                  92                  => 'quatre-vingt-douze',
                  93                  => 'quatre-vingt-treize',
                  94                  => 'quatre-vingt-quatorze',
                  95                  => 'quatre-vingt-quinze',
                  96                  => 'quatre-vingt-seize',
                  97                  => 'quatre-vingt-dix-sept',
                  98                  => 'quatre-vingt-dix-huit',
                  99                  => 'quatre-vingt-dix-neuf',
                  100                 => 'cent',
                  1000                => 'mille',
                  1000000             => 'million',
                  1000000000          => 'milliard',
                  1000000000000       => 'mille milliard',
                  1000000000000000    => 'Quadrillion',
                  1000000000000000000 => 'Quintillion'
              );
             
              if (!is_numeric($number)) {
                  return false;
              }
             
              if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
                  // overflow
                  trigger_error(
                      'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                      E_USER_WARNING
                  );
                  return false;
              }
          
              if ($number < 0) {
                  return $negative . convert_number_to_words(abs($number));
              }
             
              $string = $fraction = null;
             
              if (strpos($number, '.') !== false) {
                  list($number, $fraction) = explode('.', $number);
              }
             
              switch (true) {
                  case $number < 21:
                      $string = $dictionary[$number];
                      break;
                  case $number < 100:
                      $tens   = ((int) ($number / 10)) * 10;
                      $units  = $number;
                      //$string = $dictionary[$tens];
                      if ($units) {
                          $string .= $dictionary[$units];
                      }
                      break;
                  case $number < 1000:
                      $hundreds  = $number / 100;
                      $remainder = $number % 100;
                     
                      if($number==100){
                          $string =  $dictionary[100];
                          if ($remainder) 
                          {
                              $string .= $conjunction . convert_number_to_words($remainder);
                          }
                       }else if($number>=200){
                          $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                          if ($remainder) {
                          $string .= $conjunction . convert_number_to_words($remainder);
                          
                          }
                      }else{
                          $string =$dictionary[100];
                          if ($remainder) {
                          $string .= $conjunction . convert_number_to_words($remainder);
                      }
                      }
                      break;
                      
                   default:
                   if($number==1000){
                      $baseUnit = pow(1000, floor(log($number, 1000)));
                      $numBaseUnits = (int) ($number / $baseUnit);
                      $remainder = $number % $baseUnit;
                      $string = $dictionary[$baseUnit];
                      if ($remainder) {
                          $string .= $remainder < 100 ? $conjunction : $separator;
                          $string .= convert_number_to_words($remainder);
                      }
                   }else if($number>=2000){
                       $baseUnit = pow(1000, floor(log($number, 1000)));
                      $numBaseUnits = (int) ($number / $baseUnit);
                      $remainder = $number % $baseUnit;
                      $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                      if ($remainder) {
                          $string .= $remainder < 100 ? $conjunction : $separator;
                          $string .= convert_number_to_words($remainder);
                      }
                   }else{
                        $baseUnit = pow(1000, floor(log($number, 1000)));
                      $numBaseUnits = (int) ($number / $baseUnit);
                      $remainder = $number % $baseUnit;
                      $string = $dictionary[$baseUnit];
                      if ($remainder) {
                          $string .= $remainder < 100 ? $conjunction : $separator;
                          $string .= convert_number_to_words($remainder);
                      }
                   }
                      break;
              }
             
              if (null !== $fraction && is_numeric($fraction)) {
                  $string .= $decimal;
                  $words = array();
                  foreach (str_split((string) $fraction) as $number) {
                      $words[] = $dictionary[$number];
                  }
                  $string .= implode(' ', $words);
              }
             
              return $string;
          }
          $arrete = convert_number_to_words($fact->ht+($fact->ht*$fact->tva/100));
    if(isset($_GET['num_facture'])){
        class myPDF extends FPDF{
        function factur($bdd){
           $factur = $bdd->prepare("SELECT * FROM facture WHERE num_facture=?");
           $factur->execute(array($_GET['num_facture']));
           $fac=$factur->fetch(PDO::FETCH_OBJ);
         }
          function header(){
            $this->SetFont('Arial','B',8);
            $this->Image('img/ente2.png',10,);
            // $this->Cell(4,5,utf8_decode(" "),2,0,'L');
            // $this->Cell(60,5,utf8_decode("DOIT : "),2,0,'L');
            $this->Ln();
          }
          function doit($bdd){
            $facture = $bdd->prepare("SELECT * FROM facture WHERE num_facture=?");
            $facture->execute(array($_GET['num_facture']));
            $fact=$facture->fetch(PDO::FETCH_OBJ);

            $client=$bdd->prepare("SELECT * FROM client WHERE num_clt=? ");
            $client->execute(array($fact->num_clt));
            $clt=$client->fetch(PDO::FETCH_OBJ);
            $this->SetFont('Times','B',16);
            $this->Cell(5,5,utf8_decode(" "),2,0,'L');
            $this->Cell(180,7,utf8_decode($fact->type_fact.' N° '.$fact->num_clt),1,0,'C');
            $this->Ln();
            $this->Ln();
            $this->SetFont('Times','B',11);
            $this->Cell(4,-100,utf8_decode(" "),2,0,'L');
            $this->Cell(140,5,utf8_decode("DOIT : ".$clt->nomclt." ".$clt->prenomclt),2,0,'L');
            $this->Cell(50,5,utf8_decode("Ségou, le : ".date('d/m/Y', strtotime($fact->date_fact))),2,0,'L');
           $this->Ln();

          }
          function footer(){
            $this->SetY(-18);
            $this->SetFont('Arial','',8);
            $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
          }
    
          function headerTable(){
              $this->Ln();
              $this->SetFont('Times','B',11);
              $this->Cell(5,5,' ',2,0,'C');
               $this->Cell(85,5,'DESIGNATION',1,0,'C');
              $this->Cell(15,5,'QTE',1,0,'C');
              $this->Cell(35,5,'P.U',1,0,'C');
              $this->Cell(45,5,'MONTANT',1,0,'C');
             
              $this->Ln();
          }
          
          function viewTable($bdd){
                $facture = $bdd->prepare("SELECT * FROM facture WHERE num_facture=?");
                $facture->execute(array($_GET['num_facture']));
                $fact=$facture->fetch(PDO::FETCH_OBJ);

                $content=$bdd->prepare("SELECT * FROM contenir 
                INNER JOIN produit ON produit.refProduit=contenir.id_article
                WHERE contenir.id_fact=?
                ORDER BY contenir.id DESC");
                $content->execute(array($_GET['num_facture']));

                while($resultats=$content->fetch(PDO::FETCH_OBJ)){
                    $this->SetFont('Times','',11);
                    $this->Cell(5,7,' ',2,0,'L');
                    $this->Cell(85,7,utf8_decode($resultats->designation),1,0,'L');
                    $this->Cell(15,7,utf8_decode($resultats->qte),1,0,'C');
                    $this->Cell(35,7,utf8_decode(number_format($resultats->prix, 2, ',', ' ').' FCFA'),1,0,'R');
                    $this->Cell(45,7,utf8_decode(number_format($resultats->montant, 2, ',', ' ').' FCFA'),1,0,'R');
                   
                    // $this->Cell(15,5, date('d-m-Y', strtotime($resultats->date_absence)),1,0,'C');
                    // $this->Cell(15,5, date('d-m-Y', strtotime($resultats->date_retour)),1,0,'C');
              
              $this->Ln(); 
            }
                    $this->SetFont('Times','B',11);
                    $this->Cell(5,7,' ',2,0,'L');
                    $this->Cell(85,7,'',2,0,'L');
                    $this->Cell(15,7,utf8_decode(""),2,0,'C');
                    $this->Cell(35,7,utf8_decode("HT"),1,0,'R');
                    $this->Cell(45,7,utf8_decode(number_format($fact->ht, 2, ',', ' ').' FCFA'),1,0,'R');
                    $this->Ln(); 
                    $this->Cell(5,7,' ',2,0,'L');
                    $this->Cell(85,7,'',2,0,'L');
                    $this->Cell(15,7,utf8_decode(""),2,0,'C');

                    $this->Cell(35,7,utf8_decode("TVA ".$fact->tva.'%'),1,0,'R');
                    $this->Cell(45,7,utf8_decode(number_format($fact->ht*$fact->tva/100, 2, ',', ' ').' FCFA'),1,0,'R');
                    $this->Ln(); 
                    $this->Cell(5,7,' ',2,0,'L');
                    $this->Cell(85,7,'',2,0,'L');
                    $this->Cell(15,7,utf8_decode(""),2,0,'C');
                    $this->Cell(35,7,utf8_decode("TTC"),1,0,'R');
                    $this->Cell(45,7,utf8_decode(number_format($fact->ht+($fact->ht*$fact->tva/100), 2, ',', ' ').' FCFA'),1,0,'R');

          }
          function typefact($fact){
                $this->SetFont('Times','B',8);
                $this->Ln();
                 $this->Ln(); 
                $this->Cell(5,7,'',2,0,'L');
                $this->Cell(65,7,utf8_decode('Arrêté le présente '. $fact->type_fact.' à la somme de :'),2,0,'L');
          }
           function arrete($arrete){
                $this->SetFont('Times','',8);
                $this->Cell(5,7,$arrete.' Francs CFA',2,0,'L');
          }
               
          
          
          function signature($fact){

                $this->Ln(); 
                $this->Ln();
                $this->Ln(); 
                $this->Ln(); 
                $this->Cell(5,7,'',2,0,'L');
                if($fact->type_fact=='Facture'){
                $this->Cell(50,7,'POUR ACQUIT',2,0,'L');
                }else{
                  $this->Cell(50,7,' ',2,0,'L');
                }
                $this->Cell(105,7,'',2,0,'L');
                $this->Cell(85,7,'SOFTECH',2,0,'L');
          }

      } 
  }
  
$pdf= new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->doit($bdd);
$pdf->headerTable();
$pdf->viewTable($bdd);
$pdf->typefact($fact);
$pdf->arrete($arrete);
$pdf->signature($fact);
$pdf->Output();

 ?>
