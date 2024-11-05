<?php
include 'setting.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eleveId = htmlspecialchars($_POST['eleveId']);
    $devoir1 = htmlspecialchars($_POST['devoir1']);
    $devoir2 = htmlspecialchars($_POST['devoir2']);
    $devoir3 = htmlspecialchars($_POST['devoir3']);
    $devoir4 = htmlspecialchars($_POST['devoir4']);
    $devoir5 = htmlspecialchars($_POST['devoir5']);
    $devoir6 = htmlspecialchars($_POST['devoir6']);

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=p1', 'root', '');

        // Insérer ou mettre à jour les moyennes dans la table devoirs
        $stmt = $pdo->prepare("
            INSERT INTO devoirs (ideleve, devoir1, devoir2, devoir3, devoir4, devoir5, devoir6) 
            VALUES (:ideleve, :devoir1, :devoir2, :devoir3, :devoir4, :devoir5, :devoir6) 
            ON DUPLICATE KEY UPDATE 
                devoir1 = :devoir1, devoir2 = :devoir2, devoir3 = :devoir3, 
                devoir4 = :devoir4, devoir5 = :devoir5, devoir6 = :devoir6
        ");
        $stmt->bindParam(':ideleve', $eleveId);
        $stmt->bindParam(':devoir1', $devoir1);
        $stmt->bindParam(':devoir2', $devoir2);
        $stmt->bindParam(':devoir3', $devoir3);
        $stmt->bindParam(':devoir4', $devoir4);
        $stmt->bindParam(':devoir5', $devoir5);
        $stmt->bindParam(':devoir6', $devoir6);

        if ($stmt->execute()) {
            $message = "Moyennes mises à jour avec succès.";
        } else {
            $message = "Erreur lors de la mise à jour des moyennes.";
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
        input[type="number"] {
            width: 100%;
            padding: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 0.25rem;
        }
        button {
            margin-top: 1rem;
        }
    </style>
</head>
<body>
<main>
    <section class="dark:bg-gray-800">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-4">Saisir les Moyennes des Élèves</h2>

            <form action="" method="post">
                <label for="eleveId">ID de l'élève :</label>
                <input type="number" name="eleveId" required>

                <label for="devoir1">Devoir 1 :</label>
                <input type="number" step="0.01" name="devoir1">

                <label for="devoir2">Devoir 2 :</label>
                <input type="number" step="0.01" name="devoir2">

                <label for="devoir3">Devoir 3 :</label>
                <input type="number" step="0.01" name="devoir3">

                <label for="devoir4">Devoir 4 :</label>
                <input type="number" step="0.01" name="devoir4">

                <label for="devoir5">Devoir 5 :</label>
                <input type="number" step="0.01" name="devoir5">

                <label for="devoir6">Devoir 6 :</label>
                <input type="number" step="0.01" name="devoir6">

                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-md">Soumettre</button>
            </form>

            <?php if (isset($message)) echo "<p class='text-green-500 mt-4'>$message</p>"; ?>
        </div>
    </section>
</main>
</body>
</html>
