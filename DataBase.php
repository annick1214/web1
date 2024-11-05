<?php
try {
    $base_com = new PDO("mysql:host=localhost;dbname=p1", "root", "");
} catch (Exception $e) {
    die("Erreur" . $e->getMessage());
}
?>
