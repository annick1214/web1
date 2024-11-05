<?php   
include 'setting.php';

$siteId = "";
$siteName = ""; // Initialiser une variable pour stocker le nom du site

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $siteId = htmlspecialchars($_POST['id']);
}

try {
    $pdo = new PDO('mysql:host=localhost;dbname=p1', 'root', '');

    // Requête pour récupérer le nom du site
    $siteQuery = "SELECT nomSite FROM site WHERE idSite = :siteId"; 
    $siteStmt = $pdo->prepare($siteQuery);
    $siteStmt->bindParam(':siteId', $siteId);
    $siteStmt->execute();
    
    // Vérifiez si un site a été trouvé et récupérez le nom
    $siteResult = $siteStmt->fetch(PDO::FETCH_ASSOC);
    if ($siteResult) {
        $siteName = $siteResult['nomSite']; // Stocker le nom du site
    } else {
        $siteName = "Nom du site introuvable"; // Valeur par défaut si le site n'est pas trouvé
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des évaluations des élèves</title>
    <?php include 'header.php'; ?>
    <style>
        .table-row {
            cursor: pointer;
        }
        .table-row:hover {
            background-color: #d4edda;
        }
        .eval-table {
            margin-top: 10px;
            border-collapse: collapse;
            width: 100%;
        }
        .eval-table th, .eval-table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        @media print {
            .print-button {
                display: none; /* Masque le bouton lors de l'impression */
            }
        }
    </style>
    <script>
        function redirectToPayment(matricule) {
            window.location.href = "ajmoyennne.php?matricule=" + matricule;
        }

        function printPage() {
            window.print();
        }
    </script>
</head>
<body>
<main>
    <section class="dark:bg-gray-800">
        <div class="flex justify-between items-center py-4">
            <a href="classe2.php" class="text-gray-600 dark:text-gray-200">Retour</a>
            <button onclick="printPage()" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200 print-button">
                Imprimer
            </button>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="text-center mb-4">
            <h3 class="text-2xl font-bold text-gray-800">
                        <span class="text-blue-500">Classe de : <?php echo $siteName; ?></span>
                    </h3>
            </div>

            <h2 class="text-2xl font-bold mb-4">Liste des Élèves</h2>
            
            <?php
            try {
                $stmt = $pdo->prepare("
                    SELECT e.matriculeeleve, e.nomeleve, e.prenomeleve, e.contacteleve, m.moyenne
                    FROM eleve e
                    LEFT JOIN moyenne m ON e.matriculeeleve = m.matriculeeleve
                    WHERE e.site = :siteId
                    ORDER BY e.nomeleve ASC
                ");
                
                $stmt->bindParam(':siteId', $siteId);
                $stmt->execute();

                $eleves = [];
                
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $matricule = $row['matriculeeleve'];
                    $contacteleve = $row['contacteleve'];

                    if (!isset($eleves[$matricule])) {
                        $eleves[$matricule] = [
                            'nomeleve' => $row['nomeleve'],
                            'prenomeleve' => $row['prenomeleve'],
                            'contacteleve' => $contacteleve,
                            'moyennes' => [],
                        ];
                    }

                    // Ajouter la moyenne à l'élève
                    if ($row['moyenne']) {
                        $eleves[$matricule]['moyennes'][] = $row['moyenne'];
                    }
                }

                if (!empty($eleves)) {
                    $maxMoyennes = max(array_map('count', array_column($eleves, 'moyennes')));
            ?>
                <div class="overflow-x-auto">
                    <table class="eval-table">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border-2 border-gray-400 text-left py-3 px-4 font-semibold text-gray-700">Matricule</th>
                                <th class="border-2 border-gray-400 text-left py-3 px-4 font-semibold text-gray-700">Nom</th>
                                <th class="border-2 border-gray-400 text-left py-3 px-4 font-semibold text-gray-700">Prénom</th>
                                <?php
                                // Affichage dynamique des colonnes des moyennes
                                for ($i = 1; $i <= $maxMoyennes; $i++) {
                                    echo '<th class="border-2 border-gray-400 text-left py-3 px-4 font-semibold text-gray-700">ÉVAL ' . $i . '</th>';
                                }
                                ?>
                                <th class="border-2 border-gray-400 text-left py-3 px-4 font-semibold text-gray-700">Contact</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            <?php
                            foreach ($eleves as $matricule => $eleve) {
                                echo '<tr class="table-row" onclick="redirectToPayment(\'' . htmlspecialchars($matricule) . '\')">';
                                echo '<td class="border-2 border-gray-400 py-3 px-4">' . htmlspecialchars($matricule) . '</td>';
                                echo '<td class="border-2 border-gray-400 py-3 px-4">' . htmlspecialchars($eleve['nomeleve']) . '</td>';
                                echo '<td class="border-2 border-gray-400 py-3 px-4">' . htmlspecialchars($eleve['prenomeleve']) . '</td>';
                                
                                // Affichage des moyennes et des mentions dans une seule cellule
                                foreach ($eleve['moyennes'] as $moyenne) {
                                    $mention = getMention($moyenne);
                                    echo '<td class="border-2 border-gray-400 py-3 px-4">' . htmlspecialchars($moyenne) . '<br><small>' . htmlspecialchars($mention) . '</small></td>';
                                }
                                
                                // Compléter les colonnes vides si pas de moyenne
                                for ($j = count($eleve['moyennes']); $j < $maxMoyennes; $j++) {
                                    echo '<td class="border-2 border-gray-400 py-3 px-4">N/A</td>';
                                }
                                
                                // Afficher le contact à la fin
                                echo '<td class="border-2 border-gray-400 py-3 px-4">' . htmlspecialchars($eleve['contacteleve']) . '</td>';
                                
                                echo '</tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            <?php
                } else {
                    echo "<p class='text-center text-blue-500 font-bold'>Aucun élève inscrit dans cette classe</p>";
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

<?php
function getMention($moyenne) {
    if ($moyenne < 0 || $moyenne > 20) {
        return "Moyenne invalide";
    } elseif ($moyenne >= 16) {
        return "Excellent";
    } elseif ($moyenne >= 14) {
        return "Très bien";
    } elseif ($moyenne >= 12) {
        return "Bien";
    } elseif ($moyenne >= 10) {
        return "Passable";
    } elseif ($moyenne >= 8) {
        return "Insuffisant";
    } else {
        return "Très insuffisant";
    }
}
?>
