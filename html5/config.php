<?php
session_start();

try {
    $pdo = new PDO("sqlite:" . __DIR__ . "/cozybites.sqlite");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("CREATE TABLE IF NOT EXISTS utilizatori (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        username TEXT NOT NULL UNIQUE,
        parola TEXT NOT NULL,
        rol TEXT DEFAULT 'user',
        poza_profil TEXT DEFAULT NULL
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS retete (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        id_utilizator INTEGER NOT NULL,
        nume_reteta TEXT NOT NULL,
        categorie TEXT NOT NULL,
        timp_preparare INTEGER NOT NULL,
        FOREIGN KEY (id_utilizator) REFERENCES utilizatori(id) ON DELETE CASCADE
    )");

    $check = $pdo->query("SELECT COUNT(*) FROM utilizatori")->fetchColumn();
    if ($check == 0) {
        $pdo->exec("INSERT INTO utilizatori (username, parola, rol) VALUES ('admin1', 'parola123', 'admin')");
        $pdo->exec("INSERT INTO utilizatori (username, parola, rol) VALUES ('yani', 'parolayani', 'user')");
    }

} catch (\PDOException $e) {
    die("Eroare la conectarea SQLite: " . $e->getMessage());
}

if (!isset($_SESSION['logat']) && isset($_COOKIE['user_login'])) {
    $usernameDinCookie = $_COOKIE['user_login'];
    $stmt = $pdo->prepare("SELECT * FROM utilizatori WHERE username = :user");
    $stmt->execute(['user' => $usernameDinCookie]);
    $utilizatorGasit = $stmt->fetch();

    if ($utilizatorGasit) {
        $_SESSION['logat'] = true;
        $_SESSION['id_utilizator'] = $utilizatorGasit['id'];
        $_SESSION['username'] = $utilizatorGasit['username'];
        $_SESSION['rol'] = $utilizatorGasit['rol'];
    }
}
?>