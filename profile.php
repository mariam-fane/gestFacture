<?php
session_start(); 
$nom="Profile";
if (!isset($_SESSION['id_user']) AND !isset($_SESSION['email_user'])) {
  header('Location:login.php');
}
  require_once('db.php');
   if (isset($_POST['valider'])) {
      $nom_user = $_POST['nom_user'];
      $prenom_user = $_POST['prenom_user'];
      $email_user = $_POST['email_user'];
      $mdp_user = $_POST['mdp_user'];
      $mdp_user_conf = $_POST['mdp_user_conf'];


      if ($mdp_user==$mdp_user_conf) {
        $mdp_user_hash=sha1($mdp_user);

       
          $update_user=$bdd->prepare("UPDATE user SET 
              nom_user=:nom_user,
              prenom_user=:prenom_user,
               email_user=:email_user,
               mdp_user=:mdp_user
              WHERE id_user=:id");
               $update_user->bindValue(':id',$_SESSION['id_user']);
               $update_user->bindValue(':nom_user',$nom_user);
               $update_user->bindValue(':prenom_user',$prenom_user);
               $update_user->bindValue(':email_user',$email_user);
               $update_user->bindValue(':mdp_user',$mdp_user_hash);
               $update_user->execute();

               header('Location:logout.php');

      }else{
        $messag="Vos mots de passe ne se correspondent pas!";
      }
  }
 ?>
<!DOCTYPE html>
<html lang="en">



<body id="page-top">
  <div id="wrapper">
     <?php include('menu.php') ?>
    <!-- Sidebar -->

      <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
        <!-- TopBar -->
            <?php include('nave.php') ?>
      <!-- Register Content -->
          <div class="container-fluid" id="container-wrapper">
             <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="h3 mb-0 text-gray-800">Gestion de mon compte utilisateur</h1>
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="./">Accueil</a></li>
                  <li class="breadcrumb-item">Utilisateur</li>
                  <li class="breadcrumb-item active" aria-current="page">Ajouter un utilisateur</li>
                </ol>
              </div>
              <div class="container-login">
                <div class="row justify-content-center">
                  <div class="col-xl-10 col-lg-12 col-md-9">
                    <div class="card shadow-sm my-5">
                      <div class="card-body p-0">
                        <div class="text-center bg-info">
                            <h1 class="h4 text-gray-900 mb-4">Profile</h1>
                        </div>
                        <div class="row">

                          <div class="col-lg-12">
                            <div class="login-form">
                             
                              <form method="POST" action="">
                                <div class="form-group">
                                  <label>Nom</label>
                                  <input type="text" class="form-control" name="nom_user" value="<?php if(isset($nom_user)){ echo $nom_user;}else{ echo $_SESSION['nom_user'];} ?>" id="exampleInputFirstName" placeholder="Entrer votre nom" required>
                                  <?php if (isset($message)) { ?>
                                      <span class="text-danger"><?php echo $message; ?></span>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                  <label>Prénom</label>
                                  <input type="text" class="form-control" name="prenom_user" 
                                  value="<?php if(isset($prenom_user)){ echo $prenom_user;}else{ echo $_SESSION['prenom_user'];} ?>" id="exampleInputLastName" placeholder="Entrer votre prénom" required>
                                  <?php if (isset($message)) { ?>
                                      <span class="text-danger"><?php echo $message; ?></span>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                  <label>Email</label>
                                  <input type="email" class="form-control" name="email_user" 
                                  value="<?php if(isset($email_user)){ echo $email_user;}else{ echo $_SESSION['email_user'];}  ?>" id="exampleInputEmail" aria-describedby="emailHelp"
                                    placeholder="Entrer votre addresse email" required>
                                      <?php if (isset($message)) { ?>
                                      <span class="text-danger"><?php echo $message; ?></span>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                  <label>Mot de passe</label>
                                  <input type="password" class="form-control" name="mdp_user" value="<?php if(isset($mdp_user)){ echo $mdp_user;} ?>" id="exampleInputPassword" placeholder="Taper votre mot de passe" required maxlength="10" minlength="6">
                                </div>
                                <div class="form-group">
                                  <label>Confirmer le mot de passe</label>
                                  <input type="password" class="form-control" name="mdp_user_conf" value="<?php if(isset($mdp_user_conf)){ echo $mdp_user_conf;} ?>" id="exampleInputPasswordRepeat"
                                    placeholder="Rétaper votre mot de passe">
                                    <?php if (isset($messag)) { ?>
                                      <span class="text-danger"><?php echo $messag; ?></span>
                                    <?php } ?>
                                </div>
                                <div class="form-group">
                                  <button type="submit" name="valider" class="btn btn-primary ">Valider</button>
                                </div>
                               
                              </form>
                              
                            </div>
                          </div>
                           <!--  <div class="col-lg-4">
                                <div class="form-group">
                                  <label>Photo</label>
                                  <input type="file" name="photo" >
                                </div>
                                <div class="form-group">
                                  <img src="img/default.jpg" class="img-fluid" width="400">   
                                </div>
                            </div>      -->
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
      <!-- Register Content -->
        </div>
         <!-- Footer -->
       <?php include('footer.php') ?>
      <!-- Footer -->
      </div>
    </div>
  </div>
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
</body>

</html>