<?php
require_once __DIR__ . '/config.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Clínica Médica</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/style.css">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden; /* Remove a barra de rolagem */
        }
        
        .wrapper {
            display: flex;
            flex-direction: column;
            height: 100vh; /* 100% da altura da viewport */
        }
        
        .main-content {
            flex: 1;
            overflow-y: auto; /* Permite rolagem apenas no conteúdo principal se necessário */
        }
        
        .navbar {
            flex-shrink: 0;
        }
        
        .footer {
            flex-shrink: 0;
            width: 100%;
        }
        
        /* Estilos da Navbar */
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }
        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .nav-link {
            font-weight: 500;
            margin: 0 5px;
        }
        .nav-link:hover {
            color: #2a9d8f !important;
        }

        
    </style>
</head>
<body>
<div class="wrapper">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>">
                <i class="fas fa-hospital me-2" style="color: #2a9d8f;"></i>
                Clínica Saúde Total
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>">
                            <i class="fas fa-home me-1"></i> Início
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>/pacientes/listar.php">
                            <i class="fas fa-user-injured me-1"></i> Pacientes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-calendar-alt me-1"></i> Agendamentos
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    