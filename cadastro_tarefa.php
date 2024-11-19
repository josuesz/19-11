<?php
session_start();
require 'db.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $descricao = $_POST['descricao'];
    $usuario_id = $_SESSION['usuario_id'];

    // Insere a nova tarefa
    $stmt = $conn->prepare("INSERT INTO tarefas (descricao, usuario_id) VALUES (:descricao, :usuario_id)");
    $stmt->execute(['descricao' => $descricao, 'usuario_id' => $usuario_id]);

    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Tarefa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 50px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        textarea {
            width: 100%;
            height: 150px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            background-color: #f9f9f9;
            resize: none;
        }

        textarea:focus {
            border-color: #4CAF50;
            background-color: #fff;
            outline: none;
        }

        button {
            padding: 12px 0;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049;
        }

        .back-link {
            text-align: center;
            font-size: 14px;
            margin-top: 20px;
        }

        .back-link a {
            color: #007BFF;
            text-decoration: none;
        }

        .back-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Cadastrar Tarefa</h1>
        <form method="POST">
            <textarea name="descricao" placeholder="Descrição da tarefa" required></textarea>
            <button type="submit">Cadastrar Tarefa</button>
        </form>
        <div class="back-link">
            <p><a href="index.php">Voltar para a página inicial</a></p>
        </div>
    </div>
</body>
</html>
