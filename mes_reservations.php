<?php 
   session_start();  
   if ($_SESSION['role'] !== "client") {
    header("Location: login.php");
    exit();
}
    include 'DataBase.php';
    $role ="";
    if($_SESSION){
        $id =  $_SESSION['idUtilisateur'];
    $nom = $_SESSION['nomUtilisateur'];
    $prenom = $_SESSION['prenomUtilisateur'];
    $email = $_SESSION['emailUtilisateur'];
    $tel = $_SESSION['contactUtilisateur'];
    $pp = $_SESSION['photoUtilisateur'];
    $role = $_SESSION['role'];
    $dateAdd = $_SESSION['dateAdd'];
    }
 
    $count = "SELECT COUNT(idReservation) AS nombrereservation FROM reservation WHERE idUtilisateur = :id";
    $result = $base_com->prepare($count);
    $result->bindParam(':id', $id, PDO::PARAM_INT);
    $result->execute();
    $resulta = $result->fetch(PDO::FETCH_ASSOC);

    $resev = "SELECT rv.*, ri.*, s.*
              FROM reservation rv 
              INNER JOIN utilisateur u ON u.idUtilisateur = rv.idUtilisateur 
              INNER JOIN ressourceimmobiliere ri ON rv.idLocal = ri.idLocal 
              INNER JOIN site s ON s.idSite = ri.idSite 
              WHERE rv.idUtilisateur = :id ";

    $stmt = $base_com->prepare($resev);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
    <script src="https://checkout.fedapay.com/js/checkout.js"></script>

  
          <?php
           include 'header.php';
           ?>
    <main >
    <div class="container mx-auto px-4 py-8 dark:bg-gray-800">
    <h1 class="text-2xl font-bold mb-4 dark:text-white">Historique de mes réservations  <span class="text-green-400"><?php echo $resulta['nombrereservation'];?></span></h1>
    <div class="flex flex-col mt-6">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                                <div class="overflow-hidden border border-gray-200 dark:border-gray-700 md:rounded-lg">
                                <?php
               if (isset($_GET['idReservation'])) {
                $idReservation = $_GET['idReservation'];
                
                $stmt = $base_com->prepare("DELETE FROM reservation WHERE idReservation = :idReservation");
                $stmt->bindParam(':idReservation', $idReservation);
                
                if ($stmt->execute()) {
                    echo "<div class='w-full text-white bg-yellow-400 mb-6'>
                            <div class='container flex items-center justify-between px-6 py-4 mx-auto'>
                                <div class='flex'>
                                    <svg viewBox='0 0 40 40' class='w-6 h-6 fill-current'>
                                        <path d='M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z'>
                                        </path>
                                    </svg>
                                    <p class='mx-3'>Votre réservation a été annulée !</p>
                                </div>
                            </div>
                        </div>";
                        echo "<script>
                                setTimeout(function(){
                                    window.location.href = 'mes_reservations.php';
                                }, 2000); 
                            </script>";
                    } else {
                        echo "Erreur de l'annulation de la réservation: " . $stmt->errorInfo()[2];
                    }
                }
                ?>
                                <?php
                                    if ($stmt->rowCount() > 0) {
                                ?>
                                
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700" id="">
                                        <thead class="bg-gray-50 dark:bg-gray-800">
                                        <tr>
                                            <th class="py-3 px-4 text-left dark:text-white font-bold">Site</th>
                                            <th class="py-3 px-4 text-left dark:text-white font-bold">Type de local</th>
                                            <th class="py-3 px-4 text-left dark:text-white font-bold">Date et heure de début</th>
                                            <th class="py-3 px-4 text-left dark:text-white font-bold">Date et heure de fin</th>
                                            <th class="py-3 px-4 text-left dark:text-white font-bold">Prix total</th>
                                            <th class="py-3 px-4 text-left dark:text-white font-bold">Statut</th>
                                            <th class="py-3 px-4 text-center dark:text-white font-bold">Action</th>
                                          </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                                        <?php
                                         while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                           $staut = $row['statutReservation'];
                                           $idReservation = $row['idReservation'];
                                        ?>
                                                
                                            <tr>
                                                <td class="px-4 py-4 text-sm font-medium text-gray-700 whitespace-nowrap">
                                                    <div class="inline-flex items-center gap-x-3">                
                                                        <div class="flex items-center gap-x-2">
                                                            <div>
                                                                <h2 class="font-medium text-green-500 font-bold "><?php echo $row['nomSite'];?></h2>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap"><?php echo $row['typeLocal'];?></td>
                                                <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap"><?php echo $row['dateStart'];?></td>
                                                <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap"><?php echo $row['dateEnd'];?></td>
                                                <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap"><?php echo $row['paiementReservation'];?> <span class="text-green-500">XOF</span></td>
                                                <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap"><?php echo strtoupper($row['statutReservation']);?></td>
                                                <td class="px-4 py-4 text-sm whitespace-nowrap">
                                                <div class="flex items-center gap-x-6 flex">
                                                    <?php if ($staut == "en attente") { ?>
                                                        <a href="mes_reservations.php?idReservation=<?php echo $row['idReservation']; ?>" class="flex">
                                                            <button onclick="return confirm('Voulez-vous annuler cette réservation ?');" class="flex font-bold bg-gray-200 rounded p-3  transition-colors duration-200 text-black focus:outline-none">
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                                                  <path fill-rule="evenodd" d="m6.72 5.66 11.62 11.62A8.25 8.25 0 0 0 6.72 5.66Zm10.56 12.68L5.66 6.72a8.25 8.25 0 0 0 11.62 11.62ZM5.105 5.106c3.807-3.808 9.98-3.808 13.788 0 3.808 3.807 3.808 9.98 0 13.788-3.807 3.808-9.98 3.808-13.788 0-3.808-3.807-3.808-9.98 0-13.788Z" clip-rule="evenodd" />
                                                                </svg>
                                                            </button>
                                                        </a>
                                                    <?php } elseif ($staut == "en attente de validation") { ?>
                                                            <button id="envoy-<?php echo $idReservation; ?>" class="flex font-bold bg-green-500 rounded p-3 text-white transition-colors duration-200 hover:text-black focus:outline-none">
                                                                Payer
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                                                  <path d="M4.5 3.75a3 3 0 0 0-3 3v.75h21v-.75a3 3 0 0 0-3-3h-15Z" />
                                                                  <path fill-rule="evenodd" d="M22.5 9.75h-21v7.5a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3v-7.5Zm-18 3.75a.75.75 0 0 1 .75-.75h6a.75.75 0 0 1 0 1.5h-6a.75.75 0 0 1-.75-.75Zm.75 2.25a.75.75 0 0 0 0 1.5h3a.75.75 0 0 0 0-1.5h-3Z" clip-rule="evenodd" />
                                                                </svg>
                                                            </button>
                                                            <script type='text/javascript'>
                                                            FedaPay.init('#envoy-<?php echo $idReservation; ?>',{public_key:'pk_live_aUkrfJsnm8CwH4P-K9WG4oJQ',
                                                            transaction:{amount:<?php echo $row['paiementReservation'];?>,description:'Payement réservation de local de type<?php echo $row['typeLocal'];?> à <?php echo $row['nomSite'];?> pour le <?php echo $row['dateStart'];?> au <?php echo $row['dateStart'];?>'},
                                                            customer:{lastname:'<?php echo $nom;?>',firstname:'<?php echo $prenom;?>'}});
                                                        </script>
                                                      
                                                    <?php } ?>
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
                                        echo "<p class='text-center text-blue-500 font-bold' >Aucune réservation !</p>";
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
                    </div>
  
  </div>
    </main>

  
    <?php
           include 'footer.php';
           ?>

</body>
</html>