<?php
include 'setting.php'; // Connexion à la base de données

$matricule = isset($_GET['matricule']) ? htmlspecialchars($_GET['matricule']) : '';
$montant = isset($_GET['montant']) ? htmlspecialchars($_GET['montant']) : '';
$nomeleve = '';
$prenomeleve = '';
$reste_a_payer = 0;

if ($matricule) {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=p1', 'root', '');

        // Récupérer les informations de l'élève
        $stmt = $pdo->prepare("SELECT nomeleve, prenomeleve FROM eleve WHERE matriculeeleve = :matricule");
        $stmt->bindParam(':matricule', $matricule);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $eleve = $stmt->fetch(PDO::FETCH_ASSOC);
            $nomeleve = $eleve['nomeleve'];
            $prenomeleve = $eleve['prenomeleve'];

            // Calculer le reste à payer
            $stmt = $pdo->prepare("SELECT SUM(montant) as total_paye FROM paye WHERE matriculeeleve = :matricule");
            $stmt->bindParam(':matricule', $matricule);
            $stmt->execute();
            $total_paye = $stmt->fetch(PDO::FETCH_ASSOC)['total_paye'];
            $reste_a_payer = 47500 - $total_paye;
        } else {
            $message = "Aucun élève trouvé avec ce matricule.";
        }
    } catch (PDOException $e) {
        $message = "Erreur : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quittance de Paiement</title>
    <style>
        body {
            text-align: center;
        }
        h1, h2 {
            margin: 20px 0;
        }
        @media print {
            button {
                display: none; /* Masquer le bouton lors de l'impression */
            }
        }
    </style>
</head>
<body>
    <h1>École Primaire Le Paradis</h1>
    <h2>Quittance de Paiement</h2>
    <p><strong>Matricule :</strong> <?php echo $matricule; ?></p>
    <p><strong>Nom :</strong> <?php echo $nomeleve; ?></p>
    <p><strong>Prénom :</strong> <?php echo $prenomeleve; ?></p>
    <p><strong>Montant Payé :</strong> <?php echo $montant; ?> €</p>
    <p><strong>Reste à Payer :</strong> <?php echo $reste_a_payer; ?> €</p>
    <p>Merci pour votre paiement !</p>
    <button onclick="window.print()">Imprimer la Quittance</button>
</body>
</html>
