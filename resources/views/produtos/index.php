<?php
ob_start();
?>

<div class="fade-in">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="mb-2"><i class="fas fa-box text-primary"></i> Gestão de Produtos</h1>
            <p class="text-muted mb-0">Gerencie seu inventário de forma eficiente</p>
        </div>
        <a href="/produtos/create" class="btn btn-primary">
            <i class="fas fa-plus"></i> Novo Produto
        </a>
    </div>

    <!-- Estatísticas -->
    <div class="row mb-5">
        <div class="col-md-3 mb-3">
            <div class="stats-card">
                <div class="stats-number"><?= count($produtos) ?></div>
                <div class="stats-label"><i class="fas fa-boxes"></i> Total de Produtos</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #059669, #10b981);">
                <div class="stats-number"><?= array_sum(array_column($produtos, 'estoque')) ?></div>
                <div class="stats-label"><i class="fas fa-warehouse"></i> Itens em Estoque</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #d97706, #f59e0b);">
                <div class="stats-number"><?= count(array_unique(array_column($produtos, 'categoria'))) ?></div>
                <div class="stats-label"><i class="fas fa-tags"></i> Categorias</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="stats-card" style="background: linear-gradient(135deg, #dc2626, #ef4444);">
                <div class="stats-number"><?= count(array_filter($produtos, function($p) { return $p['estoque'] <= 10; })) ?></div>
                <div class="stats-label"><i class="fas fa-exclamation-triangle"></i> Estoque Baixo</div>
            </div>
        </div>
    </div>
</div>

<?php if (empty($produtos)): ?>
    <div class="card border-0 shadow-sm">
        <div class="card-body text-center py-5">
            <i class="fas fa-box-open fa-4x text-muted mb-4"></i>
            <h4 class="text-muted mb-3">Nenhum produto cadastrado</h4>
            <p class="text-muted mb-4">Comece adicionando seu primeiro produto ao sistema</p>
            <a href="/produtos/create" class="btn btn-primary btn-lg">
                <i class="fas fa-plus"></i> Cadastrar Primeiro Produto
            </a>
        </div>
    </div>
