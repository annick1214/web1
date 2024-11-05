<?php 
include 'setting.php';

$siteId = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $siteId = htmlspecialchars($_POST['id']);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des anciens élèves</title>
    <?php include 'header.php'; ?>
    <style>
        .table-row:hover {
            background-color: #d4edd5; /* Couleur verte claire au survol */
            
        }
    </style>
</head>
<body>
<main>
    <section class="dark:bg-gray-800">
        <div class="flex items-center py-4 overflow-x-auto whitespace-nowrap">
            <!--<a href="index.php" class="text-gray-600 dark:text-gray-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                </svg>
            </a>-->
            <a href="classe1.php" class="flex items-center text-gray-600 -px-2 dark:text-gray-200 hover:underline">
                <span class="mx-5 text-gray-500 dark:text-gray-300 rtl:-scale-x-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </span>
                <span class="mx-2">Retour</span>
            </a>
        </div>   
          
        <div class="bg-white shadow-md rounded-lg p-6">
            
            <?php
            // Connexion à la base de données
            try {
                $pdo = new PDO('mysql:host=localhost;dbname=p1', 'root', '');

                // Compter le nombre total d'anciens élèves pour le site sélectionné
                $count = "SELECT COUNT(ideleve) AS nombreeleve FROM eleve WHERE site = :siteId AND statut = 'Ancien'";
                $countStmt = $pdo->prepare($count);
                $countStmt->bindParam(':siteId', $siteId);
                $countStmt->execute();
                $resulta = $countStmt->fetch(PDO::FETCH_ASSOC) ?: ['nombreeleve' => 0];
                ?>
                <h3 class="text-2xl font-bold text-gray-800 mb-4">
                    Liste des anciens élèves 
                    <!--<span class="text-green-500"><?php echo $resulta['nombreeleve']; ?></span>-->
                </h3>
                <!--<div class="flex justify-end mb-4">
                    <a href="inscription.php" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-200">
                        Inscription
                    </a>
                </div>-->
            <?php
            } catch (PDOException $e) {
                echo "Erreur : " . $e->getMessage();
            }
            ?>

            <?php
            // Préparation de la requête pour récupérer les anciens élèves inscrits sur le site
            try {
                $stmt = $pdo->prepare("SELECT * FROM eleve WHERE site = :siteId AND statut = 'Ancien'");
                $stmt->bindParam(':siteId', $siteId);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
            ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse border-2 border-gray-400 rounded-lg shadow-lg">
                        <thead class="bg-gray-300">
                            <tr>
                                <th class="border-2 border-gray-400 text-left py-3 px-4 font-semibold text-gray-700">Code</th>
                                <th class="border-2 border-gray-400 text-left py-3 px-4 font-semibold text-gray-700">Nom</th>
                                <th class="border-2 border-gray-400 text-left py-3 px-4 font-semibold text-gray-700">Prénom</th>
                               <!-- <th class="border-2 border-gray-400 text-left py-3 px-4 font-semibold text-gray-700">Date d'ajout</th>-->
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            <?php
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <tr class="table-row cursor-pointer" /*onclick="window.location='details.php?id=<?php echo $row['ideleve']; ?>'*/">
                                <td class="border-2 border-gray-400 py-3 px-4"><?php echo $row['matriculeeleve']; ?></td>
                                <td class="border-2 border-gray-400 py-3 px-4"><?php echo $row['nomeleve']; ?></td>
                                <td class="border-2 border-gray-400 py-3 px-4"><?php echo $row['prenomeleve']; ?></td>
                                <!--<td class="border-2 border-gray-400 py-3 px-4"><?php echo $row['dateAdd']; ?></td>-->
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            <?php
                } else {
                    echo "<p class='text-center text-blue-500 font-bold'>Aucun ancien élève inscrit dans cette classe</p>";
                }
            } catch (PDOException $e) {
                echo "Erreur : " . $e->getMessage();
            }
            ?>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6">
            <?php
            // Connexion à la base de données
            try {
                $pdo = new PDO('mysql:host=localhost;dbname=p1', 'root', '');

                // Compter le nombre total d'anciens élèves pour le site sélectionné
                $count = "SELECT COUNT(ideleve) AS nombreeleve FROM paye WHERE site = :siteId AND tranche1 = '25000'";
                $countStmt = $pdo->prepare($count);
                $countStmt->bindParam(':siteId', $siteId);
                $countStmt->execute();
                $resulta = $countStmt->fetch(PDO::FETCH_ASSOC) ?: ['nombreeleve' => 0];
                // Compter le nombre total d'élèves pour le site sélectionné
                /*$count = "SELECT COUNT(ideleve) AS nombreeleve FROM eleve WHERE site = :siteId";
                $countStmt = $pdo->prepare($count);
                $countStmt->bindParam(':siteId', $siteId);
                $countStmt->execute();
                $resulta = $countStmt->fetch(PDO::FETCH_ASSOC) ?: ['nombreeleve' => 0];*/

                ?>
                
                <h3 class="text-2xl font-bold text-gray-800 mb-4">
                                    Liste des nouveaux élèves 
                    <!--<span class="text-green-500"><?php echo $resulta['nombreeleve']; ?></span>-->
                </h3>
                <!--<div class="flex justify-end mb-4">
                    <a href="inscription.php" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-200">
                        Inscription
                    </a>
                </div>-->
            <?php
            } catch (PDOException $e) {
                echo "Erreur : " . $e->getMessage();
            }
            ?>

            <?php
            // Préparation de la requête pour récupérer les anciens élèves inscrits sur le site
            try {
                $stmt = $pdo->prepare("SELECT * FROM paye WHERE site = :siteId AND tranche1 = '25000'");
                $stmt->bindParam(':siteId', $siteId);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
            ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse border-2 border-gray-400 rounded-lg shadow-lg">
                        <thead class="bg-gray-300">
                            <tr>
                                <th class="border-2 border-gray-400 text-left py-3 px-4 font-semibold text-gray-700">Code</th>
                                <th class="border-2 border-gray-400 text-left py-3 px-4 font-semibold text-gray-700">Nom</th>
                                <th class="border-2 border-gray-400 text-left py-3 px-4 font-semibold text-gray-700">Prénom</th>
                                <!--<th class="border-2 border-gray-400 text-left py-3 px-4 font-semibold text-gray-700">Date d'ajout</th>-->
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            <?php
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <tr class="table-row cursor-pointer" onclick="window.location='details.php?id=<?php echo $row['ideleve']; ?>'">
                                <td class="border-2 border-gray-400 py-3 px-4"><?php echo $row['matriculeeleve']; ?></td>
                                <td class="border-2 border-gray-400 py-3 px-4"><?php echo $row['nomeleve']; ?></td>
                                <td class="border-2 border-gray-400 py-3 px-4"><?php echo $row['prenomeleve']; ?></td>
                               <!-- <td class="border-2 border-gray-400 py-3 px-4"><?php echo $row['dateAdd']; ?></td>-->
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            <?php
                } else {
                    echo "<p class='text-center text-blue-500 font-bold'>Aucun nouveau élève inscrit dans cette classe</p>";
                }
            } catch (PDOException $e) {
                echo "Erreur : " . $e->getMessage();
            }
            ?>
        </div>
    </section>
</main>
</body>
</html>
