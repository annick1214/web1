<?php    
include 'setting.php';

$siteId = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $siteId = htmlspecialchars($_POST['id']);
}

// Dates limites pour les tranches
$dateTranche1 = new DateTime("2024-10-02");
$dateTranche2 = new DateTime("2024-12-02");
$dateTranche3 = new DateTime("2025-02-02");

$notifications = []; // Pour stocker les notifications à envoyer

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des paiements des anciens élèves</title>
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
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-4">Liste de Paiement des Élèves</h2>
            <div class="flex justify-end mb-4">
                <button onclick="printPage()" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200 print-button">
                    Imprimer
                </button>
            </div>
            <?php
            try {
                $pdo = new PDO('mysql:host=localhost;dbname=p1', 'root', '');

                $stmt = $pdo->prepare("
                    SELECT e.matriculeeleve, e.nomeleve, e.prenomeleve, e.contacteleve,
                           GROUP_CONCAT(p.montant ORDER BY p.idpaye) AS paiements
                    FROM eleve e
                    LEFT JOIN paye p ON e.matriculeeleve = p.matriculeeleve
                    WHERE e.site = :siteId AND e.statut = 'A'
                    GROUP BY e.matriculeeleve
                    ORDER BY e.nomeleve ASC
                ");
                $stmt->bindParam(':siteId', $siteId);
                $stmt->execute();

                $eleves = [];

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $matricule = $row['matriculeeleve'];
                    $paiements = explode(',', $row['paiements']);
                    $total_paye = array_sum($paiements);

                    // Définir les frais d'inscription avec un maximum de 2500
                    $frais_inscription = min($total_paye, 2500);
                    $rester = max(0, $total_paye - 2500);

                    // Tranche 1
                    $tranche1 = min($rester, 25000);
                    $rester -= $tranche1;

                    // Tranche 2
                    $tranche2 = min($rester, 10000);
                    $rester -= $tranche2;

                    // Tranche 3
                    $tranche3 = min($rester, 10000);

                    // Total
                    $total = $frais_inscription + $tranche1 + $tranche2 + $tranche3;

                    // Reste à Payer
                    $reste_a_payer = 47500 - $total;

                    $eleves[$matricule] = [
                        'nomeleve' => $row['nomeleve'],
                        'prenomeleve' => $row['prenomeleve'],
                        'contacteleve' => $row['contacteleve'],
                        'frais_inscription' => $frais_inscription,
                        'tranche1' => $tranche1,
                        'tranche2' => $tranche2,
                        'tranche3' => $tranche3,
                        'total' => $total,
                        'reste_a_payer' => $reste_a_payer,
                    ];

                    // Vérification des notifications
                    $contacteleve = $row['contacteleve'];
                    $currentDate = new DateTime();

                    // Notification pour Tranche 1
                    if ($currentDate > $dateTranche1) {
                        // Tranche déjà échue
                        $notifications[] = "Le paiement de la tranche 1 pour $matricule est en retard. Contact: $contacteleve.";
                    } elseif ($currentDate >= $dateTranche1->modify('-7 days') && $currentDate <= $dateTranche1) {
                        $notifications[] = "Rappel: La tranche 1 de $matricule doit être payée au plus tard le " . $dateTranche1->format('d/m/Y') . ". Reste à payer: " . $tranche1;
                    } elseif ($currentDate >= $dateTranche1->modify('-2 days') && $currentDate <= $dateTranche1) {
                        $notifications[] = "Urgent: La tranche 1 de $matricule doit être payée au plus tard le " . $dateTranche1->format('d/m/Y') . ". Reste à payer: " . $tranche1;
                    }

                    // Réinitialiser la date pour la tranche 2
                    $dateTranche1 = new DateTime("2024-10-02");

                    // Notification pour Tranche 2
                    if ($currentDate > $dateTranche2) {
                        $notifications[] = "Le paiement de la tranche 2 pour $matricule est en retard. Contact: $contacteleve.";
                    } elseif ($currentDate >= $dateTranche2->modify('-7 days') && $currentDate <= $dateTranche2) {
                        $notifications[] = "Rappel: La tranche 2 de $matricule doit être payée au plus tard le " . $dateTranche2->format('d/m/Y') . ". Reste à payer: " . $tranche2;
                    } elseif ($currentDate >= $dateTranche2->modify('-2 days') && $currentDate <= $dateTranche2) {
                        $notifications[] = "Urgent: La tranche 2 de $matricule doit être payée au plus tard le " . $dateTranche2->format('d/m/Y') . ". Reste à payer: " . $tranche2;
                    }

                    // Réinitialiser la date pour la tranche 3
                    $dateTranche2 = new DateTime("2024-12-02");

                    // Notification pour Tranche 3
                    if ($currentDate > $dateTranche3) {
                        $notifications[] = "Le paiement de la tranche 3 pour $matricule est en retard. Contact: $contacteleve.";
                    } elseif ($currentDate >= $dateTranche3->modify('-7 days') && $currentDate <= $dateTranche3) {
                        $notifications[] = "Rappel: La tranche 3 de $matricule doit être payée au plus tard le " . $dateTranche3->format('d/m/Y') . ". Reste à payer: " . $tranche3;
                    } elseif ($currentDate >= $dateTranche3->modify('-2 days') && $currentDate <= $dateTranche3) {
                        $notifications[] = "Urgent: La tranche 3 de $matricule doit être payée au plus tard le " . $dateTranche3->format('d/m/Y') . ". Reste à payer: " . $tranche3;
                    }
                }

                if (!empty($notifications)) {
                    echo "<div class='bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4'>";
                    foreach ($notifications as $notification) {
                        echo "<p>$notification</p>";
                    }
                    echo "</div>";
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
                                $nomeleve = htmlspecialchars($eleve['nomeleve']);
                                $prenomeleve = htmlspecialchars($eleve['prenomeleve']);
                                $contacteleve = htmlspecialchars($eleve['contacteleve']);
                                $frais_inscription = htmlspecialchars($eleve['frais_inscription']);
                                $tranche1 = htmlspecialchars($eleve['tranche1']);
                                $tranche2 = htmlspecialchars($eleve['tranche2']);
                                $tranche3 = htmlspecialchars($eleve['tranche3']);
                                $total = htmlspecialchars($eleve['total']);
                                $reste_a_payer = htmlspecialchars($eleve['reste_a_payer']);

                                echo '<tr class="table-row" onclick="redirectToPayment(\'' . htmlspecialchars($matricule) . '\')">';
                                echo '<td class="border-2 border-gray-400 py-3 px-4">' . htmlspecialchars($matricule) . '</td>';
                                echo '<td class="border-2 border-gray-400 py-3 px-4">' . $nomeleve . '</td>';
                                echo '<td class="border-2 border-gray-400 py-3 px-4">' . $prenomeleve . '</td>';
                                echo '<td class="border-2 border-gray-400 py-3 px-4">' . $frais_inscription . '</td>';
                                echo '<td class="border-2 border-gray-400 py-3 px-4">' . $tranche1 . '</td>';
                                echo '<td class="border-2 border-gray-400 py-3 px-4">' . $tranche2 . '</td>';
                                echo '<td class="border-2 border-gray-400 py-3 px-4">' . $tranche3 . '</td>';
                                echo '<td class="border-2 border-gray-400 py-3 px-4">' . $total . '</td>';
                                echo '<td class="border-2 border-gray-400 py-3 px-4">' . $reste_a_payer . '</td>';
                                echo '<td class="border-2 border-gray-400 py-3 px-4">' . $contacteleve . '</td>';
                                echo '</tr>';
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
    </section>
</main>
</body>
</html>



<?php
// Code de connexion à la base de données
include 'setting.php';

$matricule = ""; // Initialiser la variable

// Vérifier si le matricule a été passé en paramètre
if (isset($_GET['matricule'])) {
    $matricule = htmlspecialchars($_GET['matricule']);
}

// Le reste de ton code pour afficher les informations de l'élève ou le formulaire
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de l'Élève</title>
    <?php include 'header.php'; ?>
</head>
<body>
<main>
    <div>
        <h2>Détails de l'Élève</h2>
        <form method="POST" action="traitement.php">
            <input type="hidden" name="matricule" value="<?php echo $matricule; ?>">
            <label for="ajout_eval">Ajouter une évaluation :</label>
            <input type="number" id="ajout_eval" name="ajout_eval" required>
            <button type="submit">Envoyer</button>
        </form>
    </div>
</main>
</body>
</html>
