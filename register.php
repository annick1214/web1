<?php 
session_start(); 
    if (isset($_SESSION['idUtilisateur'])) {

        if ($_SESSION['role'] == 'gs') {
            header("Location: Gs/index.php");
        } elseif($_SESSION['role'] == 'cm') {
            header("Location: accountant/index.php");
        }elseif($_SESSION['role'] == 'admin') {
         header("Location: admin/index.php");
        }elseif($_SESSION['role'] == 'client'){
         header("Location: index.php");
        }
        exit(); 
     }
     
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $nom = strtoupper(htmlspecialchars($_POST["nom"]));
        $prenom = htmlspecialchars($_POST["prenom"]);
        $email = htmlspecialchars($_POST["email"]);
        $tel = htmlspecialchars($_POST["tel"]);
        $password = htmlspecialchars($_POST["motspass"]);
        $confpassword = htmlspecialchars($_POST["confmotspass"]);

        if(!empty($nom) && !empty( $prenom) && !empty($email) && !empty($tel) && !empty($password) && !empty($confpassword)){

            if($password !== $confpassword) {
                $erreur = "Veuillez confirmer vos mots de passe !";
            }else {
   
         $hashed_password = password_hash($password, PASSWORD_DEFAULT);
   
   
         include 'Database.php';
   
           try {
   
               $requete_existence = $base_com->prepare("SELECT emailUtilisateur FROM utilisateur WHERE emailUtilisateur = ?");
               $requete_existence->execute([$email]);
               $resultat = $requete_existence->fetch();
   
               if ($resultat) {
                   $erreur = "Cet utilisateur existe déjà !";
               } else {
   
                  $requete_insertion = $base_com->prepare("INSERT INTO utilisateur (nomUtilisateur, prenomUtilisateur, emailUtilisateur, contactUtilisateur, password, dateAdd) VALUES (?, ?, ?, ?, ?,NOW())");
                   $requete_insertion->execute([$nom, $prenom, $email, $tel,$hashed_password]);
   
                   $message = "Inscription réussie $prenom $nom <a class='text-blue-400' href='login.php'> Se connecter ici</a>";
               }
           } catch (PDOException $e) {
               $erreur = "Erreur lors de la connexion à la base de données : " . $e->getMessage();
           }
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
        <div class="w-full max-w-sm mx-auto overflow-hidden bg-gray-100 rounded-lg border-solid dark:border-2 border-green-400   mt-20 shadow-md dark:bg-gray-800 mb-20">
            <div class=" bg-[#e6ccb3] px-8 py-8">
                <form class="w-full max-w-md" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="flex justify-center mx-auto">
                    <h3 class="mt-3 text-xl font-medium text-center text-gray-600 dark:text-gray-200">Inscrivez-vous</h3>
                        <!--<a href="index.php"><img class="w-auto h-7 sm:h-10 rounded-lg" src="assets/images/logohecm.png" alt=""></a>-->
                    </div>
                        
                    <!--<p class="mt-1 text-center text-gray-500 dark:text-gray-400">Inscrivez-vous</p>-->
                    <?php if (!empty($message)): ?>
                    <div class="flex w-full max-w-sm overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <div class="flex items-center justify-center w-12 bg-emerald-500">
                            <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z" />
                            </svg>
                        </div>

                        <div class="px-4 py-2 -mx-3">
                            <div class="mx-3">
                                
                                <p class="text-sm text-gray-600 dark:text-gray-200 font-bold"><?php echo $message; ?></p>
                            </div>
                        </div>
                    </div>
               <?php endif; ?>
               <?php if (!empty($erreur)): ?>
                 <div class="flex w-full max-w-sm overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800 mt-4">
                        <div class="flex items-center justify-center w-12 bg-red-500">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 ">
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

                    <div class="relative flex items-center mt-4">
                        <span class="absolute">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-3 text-gray-300 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </span>
        
                        <input type="text" name="nom" class="block w-full py-3 text-gray-700 bg-white border rounded-lg px-11 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-green-400 dark:focus:border-green-300 focus:ring-green-300 focus:outline-none focus:ring focus:ring-opacity-40" placeholder="Nom">
                    </div>

                    <div class="relative flex items-center mt-4">
                        <span class="absolute">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-3 text-gray-300 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </span>
        
                        <input type="text" name="prenom" class="block w-full py-3 text-gray-700 bg-white border rounded-lg px-11 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-green-400 dark:focus:border-green-300 focus:ring-green-300 focus:outline-none focus:ring focus:ring-opacity-40" placeholder="Prénom">
                    </div>

                    <div class="relative flex items-center mt-4">
                        <span class="absolute">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mx-3 text-gray-300 dark:text-gray-500   ">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                        </svg>
                        </span>
        
                        <input type="tel" name="tel" class="block w-full py-3 text-gray-700 bg-white border rounded-lg px-11 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-green-400 dark:focus:border-green-300 focus:ring-green-300 focus:outline-none focus:ring focus:ring-opacity-40" placeholder="Téléphone">
                    </div>
        
                    <div class="relative flex items-center mt-4">
                        <span class="absolute">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-3 text-gray-300 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </span>
        
                        <input type="email" name="email" class="block w-full py-3 text-gray-700 bg-white border rounded-lg px-11 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-green-400 dark:focus:border-green-300 focus:ring-green-300 focus:outline-none focus:ring focus:ring-opacity-40" placeholder="Adresse email">
                    </div>
        
                    <div class="relative flex items-center mt-4">
                        <span class="absolute">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-3 text-gray-300 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </span>
        
                        <input type="password" name="motspass" class="block w-full px-10 py-3 text-gray-700 bg-white border rounded-lg dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-green-400 dark:focus:border-green-300 focus:ring-green-300 focus:outline-none focus:ring focus:ring-opacity-40" placeholder="Mots de passe ">
                    </div>
        
                    <div class="relative flex items-center mt-4">
                        <span class="absolute">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-3 text-gray-300 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </span>
        
                        <input type="password" name="confmotspass" class="block w-full px-10 py-3 text-gray-700 bg-white border rounded-lg dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-green-400 dark:focus:border-green-300 focus:ring-green-300 focus:outline-none focus:ring focus:ring-opacity-40" placeholder="Confirmer votre mots passe">
                    </div>
        
                    <div class="flex items-center justify-between mt-4">        
                        <button type="submit" class="px-6 py-2 m-auto text-sm font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-green-600 rounded-lg hover:bg-green-800 focus:outline-none focus:ring focus:ring-green-300 focus:ring-opacity-50">
                            S'inscrire
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="flex items-center justify-center py-4 text-center bg-gray-50 dark:bg-gray-700">
                <span class="text-sm text-gray-600 dark:text-gray-200">Déjà inscrit ? </span>
        
                <a href="login.php" class="mx-2 text-sm font-bold text-green-600 hover:underline">Connexion</a>
            </div>
        </div>
    </main>
</body>
</html>