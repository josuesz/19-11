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

// Verifica se a tarefa existe e pertence ao usuário
$stmt = $conn->prepare("SELECT * FROM tarefas WHERE id = :id AND usuario_id = :usuario_id");
$stmt->execute(['id' => $tarefa_id, 'usuario_id' => $usuario_id]);
$tarefa = $stmt->fetch();

if (!$tarefa) {
    echo "Tarefa não encontrada ou você não tem permissão para excluir essa tarefa.";
    exit();
}

// Exclui a tarefa do banco de dados
$stmt = $conn->prepare("DELETE FROM tarefas WHERE id = :id AND usuario_id = :usuario_id");
$stmt->execute(['id' => $tarefa_id, 'usuario_id' => $usuario_id]);

// Redireciona para a página principal
header('Location: index.php');
exit();
?>
