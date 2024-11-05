<?php
    include 'setting.php';
    $count = "SELECT COUNT(idSite) AS nombreSite FROM site";
    $result = $base_com->prepare($count);
    $result->execute();
    $resulta = $result->fetch(PDO::FETCH_ASSOC);

    $recupMat = "SELECT *
    FROM site ";

    $stmt = $base_com->prepare($recupMat);
    $stmt->execute();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN - E-Gest</title>

        <!-- Sidebar -->
            <?php 
             include 'header.php';
            ?>
                          <div class="flex items-center py-2 overflow-x-auto whitespace-nowrap">
                        <!--<a href="index.php" class="text-gray-600 dark:text-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                            </svg>
                        </a>-->
                    
                        <span class="mx-5 text-gray-500 dark:text-gray-300 rtl:-scale-x-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    
                        <a href="addsite.php" class="flex items-center text-gray-600 -px-2 dark:text-gray-200 hover:underline">
                        
                    
                            <span class="mx-2">Ajouter une nouvelle classe</span>
                            <!--<span class="mx-5 text-gray-500 dark:text-gray-300 rtl:-scale-x-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                           <span class="mx-2">Site</span>-->

                        </a>
                    </div>               
                     <section class="container px-2 mx-auto mt-10">
                        <div class="relative flex flex-col min-w-0 break-words border border-dashed bg-clip-border rounded-2 border-stone-200 bg-white mb-5 draggable">
                            <!-- card header -->
                            <div class="px-9 pt-5 flex justify-between items-stretch flex-wrap min-h-[70px] pb-0 bg-transparent">
                            <h3 class="flex flex-col items-start justify-center m-2 ml-0 font-medium text-xl/tight text-dark font-display">
                                <span class="mr-3 font-semibold text-dark">Nombre de classe <span class="px-3 py-1 text-5xl text-green-500 bg-green-100 rounded-full dark:text-green-500"><?php echo $resulta['nombreSite'];?></span></span>   
                                
                            </h3>
                            <div class="relative flex flex-wrap items-center my-2">
                                <a href="addsite.php" class="inline-block text-[.925rem] font-medium leading-normal text-center align-middle cursor-pointer rounded-2xl transition-colors duration-150 ease-in-out text-green-400 hover:text-white bg-white border-green-400 shadow-none border-2 py-2 px-5 hover:bg-green-400 active:bg-white focus:bg-white"> Ajouter une nouveau classe </a>
                            </div>
                            </div>
                            <!-- end card header -->
                            <!-- card body  -->
                            <div class="flex-auto block py-4  pt-3 px-9">
                            <div class="overflow-x-auto">
                              <?php
                                    if ($stmt->rowCount() > 0) {
                                ?>
                             <table id="liste"class="min-w-full border-collapse border-2 border-gray-500 rounded-lg shadow-lg">
                                <thead class="align-bottom">
                                    <tr class="dark:bg-gray-800 font-semibold text-[0.95rem] text-secondary-dark">
                                    <th class="pb-3 text-start">NOM</th>
                                    <!--<th class="pb-3  text-black ">CONTACT</th>
                                    <th class="pb-3  text-black">EMAIL</th>
                                    <th class="pb-3 text-black">ADRESSE</th>-->
                                    <th class=" pb-3  ">CREATION</th>
                                    <th class="pb-3 text-start ">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                 <?php
                                         while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <tr class="border-b border-dashed last:border-b-4">
                                        <!-- Nom -->

                                        <!-- Code -->
                                        <td class=" px-4 py-4 text-sm font-medium text-gray-700 whitespace-nowrap">
                                            <div class="inline-flex items-center gap-x-3">                
                                                <div class="flex items-center gap-x-2">
                                                   <!-- <img class="object-cover w-10 h-10 rounded-full" src="<?php $pp = $row['cover']; echo ($pp ? $pp : '../assets/images/defaultpp.png'); ?>" alt="">-->
                                                    <div>
                                                        <h2 class="font-bold text-black "><?php echo $row['nomSite'];?></h2>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    
                                        <!-- Satut -->
                                       <!-- <td class="p-3 pr-0 text-center">
                                            <span class="text-center align-baseline inline-flex px-2 py-1 mr-auto items-center font-semibold text-base/none text-success bg-success-light rounded-lg">
                                            <?php echo $row['contactSite'];?>
                                            </span>
                                        </td>
                                        <!-- Autre état -->
                                        <!--<td class="p-3 pr-0 text-center"><?php echo $row['emailSite'];?></td>
                                        <!-- Autre statut -->
                                        <!--<td class="p-3 text-center"><?php echo $row['adresseSite'];?></td>
                                        <!-- Date ajout -->
                                        <td class=" p-3 pr-0 text-center"><?php echo $row['dateCreat'];?></td>
                                        <!-- Détails -->
                                        <td class="text-cnter  p-3 pr-0 text-end">
                                        <div class="flex items-center gap-x-6">
                                                       <!-- <button class="text-gray-500 transition-colors duration-200 text-red-500 focus:outline-none">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                            </svg>
                                                        </button>-->
            
                                                        <button class="  text-gray-500  transition-colors duration-200 text-yellow-500 focus:outline-none">
                                                            <a href="modsite.php?idSite=<?php echo $row['idSite'];?>">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 items-center">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                            </svg>
                                                            </a>
                                                        </button>
                                                        
                                                    </div>
                                         </td>
                                    </tr>
                                    <?php
                                        }
                                    ?>
                                </tbody>
                                </table>
                                <?php
                                    }else {
                                        echo "<p class='text-center text-blue-500 font-bold' >Aucun site !</p>";
                                    }
                                ?>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $('#liste').DataTable({
                                            "language": {
                                                "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/French.json"
                                            }
                                        });
                                    });
                                </script>
                            </div>
                            </div>
                        </div>  
                    </section>
                
        </div>
<script src="../assets/js/main.js"></script>
</body>
</html>