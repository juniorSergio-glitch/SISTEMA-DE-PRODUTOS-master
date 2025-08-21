# 🚀 Como Iniciar o Sistema de Produtos

Este sistema foi configurado para ser **totalmente portátil** e **não requer instalação prévia do PHP**.

## 📋 Pré-requisitos

- **Navegador web** (Chrome, Firefox, Edge, etc.)
- **Windows** (para os scripts .bat e .ps1)

O PHP já está incluído no projeto!

## 🎯 Opções de Inicialização

### Opção 1: Script Batch (Recomendado para iniciantes)

```bash
# Clique duplo no arquivo ou execute no terminal:
start.bat
```

**Características:**
- ✅ Simples e direto
- ✅ Funciona em qualquer Windows
- ✅ Abre automaticamente o navegador
- ✅ Mostra logs do servidor

### Opção 2: Script PowerShell (Recomendado para usuários avançados)

```powershell
# Execute no PowerShell:
.\start.ps1
```

**Características:**
- ✅ Interface mais elegante com cores
- ✅ Verificações de sistema automáticas
- ✅ Detecção de conflitos de porta
- ✅ Tratamento de erros avançado
- ✅ Logs detalhados

### Opção 3: Manual (Para desenvolvedores)

```bash
# No terminal, dentro da pasta do projeto:
php\php.exe -S localhost:8000

# Em seguida, abra o navegador em:
# http://localhost:8000
```

## 🌐 Acessando o Sistema

Após executar qualquer um dos scripts, o sistema estará disponível em:

**🔗 http://localhost:8000**

O navegador será aberto automaticamente (exceto na opção manual).

## 🛑 Como Parar o Servidor

- Pressione **Ctrl + C** no terminal onde o servidor está rodando
- Ou feche a janela do terminal

## 🔧 Solução de Problemas

### Erro: "PHP portátil não encontrado"

1. Verifique se a pasta `php` existe no diretório do projeto.
2. Se não existir, pode ser necessário baixar o projeto novamente.

### Erro: "Porta 8000 em uso"

1. Verifique processos usando a porta:
   ```bash
   netstat -ano | findstr :8000
   ```

2. Finalize o processo ou use outra porta:
   ```bash
   php\php.exe -S localhost:8001
   ```

### Navegador não abre automaticamente

- Abra manualmente: http://localhost:8000
- Verifique se há bloqueadores de pop-up

## 📁 Estrutura do Projeto

```
sistema-produtos/
├── php/                 # PHP portátil (não requer instalação)
├── start.bat          # Script de inicialização (Batch)
├── start.ps1          # Script de inicialização (PowerShell)
├── INICIAR.md         # Este arquivo de instruções
├── index.php          # Arquivo principal
├── routes/web.php     # Rotas do sistema
├── app/Http/Controllers/ # Controladores
├── resources/views/   # Templates das páginas
└── storage/produtos.json # Banco de dados (JSON)
```

## 🎨 Funcionalidades do Sistema

- ✅ **CRUD Completo** - Criar, visualizar, editar e excluir produtos
- ✅ **Interface Moderna** - Design profissional e responsivo
- ✅ **Busca em Tempo Real** - Filtros dinâmicos
- ✅ **Validação Avançada** - Cliente e servidor
- ✅ **Gestão de Estoque** - Alertas e indicadores visuais
- ✅ **Categorização** - Organização por categorias
- ✅ **Estatísticas** - Dashboard com métricas

## 📞 Suporte

Se encontrar problemas:

1. Verifique os pré-requisitos
2. Consulte a seção de solução de problemas
3. Verifique os logs no terminal
4. Reinicie o sistema

---

**💡 Dica:** Para desenvolvimento, recomendamos usar o script PowerShell por suas funcionalidades avançadas de diagnóstico.

**🎯 Objetivo:** Este sistema foi desenvolvido para ser simples, eficiente e profissional. Aproveite! 🚀