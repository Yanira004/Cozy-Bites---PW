<?php
global $pdo;
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['id_utilizator'])) {
    $id_user = $_SESSION['id_utilizator'];
    $nume    = $_POST['nume_reteta'];
    $cat     = $_POST['categorie'];
    $timp    = $_POST['timp'];

    $stmt = $pdo->prepare("INSERT INTO retete (id_utilizator, nume_reteta, categorie, timp_preparare) VALUES (?, ?, ?, ?)");
    $stmt->execute([$id_user, $nume, $cat, $timp]);
    $id_reteta = $pdo->lastInsertId();

    if (!empty($_FILES['poze']['name'][0])) {
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);

        foreach ($_FILES['poze']['tmp_name'] as $key => $tmp_name) {
            $file_name   = time() . "_" . basename($_FILES['poze']['name'][$key]);
            $target_file = $target_dir . $file_name;

            if (move_uploaded_file($tmp_name, $target_file)) {
                $stmt_img = $pdo->prepare("INSERT INTO retete_imagini (id_reteta, cale_fisier) VALUES (?, ?)");
                $stmt_img->execute([$id_reteta, $target_file]);
            }
        }
    }

    header("Location: carduri.php");
    exit();
}
?>