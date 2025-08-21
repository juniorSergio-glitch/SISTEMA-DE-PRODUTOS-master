<?php
ob_start();
?>

<div class="fade-in">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="mb-2"><i class="fas fa-eye text-primary"></i> Detalhes do Produto</h1>
            <p class="text-muted mb-0">Visualize todas as informações do produto</p>
        </div>
        <div class="btn-group">
            <a href="/produtos/<?= $produto['id'] ?>/edit" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="/" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Voltar à Lista
            </a>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <!-- Card Principal do Produto -->
        <div class="card border-0 shadow-lg mb-4">
            <div class="card-header bg-gradient text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-cube"></i> <?= htmlspecialchars($produto['nome']) ?>
                    </h5>
                    <span class="badge bg-light text-dark">#<?= htmlspecialchars($produto['id']) ?></span>
                </div>
            </div>
            <div class="card-body p-4">
                <!-- Informações Principais -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="info-item mb-3">
                            <label class="info-label">
                                <i class="fas fa-tag text-primary"></i> Categoria
                            </label>
                            <div class="info-value">
                                <span class="badge bg-secondary fs-6 px-3 py-2">
                                    <i class="fas fa-folder"></i> <?= htmlspecialchars($produto['categoria']) ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-item mb-3">
                            <label class="info-label">
                                <i class="fas fa-dollar-sign text-success"></i> Preço
                            </label>
                            <div class="info-value">
                                <span class="price fs-2 fw-bold text-success">
                                    R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Descrição -->
                <div class="info-item mb-4">
                    <label class="info-label">
                        <i class="fas fa-align-left text-primary"></i> Descrição
                    </label>
                    <div class="info-value">
                        <div class="description-box p-3 bg-light rounded">
                            <?= !empty($produto['descricao']) ? nl2br(htmlspecialchars($produto['descricao'])) : '<em class="text-muted">Nenhuma descrição fornecida</em>' ?>
                        </div>
                    </div>
                </div>

                <!-- Estoque com Barra de Progresso -->
                <div class="info-item mb-4">
                    <label class="info-label">
                        <i class="fas fa-warehouse text-info"></i> Estoque
                    </label>
                    <div class="info-value">
                        <div class="d-flex align-items-center mb-2">
                            <span class="<?= $produto['estoque'] <= 5 ? 'stock-low' : ($produto['estoque'] <= 20 ? 'stock-medium' : 'stock-high') ?> fw-bold fs-4 me-3">
                                <?= $produto['estoque'] ?> unidades
                            </span>
                            <div class="flex-grow-1">
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar <?= $produto['estoque'] <= 5 ? 'bg-danger' : ($produto['estoque'] <= 20 ? 'bg-warning' : 'bg-success') ?>" 
                                         style="width: <?= min(100, ($produto['estoque'] / 100) * 100) ?>%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="stock-status">
                            <?php if ($produto['estoque'] > 20): ?>
                                <span class="badge bg-success">
                                    <i class="fas fa-check-circle"></i> Estoque adequado
                                </span>
                            <?php elseif ($produto['estoque'] > 5): ?>
                                <span class="badge bg-warning">
                                    <i class="fas fa-exclamation-triangle"></i> Estoque baixo - considere repor
                                </span>
                            <?php else: ?>
                                <span class="badge bg-danger">
                                    <i class="fas fa-times-circle"></i> Estoque crítico - reposição urgente
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Datas -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="info-label">
                                <i class="fas fa-calendar-plus text-info"></i> Criado em
                            </label>
                            <div class="info-value text-muted">
                                <?= date('d/m/Y H:i', strtotime($produto['created_at'])) ?>
                            </div>
                        </div>
                    </div>
                    <?php if (isset($produto['updated_at']) && $produto['updated_at'] !== $produto['created_at']): ?>
                    <div class="col-md-6">
                        <div class="info-item">
                            <label class="info-label">
                                <i class="fas fa-calendar-edit text-warning"></i> Última atualização
                            </label>
                            <div class="info-value text-muted">
                                <?= date('d/m/Y H:i', strtotime($produto['updated_at'])) ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Card de Status -->
        <div class="card border-0 shadow-lg mb-4">
            <div class="card-header bg-gradient text-white">
                <h5 class="mb-0">
                    <i class="fas fa-chart-line"></i> Status do Produto
                </h5>
            </div>
            <div class="card-body text-center p-4">
                <?php if ($produto['estoque'] > 20): ?>
                    <div class="status-icon text-success mb-3">
                        <i class="fas fa-check-circle fa-4x"></i>
                    </div>
                    <h5 class="text-success">Estoque Adequado</h5>
                    <p class="text-muted">Produto com boa disponibilidade no estoque</p>
                <?php elseif ($produto['estoque'] > 5): ?>
                    <div class="status-icon text-warning mb-3">
                        <i class="fas fa-exclamation-triangle fa-4x"></i>
                    </div>
                    <h5 class="text-warning">Estoque Baixo</h5>
                    <p class="text-muted">Considere fazer reposição em breve</p>
                <?php else: ?>
                    <div class="status-icon text-danger mb-3">
                        <i class="fas fa-times-circle fa-4x"></i>
                    </div>
                    <h5 class="text-danger">Estoque Crítico</h5>
                    <p class="text-muted">Reposição urgente necessária</p>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Card de Valor -->
        <div class="card border-0 shadow-lg mb-4">
            <div class="card-body text-center p-4">
                <div class="stats-icon mb-3">
                    <i class="fas fa-calculator fa-3x text-primary"></i>
                </div>
                <h6 class="text-muted mb-2">Valor Total em Estoque</h6>
                <div class="price fs-3 fw-bold text-success">
                    R$ <?= number_format($produto['preco'] * $produto['estoque'], 2, ',', '.') ?>
                </div>
                <small class="text-muted">
                    <?= $produto['estoque'] ?> × R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
                </small>
            </div>
        </div>
        
        <!-- Card de Ações -->
        <div class="card border-0 shadow-lg">
            <div class="card-header bg-light">
                <h6 class="mb-0 text-center">
                    <i class="fas fa-cogs text-primary"></i> Ações Disponíveis
                </h6>
            </div>
            <div class="card-body p-3">
                <div class="d-grid gap-2">
                    <a href="/produtos/<?= $produto['id'] ?>/edit" class="btn btn-warning btn-lg">
                        <i class="fas fa-edit"></i> Editar Produto
                    </a>
                    <button type="button" class="btn btn-danger btn-lg" onclick="confirmDelete()">
                        <i class="fas fa-trash"></i> Excluir Produto
                    </button>
                    <a href="/" class="btn btn-secondary btn-lg">
                        <i class="fas fa-list"></i> Todos os Produtos
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

        
        <!-- Alertas de estoque -->
        <?php if ($produto['estoque'] <= 5 && $produto['estoque'] > 0): ?>
        <div class="alert alert-warning mt-3">
            <i class="fas fa-exclamation-triangle"></i>
            <strong>Atenção!</strong> Este produto está com estoque baixo (<?= $produto['estoque'] ?> unidades).
        </div>
        <?php elseif ($produto['estoque'] == 0): ?>
        <div class="alert alert-danger mt-3">
            <i class="fas fa-times-circle"></i>
            <strong>Produto Esgotado!</strong> Este produto não está disponível no momento.
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal de Confirmação de Exclusão -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle"></i> Confirmar Exclusão
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-4">
                <i class="fas fa-trash fa-4x text-danger mb-3"></i>
                <h5>Tem certeza que deseja excluir este produto?</h5>
                <p class="text-muted mb-4">
                    <strong><?= htmlspecialchars($produto['nome']) ?></strong><br>
                    Esta ação não pode ser desfeita.
                </p>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Cancelar
                </button>
                <form method="POST" action="/produtos/<?= $produto['id'] ?>/delete" style="display: inline;">
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Sim, Excluir
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.info-label {
    font-weight: 600;
    color: #374151;
    font-size: 0.9rem;
    margin-bottom: 0.5rem;
    display: block;
}

.info-value {
    font-size: 1rem;
    color: #1f2937;
}

.info-item {
    margin-bottom: 1.5rem;
}

.description-box {
    min-height: 60px;
    border: 1px solid #e5e7eb;
}

.status-icon {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.stats-icon {
    opacity: 0.8;
}
</style>

<script>
function confirmDelete() {
    const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
    modal.show();
}

// Animação de entrada
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        setTimeout(() => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.5s ease';
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 50);
        }, index * 100);
    });
});
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>