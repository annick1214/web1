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
    <title>Liste des élèves</title>
    <?php include 'header.php'; ?>
    <style>
        .table-row:hover {
            background-color: #d4edda; /* Couleur verte claire au survol */
        }
        .text-center {
            text-align: center; /* Centrage du texte */
        }
        @media print {
            .print-button,
            .inscription-link,
            .return-link, /* Masque le lien de retour lors de l'impression */
            .header { /* Masque l'en-tête ou le menu si nécessaire */
                display: none; 
            }
            body {
                margin: 0; /* Supprime les marges pour l'impression */
            }
        }
    </style>
    <script>
        function printPage() {
            window.print(); // Ouvre la boîte de dialogue d'impression
        }
    </script>
</head>
<body>
<main>
    <section class="dark:bg-gray-800">
        <div class="flex justify-between items-center py-4 header">
            <a href="classe.php" class="text-gray-600 dark:text-gray-200 return-link">Retour</a>
            <button onclick="printPage()" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200 print-button">
                Imprimer
            </button>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6">
            <?php
            // Connexion à la base de données
            try {
                $pdo = new PDO('mysql:host=localhost;dbname=p1', 'root', '');

                // Récupérer le nom du site
                $siteQuery = "SELECT nomSite FROM site WHERE idSite = :siteId";
                $siteStmt = $pdo->prepare($siteQuery);
                $siteStmt->bindParam(':siteId', $siteId);
                $siteStmt->execute();
                $siteName = $siteStmt->fetch(PDO::FETCH_ASSOC)['nomSite'] ?? 'Inconnu';

                // Compter le nombre total d'élèves pour le site sélectionné
                $count = "SELECT COUNT(ideleve) AS nombreeleve FROM eleve WHERE site = :siteId";
                $countStmt = $pdo->prepare($count);
                $countStmt->bindParam(':siteId', $siteId);
                $countStmt->execute();
                $resulta = $countStmt->fetch(PDO::FETCH_ASSOC) ?: ['nombreeleve' => 0];

                // Compter le nombre de garçons
                $countBoys = "SELECT COUNT(ideleve) AS nombregarcons FROM eleve WHERE site = :siteId AND sexe = 'Masculin'";
                $countBoysStmt = $pdo->prepare($countBoys);
                $countBoysStmt->bindParam(':siteId', $siteId);
                $countBoysStmt->execute();
                $resultBoysCount = $countBoysStmt->fetch(PDO::FETCH_ASSOC) ?: ['nombregarcons' => 0];

                // Compter le nombre de filles
                $countGirls = "SELECT COUNT(ideleve) AS nombrefilles FROM eleve WHERE site = :siteId AND sexe = 'Féminin'";
                $countGirlsStmt = $pdo->prepare($countGirls);
                $countGirlsStmt->bindParam(':siteId', $siteId);
                $countGirlsStmt->execute();
                $resultGirlsCount = $countGirlsStmt->fetch(PDO::FETCH_ASSOC) ?: ['nombrefilles' => 0];
            ?>
                <div class="text-center mb-4">
                    <h3 class="text-2xl font-bold text-gray-800">
                        <span class="text-blue-500">Classe de : <?php echo $siteName; ?></span>
                    </h3>
                </div>
                <h3 class="text-xl  font-bold text-gray-800 mb-4">
                    Liste des élèves : 
                    
                </h3>
                <!--<div class="flex justify-end mb-4">
                    <a href="inscription.php" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-200 inscription-link">
                        Inscription
                    </a>
                </div>-->
            <?php
            } catch (PDOException $e) {
                echo "Erreur : " . $e->getMessage();
            }
            ?>

            <?php
            // Préparation de la requête pour récupérer les élèves inscrits sur le site, triés par nom
            try {
                $stmt = $pdo->prepare("SELECT * FROM eleve WHERE site = :siteId ORDER BY nomeleve ASC");
                $stmt->bindParam(':siteId', $siteId);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
            ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse border-2 border-gray-400 rounded-lg shadow-lg">
                        <thead class="bg-gray-300">
                            <tr>
                                <th class="border-2 border-gray-400 text-left py-3 px-4 font-semibold text-gray-700">Matricule</th>
                                <th class="border-2 border-gray-400 text-left py-3 px-4 font-semibold text-gray-700">Nom</th>
                                <th class="border-2 border-gray-400 text-left py-3 px-4 font-semibold text-gray-700">Prénom</th>
                                <th class="border-2 border-gray-400 text-left py-3 px-4 font-semibold text-gray-700">Sexe</th>
                                <th class="border-2 border-gray-400 text-left py-3 px-4 font-semibold text-gray-700">Statut</th>
                                <th class="border-2 border-gray-400 text-left py-3 px-4 font-semibold text-gray-700">Contact parents</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            <?php
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                            <tr class="table-row cursor-pointer" onclick="window.location='detaille.php?id=<?php echo $row['ideleve']; ?>'">
                                <td class="border-2 border-gray-400 py-3 px-4"><?php echo $row['matriculeeleve']; ?></td>
                                <td class="border-2 border-gray-400 py-3 px-4"><?php echo $row['nomeleve']; ?></td>
                                <td class="border-2 border-gray-400 py-3 px-4"><?php echo $row['prenomeleve']; ?></td>
                                <td class="border-2 border-gray-400 py-3 px-4"><?php echo $row['sexe']; ?></td>
                                <td class="border-2 border-gray-400 py-3 px-4"><?php echo $row['statut']; ?></td>
                                <td class="border-2 border-gray-400 py-3 px-4"><?php echo $row['contacteleve']; ?></td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            <?php
                } else {
                    echo "<p class='text-center text-blue-500 font-bold'>Aucun élève inscrit dans cette classe </p>";
                }
            } catch (PDOException $e) {
                echo "Erreur : " . $e->getMessage();
            }
            ?><br>
            <div class="flex justify-center">
                
                <h3 class="text-xl mx-6 font-bold text-gray-800 mb-4">
                    Effectif garçons : 
                    <span class="text-blue-500"><?php echo $resultBoysCount['nombregarcons']; ?></span>
                </h3>
                <h3 class="text-xl font-bold mx-6 text-gray-800 mb-2">
                    Effectif filles : 
                    <span class="text-pink-500"><?php echo $resultGirlsCount['nombrefilles']; ?></span>
                </h3>
                <h3 class="text-2xl mx-6 font-bold text-gray-800 mb-4">
                    Effectif total : 
                    <span class="text-green-500"><?php echo $resulta['nombreeleve']; ?></span>
                </h3>
                </div>
        </div>
        
    </section>
</main>
</body>
</html>
