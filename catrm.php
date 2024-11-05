<?php
include 'setting.php';
    if (isset($_POST['add'])) {
        $categorie = $_POST['categorie'];
    
        if(!empty($categorie)){
        $sql = "SELECT * FROM categoriematerielle where nomCategorie = ?";
        $stmt = $base_com->prepare($sql);
        $stmt->execute([$categorie ]);
        $resultat = $stmt->fetch();
        if($resultat){
            $erreurr = "La catégorie est déjà inscrit !";
        }else{
            $req = $base_com->prepare("INSERT INTO categoriematerielle(nomCategorie) value (?)");
            $req->execute([$categorie ]);
    
            $messagee = "Nouveau type ajouter ".$categorie  ;
        }
        }else{
        $erreurr = "Le champs est requis";
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comptable-Matière - E-Gest| catégorie</title>
        <!-- Sidebar -->
           <?php
             include 'header.php';
           ?>
              
                    <div class="flex items-center py-4 overflow-x-auto whitespace-nowrap">
                        <!--<a href="#" class="text-gray-600 dark:text-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                            </svg>
                        </a>-->
                        
                        <span class=" text-gray-500 dark:text-gray-300 rtl:-scale-x-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                        <a href="resmat.php" class="text-gray-600 dark:text-gray-200">
                        <span class="mx-2 text-gray-500 dark:text-gray-300 rtl:-scale-x-100">Catégories ressources matérielles</span>
                        </a>
                    </div>

                    <section class="container px-4 mx-auto flex flex-col items-center">
                        <div class="mt-6 w-full max-w-lg">
                              <?php if (!empty($messagee)): ?>
                                <div class="text-white bg-emerald-500 container flex items-center justify-between px-6 py-2 mx-auto">
                                    <div class="flex items-center gap-x-3">
                                        <svg viewBox="0 0 40 40" class="w-6 h-6 fill-current">
                                            <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z"></path>
                                        </svg>
                                        <p class="mx-3"><?php echo $messagee; ?></p>
                                    </div>
                                    <button class="p-1 transition-colors duration-300 transform rounded-md hover:bg-opacity-25 hover:bg-gray-600 focus:outline-none">
                                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M6 18L18 6M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                        </svg>
                                    </button>
                                </div>
                                <?php endif; ?>
                                <?php if (!empty($erreurr)): ?>
                                    <div class="text-white bg-red-500 container flex items-center justify-between px-6 py-2 mx-auto">
                                        <div class="flex items-center gap-x-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 ">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                                        </svg>

                                            <p class="mx-3"><?php echo $erreurr; ?></p>
                                        </div>
                                        <button class="p-1 transition-colors duration-300 transform rounded-md hover:bg-opacity-25 hover:bg-gray-600 focus:outline-none">
                                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6 18L18 6M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                        </button>
                                    </div>
                                <?php endif; ?>
                                <form id="category-form" action="catrm.php" method="post" class="mt-4">
                                    <input type="text" name="categorie" class="block w-full mb-2 py-2.5 text-gray-700 placeholder-gray-400/70 bg-white border border-gray-200 rounded-lg pl-11 pr-5 rtl:pr-11 rtl:pl-5 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-green-400 dark:focus:border-green-300 focus:ring-green-300 focus:outline-none focus:ring focus:ring-opacity-40" placeholder="Ajouter une nouvelle catégorie...">
                                    <input type="submit" name="add" class="mx-3 px-8 py-2.5 leading-5 text-white transition-colors duration-300 transform bg-gray-700 rounded-md hover:bg-green-600 focus:outline-none focus:bg-green-600" value="Enrégistrer">
                                </form>
                            </div>
                            <div class="mt-6 w-full max-w-lg">
                                     <?php
                                        $sql = "SELECT * FROM categoriematerielle";
                                        $stmt = $base_com->prepare($sql);
                                        $stmt->execute();
                                        if ($stmt->rowCount() > 0) {?>
                                        <table id="categorie" class="w- w-full divide-y divide-gray-200 dark:divide-gray-700">
                                        <thead class="bg-gray-50 dark:bg-gray-800">
                                            <tr>
                                                <th scope="col" class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                                    <div class="flex items-center gap-x-3">
                                                        <span>Nom</span>
                                                    </div>
                                                </th>
                                                <th scope="col" class="relative py-3.5 px-4">
                                                    <span class="sr-only">Modifier</span>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                                        <?php
                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        ?>                
                                        <tr>
                                            <td class="px-4 py-4 text-sm font-medium text-gray-700 whitespace-nowrap">
                                                <h2 class="font-medium text-gray-800 dark:text-white"><?php echo $row['nomCategorie']; ?></h2>
                                            </td>
                                            <td class="px-4 py-4 text-sm whitespace-nowrap">
                                                <div class="flex items-center gap-x-6">
                                                    <button class="text-gray-500 transition-colors duration-200 dark:hover:text-red-500 dark:text-gray-300 hover:text-red-500 focus:outline-none">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                        </svg>
                                                    </button>
                                                    <button class="text-gray-500 transition-colors duration-200 dark:hover:text-yellow-500 dark:text-gray-300 hover:text-yellow-500 focus:outline-none">
                                                        <a href="modcat.php">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                            </svg>
                                                        </a>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                                }
                                            } else {
                                        ?>
                                            <div class="text-white bg-blue-500 container flex items-center justify-between px-6 py-2 mx-auto">
                                            <div class="flex items-center gap-x-3">
                                                            <svg viewBox="0 0 40 40" class="w-6 h-6 fill-current">
                                                                <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z">
                                                                </path>
                                                            </svg>

                                                        <p class="mx-3">Aucun type de matériel enregistrer</p>
                                                    </div>

                                                    
                                                </div>
                                                
                                            <?php
                                        }
                                        ?>
                                </tbody>
                            </table>
                           
                        </div>
                    </section>


    </div>
    <script src="../assets/js/main.js"></script>
</body>
</html>
