<?php
require_once __DIR__ . '/includes/header.php';
?>
<link rel="stylesheet" href="../css/style.css">

<style>
    .hero-section {
        background: 
            linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
            url('<?php echo BASE_URL; ?>/assets/img/3.jpg') no-repeat center center/cover;
        height: 90vh;
        display: flex;
        align-items: center;
        color: white;
        text-align: center;
        position: relative;
        margin: 0;
    }
    
    .hero-content {
        width: 100%;
        padding: 0 15px;
        z-index: 1;
    }
    
    .hero-title {
        font-size: 3.5rem;
        font-weight: 700;
        margin-bottom: 20px;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }
    
    .hero-subtitle {
        font-size: 1.5rem;
        margin-bottom: 30px;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
    }
    
    .action-buttons .btn {
        margin: 10px;
        padding: 12px 30px;
        font-size: 1.1rem;
        border-radius: 50px;
        transition: all 0.3s ease;
    }
    
    .btn-primary {
        background-color: #2a9d8f;
        border-color: #2a9d8f;
    }
    
    .btn-primary:hover {
        background-color: #21867a;
        border-color: #21867a;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    }
    
    .features-section {
        padding: 80px 0;
        background-color: #f8f9fa;
    }
    
    .feature-icon {
        font-size: 3rem;
        color: #2a9d8f;
        margin-bottom: 20px;
    }
    
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
        }
        
        .hero-subtitle {
            font-size: 1.2rem;
        }
    }
</style>

<!-- Seção Hero com imagem de fundo -->
<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">Bem-vindo à Clínica Saúde Total</h1>
            <p class="hero-subtitle">Cuidando da sua saúde com excelência e comprometimento</p>
            <!-- <div class="action-buttons">
                <a href="<?php echo BASE_URL; ?>/pacientes/listar.php" class="btn btn-primary btn-lg">
                    <i class="fas fa-user-injured"></i> Gerenciar Pacientes
                </a>
                <a href="#" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-calendar-alt"></i> Agendar Consulta
                </a>
            </div> -->
        </div>
    </div>
</section>

<!-- Seção de Recursos -->
<section class="features-section">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4 mb-5">
                <div class="feature-icon">
                    <i class="fas fa-heartbeat"></i>
                </div>
                <h3>Atendimento Personalizado</h3>
                <p>Cuidamos de cada paciente com atenção individualizada e tratamentos específicos.</p>
            </div>
            <div class="col-md-4 mb-5">
                <div class="feature-icon">
                    <i class="fas fa-user-md"></i>
                </div>
                <h3>Corpo Clínico Qualificado</h3>
                <p>Profissionais especializados e com vasta experiência em suas áreas de atuação.</p>
            </div>
            <div class="col-md-4 mb-5">
                <div class="feature-icon">
                    <i class="fas fa-hospital"></i>
                </div>
                <h3>Infraestrutura Completa</h3>
                <p>Instalações modernas e equipamentos de última geração para melhor atendimento.</p>
            </div>
        </div>
    </div>
</section>

<?php
require_once __DIR__ . '/includes/footer.php';
?>