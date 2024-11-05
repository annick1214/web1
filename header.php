<link rel="shortcut icon" href="../assets/images/logohecm.png" type="image/x-icon"/>
    <script defer src="../assets/js/aplines.js"></script>
    <script src="../assets/js/tailwind.js"></script>
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/datatable.css">
    <script type="text/javascript" src="../assets/js/jquery.js"></script>
    <script type="text/javascript" src="../assets/js/datatable.js"></script>
</head>
<body class=" bg-[#e6ccb3]">
    <div class="flex">
        <!-- Sidebar -->
<aside id="sidebar" class="dark:bg-white text-white w-64 hidden md:block">
            <div class="flex flex-col w-41  px-4 py-8  border-r rtl:border-r-0 rtl:border-l dark:bg-gray-800 dark:border-gray-700" >
                <a href="classe.php">
                <span class="mx-1 font-s text-base font-medium text-lg font-bold text-gray-900">TABLEAU DE BORD</span>    
                <!--<img class="w-40 h-14 mx-auto rounded" src="../assets/images/logohecm.png" alt="">-->
                </a>
            
               <!-- <hr class="my-6 border-green-500 dark:border-green-500" />-->

            
                <div class="flex flex-col justify-between flex-1 mt-6">
                    <nav >

                        
                        
                            <!-- statistique des eleves-->
                            <div x-data="{ isOpen: false }" @click.away="isOpen = false" class="relative">
                            
                            <a class="flex items-center px-4 py-2 mt-5  rounded dark:border-2  text-black hover:bg-[#964B00] hover:text-white dark:text-green-500 dark:border-gray-800 dark:hover:bg-green-500 dark:hover:text-white" href="recherce.php">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd" d="M5.25 2.25a3 3 0 0 0-3 3v4.318a3 3 0 0 0 .879 2.121l9.58 9.581c.92.92 2.39 1.186 3.548.428a18.849 18.849 0 0 0 5.441-5.44c.758-1.16.492-2.629-.428-3.548l-9.58-9.581a3 3 0 0 0-2.122-.879H5.25ZM6.375 7.5a1.125 1.125 0 1 0 0-2.25 1.125 1.125 0 0 0 0 2.25Z" clip-rule="evenodd" />
                        </svg>

        
                              
                            <span class="mx-4 text-lg">Recherche</span>
                        </a>
                            <div x-data="{ isOpen: false }" @click.away="isOpen = false" class="relative">
                            <a @click="isOpen = !isOpen" class="flex items-center px-4 py-2 mt-5  rounded dark:border-2  text-black hover:bg-[#964B00] hover:text-white dark:text-green-500 dark:border-gray-800 dark:hover:bg-green-500 dark:hover:text-white" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path d="M4.5 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM14.25 8.625a3.375 3.375 0 1 1 6.75 0 3.375 3.375 0 0 1-6.75 0ZM1.5 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM17.25 19.128l-.001.144a2.25 2.25 0 0 1-.233.96 10.088 10.088 0 0 0 5.06-1.01.75.75 0 0 0 .42-.643 4.875 4.875 0 0 0-6.957-4.611 8.586 8.586 0 0 1 1.71 5.157v.003Z" />
                            </svg>

                                  
                                <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': isOpen, 'rotate-0': !isOpen}" class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform rotate-1 md:-mt-1">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="mx-4 font-medium">Elèves</span>
                               
                            </a>
                            <div x-show="isOpen" class="absolute top-full left-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
                            <a href="inscription.php" class="block px-4 hover:text-white py-2 text-base text-gray-700 hover:bg-green-600 font-bold">Inscription</a>
                            <a href="classe.php" class="block px-4 hover:text-white py-2 text-base text-gray-700 hover:bg-green-600 font-bold">Liste des élèves par classe</a>
