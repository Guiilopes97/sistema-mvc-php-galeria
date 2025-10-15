<?php
$content = ob_get_clean();
ob_start();
?>

<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 sm:mb-6 gap-4">
    <div>
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-1 sm:mb-2">Galeria de Fotos</h1>
        <p class="text-sm sm:text-base text-gray-600">Explore nossa coleção de imagens incríveis</p>
    </div>
    <a href="/photos/create" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors text-sm sm:text-base flex items-center justify-center">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Enviar Foto
    </a>
</div>

<!-- Filtros por Categoria -->
<?php if (!empty($categories)): ?>
    <div class="mb-4 sm:mb-6">
        <div class="flex flex-wrap gap-2">
            <a href="/photos" class="px-3 sm:px-4 py-2 rounded-full text-xs sm:text-sm font-medium transition-colors <?= !$selectedCategory ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' ?>">
                Todas
            </a>
            <?php foreach ($categories as $category): ?>
                <a href="/photos?category=<?= urlencode($category) ?>" class="px-3 sm:px-4 py-2 rounded-full text-xs sm:text-sm font-medium transition-colors <?= $selectedCategory === $category ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' ?>">
                    <?= htmlspecialchars($category) ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<!-- Grid de Fotos -->
<?php if (empty($photos)): ?>
    <div class="bg-gray-50 border border-gray-200 rounded-lg p-12 text-center">
        <div class="text-gray-400 mb-4">
            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">Nenhuma foto encontrada</h3>
        <p class="text-gray-600">
            <?php if ($selectedCategory): ?>
                Não há fotos na categoria "<?= htmlspecialchars($selectedCategory) ?>".
            <?php else: ?>
                Ainda não há fotos cadastradas na galeria.
            <?php endif; ?>
        </p>
    </div>
<?php else: ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
        <?php foreach ($photos as $photo): ?>
            <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-300 group">
                <!-- Imagem -->
                <div class="relative overflow-hidden cursor-pointer" onclick="openPhotoModal(<?= $photo['id'] ?>, '<?= htmlspecialchars($photo['title']) ?>', '<?= htmlspecialchars($photo['image_url']) ?>', '<?= htmlspecialchars($photo['description'] ?? '') ?>', '<?= htmlspecialchars($photo['category'] ?? '') ?>', '<?= date('d/m/Y H:i', strtotime($photo['created_at'])) ?>')">
                    <img src="<?= htmlspecialchars($photo['image_url']) ?>" 
                         alt="<?= htmlspecialchars($photo['title']) ?>"
                         class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300"
                         loading="lazy">
                    
                    <!-- Overlay com informações -->
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-end">
                        <div class="p-4 text-white transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                            <?php if (!empty($photo['category'])): ?>
                                <span class="inline-block bg-blue-600 bg-opacity-90 text-xs font-medium px-2 py-1 rounded-full mb-2">
                                    <?= htmlspecialchars($photo['category']) ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Ícone de expandir -->
                    <div class="absolute top-2 right-2 bg-black bg-opacity-50 text-white p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                        </svg>
                    </div>
                </div>
                
                <!-- Conteúdo -->
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">
                        <a href="/photos/<?= $photo['id'] ?>" class="hover:text-blue-600 transition-colors">
                            <?= htmlspecialchars($photo['title']) ?>
                        </a>
                    </h3>
                    
                    <?php if (!empty($photo['description'])): ?>
                        <p class="text-gray-600 text-sm line-clamp-3 mb-3">
                            <?= htmlspecialchars($photo['description']) ?>
                        </p>
                    <?php endif; ?>
                    
                    <div class="flex items-center justify-between text-xs text-gray-500">
                        <span><?= date('d/m/Y', strtotime($photo['created_at'])) ?></span>
                        <a href="/photos/<?= $photo['id'] ?>" class="text-blue-600 hover:text-blue-800 font-medium">
                            Ver detalhes →
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Paginação -->
    <?php if ($pagination['total'] > 1): ?>
        <div class="flex justify-center">
            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px">
                <?php if ($pagination['current'] > 1): ?>
                    <a href="?page=<?= $pagination['current'] - 1 ?><?= $selectedCategory ? '&category=' . urlencode($selectedCategory) : '' ?>" 
                       class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <span class="sr-only">Anterior</span>
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $pagination['total']; $i++): ?>
                    <a href="?page=<?= $i ?><?= $selectedCategory ? '&category=' . urlencode($selectedCategory) : '' ?>" 
                       class="relative inline-flex items-center px-4 py-2 border text-sm font-medium <?= $i === $pagination['current'] ? 'z-10 bg-blue-50 border-blue-500 text-blue-600' : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50' ?>">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>

                <?php if ($pagination['current'] < $pagination['total']): ?>
                    <a href="?page=<?= $pagination['current'] + 1 ?><?= $selectedCategory ? '&category=' . urlencode($selectedCategory) : '' ?>" 
                       class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <span class="sr-only">Próxima</span>
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    </a>
                <?php endif; ?>
            </nav>
        </div>
    <?php endif; ?>
