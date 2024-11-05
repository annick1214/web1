<?php
    include 'setting.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comptable-Matière - E-Gest</title>
        <!-- Sidebar -->
        <?php
            include 'header.php';
        ?>

        <!-- Main Content -->
            <div class="mt-6 ">
                <form action="" class="flex">
                    <input type="text" name="newcategorie" class="block w-60 mb-2 py-2.5 text-gray-700 placeholder-gray-400/70 bg-white border border-gray-200 rounded-lg pl-11 pr-5 rtl:pr-11 rtl:pl-5 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-green-400 dark:focus:border-green-300 focus:ring-green-300 focus:outline-none focus:ring focus:ring-opacity-40" placeholder="Ajouter une nouvelle catégorie...">
                    <button type="submit" class="px-8 py-2.5 leading-5 text-white transition-colors duration-300 transform bg-gray-700 rounded-md hover:bg-green-600 focus:outline-none focus:bg-green-600">Modifier</button>
                </form>
            </div>
        </main>
    </div>

    <script src="../assets/js/main.js"></script>
</body>
</html>
