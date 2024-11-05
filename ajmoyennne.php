<?php
include 'setting.php'; // Connexion à la base de données
$message = '';
$matricule = ''; // Initialiser la variable matricule

// Vérifie si un matricule a été passé dans l'URL
if (isset($_GET['matricule'])) {
    $matricule = htmlspecialchars($_GET['matricule']); // Récupérer le matricule de l'élève
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $matricule = isset($_POST['matriculeeleve']) ? htmlspecialchars($_POST['matriculeeleve']) : $matricule;
    $moyennes = isset($_POST['moyenne']) ? htmlspecialchars($_POST['moyenne']) : '';
    $decision = isset($_POST['decision']) ? htmlspecialchars($_POST['decision']) : '';

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=p1', 'root', '');

        // Récupérer l'ID de l'élève et son contact
        $stmt = $pdo->prepare("SELECT ideleve, contacteleve FROM eleve WHERE matriculeeleve = :matricule");
        $stmt->bindParam(':matricule', $matricule);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $eleve = $stmt->fetch(PDO::FETCH_ASSOC);
            $eleveId = $eleve['ideleve'];
            $contact = $eleve['contacteleve'];

            // Convertir les moyennes en tableau
            $moyenneArray = explode(',', $moyennes);
            foreach ($moyenneArray as $index => $moyenne) {
                $moyenneArray[$index] = trim($moyenne); // Enlever les espaces
            }

            // Préparer la requête d'insertion des moyennes
            $stmt = $pdo->prepare("
                INSERT INTO moyenne (ideleve, moyenne, matriculeeleve) 
                VALUES (:ideleve, :moyenne, :matriculeeleve)
            ");

            $stmt->bindParam(':ideleve', $eleveId);
            $mentions = [];

            foreach ($moyenneArray as $moyenne) {
                $stmt->bindParam(':moyenne', $moyenne);
                $stmt->bindParam(':matriculeeleve', $matricule);
                $stmt->execute(); // Exécution pour chaque moyenne

                // Calcul de la mention en fonction de la moyenne
                if ($moyenne >= 16) {
                    $mention = "Très bien";
                } elseif ($moyenne >= 14) {
                    $mention = "Bien";
                } elseif ($moyenne >= 12) {
                    $mention = "Assez bien";
                } elseif ($moyenne >= 10) {
                    $mention = "Passable";
                } else {
                    $mention = "Insuffisant";
                }

                // Ajouter la mention à la liste des mentions
                $mentions[] = "Moyenne: $moyenne - Mention: $mention";
            }

            // Afficher le matricule et les mentions dans le message de confirmation
            $message = "Moyenne(s) de l'élève avec matricule $matricule mise(s) à jour avec succès.<br>";
            $message .= implode('<br>', $mentions); // Ajouter les moyennes et les mentions au message

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
    <title>Saisir les Moyennes des Élèves</title>
    <?php include 'header.php'; ?>
    <style>
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }
        input[type="text"], input[type="number"], select {
            width: 100%;
            padding: 0.4rem;
            margin-bottom: 0.3rem;
            border: 2px solid #ccc;
            border-radius: 0.25rem;
        }
        button {
            margin-top: 1rem;
        }
    </style>
</head>
<body>
<main>
    <section class="flex items-center py-2 overflow-x-auto whitespace-nowrap">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-4">Saisir les Moyennes des Élèves</h2>

            <form action="ajmoyennne.php" method="post">
                <label for="matriculeeleve">Matricule de l'élève :</label>
                <input type="text" name="matriculeeleve" value="<?php echo htmlspecialchars($matricule); ?>" required>

                <label for="moyenne">Moyennes des devoirs (séparées par des virgules) :</label>
                <input type="text" name="moyenne" required>

                <label for="decision">Décision :</label>
                <select name="decision" required>
                    <option value="admis">Aucun</option>
                    <option value="admis">Admis</option>
                    <option value="redouble">Redouble</option>
                </select><br>

                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Enregistrer</button>
                <button type="button" onclick="window.location.href='listancien.php'" class="bg-gray-500 text-white px-4 py-2 rounded-md ml-2">Retour</button>
            </form>

            <?php if (isset($message)) echo "<p class='text-green-500 mt-4'>$message</p>"; ?>
        </div>
    </section>
</main>
</body>
</html>
