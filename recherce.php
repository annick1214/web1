<?php
include 'setting.php'; // Inclure les paramètres de connexion à la base de données

// Variable pour le message de recherche
$message = "";
$eleve = null;

// Récupérer les suggestions pour le champ de recherche
if (isset($_GET['term'])) {
    $term = htmlspecialchars($_GET['term']);
    $suggestions = [];
    
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=p1', 'root', '');
        
        $stmt = $pdo->prepare("
            SELECT CONCAT(nomeleve, ' ', prenomeleve) AS fullName
            FROM eleve
            WHERE nomeleve LIKE :term OR prenomeleve LIKE :term
            LIMIT 10
        ");
        $term = "$term%"; // On recherche les noms qui commencent par le terme
        $stmt->bindParam(':term', $term);
        $stmt->execute();
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $suggestions[] = $row['fullName'];
        }
    } catch (PDOException $e) {
        // Gérer l'erreur si nécessaire
    }
    echo json_encode($suggestions);
    exit;
}

// Traitement de la recherche par nom, prénom ou matricule
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $searchTerm = htmlspecialchars($_POST['fullName']);

    // Connexion à la base de données
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=p1', 'root', '');

        // Vérifier si c'est un matricule ou un nom
        if (is_numeric($searchTerm)) {
            $stmt = $pdo->prepare("
                SELECT eleve.*, site.nomSite 
                FROM eleve 
                LEFT JOIN site ON eleve.site = site.idSite 
                WHERE eleve.matriculeeleve = :matricule
            ");
            $stmt->bindParam(':matricule', $searchTerm);
        } else {
            $names = explode(' ', $searchTerm, 2); // Séparer le nom et le prénom
            $nom = $names[0]; // Premier mot est le nom
            $prenom = isset($names[1]) ? $names[1] : ''; // Deuxième mot est le prénom, s'il existe

            $stmt = $pdo->prepare("
                SELECT eleve.*, site.nomSite 
                FROM eleve 
                LEFT JOIN site ON eleve.site = site.idSite 
                WHERE eleve.nomeleve = :nom AND eleve.prenomeleve = :prenom
            ");
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
        }
        
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $eleve = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $message = "Aucun élève trouvé avec ce nom, prénom ou matricule.";
        }
    } catch (PDOException $e) {
        $message = "Erreur lors de la recherche : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recherche d'Élève</title>
    <?php include 'header.php'; ?>
    <style>
        .form-container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            text-align: center;
        }
        h2 {
            font-weight: bold;
            font-size: 28px; /* Agrandi */
            margin-bottom: 20px;
        }
        .form-group {
            display: flex;
            align-items: center; /* Centrer verticalement */
            margin-bottom: 15px;
        }
        .form-group label {
            margin-right: 10px; /* Espace entre le label et le champ */
            font-weight: bold;
            font-size: 20px; /* Agrandi */
        }
        .form-group input {
            flex: 1; /* Prendre l'espace restant */
            padding: 15px; /* Agrandi */
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 18px; /* Agrandi */
        }
        .btn-submit {
            padding: 15px 20px; /* Agrandi */
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 10px; /* Espace entre le champ et le bouton */
            font-size: 18px; /* Agrandi */
        }
        .btn-submit:hover {
            background-color: #0056b3;
        }
        .suggestions {
            border: 1px solid #ccc;
            background: white;
            position: absolute;
            z-index: 1000;
            width: calc(100% - 2px); /* Ajuster pour correspondre au champ */
            max-height: 200px;
            overflow-y: auto;
            margin-top: 5px; /* Espace entre le champ et les suggestions */
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2); /* Ajout d'une ombre pour un meilleur contraste */
        }
        .suggestion-item {
            padding: 10px;
            cursor: pointer;
        }
        .suggestion-item:hover {
            background-color: #f0f0f0;
        }
        .message {
            margin-bottom: 15px;
            color: #dc3545; /* Couleur rouge pour les messages d'erreur */
            font-size: 20px; /* Agrandi */
        }
        .eleve-info {
            margin-top: 20px;
            text-align: left;
            background-color: #e2f0d9;
            padding: 20px; /* Agrandi */
            border-radius: 5px;
            font-size: 18px; /* Agrandi */
        }
        .eleve-info p {
            margin: 5px 0; /* Ajout d'espace entre les paragraphes */
        }
    </style>
    <script>
        function fetchSuggestions() {
            let input = document.getElementById('fullName').value;
            if (input.length < 1) {
                document.getElementById('suggestions').innerHTML = '';
                return;
            }
            fetch(`?term=${encodeURIComponent(input)}`)
                .then(response => response.json())
                .then(data => {
                    let suggestionsContainer = document.getElementById('suggestions');
                    suggestionsContainer.innerHTML = '';
                    data.forEach(item => {
                        let div = document.createElement('div');
                        div.className = 'suggestion-item';
                        div.textContent = item;
                        div.onclick = () => {
                            document.getElementById('fullName').value = item;
                            suggestionsContainer.innerHTML = '';
                        };
                        suggestionsContainer.appendChild(div);
                    });
                });
        }
    </script>
</head>
<body>
<main>
    <section>
        <div class="form-container">
            <h2>Recherche d'Élève</h2>
            <?php if ($message): ?>
                <div class="message"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            <form method="POST" action="">
                <div class="form-group">
                    <input type="text" id="fullName" name="fullName" placeholder="Nom Prénom ou Matricule" required oninput="fetchSuggestions()">
                    <button type="submit" class="btn-submit">Rechercher</button>
                </div>
                <div id="suggestions" class="suggestions"></div>
            </form>

            <?php if ($eleve): ?>
                <div class="eleve-info">
                    <h3>Informations de l'Élève</h3>
                    <p><strong>Matricule :</strong> <?php echo htmlspecialchars($eleve['matriculeeleve']); ?></p>
                    <p><strong>Nom :</strong> <?php echo htmlspecialchars($eleve['nomeleve']); ?></p>
                    <p><strong>Prénom :</strong> <?php echo htmlspecialchars($eleve['prenomeleve']); ?></p>
                    <p><strong>Date de Naissance :</strong> <?php echo htmlspecialchars($eleve['datenaissance']); ?></p>
                    <p><strong>Site :</strong> <?php echo htmlspecialchars($eleve['nomSite']); ?></p>
                    <p><strong>Contact :</strong> <?php echo htmlspecialchars($eleve['contacteleve']); ?></p>
                    <p><strong>Sexe :</strong> <?php echo htmlspecialchars($eleve['sexe']); ?></p>
                    <p><strong>Statut :</strong> <?php echo htmlspecialchars($eleve['statut']); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>
</body>
</html>
