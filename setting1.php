<?php
    session_start();
    include '../DataBase.php';
    if ($_SESSION['role'] !== "admin") {
        header("Location: ../login.php");
        exit();
    }

    $id =  $_SESSION['idUtilisateur'];
    $nom = $_SESSION['nomUtilisateur'];
    $prenom = $_SESSION['prenomUtilisateur'];
    $email = $_SESSION['emailUtilisateur'];
    $tel = $_SESSION['contactUtilisateur'];
    $pp = $_SESSION['photoUtilisateur'];
    $role = $_SESSION['role'];
    $dateAdd = $_SESSION['dateAdd'];

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['mofconf'])) {
        $nomm = strtoupper($_POST['nom']);
        $prenomm = $_POST['prenom'];
        $emailm = $_POST['email'];
        $contactm =$_POST['contact'];
        $pp = $_SESSION['photoUtilisateur'] ? $_SESSION['photoUtilisateur'] : null;
    if(!empty($nomm) && !empty($prenomm) && !empty($emailm) && !empty($contactm)){
        
      
    if (isset($_FILES['photoUtilisateur']) && $_FILES['photoUtilisateur']['error'] === UPLOAD_ERR_OK) {
        $destination_folder = '../PPuser/';
        if (!file_exists($destination_folder)) {
            mkdir($destination_folder, 0777, true);
        }

        $img_name = $_SESSION['idUtilisateur'] . '_' . basename($_FILES['photoUtilisateur']['name']);
        $img_path = $destination_folder . $img_name;
        if (move_uploaded_file($_FILES['photoUtilisateur']['tmp_name'], $img_path)) {
            $pp = $img_path;
            $_SESSION['photoUtilisateur'] = $pp;
        } else {
            $erreur = "Erreur lors du téléchargement de l'image.";
        }
    }

    if (empty($erreur)) {

        $requete = $base_com->prepare("UPDATE utilisateur SET nomUtilisateur = ?, prenomUtilisateur = ?, emailUtilisateur = ?, contactUtilisateur = ?, photoUtilisateur = ? WHERE idUtilisateur = ?");

        $requete->execute([$nomm, $prenomm, $emailm, $contactm, $pp, $_SESSION['idUtilisateur']]);

        $message = "modification réussie";
        echo"<script>
        setTimeout(function(){
            window.location.href = 'confi.php';
        }, 1000); 
       </script> ";
        $_SESSION['nomUtilisateur'] = $nomm;
        $_SESSION['prenomUtilisateur'] = $prenomm;
        $_SESSION['emailUtilisateur'] = $emailm;
        $_SESSION['contactUtilisateur'] = $contactm;
        $_SESSION['photoUtilisateur'] = $pp;
    
   
    }
} else{
    $erreur = "Tous les champs sont requis";
 }  
}

?>
