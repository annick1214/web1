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
    <title>Liste des paiements des élèves</title>
    <?php include 'header.php'; ?>
    <style>
        .table-row {
            cursor: pointer;
        }
        .table-row:hover {
            background-color: #d4edda;
        }
        .paye-table {
            margin-top: 10px;
            border-collapse: collapse;
            width: 100%;
        }
        .paye-table th, .paye-table td {
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
            window.location.href = "payement.php?matricule=" + matricule;
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
            <a href="classe3.php" class="text-gray-600 dark:text-gray-200">Retour</a>
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
            <h2 class="text-2xl font-bold mb-4">Liste de Paiement des Élèves</h2>
            
            <?php
            try {
                $stmt = $pdo->prepare("
                    SELECT e.matriculeeleve, e.nomeleve, e.prenomeleve, e.contacteleve,
                           COALESCE(GROUP_CONCAT(p.montant ORDER BY p.idpaye), '') AS paiements
                    FROM eleve e
                    LEFT JOIN paye p ON e.matriculeeleve = p.matriculeeleve
                    WHERE e.site = :siteId
                    GROUP BY e.matriculeeleve
                    ORDER BY e.nomeleve ASC
                ");
                
                $stmt->bindParam(':siteId', $siteId);
                $stmt->execute();

                $eleves = [];
                $currentYear = date("Y");

                // Dates limites pour chaque tranche
                $dates = [
                    'tranche1' => "02-10-$currentYear",
                    'tranche2' => "02-12-" . ($currentYear),
                    'tranche3' => "02-02-" . ($currentYear + 1)
                ];

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $matricule = $row['matriculeeleve'];
                    $paiements = explode(',', $row['paiements']);
                    $total_paye = array_sum($paiements);

                    // Définir les frais d'inscription avec un maximum de 2500
                    $frais_inscription = min($total_paye, 2500);
                    $rester = max(0, $total_paye - 2500);

                    // Montants fixes pour chaque tranche
                    $tranche1 = min($rester, 25000);
                    $rester -= $tranche1;

                    $tranche2 = min($rester, 10000);
                    $rester -= $tranche2;

                    $tranche3 = min($rester, 10000);

                    // Total
                    $total = $frais_inscription + $tranche1 + $tranche2 + $tranche3;

                    // Reste à Payer
                    $reste_a_payer = 47500 - $total;

                    // Notification par SMS
                    $contacteleve = $row['contacteleve'];

                    foreach ($dates as $tranche => $date) {
                        $dateLimite = strtotime($date);
                        $dateAlerte7jours = strtotime("-7 days", $dateLimite);
                        $dateAlerte3jours = strtotime("-3 days", $dateLimite);

                        if (time() >= $dateAlerte7jours && time() < $dateLimite) {
                            $montantRestant = ${$tranche}; // Montant de la tranche à payer
                            // Envoyer SMS
                            // Ici, vous pouvez intégrer votre logique d'envoi de SMS
                            // sendSMS($contacteleve, "Rappel : Vous devez payer la tranche " . ucfirst($tranche) . " de " . $montantRestant . " avant le " . date('d-m-Y', $dateLimite));
                        } elseif (time() >= $dateAlerte3jours && time() < $dateLimite) {
                            $montantRestant = ${$tranche}; // Montant de la tranche à payer
                            // Envoyer SMS
                            // sendSMS($contacteleve, "Rappel : Vous devez payer la tranche " . ucfirst($tranche) . " de " . $montantRestant . " avant le " . date('d-m-Y', $dateLimite));
                        }
                    }

                    $eleves[$matricule] = [
                        'nomeleve' => $row['nomeleve'],
                        'prenomeleve' => $row['prenomeleve'],
                        'contacteleve' => $contacteleve,
                        'frais_inscription' => $frais_inscription,
                        'tranche1' => $tranche1,
                        'tranche2' => $tranche2,
                        'tranche3' => $tranche3,
                        'total' => $total,
                        'reste_a_payer' => $reste_a_payer,
                    ];
                }

                if (!empty($eleves)) {
            ?>
                <div class="overflow-x-auto">
                    <table class="paye-table">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border-2 border-gray-400 text-left py-3 px-4 font-semibold text-gray-700">Matricule</th>
                                <th class="border-2 border-gray-400 text-left py-3 px-4 font-semibold text-gray-700">Nom</th>
                                <th class="border-2 border-gray-400 text-left py-3 px-4 font-semibold text-gray-700">Prénom</th>
                                <th class="border-2 border-gray-400 text-left py-3 px-4 font-semibold text-gray-700">Frais d'inscription</th>
                                <th class="border-2 border-gray-400 text-left py-3 px-4 font-semibold text-gray-700">Tranche 1</th>
                                <th class="border-2 border-gray-400 text-left py-3 px-4 font-semibold text-gray-700">Tranche 2</th>
                                <th class="border-2 border-gray-400 text-left py-3 px-4 font-semibold text-gray-700">Tranche 3</th>
                                <th class="border-2 border-gray-400 text-left py-3 px-4 font-semibold text-gray-700">Total</th>
                                <th class="border-2 border-gray-400 text-left py-3 px-4 font-semibold text-gray-700">Reste à Payer</th>
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
                                echo '<td class="border-2 border-gray-400 py-3 px-4">' . htmlspecialchars($eleve['frais_inscription']) . '</td>';
                                echo '<td class="border-2 border-gray-400 py-3 px-4">' . htmlspecialchars($eleve['tranche1']) . '</td>';
                                echo '<td class="border-2 border-gray-400 py-3 px-4">' . htmlspecialchars($eleve['tranche2']) . '</td>';
                                echo '<td class="border-2 border-gray-400 py-3 px-4">' . htmlspecialchars($eleve['tranche3']) . '</td>';
                                echo '<td class="border-2 border-gray-400 py-3 px-4">' . htmlspecialchars($eleve['total']) . '</td>';
                                echo '<td class="border-2 border-gray-400 py-3 px-4">' . htmlspecialchars($eleve['reste_a_payer']) . '</td>';
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
