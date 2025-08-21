<?php

// require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/Http/Controllers/ProdutoController.php';

// Inicializar sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Função para processar rotas
function routeHandler($method, $uri, $callback) {
    $requestMethod = $_SERVER['REQUEST_METHOD'];
    $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    
    // Suporte para method spoofing (PUT, DELETE via POST)
    if ($requestMethod === 'POST' && isset($_POST['_method'])) {
        $requestMethod = strtoupper($_POST['_method']);
    }
    
    // Converter padrões de rota para regex
    $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $uri);
    $pattern = '#^' . $pattern . '$#';
    
    if ($requestMethod === $method && preg_match($pattern, $requestUri, $matches)) {
        array_shift($matches); // Remove o match completo
        call_user_func_array($callback, $matches);
        return true;
    }
    
    return false;
}

// Função para redirecionar
function redirect($url, $statusCode = 302) {
    header("Location: $url", true, $statusCode);
    exit;
}

// Middleware para verificar CSRF token
function verifyCsrfToken() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $token = $_POST['_token'] ?? '';
        $sessionToken = $_SESSION['_token'] ?? '';
        
        if (empty($token) || empty($sessionToken) || $token !== $sessionToken) {
            http_response_code(419);
            die('CSRF token mismatch');
        }
    }
}

// Gerar CSRF token se não existir
if (!isset($_SESSION['_token'])) {
    $_SESSION['_token'] = bin2hex(random_bytes(32));
}

// Instanciar o controller
$produtoController = new ProdutoController();

// Definir as rotas
try {
    // Rota principal - Lista de produtos
    if (routeHandler('GET', '/', function() use ($produtoController) {
        $produtoController->index();
    })) {
        exit;
    }
    
    // Rota para listar produtos
    if (routeHandler('GET', '/produtos', function() use ($produtoController) {
        $produtoController->index();
    })) {
        exit;
    }
    
    // Rota para mostrar formulário de criação
    if (routeHandler('GET', '/produtos/create', function() use ($produtoController) {
        $produtoController->create();
    })) {
        exit;
    }
    
    // Rota para salvar novo produto
    if (routeHandler('POST', '/produtos', function() use ($produtoController) {
        verifyCsrfToken();
        $produtoController->store();
    })) {
        exit;
    }
    
    // Rota para mostrar produto específico
    if (routeHandler('GET', '/produtos/{id}', function($id) use ($produtoController) {
        $produtoController->show($id);
    })) {
        exit;
    }
    
    // Rota para mostrar formulário de edição
    if (routeHandler('GET', '/produtos/{id}/edit', function($id) use ($produtoController) {
        $produtoController->edit($id);
    })) {
        exit;
    }
    
    // Rota para atualizar produto
    if (routeHandler('PUT', '/produtos/{id}', function($id) use ($produtoController) {
        verifyCsrfToken();
        $produtoController->update($id);
    })) {
        exit;
    }
    
    // Rota para excluir produto
    if (routeHandler('DELETE', '/produtos/{id}', function($id) use ($produtoController) {
        verifyCsrfToken();
        $produtoController->destroy($id);
    })) {
        exit;
    }
    
    // Rota 404 - Página não encontrada
    http_response_code(404);
    echo "<h1>404 - Página não encontrada</h1>";
    
} catch (Exception $e) {
    // Tratamento de erros
    http_response_code(500);
    echo "<h1>500 - Erro interno do servidor</h1>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
}