<a href="classe1.php" class="block px-4 py-2 hover:text-white text-base text-gray-700 hover:bg-green-600 font-bold">Statistique Générale</a>
<a href="classe2.php" class="block px-4 py-2 hover:text-white text-base text-gray-700 hover:bg-green-600 font-bold">Moyennes</a>
<a href="classe3.php" class="block px-4 py-2 hover:text-white text-base text-gray-700 hover:bg-green-600 font-bold">Scolarité</a>
<a href="anne.php" class="block px-4 py-2 hover:text-white text-base text-gray-700 hover:bg-green-600 font-bold">Recherche</a>

                            </div>
                        </div>      
                        
                        <!-- statistique de lq scolarite -->
                        <!--<div x-data="{ isOpen: false }" @click.away="isOpen = false" class="relative">
                            <a @click="isOpen = !isOpen" class="flex items-center px-4 py-2 mt-5  rounded dark:border-2 text-black hover:bg-[#964B00] hover:text-white dark:text-green-500 dark:border-gray-800 dark:hover:bg-green-500 dark:hover:text-white" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v.75c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875v-.75C22.5 3.839 21.66 3 20.625 3H3.375Z" />
                            <path fill-rule="evenodd" d="m3.087 9 .54 9.176A3 3 0 0 0 6.62 21h10.757a3 3 0 0 0 2.995-2.824L20.913 9H3.087Zm6.163 3.75A.75.75 0 0 1 10 12h4a.75.75 0 0 1 0 1.5h-4a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                            </svg>
                            
                                <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': isOpen, 'rotate-0': !isOpen}" class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform rotate-0 md:-mt-1">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="mx-4 text-lg">Scolarite</span>         
                            </a>
                        
                            <div x-show="isOpen" class="absolute top-full left-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
                            <a href="classe3.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-600">Scolarité</a>   
                            <a href="classe4.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-600">Tranche 1</a>
                               <!-- <a href="resmatna.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-600">Non Attribuer</a>--
                                <a href="classes2.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-600">Les élèves ayant payé la première, deuxième, ou troisième tranche.</a>
                                <a href="classes3.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-600">Montant total collecté et montant restant.</a>
                            </div>-->
                        </div>   
                        <!-- -->
                        <div x-data="{ isOpen: false }" @click.away="isOpen = false" class="relative">
                            <a @click="isOpen = !isOpen" class="flex items-center px-4 py-2 mt-5  rounded dark:border-2 text-black hover:bg-[#964B00] hover:text-white dark:text-green-500 dark:border-gray-800 dark:hover:bg-green-500 dark:hover:text-white" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v.75c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875v-.75C22.5 3.839 21.66 3 20.625 3H3.375Z" />
                            <path fill-rule="evenodd" d="m3.087 9 .54 9.176A3 3 0 0 0 6.62 21h10.757a3 3 0 0 0 2.995-2.824L20.913 9H3.087Zm6.163 3.75A.75.75 0 0 1 10 12h4a.75.75 0 0 1 0 1.5h-4a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
                            </svg>
                            
                                <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': isOpen, 'rotate-0': !isOpen}" class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform rotate-0 md:-mt-1">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="mx-4 text-lg">Ressource</span>         
                            </a>
                        
                            <div x-show="isOpen" class="absolute top-full left-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
                            <a href="resmat.php" class="block hover:text-white px-4 py-2 text-base text-gray-700 hover:bg-green-600 font-bold">Toutes les ressources</a>
<a href="resmatna.php" class="block px-4 py-2 text-base hover:text-white text-gray-700 hover:bg-green-600 font-bold">Non Attribué</a>
<a href="resmata.php" class="block px-4 py-2 text-base hover:text-white text-gray-700 hover:bg-green-600 font-bold">Attribué</a>
<a href="histoatt.php" class="block px-4 py-2 text-base hover:text-white text-gray-700 hover:bg-green-600 font-bold">Historique Attribution</a>

                            </div>
                        </div>      
                     
                        <div x-data="{ isOpen: false }" @click.away="isOpen = false" class="relative">
                            <a @click="isOpen = !isOpen" class="flex items-center px-4 py-2 mt-5  rounded dark:border-2  text-black hover:bg-[#964B00] hover:text-white dark:text-green-500 dark:border-gray-800 dark:hover:bg-green-500 dark:hover:text-white" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                            <path fill-rule="evenodd" d="M2.25 13.5a8.25 8.25 0 0 1 8.25-8.25.75.75 0 0 1 .75.75v6.75H18a.75.75 0 0 1 .75.75 8.25 8.25 0 0 1-16.5 0Z" clip-rule="evenodd" />
                            <path fill-rule="evenodd" d="M12.75 3a.75.75 0 0 1 .75-.75 8.25 8.25 0 0 1 8.25 8.25.75.75 0 0 1-.75.75h-7.5a.75.75 0 0 1-.75-.75V3Z" clip-rule="evenodd" />
                            </svg>
                              
                                <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': isOpen, 'rotate-0': !isOpen}" class="inline w-4 h-4 mt-1 ml-1 transition-transform duration-200 transform rotate-0 md:-mt-1">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="mx-4 text-lg">Statistique</span>         
                            </a>
                        
                            <div x-show="isOpen" class="absolute top-full  left-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10">
                            <a href="statsg.php" class="block hover:text-white px-4 py-2 text-base text-gray-700 hover:bg-green-600 font-bold">Générale</a>
