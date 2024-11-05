<?php 
// Informations du paiement
$matricule = "123456"; // Remplacer par la valeur dynamique
$nom = "Dupont"; // Remplacer par la valeur dynamique
$prenom = "Jean"; // Remplacer par la valeur dynamique
$classe = "1A"; // Remplacer par la valeur dynamique
$montantPaye = 100; // Remplacer par la valeur dynamique
$montantRestant = 50; // Remplacer par la valeur dynamique
$dateHeure = date("d/m/Y H:i"); // Date et heure actuelles

// Générer la quittance
echo '
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quittance de Paiement</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .quittance {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            background: white;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        h2 {
            text-align: center;
            color: green;
        }
        .info {
            margin-bottom: 15px;
        }
        .info label {
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 0.9em;
            color: #777;
        }
        .button-container {
            margin-bottom: 20px;
            text-align: center;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            background-color: green;
            color: white;
            border: none;
            border-radius: 5px;
            margin: 0 10px;
        }
    </style>
</head>
<body>

<div class="button-container">
    <button onclick="printPDF()">Imprimer la Quittance</button>
    <button onclick="savePDF()">Enregistrer la Quittance</button>
</div>

<div class="quittance" id="quittance-content">
    <h2>Quittance de Paiement</h2>
    <div class="info">
        <label>Matricule :</label> ' . htmlspecialchars($matricule) . '
    </div>
    <div class="info">
        <label>Nom :</label> ' . htmlspecialchars($nom) . '
    </div>
    <div class="info">
        <label>Prénom :</label> ' . htmlspecialchars($prenom) . '
    </div>
    <div class="info">
        <label>Classe :</label> ' . htmlspecialchars($classe) . '
    </div>
    <div class="info">
        <label>Montant Payé :</label> ' . htmlspecialchars($montantPaye) . ' €
    </div>
    <div class="info">
        <label>Montant Restant :</label> ' . htmlspecialchars($montantRestant) . ' €
    </div>
    <div class="info">
        <label>Date et Heure de Paiement :</label> ' . htmlspecialchars($dateHeure) . '
    </div>
    <div class="footer">
        Merci de votre paiement!
    </div>
</div>

<script>
    function printPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        // Récupérer le contenu de la quittance
        const content = document.getElementById("quittance-content").innerHTML;

        // Ajouter le contenu au PDF
        doc.fromHTML(content, 15, 15);

        // Enregistrer le PDF
        doc.save("quittance.pdf");
    }

    function savePDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        // Récupérer le contenu de la quittance
        const content = document.getElementById("quittance-content").innerHTML;

        // Ajouter le contenu au PDF
        doc.fromHTML(content, 15, 15);

        // Enregistrer le PDF
        doc.save("quittance.pdf");
    }
</script>

</body>
</html>
';
?>
