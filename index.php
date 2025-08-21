<?php

/**
 * Sistema de Produtos - Ponto de entrada da aplicação
 * 
 * Este arquivo serve como o front controller da aplicação,
 * direcionando todas as requisições para o sistema de rotas.
 */

// Definir o diretório base da aplicação
define('BASE_PATH', __DIR__);

// Configurar o timezone
date_default_timezone_set('America/Sao_Paulo');

// Configurar exibição de erros (desabilitar em produção)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Incluir o arquivo de rotas que processará a requisição
require_once __DIR__ . '/routes/web.php';