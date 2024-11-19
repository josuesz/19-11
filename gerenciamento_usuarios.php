<?php
session_start();
require 'db.php';

// Verifica se o usuário está logado e se é administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_tipo'] != 'admin') {
    header('Location: login.php');
    exit();
}

// Consulta para obter todos os usuários e suas respectivas tarefas
$stmt = $conn->prepare("SELECT u.id AS usuario_id, u.nome, u.email, t.id AS tarefa_id, t.descricao, t.status
                        FROM usuarios u
                        LEFT JOIN tarefas t ON u.id = t.usuario_id
                        ORDER BY u.id, t.data_criacao DESC");
$stmt->execute();
$usuarios = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Usuários e Tarefas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        td {
            background-color: #fff;
        }

        tr:nth-child(even) td {
            background-color: #f9f9f9;
        }

        .actions a {
            color: #007BFF;
            font-size: 14px;
            text-decoration: none;
        }

        .actions a:hover {
            text-decoration: underline;
        }

        .logout {
            display: inline-block;
            background-color: #f44336;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }

        .logout:hover {
            background-color: #e53935;
        }

        .add-task {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }

        .add-task:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gerenciamento de Usuários e Tarefas</h1>
        <a href="logout.php" class="logout">Sair</a>
        <a href="index.php" class="add-task">Voltar ao Gerenciamento de Tarefas</a>

        <table>
            <thead>
                <tr>
                    <th>Usuário</th>
                    <th>E-mail</th>
                    <th>Tarefa Descrição</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= htmlspecialchars($usuario['nome']) ?></td>
                    <td><?= htmlspecialchars($usuario['email']) ?></td>
                    <td><?= htmlspecialchars($usuario['descricao'] ?? 'Nenhuma tarefa') ?></td>
                    <td><?= htmlspecialchars($usuario['status'] ?? 'Sem status') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
