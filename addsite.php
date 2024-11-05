<?php
    include 'setting.php';

    if (isset($_POST['addSite'])) {

        $nom = strtoupper(htmlspecialchars($_POST["nomSite"]));
       /* $email = htmlspecialchars($_POST["emailSite"]);
        $tel = htmlspecialchars($_POST["telSite"]);
        $adresse = htmlspecialchars($_POST["adresseSite"]);*/

        /*if (isset($_FILES['coverSite']) && $_FILES['coverSite']['error'] === UPLOAD_ERR_OK) {
            $destination_folder = '../PPsite/';
            if (!file_exists($destination_folder)) {
                mkdir($destination_folder, 0777, true);
            }

            $img_name =  $nom.basename($_FILES['coverSite']['name']);
            $img_path = $destination_folder . $img_name;
            if (move_uploaded_file($_FILES['coverSite']['tmp_name'], $img_path)) {
                $pp = $img_path;
            } else {
                $erreur = "Erreur lors du téléchargement de l'image.";
            }
        }*/

        if(!empty($nom)/* && !empty($email) && !empty($tel) && !empty($adresse)*/){
   
           try {
   
               $requete_existence = $base_com->prepare("SELECT nomSite FROM site WHERE nomSite = ?");
               $requete_existence->execute([$nom]);
               $resultat = $requete_existence->fetch();
   
               if ($resultat) {
                   $erreur = "Cette classe existe déjà !";
               } else {
   
                  $requete_insertion = $base_com->prepare("INSERT INTO site (nomSite, /*emailSite, contactSIte, adresseSite, cover,*/ dateCreat) VALUES ( ?,NOW())");
                   $requete_insertion->execute([$nom, /*$email, $tel,$adresse,$pp*/]);
   
                   $message = "Nouvelle classe ajouté avec succès ";
               }
           } catch (PDOException $e) {
               $erreur = "Erreur lors de la connexion à la base de données : " . $e->getMessage();
           }
       }
      else{
         $erreur = "Tous les champs sont requis";
      }
    }
   
   
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN - E-Gest</title>


    <!-- Sidebar -->
            <?php 
             include 'header.php';
            ?>
                          <div class="flex items-center py-4 overflow-x-auto whitespace-nowrap">
                        <!--<a href="index.php" class="text-gray-600 dark:text-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                            </svg>
                        </a>-->
                    
                        <span class="mx-5 text-gray-500 dark:text-gray-300 rtl:-scale-x-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    
                        <a href="index1.php" class="flex items-center text-gray-600 -px-2 dark:text-gray-200 hover:underline">
                        <!--<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                  </svg>-->
                    
                            <span class="">Classe disponible</span>
                           <!-- <span class="mx-5 text-gray-500 dark:text-gray-300 rtl:-scale-x-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                           <span class="mx-2">Nouvelle Classe</span>-->

                        </a>
                    </div>               
        <div class="w-full max-w-sm mx-auto overflow-hidden bg-gray-300 rounded-lg border-solid dark:border-2 border-green-400   mt-20 shadow-md dark:bg-gray-800 mb-20">
            <div class="px-8 py-8">
                <form class="w-full max-w-md" method="POST" action="addsite.php" enctype="multipart/form-data">               
                    <h1 class="mt-1 text-center text-gray-500 dark:text-gray-400 pb-5"><span class="text-green-800 font-bold" >Ajouter une nouvelle classe</span> </h1>
                    <?php if (!empty($message)): ?>
                    <div class="flex w-full max-w-sm overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <div class="flex items-center justify-center w-12 bg-emerald-500">
                            <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z" />
                            </svg>
                        </div>

                        <div class="px-4 py-2 -mx-3">
                            <div class="mx-3">
                                <span class="font-semibold text-emerald-500 dark:text-emerald-400">Classe ajouté avec succès </span>
                                <!--<p class="text-sm text-gray-600 dark:text-gray-200 font-bold"><?php echo $message; ?></p>-->
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
                   <!-- <div class="relative flex items-center mt-4">
                        <input type="file" name="coverSite" class="block w-50 px-3 py-2 mt-2 text-sm text-gray-600 bg-white border border-gray-200 rounded-lg file:bg-gray-200 file:text-gray-700 file:text-sm file:px-4 file:py-1 file:border-none file:rounded-full dark:file:bg-gray-800 dark:file:text-gray-200 dark:text-gray-300 placeholder-gray-400/70 dark:placeholder-gray-500 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 dark:border-gray-600 dark:bg-gray-900 dark:focus:border-blue-300" />
                    </div>-->
                    <div class="relative flex items-center mt-4">
                        <span class="absolute">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6  mx-3 text-gray-300 dark:text-gray-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                        </svg>

                        </span>
        
                        <input type="text" name="nomSite" class="block w-full py-3 text-gray-700 bg-white border rounded-lg px-11 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-green-400 dark:focus:border-green-300 focus:ring-green-300 focus:outline-none focus:ring focus:ring-opacity-40" placeholder="Nom">
                    </div>


                    <!--<div class="relative flex items-center mt-4">
                        <span class="absolute">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mx-3 text-gray-300 dark:text-gray-500   ">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                        </svg>
                        </span>
        
                        <input type="text" name="telSite" class="block w-full py-3 text-gray-700 bg-white border rounded-lg px-11 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-green-400 dark:focus:border-green-300 focus:ring-green-300 focus:outline-none focus:ring focus:ring-opacity-40" placeholder="Téléphone">
                    </div>-->
        
                    <!--<div class="relative flex items-center mt-4">
                        <span class="absolute">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-3 text-gray-300 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </span>
        
                        <input type="email" name="emailSite" class="block w-full py-3 text-gray-700 bg-white border rounded-lg px-11 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-green-400 dark:focus:border-green-300 focus:ring-green-300 focus:outline-none focus:ring focus:ring-opacity-40" placeholder="Adresse email">
                    </div>
                    <div class="relative flex items-center mt-4">
                    <span class="absolute">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6  mx-3 text-gray-300 dark:text-gray-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                    </svg>
                    </span>
                        <input type="text" name="adresseSite" class="block w-full py-3 text-gray-700 bg-white border rounded-lg px-11 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-green-400 dark:focus:border-green-300 focus:ring-green-300 focus:outline-none focus:ring focus:ring-opacity-40" placeholder="Adresse du site">
                    </div>-->
        
                  
        
                    <div class="flex items-center justify-between mt-4">        
                        <input type="submit" name="addSite" class="px-6 py-2 m-auto text-sm font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-green-500 rounded-lg hover:bg-green-400 focus:outline-none focus:ring focus:ring-green-300 focus:ring-opacity-50" value="Ajouter">
                    </div>
                </form>
            </div>
       
        </div>
                
        </div>
    <script src="../assets/js/main.js"></script>
</body>
</html>