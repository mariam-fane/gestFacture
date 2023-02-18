<?php  
session_start(); 
require_once('db.php');
  if (isset($_POST['login'])) {
    if (isset($_POST['email'])
       AND isset($_POST['mdp'])) {
        if (!empty($_POST['email'])
         AND !empty($_POST['mdp'])) {
          $email=htmlspecialchars($_POST['email']);
          $mdp=sha1($_POST['mdp']);

          $reqUser=$bdd->prepare('SELECT id_user,droit_user,nom_user,prenom_user,email_user, mdp_user FROM user WHERE email_user=? AND mdp_user=?');
            $reqUser->execute(array($email, $mdp));
            $UserExist=$reqUser->rowCount();
           if ($UserExist==1) {
                  
                  $reqUserInfo=$reqUser->fetch();
                    $_SESSION['id_user']=$reqUserInfo['id_user'];
                        $_SESSION['droit_user']=$reqUserInfo['droit_user'] ;
                        $_SESSION['email_user']=$reqUserInfo['email_user'];
                        $_SESSION['nom_user']=$reqUserInfo['nom_user'];
                        $_SESSION['prenom_user']=$reqUserInfo['prenom_user'];
                         header('Location:index.php');
                      }
                      else{
                        $msg1="Mauvais mot de passe ou adresse email!";
                      }
       
        }
        else{
           $msg="Veuillez remplir tous les champs!";
        }
    }
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/soft.png" rel="icon">
  <title>G-FACTURE | Login</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-login">
  <!-- Login Content -->
  <div class="container-login">
    <div class="row justify-content-center">
      <div class="col-xl-3 col-lg-6 col-md-8 mt-5">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">ESPACE DE CONNEXION</h1>
                  </div>
                  <form class="user" action="#" method="post">
                    <div class="form-group">
                      <input type="email" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp"
                        placeholder="Entrer addresse email" name="email" value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>" required>
                        
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control" id="exampleInputPassword" placeholder="Mot de passe" name="mdp"  value="<?php if(isset($_POST['mdp'])){echo $_POST['mdp'];} ?>" required>
                       <?php if (isset($msg1)) { ?>
                          <span class="text-danger"><?php echo $msg1; ?></span>
                        <?php } ?>
                    </div>
                   
                    <div class="form-group">
                      <button type="submit" name="login" class="btn btn-primary btn-block">Se connecter</buttonu>
                    </div>
                  </form>
                  <hr>
                  <div class="text-center">
                    <a class="font-weight-bold small" href="#">G-FACTURE</a>
                  </div>
                  <div class="text-center">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Login Content -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
</body>

</html>