<?php endif; ?>

<!-- Informações da Paginação -->
<?php if (!empty($photos)): ?>
    <div class="mt-6 text-center text-sm text-gray-500">
        Mostrando <?= count($photos) ?> de <?= $pagination['totalRecords'] ?> fotos
        <?php if ($selectedCategory): ?>
            na categoria "<?= htmlspecialchars($selectedCategory) ?>"
        <?php endif; ?>
    </div>
<?php endif; ?>

<!-- Modal para expandir foto -->
<div id="photoModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden p-2 sm:p-4">
    <div class="bg-white rounded-lg max-w-4xl max-h-[95vh] sm:max-h-[90vh] overflow-hidden w-full relative">
        <!-- Botão fechar -->
        <button onclick="closePhotoModal()" class="absolute top-4 right-4 z-10 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-70 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        
        <!-- Conteúdo do modal -->
        <div class="flex flex-col lg:flex-row">
            <!-- Imagem -->
            <div class="lg:w-2/3 relative">
                <img id="modalImage" src="" alt="" class="w-full h-auto max-h-[50vh] sm:max-h-[60vh] lg:max-h-[70vh] object-contain">
                
                <!-- Botões de navegação -->
                <button onclick="navigatePhoto(-1)" class="absolute left-2 sm:left-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 sm:p-3 rounded-full hover:bg-opacity-70 transition-colors" id="prevButton">
                    <svg class="w-4 h-4 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                
                <button onclick="navigatePhoto(1)" class="absolute right-2 sm:right-4 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 sm:p-3 rounded-full hover:bg-opacity-70 transition-colors" id="nextButton">
                    <svg class="w-4 h-4 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Informações -->
            <div class="lg:w-1/3 p-4 sm:p-6 bg-gray-50">
                <div class="space-y-3 sm:space-y-4">
                    <!-- Título -->
                    <div>
                        <h2 id="modalTitle" class="text-lg sm:text-2xl font-bold text-gray-900"></h2>
                    </div>
                    
                    <!-- Categoria -->
                    <div id="modalCategory" class="hidden">
                        <span class="inline-block bg-blue-100 text-blue-800 text-xs sm:text-sm font-medium px-2 sm:px-3 py-1 rounded-full"></span>
                    </div>
                    
                    <!-- Data -->
                    <div>
                        <p class="text-xs sm:text-sm text-gray-500">
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span id="modalDate"></span>
                        </p>
                    </div>
                    
                    <!-- Descrição -->
                    <div id="modalDescription" class="hidden">
                        <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-1 sm:mb-2">Descrição</h3>
                        <p class="text-sm sm:text-base text-gray-700 leading-relaxed"></p>
                    </div>
                    
                    <!-- Ações -->
                    <div class="pt-3 sm:pt-4 border-t border-gray-200">
                        <div class="flex flex-col space-y-2">
                            
                            <button onclick="downloadPhoto()" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors flex items-center justify-center text-sm sm:text-base">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Baixar
                            </button>
                            
                            <a id="modalViewDetails" href="#" class="w-full bg-gray-600 hover:bg-gray-700 text-white font-medium py-2 px-4 rounded-lg transition-colors flex items-center justify-center text-sm sm:text-base">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Ver Detalhes
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Variáveis globais para o modal
let currentPhotoData = {};

