<?php

/**
 * Arquivo de entrada na raiz do projeto
 * Redireciona todas as requisições para a pasta public
 */

// Verificar se a pasta public existe
if (!is_dir(__DIR__ . '/public')) {
    die('Erro: Pasta public não encontrada!');
}

// Incluir o arquivo principal da aplicação
require_once __DIR__ . '/public/index.php';