<?php
require_once 'config.php';

if (isset($_GET['id']) && isset($_SESSION['logat'])) {
    global $pdo;
    $id_poza = (int)$_GET['id'];

    $stmt = $pdo->prepare("SELECT cale_fisier FROM retete_imagini WHERE id = ?");
    $stmt->execute([$id_poza]);
    $poza = $stmt->fetch();

    if ($poza) {
        if (file_exists($poza['cale_fisier'])) {
            unlink($poza['cale_fisier']);
        }

        $del = $pdo->prepare("DELETE FROM retete_imagini WHERE id = ?");
        $del->execute([$id_poza]);

        http_response_code(200);
    } else {
        http_response_code(404);
    }
} else {
    http_response_code(403);
}
exit();