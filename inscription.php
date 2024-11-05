<?php  
include 'setting.php';

// Afficher les erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_POST['addgs'])) {
    // Récupérer et échapper les entrées
    $nomeleve = htmlspecialchars($_POST["nom"]);
    $prenomeleve = htmlspecialchars($_POST["prenom"]);
    $datenaissance = htmlspecialchars($_POST["date_naissance"]);
    $sexe = htmlspecialchars($_POST["sexe"]);
    $site = htmlspecialchars($_POST["site"]);
    $contacteleve = htmlspecialchars($_POST["contact"]);

    // Vérification des champs requis
    if (!empty($nomeleve) && !empty($prenomeleve) && !empty($datenaissance) && !empty($sexe) && !empty($site) && !empty($contacteleve)) {
        try {
            // Vérifier si l'élève existe déjà sans tenir compte du site
            $requete_existence = $base_com->prepare("
                SELECT * FROM eleve 
                WHERE nomeleve = ? 
                AND prenomeleve = ?
            ");
            $requete_existence->execute([$nomeleve, $prenomeleve]);
            $resultat = $requete_existence->fetch();

            if ($resultat) {
                $erreur = "Cet élève existe déjà !";
            } else {
                // Générer le matricule
                $prefix = 'PAR';
                $idCount = $base_com->query("SELECT COUNT(*) FROM eleve")->fetchColumn();
                $nextId = $idCount + 1;
                $matricule = $prefix . str_pad($nextId, 6, '0', STR_PAD_LEFT); // Exemple : PAR0001, PAR0002, ...

                // Insérer les données de l'élève avec le matricule, en considérant que le statut est toujours "Nouveau"
                $requete_insertion = $base_com->prepare("
                    INSERT INTO eleve (matriculeeleve, nomeleve, prenomeleve, datenaissance, sexe, statut, site, contacteleve, dateAdd) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
                ");
                $requete_insertion->execute([$matricule, $nomeleve, $prenomeleve, $datenaissance, $sexe, 'Nouveau', $site, $contacteleve]);

                $idgs = $base_com->lastInsertId();

                // Mettre à jour l'ID du site
                $req2 = "UPDATE site SET ideleve = ? WHERE idSite = ?";
                $stmt2 = $base_com->prepare($req2);
                $stmt2->execute([$idgs, $site]);

                $message = "Inscription réussie : $prenomeleve $nomeleve, Matricule : $matricule";
            }
        } catch (PDOException $e) {
            $erreur = "Erreur lors de la connexion à la base de données : " . $e->getMessage();
        }
        
    } else {
        $erreur = "Tous les champs sont requis";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADMIN - E-Gest</title>
    <?php include 'header.php'; ?>
    <div class="flex items-center py-4 overflow-x-auto whitespace-nowrap">
        <a href="classe.php" class="flex items-center text-gray-600 -px-2 dark:text-gray-200 hover:underline">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
            </svg>
            <span class="mx-2">Liste des élèves</span>
        </a>
    </div>

    <div class="w-full max-w-sm mx-auto overflow-hidden bg-gray-100 rounded-lg border-solid dark:border-2 border-green-400 mt-10 shadow-md dark:bg-gray-800 mb-20">
        <div class="px-8 py-8">
            <form class="w-full max-w-md" method="POST" action="inscription.php">
                <h1 class="mt-1 h-16 text-center text-green-400 font-bold">Inscription</h1>
                <?php if (!empty($message)): ?>
                <div class="flex w-full max-w-sm overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800">
                    <div class="flex items-center justify-center w-12 bg-emerald-500">
                        <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z" />
                        </svg>
                    </div>
                    <div class="px-4 py-2 -mx-3">
                        <div class="mx-3">
                            <p class="text-sm text-gray-600 dark:text-gray-200 font-bold"><?php echo $message; ?></p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php if (!empty($erreur)): ?>
                <div class="flex w-full max-w-sm overflow-hidden bg-white rounded-lg shadow-md dark:bg-gray-800 mt-4">
                    <div class="flex items-center justify-center w-12 bg-red-500">
                        <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM20 28.3333C19.1667 28.3333 18.3334 27.5 18.3334 26.6666V21.6666C18.3334 20.8333 19.1667 20 20 20C20.8334 20 21.6667 20.8333 21.6667 21.6666V26.6666C21.6667 27.5 20.8334 28.3333 20 28.3333ZM20 18.3333C19.1667 18.3333 18.3334 17.5 18.3334 16.6666C18.3334 15.8333 19.1667 15 20 15C20.8334 15 21.6667 15.8333 21.6667 16.6666C21.6667 17.5 20.8334 18.3333 20 18.3333Z" />
                        </svg>
                    </div>
                    <div class="px-4 py-2 -mx-3">
                        <div class="mx-3">
                            <span class="font-semibold text-red-500 dark:text-red-400">Oops ! </span>
                            <p class="text-sm text-gray-600 dark:text-gray-200 font-bold"><?php echo $erreur; ?></p>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">Nom</label>
                        <input class="appearance-none block w-full bg-white text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="nom" type="text" placeholder="Nom de l'élève" required>
                    </div>
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">Prénom</label>
                        <input class="appearance-none block w-full bg-white text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="prenom" type="text" placeholder="Prénom de l'élève" required>
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-datenaissance">Date de naissance</label>
                        <input class="appearance-none block w-full bg-white text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="date_naissance" type="date" placeholder="Date de naissance" required>
                    </div>
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-sexe">Sexe</label>
                        <select class="block appearance-none w-full bg-white border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="sexe" required>
                            <option value="" disabled selected>Sexe </option>
                            <option value="Masculin">Masculin</option>
                            <option value="Féminin">Féminin</option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-site">Classe</label>
                        <select class="block appearance-none w-full bg-white border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="site" required>
                            <option value="" disabled selected>Classe</option>
                            <?php
                            $sites = $base_com->query("SELECT * FROM site")->fetchAll();
                            foreach ($sites as $site) {
                                echo "<option value='" . $site['idSite'] . "'>" . $site['nomSite'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-contact">Contact</label>
                        <input class="appearance-none block w-full bg-white text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" name="contact" type="text" placeholder="Contact parent" required>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <button class="bg-green-400 hover:bg-green-500 text-white font-bold py-2 px-4 rounded" type="submit" name="addgs">Inscription</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
