<?php  
include 'setting.php'; 
$message = '';
$quittance = '';

// Récupérer le matricule depuis l'URL
$matricule = isset($_GET['matricule']) ? htmlspecialchars($_GET['matricule']) : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire de paiement
    $matricule = isset($_POST['matriculeeleve']) ? htmlspecialchars($_POST['matriculeeleve']) : '';
    $montant = isset($_POST['montant']) ? htmlspecialchars($_POST['montant']) : '';

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=p1', 'root', '');

        // Récupérer les informations de l'élève
        $stmt = $pdo->prepare("SELECT ideleve, nomeleve, prenomeleve FROM eleve WHERE matriculeeleve = :matricule");
        $stmt->bindParam(':matricule', $matricule);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $eleve = $stmt->fetch(PDO::FETCH_ASSOC);
            $eleveId = $eleve['ideleve'];

            // Insérer dans la table "paye"
            $stmt = $pdo->prepare("INSERT INTO paye (ideleve, matriculeeleve, montant) VALUES (:ideleve, :matriculeeleve, :montant)");
            $stmt->bindParam(':ideleve', $eleveId);
            $stmt->bindParam(':matriculeeleve', $matricule);
            $stmt->bindParam(':montant', $montant);
            $stmt->execute();

            // Récupérer le total des montants payés
            $stmt = $pdo->prepare("SELECT SUM(montant) AS total_paye FROM paye WHERE ideleve = :ideleve");
            $stmt->bindParam(':ideleve', $eleveId);
            $stmt->execute();
            $totalPaye = $stmt->fetch(PDO::FETCH_ASSOC)['total_paye'];

            // Définir le montant total à payer
            $montantTotal = 47500; // Montant total fixé à 47 500 €
            $montantRestant = $montantTotal - $totalPaye; // Calcul du montant restant
            $dateHeure = date("d/m/Y H:i");

            // Génération de la quittance
            $quittance = "
                <div class='quittance' id='quittance-content' >
                    <h1 style='text-align: center; font-size: 18px;'>COMPLEXE SCOLAIRE PRIVE LE PARADIS </h1>
                    <h2>Quittance de Paiement</h2>
                    <div class='info-container'>
                        <div class='info'><label>Matricule :</label> " . htmlspecialchars($matricule) . "</div>
                        <div class='info'><label>Nom :</label> " . htmlspecialchars($eleve['nomeleve']) . "</div>
                        <div class='info'><label>Prénom :</label> " . htmlspecialchars($eleve['prenomeleve']) . "</div>
                        <div class='info'><label>Montant Payé :</label> " . htmlspecialchars($montant) . " €</div>
                        <div class='info'><label>Total Payé :</label> " . htmlspecialchars($totalPaye) . " €</div>
                        <div class='info'><label>Montant Restant :</label> " . htmlspecialchars($montantRestant) . " €</div>
                        <div class='info'><label>Date et Heure de Paiement :</label> " . htmlspecialchars($dateHeure) . "</div>
                    </div> 
                    
                    <div class='footer'>Merci de votre paiement!</div></br></br></br>
                     <h1 style='text-align: center; font-size: 18px;'>COMPLEXE SCOLAIRE PRIVE LE PARADIS </h1>
                    <h2>Quittance de Paiement</h2>
                    <div class='info-container'>
                        <div class='info'><label>Matricule :</label> " . htmlspecialchars($matricule) . "</div>
                        <div class='info'><label>Nom :</label> " . htmlspecialchars($eleve['nomeleve']) . "</div>
                        <div class='info'><label>Prénom :</label> " . htmlspecialchars($eleve['prenomeleve']) . "</div>
                        <div class='info'><label>Montant Payé :</label> " . htmlspecialchars($montant) . " €</div>
                        <div class='info'><label>Total Payé :</label> " . htmlspecialchars($totalPaye) . " €</div>
                        <div class='info'><label>Montant Restant :</label> " . htmlspecialchars($montantRestant) . " €</div>
                        <div class='info'><label>Date et Heure de Paiement :</label> " . htmlspecialchars($dateHeure) . "</div>
                    </div>
                    <div class='footer'>Merci de votre paiement!</div>
                </div>
                <div class='button-container'>
                    <button onclick='printQuittance()'>Imprimer</button>
                   <!-- <button onclick='saveQuittance()'>Enregistrer</button>-->
            ";
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
    <title>Formulaire de Paiement</title>
    <?php include 'header.php'; ?>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            display: flex;
            flex-direction: row;
            gap: 20px;
        }
        .form-container {
            background: white;
            border-radius: 5px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            flex: 1;
            text-align: center;
            height: 400px;
            overflow: auto;
        }
        .quittance {
            background: white;
            border: 2px solid #4CAF50;
            border-radius: 5px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
            flex: 1;
            text-align: center;
            margin-top: 10px;
        }
        h1, h2, h3 {
            color: #4CAF50;
        }
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 1rem;
            border: 2px solid #4CAF50;
            border-radius: 5px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #45a049;
        }
        .info-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            text-align: left;
        }
        .info {
            flex: 1 0 45%;
            margin-bottom: 10px;
            padding: 5px;
            box-sizing: border-box;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
        }
        .button-container {
            margin-top: 20px;
            text-align: center;
        }

        @media print {
            .button-container { 
                display: none; /* Masquer le conteneur de boutons lors de l'impression */
            }
            h1 {
                font-size: 24px;
                margin-bottom: 20px;
            }
            .quittance {
                border: none;
                box-shadow: none;
            }
        }
    </style>
    <script>
        function printQuittance() {
            const content = document.getElementById("quittance-content").innerHTML;
            const myWindow = window.open('', 'Print', 'height=600,width=800');
            myWindow.document.write('<html><head><title>Impression de Quittance</title>');
            myWindow.document.write('</head><body >');
            myWindow.document.write(content);
            myWindow.document.write('</body></html>');
            myWindow.document.close(); // nécessaire pour IE >= 10
            myWindow.focus(); // nécessaire pour IE >= 10
            myWindow.print();
            myWindow.close();
        }

        function saveQuittance() {
            const content = document.getElementById("quittance-content").innerText;
            const blob = new Blob([content], { type: 'text/plain' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'quittance.txt'; // Nom du fichier à télécharger
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }
    </script>
</head>
<body>
<main>
<div class="flex justify-between items-center py-4">
            <a href="classe3.php" class="text-gray-600 dark:text-gray-200">Retour</a>
        
        </div>
    <div class="container">
        <div class="form-container">
            <h2>Formulaire de Paiement</h2>
            <form action="payement.php" method="post">
                <label for="matriculeeleve">Matricule de l'élève :</label>
                <input type="text" name="matriculeeleve" value="<?php echo $matricule; ?>" required>

                <label for="montant">Montant du paiement :</label>
                <input type="number" name="montant" required step="0.01" min="0" placeholder="Entrez le montant en €">
                <button type="submit">Payer</button>
            </form>
            <?php if ($message) echo "<p style='color: red;'>$message</p>"; ?>
        </div>

        <div class="quittance">
            <h3>Quittance</h3>
            <?php if ($quittance) echo $quittance; else echo "<p>Aucune quittance à afficher.</p>"; ?>
        </div>
    </div>
</main>
</body>
</html>
