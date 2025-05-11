<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (cadastrar_paciente($pdo, $_POST)) {
        $_SESSION['mensagem'] = 'Paciente cadastrado com sucesso!';
        $_SESSION['tipo_mensagem'] = 'success';
        redirect('/pacientes/listar.php');
    } else {
        $erro = "Erro ao cadastrar paciente. Por favor, tente novamente.";
    }
}


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

?>