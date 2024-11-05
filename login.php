<?php
session_start(); 
if (isset($_SESSION['utilisateur_id'])) {

   if ($_SESSION['role'] == 'admin') {
       header("Location: admin/index.php");
   } else {
       header("Location: profile.php");
   }
   exit(); 
}

include 'DataBase.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $email = $_POST["email"];
        $password = $_POST["motspass"];
        if(!empty($email) && !empty($password)){

            $requete = $base_com->prepare("SELECT * FROM utilisateur WHERE emailUtilisateur = ?");
            $requete->execute([$email]);
            $utilisateur = $requete->fetch(PDO::FETCH_ASSOC);
            if($utilisateur){
            $cle= $utilisateur['password'];
            if (password_verify($password,$cle)) {
                $_SESSION['idUtilisateur'] = $utilisateur['idUtilisateur'];
                $_SESSION['nomUtilisateur'] = $utilisateur['nomUtilisateur'];
                $_SESSION['prenomUtilisateur'] = $utilisateur['prenomUtilisateur'];
                $_SESSION['emailUtilisateur'] = $utilisateur['emailUtilisateur'];
                $_SESSION['contactUtilisateur'] = $utilisateur['contactUtilisateur'];
                $_SESSION['photoUtilisateur'] = $utilisateur['photoUtilisateur'];
                $_SESSION['role'] = $utilisateur['role'];
                $_SESSION['dateAdd'] = $utilisateur['dateAdd'];
            
                if ($utilisateur['role'] == 'admin'){ 
                header("Location: admin/index.php");
                exit();
                }elseif($utilisateur['role'] == 'cm'){
                header("Location: accountant/index.php");
                exit();
                    }elseif($utilisateur['role'] == 'gs'){
                        header("Location: Gs/index.php");
                        exit();
                    }elseif($utilisateur['role'] == 'client'){
                        header("Location: conf.php");
                        exit();
                    }
                
            } else {
                $erreur = "Mot de passe incorrect.";
            }
            }else{
            $erreur = "Adresse email invalide";
            }
        }else{
            $erreur = "Tous les champs sont requis";
        }
    }
    
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="assets/images/logohecm.png" type="image/x-icon"/>
    <script defer src="assets/js/aplines.js"></script>
    <script src="assets/js/tailwind.js"></script>
    <link rel="stylesheet" href="assets/css/main.css">
    <link rel="stylesheet" type="text/css" href="assets/css/datatable.css">
    <script type="text/javascript" src="assets/js/jquery.js"></script>
    <script type="text/javascript" src="assets/js/datatable.js"></script>
    <title>E-Gest</title>
</head>
<body class="dark:bg-gray-800">
   
    <main>
        <div class="w-full  max-w-sm mx-auto overflow-hidden bg-gray-100 rounded-lg border-solid dark:border-2 border-green-400   mt-20 shadow-md dark:bg-gray-800">
            <div class="px-8 bg-[#e6ccb3] py-8">
                <div class="flex justify-center mx-auto">
                <h3 class="mt-3 text-xl font-medium text-center text-gray-600 dark:text-gray-200">Connectez-vous</h3>
                    <!--<a href="index.php"><img class="w-auto h-7 sm:h-10 rounded-lg" src="assets/images/logohecm.png" alt=""></a>-->
                </div>
        
                
        
               <!-- <p class="mt-1 text-center text-gray-500 dark:text-gray-400">Connectez-vous</p>-->
        
                <form class="w-full max-w-md" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <?php if (!empty($erreur)): ?>
                 <div class="flex w-full max-w-sm overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800 mt-4">
                        <div class="flex items-center justify-center w-12 bg-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                        </svg>
                        </div>

                        <div class="px-4 py-2 -mx-3">
                            <div class="mx-3">
                                <span class="font-semibold text-red-500 dark:text-red-400">Erreur</span>
                                <p class="text-sm text-gray-600 dark:text-gray-200 font-bold">
                                  <?php echo $erreur; ?>
                                </p>
                            </div>
                        </div>
                    </div>
               <?php endif; ?>                    
                <div>
                    <div class="relative flex items-center mt-2">
                        <span class="absolute">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mx-3 text-gray-400 dark:text-gray-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                        </span>

                        <input type="email" name="email" placeholder="john@example.com" class="block w-full py-2.5 text-gray-700 placeholder-gray-400/70 bg-white border border-gray-400 rounded-lg pl-11 pr-5 rtl:pr-11 rtl:pl-5 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-green-400 dark:focus:border-green-300 focus:ring-green-300 focus:outline-none focus:ring focus:ring-opacity-40">
                    </div>
                </div>
        
                    <div class="w-full mt-4">
                        <input type="password" name="motspass" class="block w-full px-4 py-2 mt-2 text-gray-700 placeholder-gray-400/70 bg-white border rounded-lg dark:bg-gray-800 dark:border-gray-400 dark:placeholder-gray-400 focus:border-green-400 dark:focus:border-green-300 focus:ring-opacity-40 focus:outline-none focus:ring focus:ring-green-300" type="Password" placeholder="Mots de passe" aria-label="Password" />
                    </div>
        
                    <div class="flex items-center justify-between mt-4">
                        <a href="#" class="text-sm text-gray-600 hover:text-green-700">Mot de passe oublié ?</a>
        
                        <button type="submit" class="px-6 py-2 text-sm font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-green-600 rounded-lg hover:bg-green-800 focus:outline-none focus:ring focus:ring-green-300 focus:ring-opacity-50">
                            Connexion
                        </button>
                    </div>
                </form>
            </div>
        
            <div class="flex items-center justify-center py-4 text-center bg-gray-50 dark:bg-gray-700">
                <span class="text-sm text-gray-600 dark:text-gray-200">Vous n'avez pas de compte </span>
        
                <a href="register.php" class="mx-2 text-sm font-bold text-green-600 dark:text-green-400 hover:underline">S'inscrire</a>
            </div>
        </div>
    </main>
</body>
</html>