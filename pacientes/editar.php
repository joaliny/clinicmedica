<?php
// pacientes/editar.php
//comentario teste
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

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm" style="border: none; border-radius: 10px;">
                <div class="card-header text-white" style="background: linear-gradient(135deg, #2a9d8f, #21867a); border-radius: 10px 10px 0 0;">
                    <h5 class="mb-0"><i class="fas fa-user-edit me-2"></i> Editar Paciente</h5>
                </div>
                <form method="POST">
                    <div class="card-body" style="padding: 25px;">
                        <?php if (!empty($erro)): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?></div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <label for="nome" class="form-label fw-medium">Nome Completo</label>
                            <input type="text" class="form-control" id="nome" name="nome" value="<?= htmlspecialchars($paciente['nome']) ?>" required style="border-radius: 8px; padding: 10px; border: 1px solid #e0e0e0;">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="cpf" class="form-label fw-medium">CPF</label>
                                <input type="text" class="form-control" id="cpf" name="cpf" value="<?= htmlspecialchars($paciente['cpf']) ?>" required style="border-radius: 8px; padding: 10px; border: 1px solid #e0e0e0;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="data_nascimento" class="form-label fw-medium">Data de Nascimento</label>
                                <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="<?= htmlspecialchars($paciente['data_nascimento']) ?>" required style="border-radius: 8px; padding: 10px; border: 1px solid #e0e0e0;">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label fw-medium">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($paciente['email']) ?>" style="border-radius: 8px; padding: 10px; border: 1px solid #e0e0e0;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="telefone" class="form-label fw-medium">Telefone</label>
                                <input type="text" class="form-control" id="telefone" name="telefone" value="<?= htmlspecialchars($paciente['telefone']) ?>" style="border-radius: 8px; padding: 10px; border: 1px solid #e0e0e0;">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="endereco" class="form-label fw-medium">Endereço</label>
                            <textarea class="form-control" id="endereco" name="endereco" rows="3" style="border-radius: 8px; padding: 10px; border: 1px solid #e0e0e0;"><?= htmlspecialchars($paciente['endereco']) ?></textarea>
                        </div>
                    </div>

                    <div class="card-footer d-flex justify-content-between" style="border-top: none; padding: 20px 25px 25px;">
                        <a href="<?= BASE_URL ?>/pacientes/listar.php" class="btn btn-secondary" style="border-radius: 8px; padding: 8px 20px;">Cancelar</a>
                        <button type="submit" class="btn text-white" style="border-radius: 8px; padding: 8px 20px; background: linear-gradient(135deg, #2a9d8f, #21867a); border: none;">
                            <i class="fas fa-save me-2"></i> Atualizar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- <form method="POST">
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
</form> -->



