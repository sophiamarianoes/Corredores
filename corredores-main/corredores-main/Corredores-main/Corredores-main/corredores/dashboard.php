<?php
include 'auth.php'; // Protege a página
include 'db.php';

$sql = "SELECT nome, email, idade, genero, cidade, distancia_favorita, tempo_medio FROM usuarios";
$stmt = $conn->prepare($sql);
$stmt->execute();
$corredores = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        .form-container, .table-container {
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
        .logout-btn {
            display: inline-block;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Sistema de Corredores</a>
        <div>
            <a href="perfil.php" class="btn btn-outline-primary">Meu Perfil</a>
            <a href="logout.php" class="btn btn-outline-danger">Logout</a>
        </div>
    </div>
</nav>

    <div class="container">
        <div class="table-container">
            <h2 class="text-center mb-4">Lista de Corredores</h2>
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Idade</th>
                        <th>Gênero</th>
                        <th>Cidade</th>
                        <th>Distância Favorita</th>
                        <th>Tempo Médio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($corredores as $corredor): ?>
                    <tr>
                        <td><?= htmlspecialchars($corredor['nome']); ?></td>
                        <td><?= htmlspecialchars($corredor['email']); ?></td>
                        <td><?= htmlspecialchars($corredor['idade']); ?></td>
                        <td><?= htmlspecialchars($corredor['genero']); ?></td>
                        <td><?= htmlspecialchars($corredor['cidade']); ?></td>
                        <td><?= htmlspecialchars($corredor['distancia_favorita']); ?></td>
                        <td><?= htmlspecialchars($corredor['tempo_medio']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
