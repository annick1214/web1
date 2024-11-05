<?php
include 'setting.php'; // Inclure les paramètres de connexion à la base de données

// Vérifier si l'ID de l'élève est passé dans l'URL
if (isset($_GET['id'])) {
    $eleveId = htmlspecialchars($_GET['id']);

    // Connexion à la base de données
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=p1', 'root', '');

        // Préparation de la requête pour récupérer les informations de l'élève
        $stmt = $pdo->prepare("SELECT * FROM eleve WHERE ideleve = :eleveId");
        $stmt->bindParam(':eleveId', $eleveId);
        $stmt->execute();

        // Vérifier si l'élève existe
        if ($stmt->rowCount() > 0) {
            $eleve = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            echo "<p>Aucun élève trouvé.</p>";
            exit;
        }
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
        exit;
    }
} else {
    echo "<p>ID de l'élève manquant.</p>";
    exit;
}

// Récupérer la liste des sites
$sites = [];
try {
    $stmt = $pdo->query("SELECT idSite, nomSite FROM site");
    $sites = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erreur lors de la récupération des sites : " . $e->getMessage();
}

// Traitement du formulaire de réinscription
$message = ""; // Variable pour le message
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données du formulaire
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $dateNaissance = htmlspecialchars($_POST['dateNaissance']);
    $siteId = htmlspecialchars($_POST['site']);
    $contact = htmlspecialchars($_POST['contact']);
    $sexe = htmlspecialchars($_POST['sexe']);

    try {
        // Marquer l'élève comme ancien et enlever son site
        $stmt = $pdo->prepare("UPDATE eleve SET statut = 'ancien', site = NULL WHERE ideleve = :eleveId");
        $stmt->bindParam(':eleveId', $eleveId);
        $stmt->execute();

        // Insérer les nouvelles informations de l'élève dans la classe supérieure
        $stmt = $pdo->prepare("INSERT INTO eleve (nomeleve, prenomeleve, site, contacteleve, sexe, dateAdd, statut, matriculeeleve, datenaissance) VALUES (:nom, :prenom, :site, :contact, :sexe, NOW(), 'actif', :matricule, :dateNaissance)");
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':site', $siteId);
        $stmt->bindParam(':contact', $contact);
        $stmt->bindParam(':sexe', $sexe);
        $stmt->bindParam(':matricule', $eleve['matriculeeleve']);
        $stmt->bindParam(':dateNaissance', $dateNaissance);
        $stmt->execute();

        // Récupérer le nom du nouveau site
        $stmt = $pdo->prepare("SELECT nomSite FROM site WHERE idSite = :siteId");
        $stmt->bindParam(':siteId', $siteId);
        $stmt->execute();
        $siteNom = $stmt->fetchColumn();

        // Réinscription réussie
        $message = "Réinscription réussie ! L'élève est inscrit en classe de \"$siteNom\".";
        
        // Mettre à jour l'élève pour afficher le nouveau site
        $eleve['site'] = $siteId; // Mettre à jour l'ID du site de l'élève
    } catch (PDOException $e) {
        $message = "Erreur lors de la réinscription : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinscription de l'élève</title>
    <?php include 'header.php'; ?>
    <style>
        .form-container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            text-align: center; /* Centrer le texte */
        }
        h2 {
            font-weight: bold; /* Mettre en gras */
            font-size: 24px; /* Taille de la police */
            margin-bottom: 20px;
        }
        .form-group {
            display: flex; /* Utiliser Flexbox pour les colonnes */
            flex-direction: column; /* Les éléments dans une colonne */
            margin-bottom: 15px;
            align-items: flex-start; /* Aligner à gauche */
        }
        .form-group label {
            margin-bottom: 5px; /* Espacement entre le label et le champ */
            font-weight: bold; /* Mettre les labels en gras */
        }
        .form-group input, .form-group select {
            width: 100%; /* Champs prennent toute la largeur */
            padding: 10px; /* Espacement interne pour le champ */
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .btn-submit {
            padding: 10px 15px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
            width: 100%; /* Bouton prend toute la largeur */
        }
        .btn-submit:hover {
            background-color: #218838;
        }
        .message {
            margin-bottom: 15px;
            color: #28a745; /* Couleur verte pour les messages de succès */
            font-size: 18px; /* Taille de la police du message */
        }
    </style>
</head>
<body>
<main>
    <section>
        <div class="form-container">
            <h2>Réinscription</h2>
            <?php if ($message): ?>
                <div class="message"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="matricule">Matricule</label>
                    <input type="text" id="matricule" name="matricule" value="<?php echo htmlspecialchars($eleve['matriculeeleve']); ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" value="<?php echo htmlspecialchars($eleve['nomeleve']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <input type="text" id="prenom" name="prenom" value="<?php echo htmlspecialchars($eleve['prenomeleve']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="dateNaissance">Date de Naissance</label>
                    <input type="date" id="dateNaissance" name="dateNaissance" value="<?php echo htmlspecialchars($eleve['datenaissance']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="site">Site</label>
                    <select id="site" name="site" required>
                        <option value="">Sélectionnez un site</option>
                        <?php foreach ($sites as $site): ?>
                            <option value="<?php echo htmlspecialchars($site['idSite']); ?>" <?php echo ($site['idSite'] == $eleve['site']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($site['nomSite']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="contact">Téléphone</label>
                    <input type="tel" id="contact" name="contact" value="<?php echo htmlspecialchars($eleve['contacteleve']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="sexe">Sexe</label>
                    <select id="sexe" name="sexe" required>
                        <option value="masculin" <?php echo ($eleve['sexe'] == 'masculin') ? 'selected' : ''; ?>>Masculin</option>
                        <option value="feminin" <?php echo ($eleve['sexe'] == 'feminin') ? 'selected' : ''; ?>>Féminin</option>
                    </select>
                </div>
                <button type="submit" class="btn-submit">Réinscrire</button>
            </form>
            <br>
            <a href="classe.php" class="btn-retour">Retour</a>
        </div>
    </section>
</main>
</body>
</html>
