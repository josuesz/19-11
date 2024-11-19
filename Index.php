<?php
session_start();
require 'db.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Consulta para obter as tarefas do usuário
$stmt = $conn->prepare("SELECT * FROM tarefas WHERE usuario_id = :usuario_id ORDER BY data_criacao DESC");
$stmt->execute(['usuario_id' => $usuario_id]);
$tarefas = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Tarefas</title>
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

        h2 {
            color: #444;
            font-size: 24px;
            margin-bottom: 10px;
        }

        a {
            color: #007BFF;
            text-decoration: none;
            font-size: 16px;
        }

        a:hover {
            text-decoration: underline;
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

        .manage-users {
            display: inline-block;
            background-color: #008CBA;
            color: white;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }

        .manage-users:hover {
            background-color: #007B9E;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bem-vindo ao Gerenciamento de Tarefas</h1>
        <a href="logout.php" class="logout">Sair</a>

        <h2>Tarefas</h2>
        <a href="cadastro_tarefa.php" class="add-task">Cadastrar nova tarefa</a>
        
        <!-- Adicionando o botão de gerenciamento de usuários -->
        <a href="gerenciamento_usuarios.php" class="manage-users">Gerenciar Usuários e Tarefas</a>

        <table>
            <thead>
                <tr>
                    <th>Descrição</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tarefas as $tarefa): ?>
                <tr>
                    <td><?= htmlspecialchars($tarefa['descricao']) ?></td>
                    <td><?= $tarefa['status'] ?></td>
                    <td class="actions">
                        <a href="editar_tarefa.php?id=<?= $tarefa['id'] ?>">Editar</a> | 
                        <a href="excluir_tarefa.php?id=<?= $tarefa['id'] ?>">Excluir</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
