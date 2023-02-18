<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/soft.png" rel="icon">
  <title>G-FACTURE | Service</title>
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
    <script src="jquery.min.js"></script>
    <script type="text/javascript">
        
        $(function(){
          $('.formcom').submit(function() {
                pseudo = $(this).find("input[name=pseudo]").val();
                message = $(this).find("textarea[name=message]").val();
                nom = $(this).find("select[name=aa]").val();
                $.post("addCom.php", {pseudo: pseudo, com: message, nom: nom}, function(data){
                    if(data!="ok"){
                      $(".error").empty().append(data)
                    }else{
                        // $("#resultatAjax").hide().append("<p><input value="+pseudo+"><b>"+pseudo+"</b> :"+message+"</p>").slideDown();
                        $("#resultatAjax").hide().append("<tr><td><input value="+1+"></td>"+"<td><input value="+pseudo+"></td>"+"<td><input value="+message+"></td>"+"<td><input value="+message+"></td></tr>").slideDown();
                    }
                });
              
                return false;
            });
        });
    </script>
</head>

<body class="grey lighten-3">

    <!--Main Navigation-->
  
    <!--Main Navigation-->

    <!--Main layout-->
    <main class="pt-5 mx-lg-5">
        <div class="container-fluid mt-5">

           

            <!--Grid row-->
            <div class="row wow fadeIn">

                <!--Grid column-->
                <div class="col-md-12 mb-4">

                    <!--Card-->
                    <div class="card">

                        <!--Card content-->
                        <div class="card-body">
                            <?php 
                                $connect = new PDO("mysql:host=localhost;dbname=test", "root", "");
                                $comm=$connect->query("SELECT * FROM commentaire");

                            ?>
                           
                                <h1>Facture</h1>
                                <form action="" method="post">
                              
                                <table class="table table-hover">
                                <!-- Table head -->
                                    <thead class="blue lighten-4">
                                        <tr>
                                            <th>Designation</th>
                                            <th>Qté</th>
                                            <th>PU</th>
                                            <th>Montant</th>
                                        </tr>
                                    </thead>
                                    <!-- Table head -->

                                    <!-- Table body -->
                                    <tbody>
                                <?php while($aff = $comm->fetch()){?>
                                    <tr>
                                        <th scope="row"><?php echo $aff['pseudo'] ?></th>
                                        <td><input type="text" value="1"></td>
                                        <td><input type="text" value="<?php echo $aff['message'] ?>"></td>
                                        <td><input type="text" value="<?php echo $aff['message'] ?>"></td>
                                    </tr>
                                    <tr id="resultatAjax"></tr>
                                <?php } ?>
                                </tbody>
                                <!-- Table body -->
                            </table>
                                </form>
                                
                                  
                            
                            <!-- Table  -->
                            
                            <h1>Ajax</h1>
                            <div class="error" style="color:red; font-size: 10px;"></div>
                            <form action="#" method="post" class="formcom">
                                <label for="">Pseudo : </label> <input type="text" name="pseudo">
                                <p>Message :</p>
                                <textarea name="message" id="" cols="30" rows="10"></textarea>
                                <p>
                                    <select name="aa" id="">
                                            <option value="1">Aly</option>
                                            <option value="2">Moussa</option>
                                            <option value="3">Papa</option>
                                    </select>
                                </p>
                                <p><input type="submit" value="Commenter"></p>
                            </form>
                            <!-- Table  -->

                        </div>

                    </div>
                    <!--/.Card-->

                </div>
                <!--Grid column-->

                <!--Grid column-->
              
                <!--Grid column-->

            </div>
            <!--Grid row-->

            <!--Grid row-->


        </div>
    </main>
    <!--Main layout-->

    <!--Footer-->
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <footer class="page-footer text-center font-small primary-color-dark darken-2 mt-4 wow fadeIn">





        <!--Copyright-->
        <div class="footer-copyright py-3">
            © 2019 Copyright:
            <a href="https://mdbootstrap.com/education/bootstrap/" target="_blank"> MDBootstrap.com </a>
        </div>
        <!--/.Copyright-->

    </footer>
    <!--/.Footer-->

</body>

</html>