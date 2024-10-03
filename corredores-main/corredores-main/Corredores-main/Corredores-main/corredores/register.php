<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
    $idade = $_POST['idade'];
    $genero = $_POST['genero'];
    $cidade = $_POST['cidade'];
    $distancia_favorita = $_POST['distancia_favorita'];
    $tempo_medio = $_POST['tempo_medio'];

    $sql = "INSERT INTO usuarios (nome, email, senha, idade, genero, cidade, distancia_favorita, tempo_medio) 
            VALUES (:nome, :email, :senha, :idade, :genero, :cidade, :distancia_favorita, :tempo_medio)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':senha', $senha);
    $stmt->bindParam(':idade', $idade);
    $stmt->bindParam(':genero', $genero);
    $stmt->bindParam(':cidade', $cidade);
    $stmt->bindParam(':distancia_favorita', $distancia_favorita);
    $stmt->bindParam(':tempo_medio', $tempo_medio);

    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Erro ao cadastrar.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Corredores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f9fb;
            font-family: 'Arial', sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .table-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
<div class="form-container">
    <h2 class="text-center mb-4">Cadastro de Corredor</h2>
    <form method="post" action="register.php">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" name="nome" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" name="senha" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="idade" class="form-label">Idade</label>
            <input type="number" name="idade" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="genero" class="form-label">Gênero</label>
            <select name="genero" class="form-select" required>
                <option value="Masculino">Masculino</option>
                <option value="Feminino">Feminino</option>
                <option value="Outro">Outro</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="cidade" class="form-label">Cidade</label>
            <input type="text" name="cidade" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="distancia_favorita" class="form-label">Distância Favorita</label>
            <select name="distancia_favorita" class="form-select" required>
                <option value="5k">5k</option>
                <option value="10k">10k</option>
                <option value="Meia Maratona">Meia Maratona</option>
                <option value="Maratona">Maratona</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="tempo_medio" class="form-label">Tempo Médio (HH:MM:SS)</label>
            <input type="time" name="tempo_medio" class="form-control" step="1" required>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </div>
    </form>
</div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