<a href="statsc.php" class="block px-4 py-2 text-base hover:text-white text-gray-700 hover:bg-green-600 font-bold">Par catégorie</a>
<a href="site.php" class="block px-4 py-2 text-base hover:text-white text-gray-700 hover:bg-green-600 font-bold">Par site</a>

                            </div>
                        </div>
            
                        <a class="flex items-center px-4 py-2 mt-5  rounded dark:border-2  text-black hover:bg-[#964B00] hover:text-white dark:text-green-500 dark:border-gray-800 dark:hover:bg-green-500 dark:hover:text-white" href="catrm.php">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd" d="M5.25 2.25a3 3 0 0 0-3 3v4.318a3 3 0 0 0 .879 2.121l9.58 9.581c.92.92 2.39 1.186 3.548.428a18.849 18.849 0 0 0 5.441-5.44c.758-1.16.492-2.629-.428-3.548l-9.58-9.581a3 3 0 0 0-2.122-.879H5.25ZM6.375 7.5a1.125 1.125 0 1 0 0-2.25 1.125 1.125 0 0 0 0 2.25Z" clip-rule="evenodd" />
                        </svg>

        
                              
                            <span class="mx-4 text-lg">Catégorie</span>
                        </a>
                         <!-- les classe disponible et l'ajout des classe-->
                         <div x-data="{ isOpen: false }" @click.away="isOpen = false" class="relative">
                        <a class="flex items-center px-4 py-2 mt-5  rounded dark:border-2  text-black hover:bg-[#964B00] hover:text-white dark:text-[#964B00] dark:border-gray-800 dark:hover:bg-green-500 dark:hover:text-white" href="index1.php">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path d="M19.006 3.705a.75.75 0 1 0-.512-1.41L6 6.838V3a.75.75 0 0 0-.75-.75h-1.5A.75.75 0 0 0 3 3v4.93l-1.006.365a.75.75 0 0 0 .512 1.41l16.5-6Z" />
                        <path fill-rule="evenodd" d="M3.019 11.114 18 5.667v3.421l4.006 1.457a.75.75 0 1 1-.512 1.41l-.494-.18v8.475h.75a.75.75 0 0 1 0 1.5H2.25a.75.75 0 0 1 0-1.5H3v-9.129l.019-.007ZM18 20.25v-9.566l1.5.546v9.02H18Zm-9-6a.75.75 0 0 0-.75.75v4.5c0 .414.336.75.75.75h3a.75.75 0 0 0 .75-.75V15a.75.75 0 0 0-.75-.75H9Z" clip-rule="evenodd" />
                        </svg>
                        <span class="mx-4 text-lg">Classe</span>
                        </a>
                        </div>
                        <!-- -->
                        <a class="flex items-center px-4 py-2 mt-5  rounded dark:border-2  text-black hover:bg-[#964B00] hover:text-white dark:text-[#964B00] dark:border-gray-800 dark:hover:bg-green-500 dark:hover:text-white" href="message.php">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                        <path fill-rule="evenodd" d="M4.848 2.771A49.144 49.144 0 0 1 12 2.25c2.43 0 4.817.178 7.152.52 1.978.292 3.348 2.024 3.348 3.97v6.02c0 1.946-1.37 3.678-3.348 3.97a48.901 48.901 0 0 1-3.476.383.39.39 0 0 0-.297.17l-2.755 4.133a.75.75 0 0 1-1.248 0l-2.755-4.133a.39.39 0 0 0-.297-.17 48.9 48.9 0 0 1-3.476-.384c-1.978-.29-3.348-2.024-3.348-3.97V6.741c0-1.946 1.37-3.68 3.348-3.97ZM6.75 8.25a.75.75 0 0 1 .75-.75h9a.75.75 0 0 1 0 1.5h-9a.75.75 0 0 1-.75-.75Zm.75 2.25a.75.75 0 0 0 0 1.5H12a.75.75 0 0 0 0-1.5H7.5Z" clip-rule="evenodd" />
                        </svg>

                            <span class="mx-4 font-medium">Message</span>
                        </a>
            
                        <hr class="my-6 border-green-500 dark:border-green-500" />
            
                 
                    </nav>
            
                    <a href="confi.php">
                         <div class="flex relative mx-6 shadow p-1 rounded bg-green-500">
                            <img class="object-cover mx-2 rounded-full h-9 w-9" src="<?php echo ($pp ? $pp : '../assets/images/defaultpp.png'); ?>" alt="">
                            <span class="top-0 mx-1 left-7 absolute  w-3.5 h-3.5 bg-green-400 border-2 border-white dark:border-gray-800 rounded-full"></span>
                            <span class="mt-2 mx-4 font-bold">Profil</span>
                        </div>
                        </a>
                     <a class="flex items-center px-5 py-2 mt-2 p-1 rounded border-2 text-red-500 border-red-500 hover:bg-red-500 hover:text-white" href="../logout.php">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                          </svg>
                            <span class="mx-4  text-lg">Déconnexion</span>
                        </a>
                </div>
                
            </div>
    
        </aside>
        <main id="main" class="flex-1 p-4">
            <button id="toggleSidebar" class="rounded-lg bg-green-500 text-gray-800 dark:bg-green-500 dark:text-white px-3 py-2 mb-4 md:hidden">  
            <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                </svg>
            </button>