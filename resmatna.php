<?php
    include 'setting.php';

    
    $count = "SELECT COUNT(idMaterielle) AS nombreMaterielle FROM ressourcematerielle where statutMaterielle ='disponible'";
    $result = $base_com->prepare($count);
    $result->execute();
    $resulta = $result->fetch(PDO::FETCH_ASSOC);

    $recupMat = "SELECT rm.*, cm.*
    FROM ressourcematerielle AS rm
    INNER JOIN categoriematerielle AS cm ON rm.typeMaterielle = cm.idCategorie where statutMaterielle ='disponible'";

    $stmt = $base_com->prepare($recupMat);
    $stmt->execute();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CM | RM Non Attribuer</title>
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
                            <span class="mx-2">Non Attribuées</span>

                        </a>
                    </div>               
                    <section class="container px-4 mx-auto mt-10">
                        <div class="relative flex flex-col min-w-0 break-words border border-dashed bg-clip-border rounded-2xl border-stone-200 bg-white mb-5 draggable">
                            <!-- card header -->
                            <div class="px-9 pt-5 flex justify-between items-stretch flex-wrap min-h-[70px] pb-0 bg-transparent">
                            <h3 class="flex flex-col items-start justify-center m-2 ml-0 font-medium text-xl/tight text-dark font-display">
                                <span class="mr-3 font-semibold text-dark">Ressources matérielles non Attribuées <span class="px-3 py-1 text-5xl text-green-500 bg-green-100 rounded-full dark:text-green-500"><?php echo $resulta['nombreMaterielle'];?></span></span>   
                                
                            </h3>
                            <div class="relative flex flex-wrap items-center my-2">
                                <a href="index.php" class="inline-block text-[.925rem] font-medium leading-normal text-center align-middle cursor-pointer rounded-2xl transition-colors duration-150 ease-in-out text-green-400 hover:text-white bg-white border-green-400 shadow-none border-2 py-2 px-5 hover:bg-green-400 active:bg-white focus:bg-white"> Ajout nouveau matérielle </a>
                            </div>
                            </div>
                            <!-- end card header -->
                            <!-- card body  -->
                            <div class="flex-auto block py-8 pt-6 px-9">
                            <div class="overflow-x-auto">
                                 <?php
                                    if ($stmt->rowCount() > 0) {
                                ?>
                                  <?php
                                if (isset($_GET['id'])) {
                                    $delete_id = $_GET['id'];
                                
                                    $delete_query = $base_com->prepare("DELETE FROM ressourcematerielle WHERE idMaterielle = ?");
                                    $delete_query->execute([$delete_id]);
                                    echo "<div class='w-full text-white bg-yellow-400'>
                                    <div class='container flex items-center justify-between px-6 py-4 mx-auto'>
                                        <div class='flex'>
                                            <svg viewBox='0 0 40 40' class='w-6 h-6 fill-current'>
                                                <path d='M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z'>
                                                </path>
                                            </svg>
                                
                                            <p class='mx-3'>La ressource a été supprimée !</p>
                                        </div>
                                    </div>
                                </div>";
                                    echo "<script>
                                            setTimeout(function(){
                                                window.location.href = 'resmatna.php';
                                            }, 2000); 
                                        </script>";
                                }
                                ?>
                                <table id="liste" class="w-full my-0 align-middle text-dark border-neutral-200 mt-5">
                                <thead class="align-bottom">
                                    <tr class="font-semibold text-[0.95rem] text-secondary-dark">
                                    <th class="pb-3 text-start ">NOM</th>
                                    <th class="pb-3  text-red-500">CODE</th>
                                    <th class="pb-3  text-yellow-500">CATEGORIE</th>
                                    <th class="pb-3 text-gray-500">ETAT</th>
                                    <th class="pb-3  ">DATE AJOUT</th>
                                    <th class="pb-3 text-start ">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php
                                         while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    ?>
                                    <tr class="border-b border-dashed last:border-b-0 bg-blue-100">
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
                                    
                                        <td class="p-3 text-center"><?php echo $row['etatMaterielle'];?></td>
                                        <td class="pr-0 text-center"><?php echo $row['dateAdd'];?></td>
                                        <td class="p-3 pr-0">
                                        <div class="flex">
                                            <button class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium leading-5 text-blue-500 hover:text-blue-700 focus:outline-none focus:ring transition duration-150 ease-in-out">
                                                <a href="modifrm.php?id=<?php echo $row['idMaterielle'];?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-2">
                                                        <path fill-rule="evenodd" d="M9.293 5.293a1 1 0 011.414 0L13 8.586V7a1 1 0 112 0v3a1 1 0 01-1 1h-3a1 1 0 110-2h1.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                        <path fill-rule="evenodd" d="M5 3a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a1 1 0 112 0v8a4 4 0 01-4 4H5a4 4 0 01-4-4V5a2 2 0 012-2h8a1 1 0 110 2H5z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Modifier
                                                </a>
                                            </button>
                                            <button class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium leading-5 text-green-500 hover:text-green-700 focus:outline-none focus:ring transition duration-150 ease-in-out">
                                                <a href="attributionrm.php?id=<?php echo $row['idMaterielle'];?>">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-2">
                                                    <path fill-rule="evenodd" d="M9.293 5.293a1 1 0 011.414 0L13 8.586V7a1 1 0 112 0v3a1 1 0 01-1 1h-3a1 1 0 110-2h1.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                    <path fill-rule="evenodd" d="M5 3a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a1 1 0 112 0v8a4 4 0 01-4 4H5a4 4 0 01-4-4V5a2 2 0 012-2h8a1 1 0 110 2H5z" clip-rule="evenodd"/>
                                                </svg>
                                                Attribuer
                                                </a>
                                            </button>
                                          
                                                <button onclick="return confirm('Voulez-vous supprimer ce materielle ?');" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium leading-5 text-red-500 hover:text-red-700 focus:outline-none focus:ring transition duration-150 ease-in-out">
                                                    <a href="resmatna.php?id=<?php echo $row['idMaterielle'];?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-2">
                                                        <path fill-rule="evenodd" d="M5.293 3.293a1 1 0 011.414 0L10 8.586l3.293-3.293a1 1 0 111.414 1.414L11.414 10l3.293 3.293a1 1 0 01-1.414 1.414L10 11.414l-3.293 3.293a1 1 0 01-1.414-1.414L8.586 10 5.293 6.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Supprimer
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
                                        echo "<p class='text-center text-blue-500 font-bold' >Aucune ressource disponible</p>";
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
                </main>
            </div>
<script src="../assets/js/main.js"></script>
</body>
</html>