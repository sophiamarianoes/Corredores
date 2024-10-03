<?php
session_start(); // Inicia a sessão
include 'auth.php'; // Verifica se o usuário está logado
include 'db.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// Obtém o email do usuário logado
$email = $_POST['email'];

// Deleta o usuário do banco de dados
$sql = "DELETE FROM usuarios WHERE email = :email";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':email', $email);

if ($stmt->execute()) {
    // Logout do usuário após a exclusão
    session_destroy(); // Destroi a sessão
    header("Location: index.php"); // Redireciona para a página inicial
    exit();
} else {
    // Redireciona com uma mensagem de erro
    $_SESSION['msg'] = "Erro ao deletar a conta.";
    header("Location: perfil.php");
    exit();
}
?>
