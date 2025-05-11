<?php
// includes/functions.php

require_once __DIR__ . '/db.php';

/**
 * Sanitiza dados de entrada
 */
function sanitize($data) {
    if ($data === null) return '';
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

/**
 * Redireciona para uma URL
 */
function redirect($url) {
    header("Location: " . BASE_URL . $url);
    exit();
}

/**
 * Exibe mensagens do sistema
 */
function display_messages() {
    if (!empty($_SESSION['mensagem'])) {
        $tipo = $_SESSION['tipo_mensagem'] ?? 'info';
        $mensagem = $_SESSION['mensagem'];
        
        echo '<div class="alert alert-' . $tipo . '">' . $mensagem . '</div>';
        
        // Limpa a mensagem após exibir
        unset($_SESSION['mensagem']);
        unset($_SESSION['tipo_mensagem']);
    }
}

/**
 * Busca todos os pacientes
 */
function get_pacientes($pdo) {
    try {
        $stmt = $pdo->query("SELECT * FROM pacientes ORDER BY nome");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erro ao buscar pacientes: " . $e->getMessage());
        return [];
    }
}

/**
 * Cadastra novo paciente
 */
function cadastrar_paciente($pdo, $dados) {
    try {
        $stmt = $pdo->prepare("INSERT INTO pacientes (nome, cpf, email, telefone, data_nascimento, endereco) 
                              VALUES (:nome, :cpf, :email, :telefone, :data_nascimento, :endereco)");
        
        return $stmt->execute([
            ':nome' => sanitize($dados['nome']),
            ':cpf' => sanitize($dados['cpf']),
            ':email' => sanitize($dados['email'] ?? null),
            ':telefone' => sanitize($dados['telefone'] ?? null),
            ':data_nascimento' => sanitize($dados['data_nascimento'] ?? null),
            ':endereco' => sanitize($dados['endereco'] ?? null)
        ]);
        
    } catch (PDOException $e) {
        error_log("Erro ao cadastrar paciente: " . $e->getMessage());
        return false;
    }
}

/**
 * Formata CPF para exibição
 */
function format_cpf($cpf) {
    if (empty($cpf)) return '';
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    return substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2);
}

/**
 * Formata telefone para exibição
 */
function format_telefone($telefone) {
    if (empty($telefone)) return '';
    $telefone = preg_replace('/[^0-9]/', '', $telefone);
    
    if (strlen($telefone) === 11) {
        return '(' . substr($telefone, 0, 2) . ') ' . substr($telefone, 2, 5) . '-' . substr($telefone, 7);
    }
    
    return $telefone;
}