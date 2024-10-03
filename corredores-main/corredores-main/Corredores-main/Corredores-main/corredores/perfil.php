<?php
include 'auth.php'; // Verifica se o usuário está logado
include 'db.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

// Obtém o email do usuário logado
$email = $_SESSION['email'];

// Busca os dados do usuário no banco de dados
$sql = "SELECT nome, email, idade, genero, cidade, distancia_favorita, tempo_medio FROM usuarios WHERE email = :email";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':email', $email);

if ($stmt->execute()) {
    $corredor = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$corredor) {
        $msg = "Usuário não encontrado.";
    }
} else {
    $msg = "Erro ao buscar informações do usuário.";
}

// Verifica se o formulário foi enviado para atualizar as informações
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    // Recebe os dados atualizados do formulário
    $nome = $_POST['nome'];
    $idade = $_POST['idade'];
    $genero = $_POST['genero'];
    $cidade = $_POST['cidade'];
    $distancia_favorita = $_POST['distancia_favorita'];
    $tempo_medio = $_POST['tempo_medio'];

    // Atualiza os dados do usuário no banco de dados
    $sql = "UPDATE usuarios SET nome = :nome, idade = :idade, genero = :genero, cidade = :cidade, distancia_favorita = :distancia_favorita, tempo_medio = :tempo_medio WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':idade', $idade);
    $stmt->bindParam(':genero', $genero);
    $stmt->bindParam(':cidade', $cidade);
    $stmt->bindParam(':distancia_favorita', $distancia_favorita);
    $stmt->bindParam(':tempo_medio', $tempo_medio);
    $stmt->bindParam(':email', $email);
    
    if ($stmt->execute()) {
        $msg = "Informações atualizadas com sucesso!";
    } else {
        $msg = "Erro ao atualizar as informações.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Corredor</title>
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
<nav class="navbar navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Sistema de Corredores</a>
        <div>
            <a href="dashboard.php" class="btn btn-outline-primary">Dashboard</a>
            <a href="logout.php" class="btn btn-outline-danger">Logout</a>
        </div>
    </div>
</nav>
    <div class="container">
        <div class="form-container">
            <h2 class="text-center mb-4">Editar Perfil</h2>
            <?php if (isset($msg)): ?>
                <div class="alert alert-info"><?= $msg ?></div>
            <?php endif; ?>
            <form method="POST" action="perfil.php">
                <input type="hidden" name="update" value="1">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome</label>
                    <input type="text" class="form-control" id="nome" name="nome" value="<?= isset($corredor['nome']) ? htmlspecialchars($corredor['nome']) : '' ?>" required>
                </div>
                <div class="mb-3">
                    <label for="idade" class="form-label">Idade</label>
                    <input type="number" class="form-control" id="idade" name="idade" value="<?= isset($corredor['idade']) ? htmlspecialchars($corredor['idade']) : '' ?>" required>
                </div>
                <div class="mb-3">
                    <label for="genero" class="form-label">Gênero</label>
                    <select class="form-control" id="genero" name="genero" required>
                        <option value="Masculino" <?= (isset($corredor['genero']) && $corredor['genero'] === 'Masculino') ? 'selected' : '' ?>>Masculino</option>
                        <option value="Feminino" <?= (isset($corredor['genero']) && $corredor['genero'] === 'Feminino') ? 'selected' : '' ?>>Feminino</option>
                        <option value="Outro" <?= (isset($corredor['genero']) && $corredor['genero'] === 'Outro') ? 'selected' : '' ?>>Outro</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="cidade" class="form-label">Cidade</label>
                    <input type="text" class="form-control" id="cidade" name="cidade" value="<?= isset($corredor['cidade']) ? htmlspecialchars($corredor['cidade']) : '' ?>" required>
                </div>
                <div class="mb-3">
                    <label for="distancia_favorita" class="form-label">Distância Favorita</label>
                    <select class="form-select" id="distancia_favorita" name="distancia_favorita" required>
                        <option value="5k" <?= (isset($corredor['distancia_favorita']) && $corredor['distancia_favorita'] === '5k') ? 'selected' : '' ?>>5k</option>
                        <option value="10k" <?= (isset($corredor['distancia_favorita']) && $corredor['distancia_favorita'] === '10k') ? 'selected' : '' ?>>10k</option>
                        <option value="Meia Maratona" <?= (isset($corredor['distancia_favorita']) && $corredor['distancia_favorita'] === 'Meia Maratona') ? 'selected' : '' ?>>Meia Maratona</option>
                        <option value="Maratona" <?= (isset($corredor['distancia_favorita']) && $corredor['distancia_favorita'] === 'Maratona') ? 'selected' : '' ?>>Maratona</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="tempo_medio" class="form-label">Tempo Médio (min/km)</label>
                    <input type="text" class="form-control" id="tempo_medio" name="tempo_medio" value="<?= isset($corredor['tempo_medio']) ? htmlspecialchars($corredor['tempo_medio']) : '' ?>" required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Atualizar Informações</button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">Deletar Conta</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de confirmação -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Deletar Conta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Você tem certeza de que deseja deletar sua conta? Esta ação não pode ser desfeita.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form method="POST" action="deletar.php" style="display:inline;">
                        <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
                        <button type="submit" class="btn btn-danger">Deletar Conta</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>