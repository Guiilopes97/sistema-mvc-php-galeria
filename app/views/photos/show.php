<?php
$content = ob_get_clean();
ob_start();
?>

<div class="mb-4 sm:mb-6">
    <a href="/photos" class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-3 sm:mb-4 text-sm sm:text-base">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Voltar para a galeria
    </a>
    
    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900"><?= htmlspecialchars($photo['title']) ?></h1>
    <?php if (!empty($photo['category'])): ?>
        <span class="inline-block bg-blue-100 text-blue-800 text-xs sm:text-sm font-medium px-2 sm:px-3 py-1 rounded-full mt-2">
            <?= htmlspecialchars($photo['category']) ?>
        </span>
    <?php endif; ?>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
    <!-- Imagem Principal -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <img src="<?= htmlspecialchars($photo['image_url']) ?>" 
                 alt="<?= htmlspecialchars($photo['title']) ?>"
                 class="w-full h-auto object-cover"
                 loading="lazy">
        </div>
    </div>
    
    <!-- Informações da Foto -->
    <div class="space-y-4 sm:space-y-6">
        <!-- Detalhes -->
        <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6">
            <h2 class="text-lg sm:text-xl font-semibold text-gray-900 mb-3 sm:mb-4">Detalhes da Foto</h2>
            
            <dl class="space-y-3 sm:space-y-4">
                <div>
                    <dt class="text-xs sm:text-sm font-medium text-gray-500">Título</dt>
                    <dd class="text-sm sm:text-base text-gray-900"><?= htmlspecialchars($photo['title']) ?></dd>
                </div>
                
                <?php if (!empty($photo['category'])): ?>
                    <div>
                        <dt class="text-xs sm:text-sm font-medium text-gray-500">Categoria</dt>
                        <dd class="text-sm sm:text-base text-gray-900">
                            <a href="/photos?category=<?= urlencode($photo['category']) ?>" class="text-blue-600 hover:text-blue-800">
                                <?= htmlspecialchars($photo['category']) ?>
                            </a>
                        </dd>
                    </div>
                <?php endif; ?>
                
                <div>
                    <dt class="text-xs sm:text-sm font-medium text-gray-500">Data de Publicação</dt>
                    <dd class="text-sm sm:text-base text-gray-900"><?= date('d/m/Y H:i', strtotime($photo['created_at'])) ?></dd>
                </div>
                
                <?php if (!empty($photo['updated_at']) && $photo['updated_at'] !== $photo['created_at']): ?>
                    <div>
                        <dt class="text-xs sm:text-sm font-medium text-gray-500">Última Atualização</dt>
                        <dd class="text-sm sm:text-base text-gray-900"><?= date('d/m/Y H:i', strtotime($photo['updated_at'])) ?></dd>
                    </div>
                <?php endif; ?>
            </dl>
        </div>
        
        <!-- Descrição -->
        <?php if (!empty($photo['description'])): ?>
            <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6">
                <h2 class="text-lg sm:text-xl font-semibold text-gray-900 mb-3 sm:mb-4">Descrição</h2>
                <p class="text-sm sm:text-base text-gray-700 leading-relaxed"><?= nl2br(htmlspecialchars($photo['description'])) ?></p>
            </div>
        <?php endif; ?>
        
        <!-- Ações -->
        <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6">
            <h2 class="text-lg sm:text-xl font-semibold text-gray-900 mb-3 sm:mb-4">Ações</h2>
            <div class="space-y-2 sm:space-y-3">
                <a href="/photos/<?= $photo['id'] ?>/edit" class="w-full bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-lg transition-colors inline-flex items-center justify-center text-sm sm:text-base">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Editar Foto
                </a>
                
                <button onclick="confirmDelete(<?= $photo['id'] ?>)" class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition-colors text-sm sm:text-base">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Remover Foto
                </button>          
                
                <button onclick="downloadPhoto()" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors text-sm sm:text-base">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Baixar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Fotos Relacionadas -->
<?php if (!empty($relatedPhotos)): ?>
    <div class="mt-8 sm:mt-12">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4 sm:mb-6">Fotos Relacionadas</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            <?php foreach ($relatedPhotos as $relatedPhoto): ?>
                <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-300 group">
                    <div class="relative overflow-hidden">
                        <img src="<?= htmlspecialchars($relatedPhoto['image_url']) ?>" 
                             alt="<?= htmlspecialchars($relatedPhoto['title']) ?>"
                             class="w-full h-40 sm:h-48 object-cover group-hover:scale-105 transition-transform duration-300"
                             loading="lazy">
                        
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-end">
                            <div class="p-3 sm:p-4 text-white transform translate-y-2 group-hover:translate-y-0 transition-transform duration-300">
                                <h3 class="font-semibold text-xs sm:text-sm line-clamp-2"><?= htmlspecialchars($relatedPhoto['title']) ?></h3>
                            </div>
                        </div>
                    </div>
                    
                    <div class="p-3 sm:p-4">
                        <h3 class="font-semibold text-gray-900 mb-1 sm:mb-2 line-clamp-2 text-sm sm:text-base">
                            <a href="/photos/<?= $relatedPhoto['id'] ?>" class="hover:text-blue-600 transition-colors">
                                <?= htmlspecialchars($relatedPhoto['title']) ?>
                            </a>
                        </h3>
                        
                        <div class="flex items-center justify-between text-xs text-gray-500">
                            <span><?= date('d/m/Y', strtotime($relatedPhoto['created_at'])) ?></span>
                            <a href="/photos/<?= $relatedPhoto['id'] ?>" class="text-blue-600 hover:text-blue-800 font-medium">
                                Ver →
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<script>

function downloadPhoto() {
    const link = document.createElement('a');
    link.href = '<?= htmlspecialchars($photo['image_url']) ?>';
    link.download = '<?= addslashes($photo['title']) ?>.jpg';
    link.target = '_blank';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

function confirmDelete(photoId) {
    if (confirm('Tem certeza que deseja remover esta foto?\n\nEsta ação não pode ser desfeita e a imagem será permanentemente excluída.')) {
        // Criar formulário para envio POST
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/photos/' + photoId + '/delete';
        
        // Adicionar token CSRF se necessário (opcional)
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '<?= md5(session_id() . 'delete_photo') ?>';
        form.appendChild(csrfToken);
        
        document.body.appendChild(form);
        form.submit();
    }
}
</script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

<?php
$content = ob_get_clean();
$title = $photo['title'];
require_once __DIR__ . '/../layouts/main.php';
?>
