<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/functions.php';

if (!isset($pdo)) {
    die('<div class="alert alert-danger">Erro: Conexão com o banco de dados não estabelecida</div>');
    // Executa uma consulta SQL (SELECT * FROM pacientes ORDER BY nome) para buscar todos os pacientes organizados pelo nome.
    // Se houver erro na consulta, ele exibe uma mensagem de erro usando PDOException.
}


// Mensagens do sistema
if (isset($_SESSION['mensagem'])): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: '<?= $_SESSION['tipo_mensagem'] ?>',
        title: '<?= $_SESSION['tipo_mensagem'] === 'success' ? 'Sucesso!' : 'Erro!' ?>',
        text: '<?= $_SESSION['mensagem'] ?>',
        confirmButtonColor: '#21867a'
    });
});
</script>
<?php
    unset($_SESSION['mensagem']);
    unset($_SESSION['tipo_mensagem']);
endif;



// Consulta pacientes
try {
    $stmt = $pdo->query("SELECT * FROM pacientes ORDER BY nome");
    $pacientes = $stmt->fetchAll(PDO::FETCH_ASSOC);  
} catch (PDOException $e) {
    die('<div class="alert alert-danger">Erro ao buscar pacientes: ' . $e->getMessage() . '</div>');
}

// $stmt:  é um objeto PDOStatement, que contém o resultado da consulta SQL.
// fetchAll(PDO::FETCH_ASSOC):  recupera todas as linhas retornadas pela consulta e as 
// transforma em um array associativo.
// PDO::FETCH_ASSOC faz com que cada linha seja retornada como um array onde as chaves 
// correspondem aos nomes das colunas do banco de dados.
// catch (PDOException $e): Captura erros na execução da consulta SQL.
// Se houver um erro, o código dentro do catch será executado, evitando que o script quebre completamente.
?>

<style>
.content-wrapper {
    min-height: calc(100vh - 150px);
    display: flex;
    flex-direction: column;
}

.footer {
    margin-top: auto;
}

