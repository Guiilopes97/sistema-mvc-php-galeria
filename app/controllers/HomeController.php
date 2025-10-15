<?php

require_once __DIR__ . '/Controller.php';

/**
 * Controller Home
 * Gerencia a página inicial
 */
class HomeController extends Controller {
    
    /**
     * Página inicial
     */
    public function index() {
        $this->view('home');
    }
}
