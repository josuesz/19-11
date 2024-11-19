<?php
session_start();
require 'db.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header('Location: login.php');
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Verifica se o ID da tarefa foi passado via GET
if (!isset($_GET['id'])) {
    echo "Tarefa não encontrada.";
    exit();
}

$tarefa_id = $_GET['id'];

// Consulta para obter os dados da tarefa
$stmt = $conn->prepare("SELECT * FROM tarefas WHERE id = :id AND usuario_id = :usuario_id");
$stmt->execute(['id' => $tarefa_id, 'usuario_id' => $usuario_id]);
$tarefa = $stmt->fetch();

if (!$tarefa) {
    echo "Tarefa não encontrada ou você não tem permissão para editar essa tarefa.";
    exit();
}

// Atualização da tarefa, caso o formulário seja enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $descricao = $_POST['descricao'];
    $status = $_POST['status'];

    // Atualiza a tarefa no banco de dados
    $stmt = $conn->prepare("UPDATE tarefas SET descricao = :descricao, status = :status WHERE id = :id AND usuario_id = :usuario_id");
    $stmt->execute([
        'descricao' => $descricao,
        'status' => $status,
        'id' => $tarefa_id,
        'usuario_id' => $usuario_id
    ]);

    // Redireciona para a página principal
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tarefa</title>
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

        a {
            text-decoration: none;
            color: #007BFF;
            font-size: 16px;
            display: block;
            margin-bottom: 20px;
            text-align: center;
        }

        a:hover {
            text-decoration: underline;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-size: 16px;
            color: #333;
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

        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            background-color: #f9f9f9;
        }

        select:focus {
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
    </style>
</head>
<body>
    <div class="container">
        <a href="index.php">Voltar</a>
        <h1>Editar Tarefa</h1>
        <form action="editar_tarefa.php?id=<?= $tarefa['id'] ?>" method="POST">
            <div>
                <label for="descricao">Descrição:</label>
                <textarea name="descricao" id="descricao" required><?= htmlspecialchars($tarefa['descricao']) ?></textarea>
            </div>
            <div>
                <label for="status">Status:</label>
                <select name="status" id="status">
                    <option value="pendente" <?= $tarefa['status'] == 'pendente' ? 'selected' : '' ?>>Pendente</option>
                    <option value="concluída" <?= $tarefa['status'] == 'concluída' ? 'selected' : '' ?>>Concluída</option>
                </select>
            </div>
            <div>
                <button type="submit">Salvar</button>
            </div>
        </form>
    </div>
</body>
</html>
