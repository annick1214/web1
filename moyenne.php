<?php
// Inclure votre fichier de configuration de base de données
include 'setting.php';

// Vérifier si un site a été sélectionné
$idSite = isset($_GET['idSite']) ? $_GET['idSite'] : null;

// Si un site est sélectionné, récupérer les élèves associés
if ($idSite) {
    $sql_eleves = "SELECT e.idEleve, e.matriculeeleve, e.nomeleve, e.prenomeleve 
                   FROM eleve e 
                   INNER JOIN site s ON e.idSite = s.idSite 
                   WHERE s.idSite = ?";
    $requete_eleves = $base_com->prepare($sql_eleves);
    $requete_eleves->execute([$idSite]);
    $eleves = $requete_eleves->fetchAll(PDO::FETCH_ASSOC);
}

// Récupérer la liste des sites
$sql_sites = "SELECT idSite, nomSite FROM site"; // Remplacez par votre table de sites
$requete_sites = $base_com->prepare($sql_sites);
$requete_sites->execute();
$sites = $requete_sites->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Élèves par Site</title>
</head>
<body>
    <h1>Choisissez un Site</h1>

    <form action="students_by_site.php" method="GET">
        <select name="idSite" required>
            <option value="">-- Sélectionnez un site --</option>
            <?php foreach ($sites as $site): ?>
                <option value="<?php echo $site['idSite']; ?>">
                    <?php echo htmlspecialchars($site['nomSite']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Afficher les élèves</button>
    </form>

    <?php if (isset($eleves)): ?>
        <h2>Élèves du Site: <?php echo htmlspecialchars($idSite); ?></h2>
        <?php if ($eleves): ?>
            <table border="1">
                <tr>
                    <th>Matricule</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                </tr>
                <?php foreach ($eleves as $eleve): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($eleve['matriculeeleve']); ?></td>
                        <td><?php echo htmlspecialchars($eleve['nomeleve']); ?></td>
                        <td><?php echo htmlspecialchars($eleve['prenomeleve']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>Aucun élève trouvé pour ce site.</p>
        <?php endif; ?>
    <?php endif; ?>

</body>
</html>