<?php else: ?>
    <!-- Filtros -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-end">
                <div class="col-md-4">
                    <label class="form-label">Buscar produtos</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" id="searchInput" placeholder="Digite o nome do produto...">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Categoria</label>
                    <select class="form-select" id="categoryFilter">
                        <option value="">Todas as categorias</option>
                        <?php 
                        $categorias = array_unique(array_column($produtos, 'categoria'));
                        foreach ($categorias as $categoria): 
                        ?>
                        <option value="<?= htmlspecialchars($categoria) ?>"><?= htmlspecialchars($categoria) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Status do Estoque</label>
                    <select class="form-select" id="stockFilter">
                        <option value="">Todos os status</option>
                        <option value="high">Em estoque</option>
                        <option value="medium">Estoque baixo</option>
                        <option value="low">Crítico</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-secondary w-100" onclick="clearFilters()">
                        <i class="fas fa-times"></i> Limpar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="productsGrid">
        <?php foreach ($produtos as $produto): ?>
            <div class="col-md-6 col-lg-4 mb-4 product-card" 
                 data-name="<?= strtolower(htmlspecialchars($produto['nome'])) ?>"
                 data-category="<?= htmlspecialchars($produto['categoria']) ?>"
                 data-stock="<?= $produto['estoque'] <= 5 ? 'low' : ($produto['estoque'] <= 20 ? 'medium' : 'high') ?>">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-cube text-primary"></i> <?= htmlspecialchars($produto['nome']) ?>
                            </h5>
                            <span class="badge bg-secondary">
                                <i class="fas fa-tag"></i> <?= htmlspecialchars($produto['categoria']) ?>
                            </span>
                        </div>
                        
                        <p class="card-text text-muted mb-3">
                            <?= htmlspecialchars($produto['descricao']) ?>
                        </p>
                        
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="price fs-4 fw-bold text-success">
                                    R$ <?= number_format($produto['preco'], 2, ',', '.') ?>
                                </span>
                                <div class="text-end">
                                    <div class="<?= $produto['estoque'] <= 5 ? 'stock-low' : ($produto['estoque'] <= 20 ? 'stock-medium' : 'stock-high') ?> fw-bold">
                                        <i class="fas fa-warehouse"></i> <?= $produto['estoque'] ?>
                                    </div>
                                    <small class="text-muted">unidades</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar <?= $produto['estoque'] <= 5 ? 'bg-danger' : ($produto['estoque'] <= 20 ? 'bg-warning' : 'bg-success') ?>" 
                                     style="width: <?= min(100, ($produto['estoque'] / 50) * 100) ?>%"></div>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <small class="text-muted">Estoque</small>
                                <small class="<?= $produto['estoque'] <= 5 ? 'text-danger' : ($produto['estoque'] <= 20 ? 'text-warning' : 'text-success') ?>">
                                    <?php if ($produto['estoque'] > 20): ?>
                                        <i class="fas fa-check-circle"></i> Em estoque
                                    <?php elseif ($produto['estoque'] > 5): ?>
                                        <i class="fas fa-exclamation-triangle"></i> Baixo
                                    <?php else: ?>
                                        <i class="fas fa-times-circle"></i> Crítico
                                    <?php endif; ?>
                                </small>
                            </div>
                        </div>
                        
                        <div class="text-muted small mb-3">
                            <i class="fas fa-calendar"></i> 
                            Criado em: <?= date('d/m/Y H:i', strtotime($produto['created_at'])) ?>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <div class="btn-group w-100" role="group">
                            <a href="/produtos/<?= $produto['id'] ?>" class="btn btn-outline-info btn-sm">
                                <i class="fas fa-eye"></i> Ver
                            </a>
                            <a href="/produtos/<?= $produto['id'] ?>/edit" class="btn btn-outline-warning btn-sm">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <form method="POST" action="/produtos/<?= $produto['id'] ?>/delete" class="d-inline" onsubmit="return confirmDelete(event)">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="fas fa-trash"></i> Excluir
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <script>
        // Filtros em tempo real
        document.getElementById('searchInput').addEventListener('input', filterProducts);
        document.getElementById('categoryFilter').addEventListener('change', filterProducts);
        document.getElementById('stockFilter').addEventListener('change', filterProducts);

        function filterProducts() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const categoryFilter = document.getElementById('categoryFilter').value;
            const stockFilter = document.getElementById('stockFilter').value;
            const cards = document.querySelectorAll('.product-card');

            cards.forEach(card => {
                const name = card.dataset.name;
                const category = card.dataset.category;
                const stock = card.dataset.stock;

                const matchesSearch = name.includes(searchTerm);
                const matchesCategory = !categoryFilter || category === categoryFilter;
                const matchesStock = !stockFilter || stock === stockFilter;

                if (matchesSearch && matchesCategory && matchesStock) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        function clearFilters() {
            document.getElementById('searchInput').value = '';
            document.getElementById('categoryFilter').value = '';
            document.getElementById('stockFilter').value = '';
            filterProducts();
        }

        function confirmDelete(event) {
            return confirm('⚠️ Tem certeza que deseja excluir este produto?\n\nEsta ação não pode ser desfeita.');
        }

        // Animação de entrada
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.product-card');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    card.style.transition = 'all 0.3s ease';
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 50);
                }, index * 50);
            });
        });
    </script>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="fas fa-chart-bar"></i> Estatísticas
                    </h5>
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="border-end">
                                <h3 class="text-primary"><?= count($produtos) ?></h3>
                                <p class="text-muted mb-0">Total de Produtos</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border-end">
                                <h3 class="text-success">
                                    R$ <?= number_format(array_sum(array_column($produtos, 'preco')), 2, ',', '.') ?>
                                </h3>
                                <p class="text-muted mb-0">Valor Total</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="border-end">
                                <h3 class="text-info"><?= array_sum(array_column($produtos, 'estoque')) ?></h3>
                                <p class="text-muted mb-0">Estoque Total</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <h3 class="text-warning">
                                <?= count(array_filter($produtos, function($p) { return $p['estoque'] <= 5; })) ?>
                            </h3>
                            <p class="text-muted mb-0">Estoque Baixo</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>