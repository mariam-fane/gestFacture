<?php 
    extract($_POST);
    var_dump($pseudo);
    // $pseudo = $_POST['pseudo'];
    // $com = $_POST['message'];
    // $nom = $_POST['aa'];
    //print_r($nom);
    if(isset($pseudo) && !empty($pseudo)){
        $connect = new PDO("mysql:host=localhost;dbname=test", "root", "");
        $insertCom = $connect->prepare("INSERT INTO commentaire(pseudo,message,nom) VALUES(?,?,?)");
        $insertCom->execute(array($pseudo,$com,$nom));
        echo "ok";
    }else{
        echo "Vous n'avez pas tapé de pseudo";
    }

    
?>