.card-pacientes {
    border: none;
    border-radius: 10px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

.table-header {
    background: linear-gradient(135deg, #2a9d8f, #21867a);
    color: white;
}

.table-title {
    background: linear-gradient(135deg, #2a9d8f, #21867a);
    color: white;
    font-size: 1.25rem;
    padding: 1rem;
}

.btn-cadastrar {
    background: linear-gradient(135deg, #2a9d8f, #21867a);
    border: none;
    padding: 10px 25px;
    font-weight: 500;
    transition: all 0.3s;
}

.btn-cadastrar:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(42, 157, 143, 0.3);
}

.table-hover tbody tr:hover {
    background-color: rgba(42, 157, 143, 0.05);
}

.empty-state {
    padding: 40px 20px;
    text-align: center;
    color: #6c757d;
}

.empty-state-icon {
    font-size: 5rem;
    color: rgb(5, 58, 111);
    margin-bottom: 20px;
}

.icon-custom {
    font-size: 24px;
    vertical-align: middle;
}
</style>

<!-- Modal de cadastrar novos pacientes -->
<div class="modal fade" id="cadastrarPacienteModal" tabindex="-1" aria-labelledby="cadastrarPacienteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content"
            style="border: none; border-radius: 10px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);">
            <div class="modal-header"
                style="background: linear-gradient(135deg, #2a9d8f, #21867a); color: white; border-radius: 9px 9px 0 0;">
                <h5 class="modal-title" id="cadastrarPacienteModalLabel">
                    <i class="fas fa-user-plus me-2"></i> Cadastrar Novo Paciente
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form method="POST" action="<?= BASE_URL ?>/pacientes/cadastrar.php">
                <!-- Define um formulário HTML que envia dados via método POST.
                 Quando ele clica em "Enviar", os dados são transmitidos ao servidor via POST.
                 O servidor processa os dados e pode armazená-los em um banco de dados ou executar ações específicas.
                 O atributo action indica para onde os dados serão enviados: cadastrar.php, localizado no diretório pacientes/. -->
                <div class="modal-body" style="padding: 25px;">
                    <?php if (isset($erro)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($erro, ENT_QUOTES, 'UTF-8') ?></div>
                    <?php endif; ?>

                    <div class="mb-3">
                        <label for="nome" class="form-label fw-medium">Nome Completo</label>
                        <input type="text" class="form-control" id="nome" name="nome" required
                            style="border-radius: 8px; padding: 10px; border: 1px solid #e0e0e0;">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cpf" class="form-label fw-medium">CPF</label>
                            <input type="text" class="form-control" id="cpf" name="cpf" required
                                style="border-radius: 8px; padding: 10px; border: 1px solid #e0e0e0;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="data_nascimento" class="form-label fw-medium">Data de Nascimento</label>
                            <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required
                                style="border-radius: 8px; padding: 10px; border: 1px solid #e0e0e0;">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label fw-medium">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email"
                                style="border-radius: 8px; padding: 10px; border: 1px solid #e0e0e0;">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="telefone" class="form-label fw-medium">Telefone</label>
                            <input type="text" class="form-control" id="telefone" name="telefone"
                                style="border-radius: 8px; padding: 10px; border: 1px solid #e0e0e0;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="endereco" class="form-label fw-medium">Endereço</label>
                        <textarea class="form-control" id="endereco" name="endereco" rows="3"
                            style="border-radius: 8px; padding: 10px; border: 1px solid #e0e0e0;"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: none; padding: 20px 25px 25px;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        style="border-radius: 8px; padding: 8px 20px; border: none;">Cancelar</button>
                    <button type="submit" class="btn btn-cadastrar text-white"
                        style="border-radius: 8px; padding: 8px 20px; background: linear-gradient(135deg, #2a9d8f, #21867a); border: none;">
                        <i class="fas fa-save me-2"></i> Cadastrar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="container py-5">
    <div class="d-flex justify-content-end mb-4">
        <a href="#" class="btn btn-cadastrar text-white" data-bs-toggle="modal"
            data-bs-target="#cadastrarPacienteModal">
            <i class="fas fa-plus-circle me-2"></i> Novo Paciente
        </a>
    </div>

    <div class="card card-pacientes">
        <?php if (empty($pacientes)): ?>
        <!-- empty($pacientes) verifica se a variável $pacientes está vazia.
            Se não houver pacientes cadastrados, o bloco "Nenhum paciente cadastrado" será exibido. -->
        <div class="empty-state">
            <i class="fas fa-user-slash empty-state-icon"></i>
            <!-- Usa o ícone fas fa-user-slash para simbolizar a ausência de pacientes.
                O texto informa que ainda não há registros no sistema. -->
            <h4 class="mb-3">Nenhum paciente cadastrado</h4>
            <p class="text-muted mb-4">Você ainda não possui pacientes cadastrados em seu sistema.</p>
            <a href="<?= BASE_URL ?>/pacientes/cadastrar.php" class="btn btn-cadastrar text-white">
                <!-- O link leva o usuário para a página de cadastro. -->
                <i class="fas fa-plus-circle me-2"></i> Cadastrar Primeiro Paciente
            </a>
        </div>
        <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr class="table-title">
                        <th colspan="5" class="text-center">
                            <i class="fas fa-user-injured me-2"></i>
                            Pacientes Cadastrados
                        </th>
                    </tr>
                    <tr class="table-header">
                        <th class="text-black">ID</th>
                        <th class="text-black">Nome</th>
                        <th class="text-black">CPF</th>
                        <th class="text-black">Telefone</th>
                        <th class="text-black text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pacientes as $paciente): ?>
                        <!-- O código percorre todos os pacientes armazenados na variável $pacientes, gerando uma linha para cada um.
                        Cada $paciente representa um registro individual de paciente. -->
                    <tr>
                        <td><?= str_pad($paciente['id'], 2, '0', STR_PAD_LEFT) ?></td>
                        <!-- str_pad() adiciona zeros à esquerda, garantindo que o ID tenha ao menos 2 dígitos (exemplo: 01, 02). -->
                        <td>
                            <div class="d-flex align-items-center">
                                <div
                                    class="avatar-sm bg-light rounded-circle me-3 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-user text-muted"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0"><?= htmlspecialchars($paciente['nome']) ?></h6>
                                    <small
                                        class="text-muted"><?= htmlspecialchars($paciente['email'] ?? 'N/A') ?></small>
                                </div>
                            </div>
                        </td>
                        <td><?= htmlspecialchars($paciente['cpf']) ?></td>
                        <td><?= htmlspecialchars($paciente['telefone']) ?></td>
                        <!-- O código exibe o CPF e o telefone do paciente, garantindo que os dados sejam mostrados de 
                         forma segura com htmlspecialchars() (evita ataques XSS). -->
                        <td class="text-end">
                            <div class="d-flex justify-content-end">
                                <a href="<?= BASE_URL ?>/pacientes/editar.php?id=<?= $paciente['id'] ?>"
                                    class="btn btn-sm btn-outline-primary me-2" data-bs-toggle="tooltip" title="Editar">
                                    <i class="fas fa-edit"></i>
                                      <!-- href="<?= BASE_URL ?>/pacientes/editar.php?id=<?= $paciente['id'] ?>" direciona o usuário para a página de edição do paciente específico.
                                      O ícone fa-edit indica visualmente que o botão é para edição. -->
                                </a>
                                
                                <a href="#" class="btn btn-sm btn-outline-danger btn-excluir-paciente"
                                    data-id="<?= $paciente['id'] ?>"
                                    data-nome="<?= htmlspecialchars($paciente['nome']) ?>" data-bs-toggle="tooltip"
                                    title="Excluir">
                                    <i class="fas fa-trash-alt"></i>
                                </a>
                                <!-- <a href="<?= BASE_URL ?>/pacientes/excluir.php?id=<?= $paciente['id'] ?>" 
                                       class="btn btn-sm btn-outline-danger"
                                       onclick="return confirm('Tem certeza que deseja excluir este paciente?')"
                                       data-bs-toggle="tooltip" title="Excluir">
                                        <i class="fas fa-trash-alt"></i>
                                    </a> -->

                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <!-- foreach percorre todos os elementos do array $pacientes, criando uma linha para cada paciente.
                    endforeach; é a forma alternativa de encerrar o loop sem usar {} (mais comum em estruturas que envolvem HTML misturado com PHP). -->
                </tbody>
            </table>
        </div>
        <?php endif; ?>
        <!-- Essa linha encerra a estrutura condicional que verificava se havia pacientes cadastrados. -->
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

<!-- O evento DOMContentLoaded garante que o código só será executado depois que o HTML da página estiver 
 totalmente carregado. -->
 <!-- querySelectorAll('.btn-excluir-paciente') seleciona todos os botões que têm a classe .btn-excluir-paciente.
 forEach(function(btn) {...}) percorre cada um desses botões e adiciona um evento de clique. -->
 <!-- addEventListener('click', function(e) {...}) escuta quando o usuário clica no botão.
  e.preventDefault() evita que o link seja acionado diretamente, permitindo que o sistema primeiro confirme a ação.
  Se o usuário confirmar (result.isConfirmed), a página é redirecionada para excluir.php, onde o paciente será removido do banco de dados. -->

<script>   
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-excluir-paciente').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();

            const pacienteId = this.getAttribute('data-id');
            const nome = this.getAttribute('data-nome');

            Swal.fire({
                title: 'Tem certeza?',
                text: `Deseja excluir o paciente "${nome}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href =
                        `<?= BASE_URL ?>/pacientes/excluir.php?id=${pacienteId}`;
                }
            });
        });
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>