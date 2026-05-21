<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

try {
    $dbPath = __DIR__ . "/cozybites.sqlite";
    $pdo = new PDO("sqlite:" . $dbPath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("CREATE TABLE IF NOT EXISTS utilizatori (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    parola TEXT NOT NULL,
    rol TEXT DEFAULT 'user',
    varsta INTEGER,
    tara TEXT,
    oras TEXT,
    bio TEXT
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS retete (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        id_utilizator INTEGER NOT NULL,
        nume_reteta TEXT NOT NULL,
        categorie TEXT NOT NULL,
        timp_preparare INTEGER NOT NULL,
        FOREIGN KEY (id_utilizator) REFERENCES utilizatori(id) ON DELETE CASCADE
    )");

    $pdo->exec("CREATE TABLE IF NOT EXISTS retete_imagini (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_reteta INTEGER NOT NULL,
    cale_fisier TEXT NOT NULL,
    FOREIGN KEY (id_reteta) REFERENCES retete(id) ON DELETE CASCADE
    )");

     $pdo->exec("CREATE TABLE IF NOT EXISTS log_profil (
     id INTEGER PRIMARY KEY AUTOINCREMENT,
     id_utilizator INTEGER,
     actiune TEXT,
     data_ora TEXT
    )");

    //$pdo->exec("INSERT INTO utilizatori (username, parola, rol) VALUES
    //('admin1', '" . password_hash('parola123', PASSWORD_DEFAULT) . "', 'admin')");

    // Inserăm utilizatorii de test
    $check = $pdo->query("SELECT COUNT(*) FROM utilizatori")->fetchColumn();
    if ($check == 0) {
        $pdo->exec("INSERT INTO utilizatori (username, parola, rol) VALUES ('admin1', 'parola123', 'admin')");
        $pdo->exec("INSERT INTO utilizatori (username, parola, rol) VALUES ('yani', 'parolayani', 'user')");
    }
} catch (\Exception $e) {
    die("Eroare SQLite: " . $e->getMessage());
}

// Logica de Remember Me adaptată pentru SQLite (fără modificări mari)
if (!isset($_SESSION['logat']) && isset($_COOKIE['user_login'])) {
    $usernameDinCookie = $_COOKIE['user_login'];
    $stmt = $pdo->prepare("SELECT * FROM utilizatori WHERE username = :user");
    $stmt->execute(['user' => $usernameDinCookie]);
    $utilizatorGasit = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($utilizatorGasit) {
        $_SESSION['logat'] = true;
        $_SESSION['id_utilizator'] = $utilizatorGasit['id'];
        $_SESSION['username'] = $utilizatorGasit['username'];
        $_SESSION['rol'] = $utilizatorGasit['rol'];
    }
}
?>