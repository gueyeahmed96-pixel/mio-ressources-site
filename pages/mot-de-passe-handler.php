<?php
// Fichier : /pages/mot-de-passe-handler.php (VERSION DE DÉBOGAGE ABSOLU)

require_once '../includes/auth_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    
    // On appelle la fonction de PHPAuth
    $result = $auth->requestReset($email, true);
    
    // ON AFFICHE LE RÉSULTAT QUOI QU'IL ARRIVE
    echo "<h1>Résultat du Débogage Absolu</h1>";
    echo "<p>Email testé : " . htmlspecialchars($email) . "</p>";
    echo "<p>Contenu de la variable \$result :</p>";
    echo "<pre>";
    var_dump($result);
    echo "</pre>";
    
    // On arrête le script pour voir le message
    exit(); 
}