<?php 
    include 'setting.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />

  
          <?php
           include 'header.php';
           ?>
  <main class="flex justify-center items-center h-screen"><div class="inline-block min-w-full align-middle md:px-6 lg:px-8 ">
                    <section class=" max-w-4xl  mx-auto bg-white p-6 rounded-md shadow-md dark:bg-gray-800">
                        <h1 class="text-center pb-5 text-lg font-semibold text-green-400 capitalize dark:text-green-400">Mes informations</h1>
                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                        <?php if (!empty($message)): ?>
                                            <div class="w-full text-white bg-emerald-500">
                                                <div class="container flex items-center justify-between px-6 py-4 mx-auto">
                                                    <div class="flex">
                                                        <svg viewBox="0 0 40 40" class="w-6 h-6 fill-current">
                                                            <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z">
                                                            </path>
                                                        </svg>

                                                        <p class="mx-3"><?php echo $message; ?></p>
                                                    </div>

                                                    <button class="p-1 transition-colors duration-300 transform rounded-md hover:bg-opacity-25 hover:bg-gray-600 focus:outline-none">
                                                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M6 18L18 6M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                    </button>
                                                </div>  
                                            </div>
                                            <?php endif; ?>
                                            <?php if (!empty($erreur)): ?>
                                            <div class="w-full text-white bg-red-500">
                                                <div class="container flex items-center justify-between px-6 py-4 mx-auto">
                                                    <div class="flex">
                                                        <svg viewBox="0 0 40 40" class="w-6 h-6 fill-current">
                                                            <path d="M20 3.36667C10.8167 3.36667 3.3667 10.8167 3.3667 20C3.3667 29.1833 10.8167 36.6333 20 36.6333C29.1834 36.6333 36.6334 29.1833 36.6334 20C36.6334 10.8167 29.1834 3.36667 20 3.36667ZM19.1334 33.3333V22.9H13.3334L21.6667 6.66667V17.1H27.25L19.1334 33.3333Z">
                                                            </path>
                                                        </svg>

                                                        <p class="mx-3"><?php echo $erreur; ?></p>
                                                    </div>

                                                    <button class="p-1 transition-colors duration-300 transform rounded-md hover:bg-opacity-25 hover:bg-gray-600 focus:outline-none">
                                                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M6 18L18 6M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <?php endif; ?>
                            <div class="flex items-center">
                                <!-- Image -->
                                <img class="object-cover mx-2 rounded-full h-9 w-9 mt-2" src="<?php echo ($pp ? $pp : '../assets/images/defaultpp.png'); ?>" alt="">
                                
                                <!-- Form fields -->
                                <div>
                                    <input type="file" name="photoUtilisateur" class="block w-50 px-6 py-2 mt-2 text-sm text-gray-600 bg-white border border-gray-200 rounded-lg file:bg-gray-200 file:text-gray-700 file:text-sm file:px-4 file:py-1 file:border-none file:rounded-full dark:file:bg-gray-800 dark:file:text-gray-200 dark:text-gray-300 placeholder-gray-400/70 dark:placeholder-gray-500 focus:border-blue-400 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-40 dark:border-gray-600 dark:bg-gray-900 dark:focus:border-blue-300" />
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2 mt-5 pt-5">
                                <div>
                                    <label class="text-gray-700 dark:text-gray-200" for="nom">Nom</label>
                                    <input id="nom" type="text" name="nom" value="<?php echo $nom ; ?>" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-green-400 focus:ring-green-300 focus:ring-opacity-40 dark:focus:border-green-300 focus:outline-none focus:ring">
                                </div>

                                <div>
                                    <label class="text-gray-700 dark:text-gray-200" for="prenom">Prénom</label>
                                    <input id="prenom" type="text" name="prenom" value="<?php echo $prenom ; ?>" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-green-400 focus:ring-green-300 focus:ring-opacity-40 dark:focus:border-green-300 focus:outline-none focus:ring">
                                </div>
                        
                                <div class="mt-1">
                                    <label class="text-gray-700 dark:text-gray-200" for="email">Email</label>
                                    <div class="relative flex items-center mt-1">
                                        <span class="absolute">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-3 text-gray-300 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        </span>
                        
                                        <input type="email" name="email" value="<?php echo $email ; ?>" class="block w-full py-2 text-gray-700 bg-white border rounded-lg px-11 dark:bg-gray-900 dark:text-gray-300 dark:border-gray-600 focus:border-green-400 dark:focus:border-green-300 focus:ring-green-300 focus:outline-none focus:ring focus:ring-opacity-40">
                                    </div>
                                </div>
                        
                                <div>
                                    <label class="text-gray-700 dark:text-gray-200" for="contact">Contact</label>
                                    <input id="contact" type="tel" name="contact" value="<?php echo $tel ; ?>" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-200 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-green-400 focus:ring-green-300 focus:ring-opacity-40 dark:focus:border-green-300 focus:outline-none focus:ring">
                                </div>               
                            </div>
                        
                            <div class="flex justify-end mt-6">
                                <input  type="submit" name="mofconf" class="px-8 py-2.5 leading-5 text-white transition-colors duration-300 transform bg-gray-700 rounded-md hover:bg-green-600 focus:outline-none focus:bg-green-600" value="Modifier">
                        </form>
                        
                    </section>
                </div>
            </main>

    <?php
    include 'footer.php';
    ?>
</body>
</html>