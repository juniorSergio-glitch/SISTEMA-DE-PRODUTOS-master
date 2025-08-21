@echo off
echo ========================================
echo    Sistema de Produtos - Inicializando
echo ========================================
echo.

REM Verifica se o PHP portátil existe
if not exist "php\php.exe" (
    echo ERRO: PHP portátil não encontrado!
    echo Verifique se a pasta 'php' existe no diretório do projeto.
    pause
    exit /b 1
)

echo ✓ PHP portátil encontrado
echo Iniciando servidor PHP...
echo Servidor rodando em: http://localhost:8000
echo Abrindo navegador automaticamente...
echo.
echo Para parar o servidor, pressione Ctrl+C
echo ========================================
echo.

start http://localhost:8000
php\php.exe -S localhost:8000