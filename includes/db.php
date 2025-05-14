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

//     Cria um objeto PDO para conectar ao banco de dados.
// "mysql:host=$host;dbname=$dbname;charset=utf8mb4": Define o tipo de banco de dados (MySQL), o host, 
// o nome do banco e o charset (UTF-8 recomendado para compatibilidade de caracteres especiais).
// Opções adicionais:
// PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION: Define que erros do banco serão tratados como exceções, facilitando o debug.
// PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC: Retorna dados como arrays associativos, sem índices numéricos.
// PDO::ATTR_EMULATE_PREPARES => false: Desativa a emulação de consultas preparadas, garantindo maior segurança 
// contra SQL Injection.
    
    // Testa a conexão
    $pdo->query("SELECT 1");
    // Executa um teste básico (SELECT 1) para verificar se a conexão foi estabelecida corretamente.
    // Se houver erro, o código passará para o bloco catch.
    
} catch (PDOException $e) {
    // Log do erro (para produção)
    error_log("Erro de conexão com o banco: " . $e->getMessage());

    // Captura erros de conexão usando um bloco try-catch.
    // Registra o erro no log (error_log()), útil para monitoramento em produção.
    // Exibe uma mensagem amigável para o usuário, sem revelar detalhes sensíveis.


    
    // Mensagem amigável (para desenvolvimento)
    die("Não foi possível conectar ao banco de dados. Por favor, tente novamente mais tarde.");
}
?>