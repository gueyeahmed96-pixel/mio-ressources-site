<?php
// Fichier : /includes/db.php
// Ce fichier gère la connexion à notre base de données MySQL.

// --- Paramètres de connexion ---
// Hôte de la base de données (généralement 'localhost' avec XAMPP)
$host = 'localhost';
// Nom de la base de données que nous avons créée dans phpMyAdmin
$dbname = 'mio_db';
// Utilisateur de la base de données (généralement 'root' avec XAMPP)
$user = 'root';
// Mot de passe de l'utilisateur (généralement vide avec XAMPP)
$pass = '';

// --- Création de la connexion avec PDO ---
// PDO (PHP Data Objects) est une manière moderne et sécurisée de parler à une base de données.
// On utilise un bloc "try...catch" pour gérer les erreurs de connexion.

try {
    // On essaie de créer une nouvelle instance de PDO.
    // Le DSN (Data Source Name) contient les informations pour se connecter.
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);

    // On configure PDO pour qu'il nous montre les erreurs s'il y en a.
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // On configure le mode de récupération des données par défaut.
    // PDO::FETCH_ASSOC renvoie les résultats sous forme de tableau associatif (clé => valeur).
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Si la connexion échoue (dans le bloc 'try'), le 'catch' s'exécute.
    // On arrête le script et on affiche un message d'erreur clair mais pas trop technique pour l'utilisateur.
    // die() arrête l'exécution du script.
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>