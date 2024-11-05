<?php
    include 'setting.php';
    $idmat = $_GET['id'];
    if (isset($_POST['addMat'])) {
            $typeMat = htmlspecialchars($_POST['typematerielle']);
            $nomMat = htmlspecialchars($_POST['nomMat']);
            $etatMat = htmlspecialchars($_POST['etatMat']);
            $descMat = htmlspecialchars($_POST['descMat']);
        
            if (!empty($typeMat) && !empty($etatMat)) {

                $req1 = "UPDATE ressourcematerielle SET nomMaterielle = ?, typeMaterielle = ?, descriptionMaterielle = ?, etatMaterielle = ? WHERE idMaterielle = ?";
                $stmt1 = $base_com->prepare($req1);
                $stmt1->execute([$nomMat, $typeMat, $descMat, $etatMat, $idmat]);
                $message = "Modification réussi !";
            }else{
                $erreur = "Tous les champs sont requis";
            }

        }
    
        $recupMat = "SELECT rm.*, cm.*
        FROM ressourcematerielle AS rm
        INNER JOIN categoriematerielle AS cm ON rm.typeMaterielle = cm.idCategorie where rm.idMaterielle =$idmat";
    
        $stmt = $base_com->prepare($recupMat);
        $stmt->execute();
        $rmat = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CM - E-Gest|Modification</title>

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
                     <section class="container px-5 mx-auto mt-10">
                        <div class="flex flex-col mt-6">
                            <div class="mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                
                                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                                        <section class="mt-5 max-w-4xl p-6 mx-auto bg-white rounded-md shadow-md dark:bg-gray-800">
                                            <h1 class="text-center text-lg font-semibold text-green-400 capitalize dark:text-green-400">Caractéristique du materielle</h1>

                                            <div style="position: relative;" class="mb-5 pb-5 mt-5">
                                                <h1 class="bg-white dark:bg-green-400" style="position: absolute; top: 0; left: 0; padding: 10px; border: 1px solid #ccc;">
                                                    Code matériel : <span class="text-red-500"><?php echo $rmat['codeMaterielle']; ?></span>
                                                </h1>
                                            </div>

                                            <form method="post" action="" class="mt-5">
                                                
                                                <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2 pt-5">
                                                    <div>
                                                        <label class="text-gray-700 dark:text-gray-200" for="username">Type materielle</label>
                                                        <select name="typematerielle" id="" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-green-400 focus:ring-green-300 focus:ring-opacity-40 dark:focus:border-green-300 focus:outline-none focus:ring">
                                                        <?php
                                                            $sql = "SELECT * FROM categoriematerielle";
                                                            $stmt = $base_com->prepare($sql);
                                                            $stmt->execute();
                                                            if ($stmt->rowCount() > 0) {
                                            
                                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                            echo "<option value=".$row['idCategorie'].">".$row['nomCategorie']."</option>";
                                                            }
                                                            }else{
                                                                echo "<option class='text-red-500' role='alert'>Aucune type recu ! <a href'catrm.php'>Ajouter</a></option>";
                                                            }
                                                                
                                                            ?> 
                                                        </select>
                                                        <small class="dark:text-white"> type actuelle: <span class="text-blue-500"><?php echo $rmat['nomCategorie']; ?></span></small>

                                                    </div>
                                        
                                                    <div>
                                                        <label class="text-gray-700 dark:text-gray-200" for="emailAddress">Nom materielle</label>
                                                        <input id="emailAddress" type="text" name="nomMat" value="<?php echo $rmat['nomMaterielle']; ?>" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-green-400 focus:ring-green-300 focus:ring-opacity-40 dark:focus:border-green-300 focus:outline-none focus:ring">
                                                    </div>
                                        
                                                    <div>
                                                        <label class="text-gray-700 dark:text-gray-200" for="password">Etat materielle</label>
                                                        <select name="etatMat" id="" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-green-400 focus:ring-green-300 focus:ring-opacity-40 dark:focus:border-green-300 focus:outline-none focus:ring">
                                                            <option value="nouveau" <?php echo ($rmat['etatMaterielle'] === 'nouveau') ?'selected' : '';?>>Neuf</option>
                                                            <option value="bonne" <?php echo ($rmat['etatMaterielle'] === 'bonne') ?'selected' : ''; ?>>Bon</option>
                                                            <option value="vielle" <?php echo ($rmat['etatMaterielle'] === 'vielle') ?'selected' : ''; ?>>Mauvais</option>
                                                        </select>
                                                    </div>
                                                    <div>
                                                        <label class="text-gray-700 dark:text-gray-200" for="password">Description materielle</label>
                                                        <textarea name="descMat" id="" cols="10" rows="5" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-green-400 focus:ring-green-300 focus:ring-opacity-40 dark:focus:border-green-300 focus:outline-none focus:ring"><?php echo $rmat['descriptionMaterielle']; ?></textarea>
                                                    </div>
                                                   
                                                </div>
                                        
                                                <div class="flex justify-end mt-6">
                                                    <input type="submit" name="addMat" onclick="return confirm('Voulez-vous enregistrer les nouvelles modifications ?');" class="px-8 py-2.5 leading-5 text-white transition-colors duration-300 transform bg-gray-700 rounded-md hover:bg-green-600 focus:outline-none focus:bg-green-600" value="Modifier">
                                                </div>
                                            </form>
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                      
                    </section>
                </main>
            </div>
<script src="../assets/js/main.js"></script>
</body>
</html>
