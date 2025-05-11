<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = sanitize($_POST['nome']);
    $cpf = sanitize($_POST['cpf']);
    $email = sanitize($_POST['email']);
    $telefone = sanitize($_POST['telefone']);
    $data_nascimento = sanitize($_POST['data_nascimento']);
    $endereco = sanitize($_POST['endereco']);

    try {
        $stmt = $pdo->prepare("INSERT INTO pacientes (nome, cpf, email, telefone, data_nascimento, endereco) 
                             VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nome, $cpf, $email, $telefone, $data_nascimento, $endereco]);
        
        $_SESSION['mensagem'] = 'Paciente cadastrado com sucesso!';
        $_SESSION['tipo_mensagem'] = 'success';
    } catch (PDOException $e) {
        $_SESSION['mensagem'] = 'Erro ao cadastrar paciente: ' . $e->getMessage();
        $_SESSION['tipo_mensagem'] = 'danger';
    }
    
    redirect(BASE_URL . '/pacientes/listar.php');
}
?>