<?php
$host = 'localhost';
$db = 'corredores';
$user = 'Sophia';
$pass = '123456';
$port = 3307; // Defina a porta que você está usando

try {
    // Inclua a porta na conexão PDO
    $conn = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>
