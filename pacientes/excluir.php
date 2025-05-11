<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

if (!isset($_GET['id'])) {
    redirect(BASE_URL . '/pacientes/listar.php');
}

$id = (int)$_GET['id'];

try {
    $stmt = $pdo->prepare("DELETE FROM pacientes WHERE id = ?");
    $stmt->execute([$id]);
    
    $_SESSION['mensagem'] = 'Paciente excluído com sucesso!';
    $_SESSION['tipo_mensagem'] = 'success';
} catch (PDOException $e) {
    $_SESSION['mensagem'] = 'Erro ao excluir paciente: ' . $e->getMessage();
    $_SESSION['tipo_mensagem'] = 'danger';
}

redirect(BASE_URL . '/pacientes/listar.php');
?>