function openPhotoModal(id, title, imageUrl, description, category, date) {
    currentPhotoData = {
        id: id,
        title: title,
        imageUrl: imageUrl,
        description: description,
        category: category,
        date: date
    };
    
    // Preencher dados do modal
    document.getElementById('modalImage').src = imageUrl;
    document.getElementById('modalImage').alt = title;
    document.getElementById('modalTitle').textContent = title;
    document.getElementById('modalDate').textContent = date;
    document.getElementById('modalViewDetails').href = `/photos/${id}`;
    
    // Categoria
    const categoryElement = document.getElementById('modalCategory');
    if (category) {
        categoryElement.classList.remove('hidden');
        categoryElement.querySelector('span').textContent = category;
    } else {
        categoryElement.classList.add('hidden');
    }
    
    // Descrição
    const descriptionElement = document.getElementById('modalDescription');
    if (description) {
        descriptionElement.classList.remove('hidden');
        descriptionElement.querySelector('p').textContent = description;
    } else {
        descriptionElement.classList.add('hidden');
    }
    
    // Mostrar modal
    document.getElementById('photoModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden'; // Prevenir scroll do body
    
    // Atualizar botões de navegação
    updateNavigationButtons();
}

function closePhotoModal() {
    document.getElementById('photoModal').classList.add('hidden');
    document.body.style.overflow = 'auto'; // Restaurar scroll do body
}

function downloadPhoto() {
    const link = document.createElement('a');
    link.href = currentPhotoData.imageUrl;
    link.download = currentPhotoData.title + '.jpg';
    link.target = '_blank';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

// Navegação por teclado
document.addEventListener('keydown', function(e) {
    const modal = document.getElementById('photoModal');
    if (modal.classList.contains('hidden')) return;
    
    switch(e.key) {
        case 'Escape':
            closePhotoModal();
            break;
        case 'ArrowLeft':
            e.preventDefault();
            navigatePhoto(-1);
            break;
        case 'ArrowRight':
            e.preventDefault();
            navigatePhoto(1);
            break;
    }
});

// Navegação entre fotos
function navigatePhoto(direction) {
    const photos = <?= json_encode($photos) ?>;
    const currentIndex = photos.findIndex(p => p.id == currentPhotoData.id);
    const newIndex = currentIndex + direction;
    
    if (newIndex >= 0 && newIndex < photos.length) {
        const newPhoto = photos[newIndex];
        openPhotoModal(
            newPhoto.id,
            newPhoto.title,
            newPhoto.image_url,
            newPhoto.description || '',
            newPhoto.category || '',
            new Date(newPhoto.created_at).toLocaleDateString('pt-BR') + ' ' + new Date(newPhoto.created_at).toLocaleTimeString('pt-BR', {hour: '2-digit', minute: '2-digit'})
        );
    }
}

// Atualizar visibilidade dos botões de navegação
function updateNavigationButtons() {
    const photos = <?= json_encode($photos) ?>;
    const currentIndex = photos.findIndex(p => p.id == currentPhotoData.id);
    
    const prevButton = document.getElementById('prevButton');
    const nextButton = document.getElementById('nextButton');
    
    // Mostrar/ocultar botão anterior
    if (currentIndex > 0) {
        prevButton.classList.remove('hidden');
    } else {
        prevButton.classList.add('hidden');
    }
    
    // Mostrar/ocultar botão próximo
    if (currentIndex < photos.length - 1) {
        nextButton.classList.remove('hidden');
    } else {
        nextButton.classList.add('hidden');
    }
}

// Fechar modal clicando fora
document.getElementById('photoModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closePhotoModal();
    }
});
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Animação do modal */
#photoModal {
    animation: fadeIn 0.3s ease-out;
}

#photoModal .bg-white {
    animation: slideIn 0.3s ease-out;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideIn {
    from { 
        opacity: 0;
        transform: scale(0.9) translateY(-20px);
    }
    to { 
        opacity: 1;
        transform: scale(1) translateY(0);
    }
}
</style>

<?php
$content = ob_get_clean();
$title = 'Galeria de Fotos';
require_once __DIR__ . '/../layouts/main.php';
?>
