<?php
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['id_utilizator'])) {
    $conn = mysqli_connect("localhost", "root", "", "cozybites_recipes");

    if (!$conn) {
        die("Conexiune eșuată MySQLi: " . mysqli_connect_error());
    }

    $id_user = $_SESSION['id_utilizator'];
    $nume = $_POST['nume_reteta'];
    $cat = $_POST['categorie'];
    $timp = $_POST['timp'];

    $sql = "INSERT INTO retete (id_utilizator, nume_reteta, categorie, timp_preparare) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "issi", $id_user, $nume, $cat, $timp);
    mysqli_stmt_execute($stmt);
    $id_reteta = mysqli_insert_id($conn);

    if (!empty($_FILES['poze']['name'][0])) {
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        foreach ($_FILES['poze']['tmp_name'] as $key => $tmp_name) {
            $file_name = time() . "_" . basename($_FILES['poze']['name'][$key]);
            $target_file = $target_dir . $file_name;

            if (move_uploaded_file($tmp_name, $target_file)) {
                $sql_img = "INSERT INTO retete_imagini (id_reteta, cale_fisier) VALUES (?, ?)";
                $stmt_img = mysqli_prepare($conn, $sql_img);
                mysqli_stmt_bind_param($stmt_img, "is", $id_reteta, $target_file);
                mysqli_stmt_execute($stmt_img);
            }
        }
    }

    mysqli_close($conn);
    header("Location: carduri.php");
    exit();
}
?>