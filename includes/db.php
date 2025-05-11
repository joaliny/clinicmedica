<?php
require_once __DIR__ . '/config.php';

// Configurações do banco de dados
$host = 'localhost';
$dbname = 'parcial';
$username = 'root';
$password = '';

try {
    // Estabelece a conexão PDO
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4", 
        $username, 
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]
    );
    
    // Testa a conexão
    $pdo->query("SELECT 1");
    
} catch (PDOException $e) {
    // Log do erro (para produção)
    error_log("Erro de conexão com o banco: " . $e->getMessage());
    
    // Mensagem amigável (para desenvolvimento)
    die("Não foi possível conectar ao banco de dados. Por favor, tente novamente mais tarde.");
}
?>