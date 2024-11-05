<?php
include 'setting.php';

$idmat = $_GET['id'];

$recupMat = "SELECT rm.*, cm.*
    FROM ressourcematerielle AS rm
    INNER JOIN categoriematerielle AS cm ON rm.typeMaterielle = cm.idCategorie 
    WHERE rm.idMaterielle = :idmat";

$stmt = $base_com->prepare($recupMat);
$stmt->execute([':idmat' => $idmat]);
$rmat = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['attribuer'])) {
    $periode = !empty($_POST['periode']) ? $_POST['periode'] : null;
    $idSite = $_POST['etatMat'];

    $dateEnd = null;
    if ($periode !== null) {
        $dateStart = new DateTime();
        $dateEnd = $dateStart->modify("+$periode days")->format('Y-m-d');
    }

  
    $insertAttribution = "INSERT INTO attribution (dateEnd, idMaterielle, idSite) VALUES (:dateEnd, :idMaterielle, :idSite)";
    $stmt = $base_com->prepare($insertAttribution);
    $stmt->execute([
        ':dateEnd' => $dateEnd,
        ':idMaterielle' => $idmat,
        ':idSite' => $idSite
    ]);

 
    $updateRessource = "UPDATE ressourcematerielle SET statutMaterielle = 'indisponible' WHERE idMaterielle = :idMaterielle";
    $stmt = $base_com->prepare($updateRessource);
    $stmt->execute([':idMaterielle' => $idmat]);

    $message = "La ressource a été attribuée avec succès";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comptable-Matière - E-Gest</title>
        <!-- Sidebar -->
           <?php
             include 'header.php';
           ?>
              
    <div class="container mx-auto mt-5 rounded-lg shadow-md p-6">
        <div class="mb-5">
            <h1 class="text-lg font-semibold text-green-500 capitalize">Caractéristique du matériel</h1>

            <div class="mt-2">
                <h2 class="text-gray-700 dark:text-gray-400 inline-block p-2 border border-gray-300 rounded-md">
                    Code matériel : <span class="text-red-500"><?php echo $rmat['codeMaterielle']; ?></span>
                </h2>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mt-2">
                <div>
                    <p class="text-gray-500 dark:text-gray-400"><strong>Type matériel :</strong> <span class="text-gray-700 dark:text-white font-bold"><?php echo $rmat['nomCategorie']; ?></span></p>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400"><strong>Nom matériel :</strong> <span class="text-gray-700 dark:text-white font-bold"><?php echo $rmat['nomMaterielle']; ?></span></p>
                </div>
                <div class="">
                    <p class="text-gray-500 dark:text-gray-400"><strong>État matériel :</strong> <span class="text-gray-700 dark:text-white font-bold"><?php echo ucfirst($rmat['etatMaterielle']); ?></span></p>
                </div>
                <div class="sm:col-span-2 mt-3">
                    <p class="text-gray-500 dark:text-gray-400"><strong>Description :</strong> <span class="text-gray-700 dark:text-white font-bold"><?php echo $rmat['descriptionMaterielle']; ?></span></p>
                </div>
            </div>
        </div>
        <form method="post" action="" class="">
            <h2 class="text-lg font-semibold text-green-500 capitalize">Détails de l'attribution</h2>
            <?php if (!empty($message)): ?>
                    <div class="flex w-full max-w-sm overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800">
                        <div class="flex items-center justify-center w-12 bg-emerald-500">
                            <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z" />
                            </svg>
                        </div>

                        <div class="px-4 py-2 -mx-3">
                            <div class="mx-3">
                                <span class="font-semibold text-emerald-500 dark:text-emerald-400">Bravo ! </span>
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
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 mt-4">
              
                <div>
                    <label class="text-gray-500 dark:text-gray-400" for="nomMat">Période</label>
                    <input id="nomMat" type="number" name="periode" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-green-400 focus:ring-green-300 focus:ring-opacity-40 dark:focus:border-green-300 focus:outline-none focus:ring">
                </div>
            </div>
            
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 mt-4">
                <div>
                    <label class="text-gray-500 dark:text-gray-400" for="nomSite">Site</label>
                    <select name="etatMat" id="etatMat" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-green-400 focus:ring-green-300 focus:ring-opacity-40 dark:focus:border-green-300 focus:outline-none focus:ring">
                        <?php
                                $sql = "SELECT * FROM site ";
                                $stmt = $base_com->prepare($sql);
                                $stmt->execute();
                                if ($stmt->rowCount() > 0) {
                
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value=".$row['idSite'].">".$row['nomSite']."</option>";
                                }
                                }else{
                                    echo "<option class='text-red-500' role='alert'>Aucun site</option>";
                                }
                                
                            ?> 
                    </select>
                </div>
           
            </div>

            <div class="flex justify-end mt-6">
                <input type="submit" name="attribuer" onclick="return confirm('Voulez-vous attribuer la ressource ?');" class="px-8 py-2.5 leading-5 text-white transition-colors duration-300 transform bg-green-600 rounded-md hover:bg-green-700 focus:outline-none focus:bg-green-700" value="Attribuer">
            </div>
        </form>
    </div>
            </section>
    </div>
    <script src="../assets/js/main.js"></script>
</body>
</html>
