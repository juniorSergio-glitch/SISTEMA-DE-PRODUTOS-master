<?php
ob_start();
?>

<div class="fade-in">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="mb-2"><i class="fas fa-edit text-warning"></i> Editar Produto</h1>
            <p class="text-muted mb-0">Modifique as informações do produto</p>
        </div>
        <div class="btn-group">
            <a href="/produtos/<?= $produto['id'] ?>" class="btn btn-info">
                <i class="fas fa-eye"></i> Visualizar
            </a>
            <a href="/" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Voltar à Lista
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Formulário Principal -->
        <div class="card border-0 shadow-lg">
            <div class="card-header bg-gradient text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-edit"></i> Editar: <?= htmlspecialchars($produto['nome']) ?>
                    </h5>
                    <span class="badge bg-light text-dark">#<?= $produto['id'] ?></span>
                </div>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="/produtos/<?= $produto['id'] ?>/update" id="editForm">
                    <input type="hidden" name="_method" value="PUT">
                    
                    
                    <!-- Nome do Produto -->
                    <div class="form-floating mb-4">
                        <input type="text" class="form-control form-control-lg" id="nome" name="nome" 
                               value="<?= htmlspecialchars($produto['nome']) ?>" placeholder="Nome do produto" required maxlength="100">
                        <label for="nome">
                            <i class="fas fa-tag text-primary"></i> Nome do Produto *
                        </label>
                        <div class="invalid-feedback"></div>
                        <div class="form-text">
                            <i class="fas fa-info-circle"></i> Digite um nome claro e descritivo para o produto
                        </div>
                    </div>

                    <!-- Categoria -->
                    <div class="mb-4">
                        <label for="categoria" class="form-label fw-bold">
                            <i class="fas fa-folder text-primary"></i> Categoria *
                        </label>
                        <select class="form-select form-select-lg" id="categoria" name="categoria" required>
                            <option value="">Selecione uma categoria</option>
                            <option value="Eletrônicos" <?= $produto['categoria'] === 'Eletrônicos' ? 'selected' : '' ?>>
                                <i class="fas fa-laptop"></i> Eletrônicos
                            </option>
                            <option value="Roupas" <?= $produto['categoria'] === 'Roupas' ? 'selected' : '' ?>>
                                <i class="fas fa-tshirt"></i> Roupas
                            </option>
                            <option value="Casa" <?= $produto['categoria'] === 'Casa' ? 'selected' : '' ?>>
                                <i class="fas fa-home"></i> Casa
                            </option>
                            <option value="Esportes" <?= $produto['categoria'] === 'Esportes' ? 'selected' : '' ?>>
                                <i class="fas fa-dumbbell"></i> Esportes
                            </option>
                            <option value="Livros" <?= $produto['categoria'] === 'Livros' ? 'selected' : '' ?>>
                                <i class="fas fa-book"></i> Livros
                            </option>
                            <option value="Beleza" <?= $produto['categoria'] === 'Beleza' ? 'selected' : '' ?>>
                                <i class="fas fa-heart"></i> Beleza
                            </option>
                            <option value="Alimentação" <?= $produto['categoria'] === 'Alimentação' ? 'selected' : '' ?>>
                                <i class="fas fa-utensils"></i> Alimentação
                            </option>
                            <option value="Outros" <?= $produto['categoria'] === 'Outros' ? 'selected' : '' ?>>
                                <i class="fas fa-ellipsis-h"></i> Outros
                            </option>
                        </select>
                        <div class="invalid-feedback"></div>
                        <div class="form-text">
                            <i class="fas fa-info-circle"></i> Escolha a categoria que melhor descreve seu produto
                        </div>
                    </div>

                    <!-- Descrição -->
                    <div class="form-floating mb-4">
                        <textarea class="form-control" id="descricao" name="descricao" 
                                  style="height: 120px" placeholder="Descrição do produto" maxlength="500"><?= htmlspecialchars($produto['descricao']) ?></textarea>
                        <label for="descricao">
                            <i class="fas fa-align-left text-primary"></i> Descrição
                        </label>
                        <div class="form-text">
                            <i class="fas fa-info-circle"></i> Opcional - Descreva características importantes do produto (máximo 500 caracteres)
                            <span id="charCount" class="float-end text-muted">0/500</span>
                        </div>
                    </div>

                    <!-- Preço e Estoque -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating mb-4">
                                <input type="number" class="form-control form-control-lg" id="preco" name="preco" 
                                       value="<?= $produto['preco'] ?>" placeholder="0.00" step="0.01" min="0" max="999999.99" required>
                                <label for="preco">
                                    <i class="fas fa-dollar-sign text-success"></i> Preço (R$) *
                                </label>
                                <div class="invalid-feedback"></div>
                                <div class="form-text">
                                    <i class="fas fa-info-circle"></i> Digite o preço do produto
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating mb-4">
                                <input type="number" class="form-control form-control-lg" id="estoque" name="estoque" 
                                       value="<?= $produto['estoque'] ?>" placeholder="0" min="0" max="999999" required>
                                <label for="estoque">
                                    <i class="fas fa-warehouse text-info"></i> Quantidade em Estoque *
                                </label>
                                <div class="invalid-feedback"></div>
                                <div class="form-text">
                                    <i class="fas fa-info-circle"></i> Digite a quantidade disponível
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Botões de Ação -->
                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <div>
                            <a href="/produtos/<?= $produto['id'] ?>" class="btn btn-outline-secondary me-2">
                                <i class="fas fa-eye"></i> Visualizar
                            </a>
                            <a href="/" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                        </div>
                        <button type="submit" class="btn btn-warning btn-lg px-4" id="submitBtn">
                            <span class="spinner-border spinner-border-sm d-none" id="loadingSpinner"></span>
                            <i class="fas fa-save" id="saveIcon"></i> Atualizar Produto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Preview do Produto -->
        <div class="card border-0 shadow-lg mb-4">
            <div class="card-header bg-light">
                <h6 class="mb-0 text-center">
                    <i class="fas fa-eye text-primary"></i> Preview do Produto
                </h6>
            </div>
            <div class="card-body p-4">
                <div id="productPreview">
                    <div class="text-center mb-3">
                        <div class="product-icon mb-2">
                            <i class="fas fa-cube fa-3x text-primary" id="previewIcon"></i>
                        </div>
                        <h5 id="previewNome" class="text-primary"><?= htmlspecialchars($produto['nome']) ?></h5>
                        <span class="badge bg-secondary" id="previewCategoria"><?= htmlspecialchars($produto['categoria']) ?></span>
                    </div>
                    
                    <div class="preview-info">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Preço:</span>
                            <span class="price fw-bold text-success" id="previewPreco">R$ <?= number_format($produto['preco'], 2, ',', '.') ?></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Estoque:</span>
                            <span id="previewEstoque" class="fw-bold"><?= $produto['estoque'] ?> unidades</span>
                        </div>
                        <div class="mb-2">
                            <span class="text-muted">Descrição:</span>
                            <p class="mt-1 text-sm" id="previewDescricao">
                                <?= !empty($produto['descricao']) ? htmlspecialchars($produto['descricao']) : '<em class="text-muted">Nenhuma descrição</em>' ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informações Adicionais -->
        <div class="card border-0 shadow-lg">
            <div class="card-header bg-light">
                <h6 class="mb-0 text-center">
                    <i class="fas fa-info-circle text-info"></i> Informações
                </h6>
            </div>
            <div class="card-body p-4">
                <div class="info-item mb-3">
                    <small class="text-muted">ID do Produto:</small>
                    <div class="fw-bold">#<?= $produto['id'] ?></div>
                </div>
                <div class="info-item mb-3">
                    <small class="text-muted">Criado em:</small>
                    <div><?= date('d/m/Y H:i', strtotime($produto['created_at'])) ?></div>
                </div>
                <?php if (isset($produto['updated_at']) && $produto['updated_at'] !== $produto['created_at']): ?>
                <div class="info-item mb-3">
                    <small class="text-muted">Última atualização:</small>
                    <div><?= date('d/m/Y H:i', strtotime($produto['updated_at'])) ?></div>
                </div>
                <?php endif; ?>
                <div class="info-item">
                    <small class="text-muted">Valor total em estoque:</small>
                    <div class="price fw-bold text-success" id="previewValorTotal">
                        R$ <?= number_format($produto['preco'] * $produto['estoque'], 2, ',', '.') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Validação em tempo real e preview
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('editForm');
    const nomeInput = document.getElementById('nome');
    const categoriaInput = document.getElementById('categoria');
    const descricaoInput = document.getElementById('descricao');
    const precoInput = document.getElementById('preco');
    const estoqueInput = document.getElementById('estoque');
    const submitBtn = document.getElementById('submitBtn');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const saveIcon = document.getElementById('saveIcon');
    
    // Preview elements
    const previewNome = document.getElementById('previewNome');
    const previewCategoria = document.getElementById('previewCategoria');
    const previewDescricao = document.getElementById('previewDescricao');
    const previewPreco = document.getElementById('previewPreco');
    const previewEstoque = document.getElementById('previewEstoque');
    const previewValorTotal = document.getElementById('previewValorTotal');
    const previewIcon = document.getElementById('previewIcon');
    const charCount = document.getElementById('charCount');
    
    // Ícones por categoria
    const categoryIcons = {
        'Eletrônicos': 'fas fa-laptop',
        'Roupas': 'fas fa-tshirt',
        'Casa': 'fas fa-home',
        'Esportes': 'fas fa-dumbbell',
        'Livros': 'fas fa-book',
        'Outros': 'fas fa-cube'
    };
    
    // Atualizar preview em tempo real
    function updatePreview() {
        const nome = nomeInput.value || 'Nome do produto';
        const categoria = categoriaInput.value || 'Sem categoria';
        const descricao = descricaoInput.value || 'Nenhuma descrição';
        const preco = parseFloat(precoInput.value) || 0;
        const estoque = parseInt(estoqueInput.value) || 0;
        
        previewNome.textContent = nome;
        previewCategoria.textContent = categoria;
        previewDescricao.innerHTML = descricao === 'Nenhuma descrição' ? 
            '<em class="text-muted">Nenhuma descrição</em>' : descricao;
        previewPreco.textContent = 'R$ ' + preco.toLocaleString('pt-BR', {minimumFractionDigits: 2});
        previewEstoque.textContent = estoque + ' unidades';
        previewValorTotal.textContent = 'R$ ' + (preco * estoque).toLocaleString('pt-BR', {minimumFractionDigits: 2});
        
        // Atualizar ícone da categoria
        const iconClass = categoryIcons[categoria] || 'fas fa-cube';
        previewIcon.className = iconClass + ' fa-3x text-primary';
    }
    
    // Contador de caracteres
    function updateCharCount() {
        const count = descricaoInput.value.length;
        charCount.textContent = count + '/500';
        charCount.className = count > 450 ? 'float-end text-warning' : 
                             count > 500 ? 'float-end text-danger' : 'float-end text-muted';
    }
    
    // Event listeners para preview
    nomeInput.addEventListener('input', updatePreview);
    categoriaInput.addEventListener('change', updatePreview);
    descricaoInput.addEventListener('input', function() {
        updatePreview();
        updateCharCount();
    });
    precoInput.addEventListener('input', updatePreview);
    estoqueInput.addEventListener('input', updatePreview);
    
    // Validação do nome
    nomeInput.addEventListener('input', function() {
        if (this.value.length > 100) {
            this.setCustomValidity('Nome deve ter no máximo 100 caracteres');
            this.classList.add('is-invalid');
        } else {
            this.setCustomValidity('');
            this.classList.remove('is-invalid');
        }
    });
    
    // Validação da descrição
    descricaoInput.addEventListener('input', function() {
        if (this.value.length > 500) {
            this.setCustomValidity('Descrição deve ter no máximo 500 caracteres');
            this.classList.add('is-invalid');
        } else {
            this.setCustomValidity('');
            this.classList.remove('is-invalid');
        }
    });
    
    // Formatação do preço
    precoInput.addEventListener('blur', function() {
        if (this.value) {
            this.value = parseFloat(this.value).toFixed(2);
            updatePreview();
        }
    });
    
    // Validação do estoque
    estoqueInput.addEventListener('input', function() {
        if (this.value < 0) {
            this.setCustomValidity('Estoque não pode ser negativo');
            this.classList.add('is-invalid');
        } else {
            this.setCustomValidity('');
            this.classList.remove('is-invalid');
        }
    });
    
    // Validação antes do envio
    form.addEventListener('submit', function(e) {
        if (!form.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        } else {
            // Mostrar loading
            submitBtn.disabled = true;
            loadingSpinner.classList.remove('d-none');
            saveIcon.classList.add('d-none');
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Atualizando...';
        }
        form.classList.add('was-validated');
    });
    
    // Inicializar preview e contador
    updatePreview();
    updateCharCount();
    
    // Animação de fade-in
    document.querySelector('.fade-in').style.opacity = '0';
    setTimeout(() => {
        document.querySelector('.fade-in').style.transition = 'opacity 0.5s ease-in';
        document.querySelector('.fade-in').style.opacity = '1';
    }, 100);
});
</script>

<style>
.fade-in {
    animation: fadeIn 0.5s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.bg-gradient {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.form-floating > label {
    padding-left: 1rem;
}

.preview-info {
    font-size: 0.9rem;
}

.info-item {
    padding: 0.5rem 0;
    border-bottom: 1px solid #f0f0f0;
}

.info-item:last-child {
    border-bottom: none;
}

.product-icon {
    padding: 1rem;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 50%;
    display: inline-block;
}

.price {
    font-size: 1.1rem;
}

.btn-group .btn {
    border-radius: 0.375rem;
    margin-left: 0.25rem;
}

.shadow-lg {
    box-shadow: 0 1rem 3rem rgba(0, 0, 0, 0.175) !important;
}
</style>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>