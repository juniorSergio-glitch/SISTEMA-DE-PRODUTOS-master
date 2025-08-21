<?php
ob_start();
?>

<div class="fade-in">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="mb-2"><i class="fas fa-plus text-primary"></i> Novo Produto</h1>
            <p class="text-muted mb-0">Adicione um novo produto ao seu inventário</p>
        </div>
        <a href="/" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar à Lista
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-lg">
            <div class="card-header bg-gradient text-white">
                <h5 class="mb-0"><i class="fas fa-info-circle"></i> Informações do Produto</h5>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="/produtos" id="produtoForm">
    
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="nome" class="form-label">
                                    <i class="fas fa-tag text-primary"></i> Nome do Produto *
                                </label>
                                <input type="text" class="form-control form-control-lg" id="nome" name="nome" 
                                       value="<?= old('nome') ?>" placeholder="Ex: Smartphone Samsung Galaxy" required maxlength="100">
                                <div class="invalid-feedback"></div>
                                <div class="form-text">Digite um nome descritivo para o produto</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="categoria" class="form-label">
                                    <i class="fas fa-folder text-primary"></i> Categoria *
                                </label>
                                <select class="form-select form-select-lg" id="categoria" name="categoria" required>
                                    <option value="">Selecione uma categoria</option>
                                    <option value="Eletrônicos" <?= old('categoria') === 'Eletrônicos' ? 'selected' : '' ?>>📱 Eletrônicos</option>
                                    <option value="Roupas" <?= old('categoria') === 'Roupas' ? 'selected' : '' ?>>👕 Roupas</option>
                                    <option value="Casa e Jardim" <?= old('categoria') === 'Casa e Jardim' ? 'selected' : '' ?>>🏠 Casa e Jardim</option>
                                    <option value="Esportes" <?= old('categoria') === 'Esportes' ? 'selected' : '' ?>>⚽ Esportes</option>
                                    <option value="Livros" <?= old('categoria') === 'Livros' ? 'selected' : '' ?>>📚 Livros</option>
                                    <option value="Beleza" <?= old('categoria') === 'Beleza' ? 'selected' : '' ?>>💄 Beleza</option>
                                    <option value="Alimentação" <?= old('categoria') === 'Alimentação' ? 'selected' : '' ?>>🍎 Alimentação</option>
                                    <option value="Outros" <?= old('categoria') === 'Outros' ? 'selected' : '' ?>>📦 Outros</option>
                                </select>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="descricao" class="form-label">
                            <i class="fas fa-align-left text-primary"></i> Descrição
                        </label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="4" 
                                  maxlength="500" placeholder="Descreva as características, especificações e benefícios do produto..."><?= old('descricao') ?></textarea>
                        <div class="form-text">Uma boa descrição ajuda na identificação e venda do produto</div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="preco" class="form-label">
                                    <i class="fas fa-dollar-sign text-success"></i> Preço (R$) *
                                </label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-success text-white">
                                        <i class="fas fa-dollar-sign"></i>
                                    </span>
                                    <input type="number" class="form-control" id="preco" name="preco" 
                                           value="<?= old('preco') ?>" step="0.01" min="0" max="999999.99" placeholder="0,00" required>
                                </div>
                                <div class="invalid-feedback"></div>
                                <div class="form-text">Preço de venda do produto</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="estoque" class="form-label">
                                    <i class="fas fa-warehouse text-info"></i> Quantidade em Estoque *
                                </label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-info text-white">
                                        <i class="fas fa-boxes"></i>
                                    </span>
                                    <input type="number" class="form-control" id="estoque" name="estoque" 
                                           value="<?= old('estoque') ?>" min="0" max="999999" placeholder="0" required>
                                    <span class="input-group-text">unidades</span>
                                </div>
                                <div class="invalid-feedback"></div>
                                <div class="form-text">Quantidade disponível para venda</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Preview do produto -->
                    <div class="card bg-light border-0 mb-4" id="productPreview" style="display: none;">
                        <div class="card-header bg-transparent">
                            <h6 class="mb-0"><i class="fas fa-eye text-primary"></i> Pré-visualização</h6>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h5 class="mb-1" id="previewNome">Nome do Produto</h5>
                                    <span class="badge bg-secondary mb-2" id="previewCategoria">Categoria</span>
                                    <p class="text-muted mb-0" id="previewDescricao">Descrição do produto...</p>
                                </div>
                                <div class="col-md-4 text-end">
                                    <div class="price fs-4 fw-bold" id="previewPreco">R$ 0,00</div>
                                    <div class="text-muted" id="previewEstoque">0 unidades</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end pt-3 border-top">
                        <a href="/" class="btn btn-secondary btn-lg me-md-2">
                            <i class="fas fa-times"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                            <i class="fas fa-save"></i> Salvar Produto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('produtoForm');
        const nomeInput = document.getElementById('nome');
        const categoriaSelect = document.getElementById('categoria');
        const descricaoTextarea = document.getElementById('descricao');
        const precoInput = document.getElementById('preco');
        const estoqueInput = document.getElementById('estoque');
        const preview = document.getElementById('productPreview');
        const submitBtn = document.getElementById('submitBtn');

        // Elementos de preview
        const previewNome = document.getElementById('previewNome');
        const previewCategoria = document.getElementById('previewCategoria');
        const previewDescricao = document.getElementById('previewDescricao');
        const previewPreco = document.getElementById('previewPreco');
        const previewEstoque = document.getElementById('previewEstoque');

        // Função para atualizar preview
        function updatePreview() {
            const nome = nomeInput.value.trim();
            const categoria = categoriaSelect.value;
            const descricao = descricaoTextarea.value.trim();
            const preco = parseFloat(precoInput.value) || 0;
            const estoque = parseInt(estoqueInput.value) || 0;

            if (nome || categoria || descricao || preco > 0 || estoque > 0) {
                preview.style.display = 'block';
                previewNome.textContent = nome || 'Nome do Produto';
                previewCategoria.textContent = categoria || 'Categoria';
                previewDescricao.textContent = descricao || 'Descrição do produto...';
                previewPreco.textContent = `R$ ${preco.toFixed(2).replace('.', ',')}`;
                previewEstoque.textContent = `${estoque} unidades`;
            } else {
                preview.style.display = 'none';
            }
        }

        // Validação em tempo real
        function validateField(field, condition, message) {
            if (condition) {
                field.classList.remove('is-invalid');
                field.classList.add('is-valid');
            } else {
                field.classList.remove('is-valid');
                field.classList.add('is-invalid');
                field.nextElementSibling.textContent = message;
            }
        }

        // Event listeners para preview
        nomeInput.addEventListener('input', updatePreview);
        categoriaSelect.addEventListener('change', updatePreview);
        descricaoTextarea.addEventListener('input', updatePreview);
        precoInput.addEventListener('input', updatePreview);
        estoqueInput.addEventListener('input', updatePreview);

        // Validação do nome
        nomeInput.addEventListener('blur', function() {
            validateField(this, this.value.trim().length >= 3, 'O nome deve ter pelo menos 3 caracteres');
        });

        // Validação da categoria
        categoriaSelect.addEventListener('change', function() {
            validateField(this, this.value !== '', 'Selecione uma categoria');
        });

        // Validação do preço
        precoInput.addEventListener('blur', function() {
            const value = parseFloat(this.value);
            validateField(this, value > 0, 'O preço deve ser maior que zero');
        });

        // Validação do estoque
        estoqueInput.addEventListener('blur', function() {
            const value = parseInt(this.value);
            validateField(this, value >= 0, 'O estoque não pode ser negativo');
        });

        // Formatação do preço
        precoInput.addEventListener('input', function() {
            let value = this.value;
            if (value && !isNaN(value)) {
                this.value = parseFloat(value).toFixed(2);
            }
        });

        // Validação do formulário
        form.addEventListener('submit', function(e) {
            let isValid = true;
            const fields = [nomeInput, categoriaSelect, precoInput, estoqueInput];
            
            fields.forEach(field => {
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('⚠️ Por favor, preencha todos os campos obrigatórios.');
                return;
            }

            // Animação do botão de submit
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Salvando...';
            submitBtn.disabled = true;
        });

        // Contador de caracteres para descrição
        descricaoTextarea.addEventListener('input', function() {
            const maxLength = 500;
            const currentLength = this.value.length;
            const remaining = maxLength - currentLength;
            
            let helpText = this.parentElement.querySelector('.form-text');
            if (remaining < 50) {
                helpText.innerHTML = `Uma boa descrição ajuda na identificação e venda do produto (${remaining} caracteres restantes)`;
                helpText.className = remaining < 20 ? 'form-text text-warning' : 'form-text text-info';
            } else {
                helpText.innerHTML = 'Uma boa descrição ajuda na identificação e venda do produto';
                helpText.className = 'form-text';
            }
        });

        // Animação de entrada
        setTimeout(() => {
            document.querySelector('.card').style.opacity = '0';
            document.querySelector('.card').style.transform = 'translateY(20px)';
            document.querySelector('.card').style.transition = 'all 0.5s ease';
            setTimeout(() => {
                document.querySelector('.card').style.opacity = '1';
                document.querySelector('.card').style.transform = 'translateY(0)';
            }, 100);
        }, 100);
    });
</script>

<script>
// Validação em tempo real
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const nomeInput = document.getElementById('nome');
    const precoInput = document.getElementById('preco');
    const estoqueInput = document.getElementById('estoque');
    
    // Validação do nome
    nomeInput.addEventListener('input', function() {
        if (this.value.length > 100) {
            this.setCustomValidity('Nome deve ter no máximo 100 caracteres');
        } else {
            this.setCustomValidity('');
        }
    });
    
    // Formatação do preço
    precoInput.addEventListener('blur', function() {
        if (this.value) {
            this.value = parseFloat(this.value).toFixed(2);
        }
    });
    
    // Validação do estoque
    estoqueInput.addEventListener('input', function() {
        if (this.value < 0) {
            this.setCustomValidity('Estoque não pode ser negativo');
        } else {
            this.setCustomValidity('');
        }
    });
    
    // Validação antes do envio
    form.addEventListener('submit', function(e) {
        if (!form.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        form.classList.add('was-validated');
    });
});
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layout.php';
?>