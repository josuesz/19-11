<?php
$host = 'localhost';
$dbname = 'gerenciamento_tarefas';
$user = 'root';  // Usuário do banco de dados (padrão no MySQL é 'root')
$pass = '';      // Senha (deixe em branco se não houver senha para o usuário root)

try {
    // Conexão usando PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Configura para lançar exceções em caso de erro
} catch (PDOException $e) {
    die("Falha na conexão: " . $e->getMessage());
}
?>
