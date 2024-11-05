<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
    <?php include 'header.php'; ?>
</head>
<body>
<main>
    <section class="dark:bg-gray-800">
        <div class="container px-6 py-10 mx-auto">
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-semibold capitalize lg:text-3xl text-green-600">moyennes par classe</h1>
            </div>
            <hr class="my-8 border-gray-200 dark:border-gray-700">
            <?php
            // Connexion à la base de données
            try {
                $pdo = new PDO('mysql:host=localhost;dbname=p1', 'root', '');

                // Préparation de la requête
                $stmt = $pdo->prepare("SELECT * FROM site"); // Assurez-vous que la requête est correcte
                $stmt->execute();

                // Vérifiez si $stmt est défini avant d'appeler rowCount()
                if ($stmt && $stmt->rowCount() > 0) {
            ?>
                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 xl:grid-cols-3">
                <?php
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <div class="flex flex-col items-center justify-center w-full max-w-sm mx-auto">
                    <!--<div class="w-full h-10 bg-gray-300 bg-center bg-cover rounded-lg shadow-md" style="background-image: url('<?php echo $row['cover'];?>');"></div>-->
                        <br><br>
                    <div class="w-56 h-30 -mt-10  overflow-hidden bg-white rounded-lg shadow-lg md:w-64 dark:bg-gray-800">
                        <h3 class="py-2 font-bold tracking-wide text-center  text-green-600 uppercase"><?php echo $row['nomSite'];?></h3>

                        <div class="flex items-center justify-between px-3 py-2 bg-gray-200 dark:bg-gray-700">
                            <form action="listancien.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $row['idSite'];?>">
                                <button type="submit" class="px-1 py-3 text-50 font-semibold text-white uppercase transition-colors duration-300 transform bg-gray-800 rounded hover:bg-[#964B00] dark:hover:bg-gray-600 focus:bg-gray-700 dark:focus:bg-gray-600 focus:outline-none">
                                    Moyenne des élèves de la classe
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php
                    }
                ?>
                </div>
                <?php
                } else {
                    echo "<p class='text-center text-blue-500 font-bold'>Aucune ressource disponible</p>";
                }
            } catch (PDOException $e) {
                echo "Erreur : " . $e->getMessage();
            }
            ?>
        </div>
    </section>
</main>
</body>
</html>
