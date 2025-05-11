<?php
// pacientes/excluir.php

// 1. Inclui os arquivos na ordem correta com caminhos absolutos
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php'; // Garanta que este arquivo existe
require_once __DIR__ . '/../includes/functions.php';

// 2. Verifica a conexão com o banco
if (!isset($pdo)) {
    die("Erro: Conexão com o banco de dados não estabelecida");
}

// 3. Verifica se o ID foi recebido
if (!isset($_GET['id'])) {
    header("Location: " . BASE_URL . "/pacientes/listar.php");
    exit();
}

$id = (int)$_GET['id'];

try {
    // 4. Prepara e executa a exclusão
    $stmt = $pdo->prepare("DELETE FROM pacientes WHERE id = ?");
    $stmt->execute([$id]);
    
    // 5. Define mensagem de sucesso
    $_SESSION['mensagem'] = 'Paciente excluído com sucesso!';
    $_SESSION['tipo_mensagem'] = 'success';
    
} catch (PDOException $e) {
    // 6. Define mensagem de erro
    $_SESSION['mensagem'] = 'Erro ao excluir paciente: ' . $e->getMessage();
    $_SESSION['tipo_mensagem'] = 'danger';
}

// 7. Redirecionamento garantido
header("Location: " . BASE_URL . "/pacientes/listar.php");
exit();