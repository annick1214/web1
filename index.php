<?php
    include 'setting.php';
    function troisPremieresLettres($texte) {
        $troisPremieresLettres = mb_substr($texte, 0, 3);
        return $troisPremieresLettres;
    }
    
    if (isset($_POST['addMat'])) {
        $typeMat = htmlspecialchars($_POST['typematerielle']);
        $nomMat = htmlspecialchars($_POST['nomMat']);
        $etatMat = htmlspecialchars($_POST['etatMat']);
        $descMat = htmlspecialchars($_POST['descMat']);

        if(!empty($typeMat) && !empty($etatMat)){

            $req = "SELECT * FROM categoriematerielle where idCategorie = ?";
            $stmt = $base_com->prepare($req);
            $stmt->execute([$typeMat]);
            $resultat = $stmt->fetch();

            $nomCat = $resultat['nomCategorie'];
            $prefCode = strtoupper(troisPremieresLettres($nomCat));

            $req1 = "INSERT INTO ressourcematerielle (nomMaterielle, typeMaterielle, descriptionMaterielle, etatMaterielle, dateAdd) VALUES (?, ?, ?, ?,NOW())";
            $stmt1 = $base_com->prepare($req1);
            $stmt1->execute([$nomMat, $typeMat, $descMat, $etatMat]);

            $nouvelId = $base_com->lastInsertId();

            $code = $prefCode.'000'.$nouvelId.'HECM'; 

            $req2 = "UPDATE ressourcematerielle SET codeMaterielle = ? WHERE idMaterielle = ?";
            $stmt2 = $base_com->prepare($req2);
            $stmt2->execute([$code, $nouvelId]);

            $message = "Ajout réussi de la ressource de type $nomCat <br> Voici le code unique de la ressource <span class='text-red-500 font-bold'>$code</span>";

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
    <title>Comptable-Matière - E-Gest</title>
  
           <?php
             include 'header.php';
           ?>
              
                    <div class="flex items-center py-4 overflow-x-auto whitespace-nowrap">
                        <a href="#" class="text-gray-600 dark:text-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                            </svg>
                        </a>
                        
                        <span class=" text-gray-500 dark:text-gray-300 rtl:-scale-x-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    
                    </div>
                     <section class="container px-5 mx-auto mt-5">
                        <div class="flex flex-col mt-6">
                            <div class="mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                
                                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                                        <section class="mt-5 max-w-4xl p-6 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800">
                                            <h1 class="text-center text-lg font-semibold text-green-400 capitalize dark:text-green-400">Ajout D'une nouvelle ressource matiellé</h1>
                                            <form method="post" action="index.php">
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
                                            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2 mt-5 pt-5">
                                                    <div>
                                                        <label class="text-gray-700 dark:text-gray-200" for="username">Type de matérielle</label>
                                                       
                                                        <select id="type" name="typematerielle" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-green-400 focus:ring-green-300 focus:ring-opacity-40 dark:focus:border-green-300 focus:outline-none focus:ring">
                                                            <?php
                                                            $sql = "SELECT * FROM categoriematerielle";
                                                            $stmt = $base_com->prepare($sql);
                                                            $stmt->execute();
                                                            if ($stmt->rowCount() > 0) {
                                            
                                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                            echo "<option value=".$row['idCategorie'].">".$row['nomCategorie']."</option>";
                                                            }
                                                            }else{
                                                                echo "<option class='text-red-500' role='alert'>Aucune catégorie recu !</option>";
                                                            }
                                                                
                                                            ?> 
                                                            
                                                        </select>
                                                    </div>
                                        
                                                    <div>
                                                        <label class="text-gray-700 dark:text-gray-200" for="nom">Nom matérielle</label>
                                                        <input id="nom" type="text" name="nomMat" placeholder="Entrer le nom du métérielle..." class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-green-400 focus:ring-green-300 focus:ring-opacity-40 dark:focus:border-green-300 focus:outline-none focus:ring">
                                                    </div>
                                        
                                                    <div>
                                                        <label class="text-gray-700 dark:text-gray-200" for="etat">Etat du matérille</label>
                                                        <select name="etatMat" id="etat" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-green-400 focus:ring-green-300 focus:ring-opacity-40 dark:focus:border-green-300 focus:outline-none focus:ring">
                                                            <option value="nouveau">Neuf</option>
                                                            <option value="bonne">Bon</option>
                                                            <option value="vielle">Mauvais</option>
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label class="text-gray-700 dark:text-gray-200" for="desc">Description du matérielle</label>
                                                        <textarea name="descMat" id="desc" cols="10" rows="5" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-green-400 focus:ring-green-300 focus:ring-opacity-40 dark:focus:border-green-300 focus:outline-none focus:ring"></textarea>
                                                    </div>
                                                   
                                                </div>
                                        
                                                <div class="flex justify-end mt-6">
                                                    <input name="addMat" type="submit" class="px-8 py-2.5 leading-5 text-white transition-colors duration-300 transform bg-gray-700 rounded-md hover:bg-green-600 focus:outline-none focus:bg-green-600" value="Enrégistrer">
                                                </div>
                                            </form>
                                        </section>
                                    </div>
                                </div>
                            </div>
                     </section>
    </div>
<script src="../assets/js/main.js"></script>
</body>
</html>
