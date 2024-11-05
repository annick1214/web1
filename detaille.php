<?php  
include 'setting.php'; // Inclure les paramètres de connexion à la base de données

// Vérifier si l'ID de l'élève est passé dans l'URL
if (isset($_GET['id'])) {
    $eleveId = htmlspecialchars($_GET['id']);

    try {
        // Connexion à la base de données
        $pdo = new PDO('mysql:host=localhost;dbname=p1', 'root', '');

        // Préparation de la requête pour récupérer les informations de l'élève
        $stmt = $pdo->prepare("SELECT e.*, s.nomSite FROM eleve e JOIN site s ON e.site = s.idSite WHERE e.ideleve = :eleveId");
        $stmt->bindParam(':eleveId', $eleveId);
        $stmt->execute();

        // Vérifier si l'élève existe
        if ($stmt->rowCount() > 0) {
            $eleve = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            echo "<p>Aucun élève trouvé.</p>";
            exit;
        }
        
        // Récupérer l'historique avec moyennes et paiements
        $stmtHistorique = $pdo->prepare("
            SELECT s.nomSite, AVG(hs.moyenne) AS moyenne, SUM(hs.paiement) AS total_paiement 
            FROM historique_site hs 
            JOIN site s ON hs.site_id = s.idSite 
            WHERE hs.eleve_id = :eleveId
            GROUP BY s.idSite
        ");
        $stmtHistorique->bindParam(':eleveId', $eleveId);
        $stmtHistorique->execute();
        $historique = $stmtHistorique->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        exit;
    }
} else {
    echo "<p>ID de l'élève manquant.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de l'élève</title>
    <?php include 'header.php'; ?>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn-retour, .btn-reinscription {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }
        .btn-retour:hover, .btn-reinscription:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<main>
    <section class="dark:bg-gray-800">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Détails de l'élève</h2>
            <table>
                <tr>
                    <th>Matricule</th>
                    <td><?php echo htmlspecialchars($eleve['matriculeeleve']); ?></td>
                </tr>
                <tr>
                    <th>Nom</th>
                    <td><?php echo htmlspecialchars($eleve['nomeleve']); ?></td>
                </tr>
                <tr>
                    <th>Prénom</th>
                    <td><?php echo htmlspecialchars($eleve['prenomeleve']); ?></td>
                </tr>
                <tr>
                    <th>Date de naissance</th>
                    <td><?php echo htmlspecialchars($eleve['datenaissance']); ?></td>
                </tr>
                <tr>
                    <th>Sexe</th>
                    <td><?php echo htmlspecialchars($eleve['sexe']); ?></td>
                </tr>
                <tr>
                    <th>Site Actuel</th>
                    <td><?php echo htmlspecialchars($eleve['nomSite']); ?></td>
                </tr>
                <tr>
                    <th>Téléphone</th>
                    <td><?php echo htmlspecialchars($eleve['contacteleve']); ?></td>
                </tr>
                <tr>
                    <th>Date d'ajout</th>
                    <td><?php echo htmlspecialchars($eleve['dateAdd']); ?></td>
                </tr>
                <tr>
                    <th>Statut</th>
                    <td><?php echo htmlspecialchars($eleve['statut']); ?></td>
                </tr>
            </table><br>

           <!-- <h3 class="text-xl font-bold text-gray-800 mt-4">Historique des Sites</h3>
            <table>
                <tr>
                    <th>Nom du Site</th>
                    <th>Moyenne</th>
                    <th>Montant Total des Paiements</th>
                    <th>Reste à Payer</th>
                </tr>
                <?php if (!empty($historique)): ?>
                    <?php foreach ($historique as $item): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($item['nomSite']); ?></td>
                            <td><?php echo htmlspecialchars($item['moyenne']); ?></td>
                            <td><?php echo htmlspecialchars($item['total_paiement']); ?></td>
                            <td><?php echo htmlspecialchars($montantTotal - $item['total_paiement']); ?></td> <!-- Remplacez $montantTotal par votre variable de montant total -->
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">Aucun historique trouvé.</td>
                    </tr>
                <?php endif; ?>
            </table><br>
                -->
            <a href="classe.php" class="btn-retour">Retour</a>
            <a href="reinscription.php?id=<?php echo $eleveId; ?>" class="btn-reinscription">Réinscription</a>
        </div>
    </section>
</main>
</body>
</html>
