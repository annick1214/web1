<?php
include 'setting.php';

// Requête pour les statistiques par catégorie
$query = "
    SELECT 
        cm.nomCategorie,
        COUNT(CASE WHEN rm.statutMaterielle = 'disponible' THEN 1 END) AS Disponibles,
        COUNT(CASE WHEN rm.statutMaterielle = 'indisponible' THEN 1 END) AS Attribués,
        COUNT(CASE WHEN rm.etatMaterielle = 'nouveau' THEN 1 END) AS Neuf,
        COUNT(CASE WHEN rm.etatMaterielle = 'bonne' THEN 1 END) AS Bon,
        COUNT(CASE WHEN rm.etatMaterielle = 'vielle' THEN 1 END) AS Mauvais,
        COUNT(*) AS Total
    FROM ressourcematerielle rm
    INNER JOIN categoriematerielle cm ON rm.typeMaterielle = cm.idCategorie
    GROUP BY cm.nomCategorie
";

$stmt = $base_com->prepare($query);
$stmt->execute();
$stats = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    
        <!--<span class="mx-5 text-gray-500 dark:text-gray-300 rtl:-scale-x-100">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
            </svg>
        </span>-->
    
        <a href="statsg.php" class="flex items-center text-gray-600 -px-2 dark:text-gray-200 hover:underline">
        
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
            <!--<h2 class="text-lg font-medium text-gray-800 dark:text-white">Statistiques par catégorie </h2>-->
            <span class="px-3 py-1 text-4xl text-green-500 bg-green-100 rounded-full dark:bg-gray-800 dark:text-green-500">Statistiques par catégorie</span>
        </div>

        <div class="w-full text-black dark:text-white">
            <div class="container flex flex-col items-center gap-10 mx-auto mt-5">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-y-8">
                    <?php foreach ($stats as $index => $row): ?>
                        <div class="flex flex-col items-center  mx-5">
                        <p class="text-2xl font-medium leading-7 text-center text-dark-grey-600 mt-4"><?php echo htmlspecialchars($row['nomCategorie']); ?></p>
                            <ul class="text-base font-medium leading-7 text-center dark:text-gray-300 mt-3">
                            <li>Total: <?php echo htmlspecialchars($row['Total']); ?></li>                            </ul>
                            <canvas id="chart<?php echo $index; ?>" width="400" height="400"></canvas>
                           
                        </div>
                        <script>
                            var ctx = document.getElementById('chart<?php echo $index; ?>').getContext('2d');
                            new Chart(ctx, {
                                type: 'pie',
                                data: {
                                    labels: ['Disponibles', 'Attribués', 'Neuf', 'Bon', 'Mauvais'],
                                    datasets: [{
                                        data: [<?php echo $row['Disponibles']; ?>, <?php echo $row['Attribués']; ?>, <?php echo $row['Neuf']; ?>, <?php echo $row['Bon']; ?>, <?php echo $row['Mauvais']; ?>],
                                        backgroundColor: ['#4CAF50', '#FFC107', '#03A9F4', '#8BC34A', '#F44336']
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
        </main>
    </div>
    <script src="../assets/js/main.js"></script>
</body>
</html>