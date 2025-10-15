<?php
$content = ob_get_clean();
ob_start();
?>

<!-- Hero Section -->
<div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg p-4 sm:p-6 lg:p-8 text-white mb-6 sm:mb-8">
    <div class="text-center">
        <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold mb-3 sm:mb-4">Bem-vindo ao Sistema MVC PHP</h1>
        <p class="text-base sm:text-lg lg:text-xl mb-4 sm:mb-6 opacity-90">Este é um sistema simples desenvolvido em PHP seguindo o padrão MVC (Model-View-Controller) com MySQL.</p>
        <div class="border-t border-white/20 pt-4 sm:pt-6 mb-4 sm:mb-6">
            <p class="text-sm sm:text-base lg:text-lg opacity-80">Explore nossa galeria de fotos com paginação e filtros por categoria.</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center">
            <a href="/photos" class="inline-flex items-center justify-center bg-white text-blue-600 font-semibold py-2 sm:py-3 px-4 sm:px-6 rounded-lg hover:bg-gray-100 transition-colors text-sm sm:text-base">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Ver Galeria
            </a>
            <a href="/photos/create" class="inline-flex items-center justify-center bg-white text-blue-600 font-semibold py-2 sm:py-3 px-4 sm:px-6 rounded-lg hover:bg-gray-100 transition-colors text-sm sm:text-base">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Enviar Foto
            </a>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
    <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 hover:shadow-md transition-shadow">
        <div class="flex items-center mb-3 sm:mb-4">
            <div class="bg-blue-100 p-2 sm:p-3 rounded-lg">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                </svg>
            </div>
            <h3 class="text-lg sm:text-xl font-semibold text-gray-900 ml-3 sm:ml-4">Model</h3>
        </div>
        <p class="text-sm sm:text-base text-gray-600">Camada responsável pela lógica de dados e comunicação com o banco de dados MySQL.</p>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 hover:shadow-md transition-shadow">
        <div class="flex items-center mb-3 sm:mb-4">
            <div class="bg-green-100 p-2 sm:p-3 rounded-lg">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
            </div>
            <h3 class="text-lg sm:text-xl font-semibold text-gray-900 ml-3 sm:ml-4">View</h3>
        </div>
        <p class="text-sm sm:text-base text-gray-600">Camada responsável pela apresentação dos dados ao usuário com interface moderna.</p>
    </div>
    
    <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6 hover:shadow-md transition-shadow sm:col-span-2 lg:col-span-1">
        <div class="flex items-center mb-3 sm:mb-4">
            <div class="bg-purple-100 p-2 sm:p-3 rounded-lg">
                <svg class="w-5 h-5 sm:w-6 sm:h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                </svg>
            </div>
            <h3 class="text-lg sm:text-xl font-semibold text-gray-900 ml-3 sm:ml-4">Controller</h3>
        </div>
        <p class="text-sm sm:text-base text-gray-600">Camada responsável por processar as requisições e coordenar Model e View.</p>
    </div>
</div>

<!-- Stats Section -->
<div class="mt-6 sm:mt-8 bg-white rounded-lg shadow-sm p-4 sm:p-6">
    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-3 sm:mb-4">Funcionalidades do Sistema</h2>
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
        <div class="text-center">
            <div class="text-xl sm:text-2xl font-bold text-blue-600">MVC</div>
            <div class="text-xs sm:text-sm text-gray-600">Arquitetura limpa</div>
        </div>
        <div class="text-center">
            <div class="text-xl sm:text-2xl font-bold text-green-600">Galeria</div>
            <div class="text-xs sm:text-sm text-gray-600">Fotos com paginação</div>
        </div>
        <div class="text-center">
            <div class="text-xl sm:text-2xl font-bold text-purple-600">Tailwind</div>
            <div class="text-xs sm:text-sm text-gray-600">Interface moderna</div>
        </div>
        <div class="text-center">
            <div class="text-xl sm:text-2xl font-bold text-yellow-600">MySQL</div>
            <div class="text-xs sm:text-sm text-gray-600">Banco de dados</div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
$title = 'Home';
require_once __DIR__ . '/layouts/main.php';
?>