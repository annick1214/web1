<?php
 include 'setting.php';

 if (isset($_GET['idDemande'])) {
     $idDemande = $_GET['idDemande'];
     $demand = "SELECT dm.*, cm.*, s.* 
                FROM demande AS dm 
                INNER JOIN categoriematerielle AS cm ON dm.typeMaterielle = cm.idCategorie 
                INNER JOIN site AS s ON s.idSite = dm.idSite 
                WHERE dm.idDemande = ?";
     $stmt = $base_com->prepare($demand);
     $stmt->execute([$idDemande]);
     $demande = $stmt->fetch(PDO::FETCH_ASSOC);
 
     if ($demande['periode'] == null) {
         $periode = 'Indéterminé';
     } else {
         $periode = $demande['periode'] . ' jour(s)';
     }
 
     if (isset($_POST['envoyer'])) {
         $statut = htmlspecialchars($_POST['statut']);
         $reponse = !empty($_POST['reponse']) ? htmlspecialchars($_POST['reponse']) : null;
 
         $req2 = "UPDATE demande SET statutDemande = ?, reponseDemande = ? WHERE idDemande = ?";
         $stmt2 = $base_com->prepare($req2);
         $stmt2->execute([$statut, $reponse, $idDemande]);
 
         $message = "Demande mise à jour avec succès.";
     }
 } else {
     $erreur = "ID de demande non fourni.";
 }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/images/logohecm.png" type="image/x-icon"/>
    <title>CM| Traitement de demande</title>
        <!-- Sidebar -->
            <?php
                include 'header.php';
             ?>

                    <div class="flex items-center py-4 overflow-x-auto whitespace-nowrap">
                        <a href="#" class="text-gray-600 dark:text-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                            </svg>
                        </a>
                    
                        <span class="mx-5 text-gray-500 dark:text-gray-300 rtl:-scale-x-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    
                        <a href="listedemande.html" class="flex items-center text-gray-600 -px-2 dark:text-gray-200 hover:underline">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                              </svg>
                    
                            <span class="mx-2">Traitement de la Demande</span>
                        </a>
                    </div>                

               
            <section class="flex flex-col bg-white dark:bg-gray-800 mt-5 rounded-lg shadow-md mb-2">
            <?php if (!empty($message)): ?>
                                            <div class="w-full text-white bg-emerald-500">
                                                <div class="container flex items-center justify-between px-6 py-4 mx-auto">
                                                    <div class="flex">
                                                        <svg viewBox="0 0 40 40" class="w-6 h-6 fill-current">
                                                            <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z">
                                                            </path>
                                                        </svg>

                                                        <p class="mx-3"><?php echo $message; ?></p>
                                                    </div>

                                                    <button class="p-1 transition-colors duration-300 transform rounded-md hover:bg-opacity-25 hover:bg-gray-600 focus:outline-none">
                                                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M6 18L18 6M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                                            <?php if (!empty($erreur)): ?>
                                            <div class="w-full text-white bg-red-500">
                                                <div class="container flex items-center justify-between px-6 py-4 mx-auto">
                                                    <div class="flex">
                                                        <svg viewBox="0 0 40 40" class="w-6 h-6 fill-current">
                                                            <path d="M20 3.36667C10.8167 3.36667 3.3667 10.8167 3.3667 20C3.3667 29.1833 10.8167 36.6333 20 36.6333C29.1834 36.6333 36.6334 29.1833 36.6334 20C36.6334 10.8167 29.1834 3.36667 20 3.36667ZM19.1334 33.3333V22.9H13.3334L21.6667 6.66667V17.1H27.25L19.1334 33.3333Z">
                                                            </path>
                                                        </svg>

                                                        <p class="mx-3"><?php echo $erreur; ?></p>
                                                    </div>

                                                    <button class="p-1 transition-colors duration-300 transform rounded-md hover:bg-opacity-25 hover:bg-gray-600 focus:outline-none">
                                                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M6 18L18 6M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                <div class="w-full px-8 py-4 bg-white dark:bg-gray-800 mt-2">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-light text-yellow-600"><?php echo $demande['dateAdd']; ?></span>
                        <a href="#" class="px-3 py-1 text-sm font-bold text-green-400 bg-gray-600 rounded"><?php echo $demande['nomSite']; ?></a>
                    </div>

                    <div class="mt-2">
                        <h1 class="text-gray-800 dark:text-white">Type : <span class="text-xl font-semibold"><?php echo $demande['nomCategorie']; ?></span></h1>
                        <p class="p-2 text-gray-800 dark:text-white ">Période : <span class="text-green-600"><?php echo $periode; ?></span></p>
                        <p class="p-2 text-gray-800 dark:text-white">Quantité: <span class="text-red-500"><?php echo $demande['quantite']; ?></span></p>
                        <p class="mt-2 p-2 text-blue-400 text-gray-800 dark:text-white"><?php echo $demande['messageDemande']; ?></p>        
                    </div>
                </div>
                <div class="w-auto px-8 py-4 bg-white dark:bg-gray-800">                  
                    <form action="" method="POST">   
                        <div class="relative flex items-center mt-2">
                            <label class="text-gray-700 dark:text-gray-200" for="statut">Décision</label>
                            <select name="statut" id="statut" class="block w-full mx-2 px-4 py-2 mt-2 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-green-400 focus:ring-green-300 focus:ring-opacity-40 dark:focus:border-green-300 focus:outline-none focus:ring">
                                <option value="accepter" class="text-green-400">ACCORDER</option>
                                <option value="refuser" class="text-red-500">REJETER</option>
                            </select>
                        </div>                  
                        <div class="mt-4">
                            <label class="text-gray-700 dark:text-gray-200" for="reponse">Réponse (Optionnelle)</label>
                            <textarea name="reponse" id="reponse" cols="15" rows="5" maxlength="500" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-green-400 focus:ring-green-300 focus:ring-opacity-40 dark:focus:border-green-300 focus:outline-none focus:ring"></textarea>
                        </div>
                        <div class="items-center justify-between mt-4">
                            <input type="submit" name="envoyer" class="px-6 py-2 text-sm font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-green-400 rounded-lg hover:bg-green-500 focus:outline-none focus:ring focus:ring-green-300 focus:ring-opacity-50" value="Valider">
                        </div>
                    </form>
                </div>
            </section>

        </main>
    </div>
    <script src="../assets/js/main.js"></script>
</body>
</html>
