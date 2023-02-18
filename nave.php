<nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
          <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <ul class="navbar-nav ml-auto">
              <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link" href="panier.php" id="" role="button"
                  aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-shopping-cart"></i>
                  <span class="badge badge-danger badge-counter"><?php if(isset($_SESSION['cart']) && count($_SESSION['cart'])>0){ echo count($_SESSION['cart']); }else{echo "0";}?></span>
                </a>
              
              </li>
           
            
            <div class="topbar-divider d-none d-sm-block"></div>
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <img class="img-profile rounded-circle" src="img/default.jpg" style="max-width: 60px">
                <span class="ml-2 d-none d-lg-inline text-white small"><?php if (isset($_SESSION['id_user'])) { echo $_SESSION['nom_user'].' '.$_SESSION['prenom_user']; } ?></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="profile.php">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Se déconnecter
                </a>
              </div>
            </li>
          </ul>
        </nav>