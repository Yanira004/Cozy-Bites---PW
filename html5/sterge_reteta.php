<?php
require_once 'config.php';
global $pdo;

if (!isset($_SESSION['logat']) || $_SESSION['rol'] !== 'admin') {
    die("Acces interzis! Doar administratorii pot șterge rețete.");
}

if (isset($_GET['id'])) {
    $id_reteta = (int)$_GET['id'];

    try {
        $pdo->beginTransaction();

        $stmt = $pdo->prepare("SELECT cale_fisier FROM retete_imagini WHERE id_reteta = ?");
        $stmt->execute([$id_reteta]);
        $poze = $stmt->fetchAll();

        foreach ($poze as $poza) {
            if (file_exists($poza['cale_fisier'])) {
                unlink($poza['cale_fisier']);
            }
        }

        $del_poze = $pdo->prepare("DELETE FROM retete_imagini WHERE id_reteta = ?");
        $del_poze->execute([$id_reteta]);

        $del_reteta = $pdo->prepare("DELETE FROM retete WHERE id = ?");
        $del_reteta->execute([$id_reteta]);

        $pdo->commit();
        header("Location: carduri.php?mesaj=reteta_stearsa");
        exit();

    } catch (Exception $e) {
        $pdo->rollBack();
        die("Eroare la ștergere: " . $e->getMessage());
    }
} else {
    header("Location: carduri.php");
    exit();
}