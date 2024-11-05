<?php 
include 'setting.php';
$querySites = "SELECT idSite, nomSite FROM site";
$stmtSites = $base_com->prepare($querySites);
$stmtSites->execute();
$sites = $stmtSites->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comptable-Matière - E-Gest | Statistique Générale</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <!-- Sidebar -->
          <?php
           include 'header.php';
           ?>

    <div class="flex items-center py-4 overflow-x-auto whitespace-nowrap">
        <!--<a href="index.php" class="text-gray-600 dark:text-gray-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
            </svg>
        </a>-->
    
       
        <a href="statsg.phps" class="flex items-center text-gray-600 -px-2 dark:text-gray-200 hover:underline">
            
            <span class="mx-5 text-gray-500 dark:text-gray-300 rtl:-scale-x-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                </svg>
            </span>
            <span class="mx-2">Retour</span>

        </a>
        
    
    
    </div>               
    <section class="container px-4 mx-auto mt-10">
        <div class="flex items-center gap-x-3">
            <h2 class="text-lg font-medium text-gray-800 dark:text-white">Sélectionnez une classe</h2>
        </div>
        <form method="POST" class="mt-5">
            <select name="idSite" class="p-2 bg-white border border-gray-300 rounded">
                <?php foreach ($sites as $site): ?>
                    <option value="<?php echo htmlspecialchars($site['idSite']); ?>">
                        <?php echo htmlspecialchars($site['nomSite']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded">Afficher les statistiques</button>
        </form>
    </section>
    <?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idSite'])) {
    $idSite = (int)$_POST['idSite'];

    $queryStats = "
        SELECT 
            s.nomSite,
            cm.nomCategorie,
            COUNT(CASE WHEN rm.etatMaterielle = 'nouveau' THEN 1 END) AS Neuf,
            COUNT(CASE WHEN rm.etatMaterielle = 'bonne' THEN 1 END) AS Bon,
            COUNT(CASE WHEN rm.etatMaterielle = 'vielle' THEN 1 END) AS Mauvais,
            COUNT(*) AS Total
        FROM ressourcematerielle rm
        INNER JOIN categoriematerielle cm ON rm.typeMaterielle = cm.idCategorie
        INNER JOIN attribution a ON rm.idMaterielle = a.idMaterielle
        INNER JOIN site s ON a.idSite = s.idSite
        WHERE a.idSite = :idSite
        GROUP BY s.nomSite, cm.nomCategorie
    ";

    $stmtStats = $base_com->prepare($queryStats);
    $stmtStats->bindParam(':idSite', $idSite, PDO::PARAM_INT);
    $stmtStats->execute();
    $stats = $stmtStats->fetchAll(PDO::FETCH_ASSOC);
?>
    <section class="container px-4 mx-auto mt-10">
        <div class="flex items-center gap-x-3">
            <h2 class="text-lg font-medium text-gray-800 dark:text-white">Statistiques pour la classe</h2>
        </div>
        <div class="w-full text-black dark:text-white">
            <div class="container flex flex-col items-center gap-10 mx-auto mt-5">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-y-8">
                    <?php foreach ($stats as $index => $row): ?>
                        <div class="flex flex-col items-center mx-5">
                            <p class="text-1xl font-medium leading-7 text-center text-dark-grey-600 mt-4">
                                <?php echo htmlspecialchars($row['nomSite']); ?> - <?php echo htmlspecialchars($row['nomCategorie']); ?>
                            </p>
                            <ul class="text-base font-medium leading-7 text-center dark:text-gray-300 mt-3">
                                <li>Total: <?php echo htmlspecialchars($row['Total']); ?></li>
                                <li>Neuf: <?php echo htmlspecialchars($row['Neuf']); ?></li>
                                <li>Bon: <?php echo htmlspecialchars($row['Bon']); ?></li>
                                <li>Mauvais: <?php echo htmlspecialchars($row['Mauvais']); ?></li>
                            </ul>
                            <canvas id="chart<?php echo $index; ?>" width="400" height="400"></canvas>
                        </div>
                        <script>
                            var ctx = document.getElementById('chart<?php echo $index; ?>').getContext('2d');
                            new Chart(ctx, {
                                type: 'pie',
                                data: {
                                    labels: ['Neuf', 'Bon', 'Mauvais'],
                                    datasets: [{
                                        data: [<?php echo $row['Neuf']; ?>, <?php echo $row['Bon']; ?>, <?php echo $row['Mauvais']; ?>],
                                        backgroundColor: ['#4CAF50', '#03A9F4', '#F44336']
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    plugins: {
                                        legend: {
                                            position: 'top',
                                        },
                                        tooltip: {
                                            callbacks: {
                                                label: function(tooltipItem) {
                                                    return tooltipItem.label + ': ' + tooltipItem.raw;
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                        </script>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
<?php
}
?>

        </main>

    <script src="../assets/js/main.js"></script>
</body>
</html> 