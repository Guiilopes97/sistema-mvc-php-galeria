<?php

/**
 * Classe Controller base
 * Fornece funcionalidades básicas para todos os controllers
 */
abstract class Controller {
    
    /**
     * Renderizar uma view
     */
    protected function view($viewName, $data = []) {
        // Extrair as variáveis do array $data para que fiquem disponíveis na view
        extract($data);
        
        // Caminho para o arquivo da view
        $viewFile = __DIR__ . '/../views/' . $viewName . '.php';
        
        // Verificar se o arquivo da view existe
        if (!file_exists($viewFile)) {
            throw new Exception("View '{$viewName}' não encontrada");
        }
        
        // Incluir o arquivo da view
        require_once $viewFile;
    }
    
    /**
     * Redirecionar para uma URL
     */
    protected function redirect($url) {
        header("Location: " . $url);
        exit();
    }
    
    /**
     * Retornar JSON
     */
    protected function json($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
    
    /**
     * Verificar se é uma requisição POST
     */
    protected function isPost() {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
    
    /**
     * Verificar se é uma requisição GET
     */
    protected function isGet() {
        return $_SERVER['REQUEST_METHOD'] === 'GET';
    }
    
    /**
     * Obter dados da requisição POST
     */
    protected function getPostData() {
        return $_POST;
    }
    
    /**
     * Obter dados da requisição GET
     */
    protected function getGetData() {
        return $_GET;
    }
    
    /**
     * Validar se um campo está presente
     */
    protected function validateRequired($data, $fields) {
        $errors = [];
        
        foreach ($fields as $field) {
            if (empty($data[$field])) {
                $errors[] = "O campo '{$field}' é obrigatório";
            }
        }
        
        return $errors;
    }
    
    /**
     * Definir mensagem de flash
     */
    protected function setFlashMessage($message, $type = 'info') {
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['flash_message'] = $message;
        $_SESSION['flash_type'] = $type;
    }
    
    /**
     * Obter e limpar mensagem de flash
     */
    protected function getFlashMessage() {
        if (!isset($_SESSION)) {
            session_start();
        }
        
        $message = null;
        $type = 'info';
        
        if (isset($_SESSION['flash_message'])) {
            $message = $_SESSION['flash_message'];
            $type = $_SESSION['flash_type'] ?? 'info';
            
            // Limpar a mensagem após usar
            unset($_SESSION['flash_message']);
            unset($_SESSION['flash_type']);
        }
        
        return ['message' => $message, 'type' => $type];
    }
}
