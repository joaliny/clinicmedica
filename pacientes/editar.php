<?php
// pacientes/editar.php

// 1. Inclui os arquivos na ordem correta
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/db.php'; // Adicionado
require_once __DIR__ . '/../includes/functions.php';
require_once __DIR__ . '/../includes/header.php';

// 2. Verifica a conexão
if (!isset($pdo)) {
    die("Erro: Conexão com o banco de dados não estabelecida");
}

// 3. Verifica se o ID foi recebido
if (!isset($_GET['id'])) {
    redirect(BASE_URL . '/pacientes/listar.php');
}

$id = (int)$_GET['id'];

// 4. Busca o paciente
try {
    $stmt = $pdo->prepare("SELECT * FROM pacientes WHERE id = ?");
    $stmt->execute([$id]);
    $paciente = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$paciente) {
        $_SESSION['mensagem'] = 'Paciente não encontrado!';
        $_SESSION['tipo_mensagem'] = 'danger';
        redirect(BASE_URL . '/pacientes/listar.php');
    }
} catch (PDOException $e) {
    die("Erro ao buscar paciente: " . $e->getMessage());
}

// 5. Processa o formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'nome' => sanitize($_POST['nome'] ?? ''),
        'cpf' => sanitize($_POST['cpf'] ?? ''),
        'email' => sanitize($_POST['email'] ?? null),
        'telefone' => sanitize($_POST['telefone'] ?? null),
        'data_nascimento' => sanitize($_POST['data_nascimento'] ?? null),
        'endereco' => sanitize($_POST['endereco'] ?? null)
    ];
    
    try {
        $stmt = $pdo->prepare("UPDATE pacientes SET 
                              nome = :nome, 
                              cpf = :cpf, 
                              email = :email, 
                              telefone = :telefone, 
                              data_nascimento = :data_nascimento, 
                              endereco = :endereco 
                              WHERE id = :id");
                              
        $stmt->execute(array_merge($dados, ['id' => $id]));
        
        $_SESSION['mensagem'] = 'Paciente atualizado com sucesso!';
        $_SESSION['tipo_mensagem'] = 'success';
        
        // SUBSTITUA ESTA LINHA:
        // redirect(BASE_URL . '/pacientes/listar.php');
        
        // POR ESTE CÓDIGO:
        header("Location: " . BASE_URL . "/pacientes/listar.php");
        exit();
        
    } catch (PDOException $e) {
        $erro = "Erro ao atualizar paciente: " . $e->getMessage();
    }
}

?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Paciente</title>
    <!-- Seus estilos aqui -->
</head>
<body>
    <div class="container py-5">
        <h2>Editar Paciente</h2>

       <?php if (!empty($erro)): ?>
    <div class="alert alert-danger">
        <?php 
        // Verifica se a função existe antes de usar
        if (function_exists('safe_html')) {
            echo htmlspecialchars($erro, ENT_QUOTES, 'UTF-8');
        } else {
            echo htmlspecialchars($erro, ENT_QUOTES, 'UTF-8');
        }
        ?>
    </div>
<?php endif; ?>

<form method="POST">
    <div class="mb-3">
        <label for="nome" class="form-label">Nome Completo</label>
        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $paciente['nome']; ?>" required>
    </div>
    
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="cpf" class="form-label">CPF</label>
            <input type="text" class="form-control" id="cpf" name="cpf" value="<?php echo $paciente['cpf']; ?>" required>
        </div>
        <div class="col-md-6 mb-3">
            <label for="data_nascimento" class="form-label">Data de Nascimento</label>
            <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" 
                   value="<?php echo $paciente['data_nascimento']; ?>" required>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo $paciente['email']; ?>">
        </div>
        <div class="col-md-6 mb-3">
            <label for="telefone" class="form-label">Telefone</label>
            <input type="text" class="form-control" id="telefone" name="telefone" value="<?php echo $paciente['telefone']; ?>">
        </div>
    </div>
    
    <div class="mb-3">
        <label for="endereco" class="form-label">Endereço</label>
        <textarea class="form-control" id="endereco" name="endereco" rows="3"><?php echo $paciente['endereco']; ?></textarea>
    </div>
    
    <button type="submit" class="btn btn-primary">Atualizar</button>
    <a href="<?php echo BASE_URL; ?>/pacientes/listar.php" class="btn btn-secondary">Cancelar</a>
</form>


<?php require_once '../includes/footer.php'; ?>
