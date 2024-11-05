<?php
    include 'setting.php';

    $count = "SELECT COUNT(idMaterielle) AS nombreMaterielle FROM ressourcematerielle";
    $result = $base_com->prepare($count);
    $result->execute();
    $resulta = $result->fetch(PDO::FETCH_ASSOC);

    $recupMat = "SELECT rm.*, cm.*
    FROM ressourcematerielle AS rm
    INNER JOIN categoriematerielle AS cm ON rm.typeMaterielle = cm.idCategorie";

    $stmt = $base_com->prepare($recupMat);
    $stmt->execute();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CM | Ressource matérielle Générale</title>
        <!-- Sidebar -->
            <?php
            include 'header.php';
            ?>

                    <div class="flex items-center py-4 overflow-x-auto whitespace-nowrap">
                        <a href="index.php" class="text-gray-600 dark:text-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                            </svg>
                        </a>
                    
                        <span class="mx-5 text-gray-500 dark:text-gray-300 rtl:-scale-x-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    
                        <a href="resmat.php" class="flex items-center text-gray-600 -px-2 dark:text-gray-200 hover:underline">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                                  </svg>
                    
                            <span class="mx-2">Ressources matérielles</span>
                            <span class="mx-5 text-gray-500 dark:text-gray-300 rtl:-scale-x-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            <span class="mx-2">Générale</span>

                        </a>
                    </div>               
                     <section class="container px-4 mx-auto mt-10">
                        <div class="relative flex flex-col min-w-0 break-words border border-dashed bg-clip-border rounded-2xl border-stone-200 bg-white mb-5 draggable">
                            <!-- card header -->
                            <div class="px-9 pt-5 flex justify-between items-stretch flex-wrap min-h-[70px] pb-0 bg-transparent">
                            <h3 class="flex flex-col items-start justify-center m-2 ml-0 font-medium text-xl/tight text-dark font-display">
                                <span class="mr-3 font-semibold text-dark">Ressources matérielles <span class="px-3 py-1 text-5xl text-green-500 bg-green-100 rounded-full dark:text-green-500"><?php echo $resulta['nombreMaterielle'];?></span></span>   
                                
                            </h3>
                            <div class="relative flex flex-wrap items-center my-2">
                                <a href="index.php" class="inline-block text-[.925rem] font-medium leading-normal text-center align-middle cursor-pointer rounded-2xl transition-colors duration-150 ease-in-out text-green-400 hover:text-white bg-white border-green-400 shadow-none border-2 py-2 px-5 hover:bg-green-400 active:bg-white focus:bg-white"> Ajout nouveau matérielle </a>
                            </div>
                        </div>
                           
                            
                            <div class="flex-auto block py-8 pt-6 px-9">
                            <div class="overflow-x-auto">
                                 <?php
                                    if ($stmt->rowCount() > 0) {
                                ?>
                             <table id="liste" class="w-full my-0 align-middle text-dark border-neutral-200">
                                <thead class="align-bottom">
                                    <tr class="font-semibold text-[0.95rem] text-secondary-dark">
                                    <th class="pb-3 text-start ">NOM</th>
                                    <th class="pb-3  text-red-500">CODE</th>
                                    <th class="pb-3  text-yellow-500">CATEGORIE</th>
                                    <th class="pb-3 text-blue-500">STATUS</th>
                                    <th class="pb-3 text-gray-500">ETAT</th>
                                    <th class="pb-3  ">DATE AJOUT</th>
                                    <th class="pb-3 text-end ">DETAILS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     <?php
                                         while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <tr class="border-b border-dashed last:border-b-0 ">
                                        <!-- Nom -->
                                        <td class="p-3 pl-0">
                                            <div class="flex items-center">
                                                <div class="flex flex-col justify-start">
                                                    <a href="javascript:void(0)" class="mb-1 font-semibold transition-colors duration-200 ease-in-out text-lg/normal text-secondary-inverse hover:text-primary"><?php echo $row['nomMaterielle'];?></a>
                                                </div>
                                            </div>
                                        </td>
                                        <!-- Code -->
                                        <td class="p-3 pr-0 text-center">
                                            <span class="font-semibold text-light-inverse text-md/normal"><?php echo $row['codeMaterielle'];?></span>
                                        </td>
                                        <!-- Satut -->
                                        <td class="p-3 pr-0 text-center">
                                            <span class="text-center align-baseline inline-flex px-2 py-1 mr-auto items-center font-semibold text-base/none text-success bg-success-light rounded-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                                                </svg><?php echo $row['nomCategorie'];?>
                                            </span>
                                        </td>
                                        <!-- Autre état -->
                                        <td  x-data="{ statut: '<?php echo $row['statutMaterielle']; ?>' }" :class="{ 'p-3 pr-0 text-center text-green-400': statut === 'disponible', 'p-3 pr-0 text-center text-red-400': statut !== 'disponible' }"><?php echo $row['statutMaterielle'];?></td>
                                        <!-- Autre statut -->
                                        <td class="p-3 text-center"><?php echo $row['etatMaterielle'];?></td>
                                        <!-- Date ajout -->
                                        <td class="pr-0 text-center"><?php echo $row['dateAdd'];?></td>
                                        <!-- Détails -->
                                        <td class="p-3 pr-0 text-end">
                                            <button class=" transition-colors duration-20 text-blue-500 focus:outline-none">
                                                <a href="modifrm.php?id=<?php echo $row['idMaterielle'];?>"> 
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php
                                        }
                                    ?>
                                    
                                
                                
                                </tbody>
                                </table>
                                <?php
                                    }else {
                                        echo "<p class='text-center text-blue-500 font-bold' >Aucune annonce en attente de validation.</p>";
                                    }
                                ?>
                                <!-- <script type="text/javascript">
                                    $(document).ready(function() {
                                        $('#liste').DataTable({
                                            "language": {
                                                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/French.json"
                                            }
                                        });
                                    });
                                </script> -->
                            </div>
                            </div>
                        </div>  
                    </section>
                </main>
            </div>
            
<script src="../assets/js/main.js"></script>
</body>
</html>