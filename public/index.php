<?php

/**
 * Arquivo principal do sistema MVC
 * Responsável por rotear as requisições
 */

// Iniciar sessão
session_start();

// Configurar timezone
date_default_timezone_set('America/Sao_Paulo');

// Incluir autoloader (caminho relativo à pasta public)
require_once __DIR__ . '/../app/autoload.php';

/**
 * Classe Router simples
 */
class Router {
    private $routes = [];
    
    public function get($path, $callback) {
        $this->routes['GET'][$path] = $callback;
    }
    
    public function post($path, $callback) {
        $this->routes['POST'][$path] = $callback;
    }
    
    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Remover o diretório base se existir
        $basePath = dirname($_SERVER['SCRIPT_NAME']);
        if ($basePath !== '/') {
            $path = substr($path, strlen($basePath));
        }
        
        // Garantir que a path comece com /
        if (empty($path) || $path[0] !== '/') {
            $path = '/' . $path;
        }
        
        // Verificar se existe rota exata
        if (isset($this->routes[$method][$path])) {
            $this->executeRoute($this->routes[$method][$path]);
            return;
        }
        
        // Verificar rotas com parâmetros
        foreach ($this->routes[$method] as $route => $callback) {
            if ($this->matchRoute($route, $path)) {
                $this->executeRoute($callback, $this->getRouteParams($route, $path));
                return;
            }
        }
        
        // Rota não encontrada
        $this->handle404();
    }
    
    private function matchRoute($route, $path) {
        // Converter rota para regex
        $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $route);
        $pattern = '#^' . $pattern . '$#';
        
        return preg_match($pattern, $path);
    }
    
    private function getRouteParams($route, $path) {
        // Extrair nomes dos parâmetros
        preg_match_all('/\{([^}]+)\}/', $route, $paramNames);
        
        // Converter rota para regex
        $pattern = preg_replace('/\{([^}]+)\}/', '([^/]+)', $route);
        $pattern = '#^' . $pattern . '$#';
        
        // Extrair valores dos parâmetros
        preg_match($pattern, $path, $matches);
        array_shift($matches); // Remover match completo
        
        // Combinar nomes e valores
        $params = [];
        foreach ($paramNames[1] as $index => $name) {
            $params[$name] = $matches[$index] ?? null;
        }
        
        return $params;
    }
    
    private function executeRoute($callback, $params = []) {
        if (is_string($callback)) {
            // Formato: 'Controller@method'
            list($controllerName, $method) = explode('@', $callback);
            
            $controllerFile = __DIR__ . '/../app/controllers/' . $controllerName . '.php';
            if (!file_exists($controllerFile)) {
                throw new Exception("Controller '{$controllerName}' não encontrado");
            }
            
            require_once $controllerFile;
            
            if (!class_exists($controllerName)) {
                throw new Exception("Classe '{$controllerName}' não encontrada");
            }
            
            $controller = new $controllerName();
            
            if (!method_exists($controller, $method)) {
                throw new Exception("Método '{$method}' não encontrado no controller '{$controllerName}'");
            }
            
            // Chamar método com parâmetros
            call_user_func_array([$controller, $method], array_values($params));
        } else {
            // Callback function
            call_user_func_array($callback, array_values($params));
        }
    }
    
    private function handle404() {
        http_response_code(404);
        echo "<h1>404 - Página não encontrada</h1>";
        echo "<p>A página que você está procurando não existe.</p>";
        echo "<a href='/'>Voltar ao início</a>";
    }
}

// Criar instância do router
$router = new Router();

// Definir rotas
$router->get('/', 'HomeController@index');

// Rotas para fotos
$router->get('/photos', 'PhotoController@index');
$router->get('/photos/create', 'PhotoController@create');
$router->post('/photos', 'PhotoController@store');
$router->get('/photos/{id}', 'PhotoController@show');
$router->get('/photos/{id}/edit', 'PhotoController@edit');
$router->post('/photos/{id}', 'PhotoController@update');
$router->post('/photos/{id}/delete', 'PhotoController@delete');
$router->get('/photos/category/{category}', 'PhotoController@category');
$router->get('/api/photos', 'PhotoController@api');
$router->get('/api/photos/categories', 'PhotoController@categories');

// Executar router
try {
    $router->dispatch();
} catch (Exception $e) {
    http_response_code(500);
    echo "<h1>Erro interno do servidor</h1>";
    echo "<p>" . htmlspecialchars($e->getMessage()) . "</p>";
    if (defined('DEBUG') && DEBUG) {
        echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    }
}