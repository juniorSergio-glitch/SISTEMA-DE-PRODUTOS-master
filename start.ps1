# Script de Inicializacao do Sistema de Produtos
# Autor: Sistema de Produtos
# Descricao: Inicia o servidor com PHP portatil e abre o navegador

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "   Sistema de Produtos - Inicializando" -ForegroundColor Yellow
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Verifica se o PHP portatil existe
if (-not (Test-Path -Path ".\php\php.exe")) {
    Write-Host "Erro: PHP portatil nao encontrado!" -ForegroundColor Red
    Write-Host "Verifique se a pasta 'php' existe no diretorio do projeto." -ForegroundColor Yellow
    Read-Host "Pressione Enter para sair"
    exit 1
}

Write-Host "PHP portatil encontrado" -ForegroundColor Green

# Verifica se a porta 8000 esta disponivel
$portInUse = Get-NetTCPConnection -LocalPort 8000 -ErrorAction SilentlyContinue
if ($portInUse) {
    Write-Host "Aviso: A porta 8000 ja esta em uso" -ForegroundColor Yellow
    $response = Read-Host "Deseja continuar mesmo assim? (s/n)"
    if ($response -ne 's' -and $response -ne 'S') {
        Write-Host "Operacao cancelada pelo usuario" -ForegroundColor Yellow
        exit 0
    }
}

Write-Host "Iniciando servidor PHP..." -ForegroundColor Blue
Write-Host "Servidor rodando em: http://localhost:8000" -ForegroundColor Green
Write-Host "Abrindo navegador automaticamente..." -ForegroundColor Blue
Write-Host ""
Write-Host "Para parar o servidor, pressione Ctrl+C" -ForegroundColor Yellow
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Inicia o servidor PHP em background
$serverJob = Start-Job -ScriptBlock {
    Set-Location $using:PWD
    .\php\php.exe -S localhost:8000
}

# Aguarda 3 segundos para o servidor inicializar
Start-Sleep -Seconds 3

# Verifica se o servidor esta rodando
try {
    $response = Invoke-WebRequest -Uri "http://localhost:8000" -TimeoutSec 5 -ErrorAction Stop
    Write-Host "Servidor iniciado com sucesso!" -ForegroundColor Green
    
    # Abre o navegador
    Start-Process "http://localhost:8000"
    Write-Host "Navegador aberto automaticamente" -ForegroundColor Green
    
} catch {
    Write-Host "Erro ao conectar com o servidor" -ForegroundColor Red
    Write-Host "Verifique se nao ha conflitos de porta" -ForegroundColor Yellow
}

Write-Host ""
Write-Host "Logs do servidor:" -ForegroundColor Cyan
Write-Host "----------------------------------------" -ForegroundColor Gray

# Monitora os logs do servidor
try {
    # Para o job em background e inicia em foreground para mostrar logs
    Stop-Job $serverJob
    Remove-Job $serverJob
    
    # Executa o servidor em foreground para mostrar logs
    .\php\php.exe -S localhost:8000
} catch {
    Write-Host "Servidor interrompido pelo usuario" -ForegroundColor Yellow
} finally {
    Write-Host ""
    Write-Host "========================================" -ForegroundColor Cyan
    Write-Host "   Sistema de Produtos - Finalizado" -ForegroundColor Yellow
    Write-Host "========================================" -ForegroundColor Cyan
}