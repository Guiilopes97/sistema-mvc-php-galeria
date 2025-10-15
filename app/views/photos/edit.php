<?php
$content = ob_get_clean();
ob_start();
?>

<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-4 sm:mb-6 gap-4">
    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Editar Foto</h1>
    <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
        <a href="/photos/<?= $photo['id'] ?>" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition-colors text-sm sm:text-base text-center">
            Ver Foto
        </a>
        <a href="/photos" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition-colors text-sm sm:text-base text-center">
            Voltar para Galeria
        </a>
    </div>
</div>

<?php if (!empty($errors)): ?>
    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Erros encontrados:</h3>
                <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
    <!-- Imagem Atual -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-lg shadow-sm p-4 sm:p-6">
            <h2 class="text-lg sm:text-xl font-semibold text-gray-900 mb-3 sm:mb-4">Imagem Atual</h2>
            <div class="relative">
                <img src="<?= htmlspecialchars($photo['image_url']) ?>" 
                     alt="<?= htmlspecialchars($photo['title']) ?>"
                     class="w-full h-40 sm:h-48 object-cover rounded-lg shadow-sm">
                <div class="absolute top-2 right-2 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded">
                    Atual
                </div>
            </div>
            <p class="text-xs sm:text-sm text-gray-500 mt-2">
                Para trocar a imagem, selecione uma nova abaixo.
            </p>
        </div>
    </div>
    
    <!-- Formulário de Edição -->
    <div class="lg:col-span-2">
        <div class="bg-white shadow-sm rounded-lg p-4 sm:p-6">
            <form method="POST" action="/photos/<?= $photo['id'] ?>" enctype="multipart/form-data" class="space-y-4 sm:space-y-6" id="editForm">
                <!-- Nova Imagem (Opcional) -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                        Nova Imagem (opcional)
                    </label>
                    <div class="mt-1 flex justify-center px-4 sm:px-6 pt-4 sm:pt-5 pb-4 sm:pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-10 sm:h-12 w-10 sm:w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                            </svg>
                            <div class="flex flex-col sm:flex-row text-sm text-gray-600">
                                <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                    <span>Selecione uma nova imagem</span>
                                    <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                                </label>
                                <p class="pl-0 sm:pl-1 mt-1 sm:mt-0">ou arraste e solte</p>
                            </div>
                            <p class="text-xs text-gray-500">
                                PNG, JPG, GIF ou WebP até 10MB
                            </p>
                        </div>
                    </div>
                    <div id="imagePreview" class="mt-4 hidden">
                        <img id="previewImg" src="" alt="Preview" class="max-w-full h-40 sm:h-48 object-cover rounded-lg shadow-sm">
                        <p class="text-xs sm:text-sm text-gray-500 mt-2">Preview da nova imagem (será redimensionada para 1920x1080)</p>
                    </div>
                </div>
                
                <!-- Título -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Título *</label>
                    <input type="text" id="title" name="title" value="<?= htmlspecialchars($data['title'] ?? $photo['title']) ?>" required
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm sm:text-base"
                           placeholder="Digite o título da foto">
                </div>
                
                <!-- Categoria -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Categoria</label>
                    <select id="category" name="category" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm sm:text-base">
                        <option value="">Selecione uma categoria</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= htmlspecialchars($category) ?>" <?= ($data['category'] ?? $photo['category']) === $category ? 'selected' : '' ?>>
                                <?= htmlspecialchars($category) ?>
                            </option>
                        <?php endforeach; ?>
                        <option value="outra" <?= ($data['category'] ?? '') === 'outra' ? 'selected' : '' ?>>Outra</option>
                    </select>
                    
                    <!-- Input para nova categoria -->
                    <div id="customCategoryDiv" class="mt-3 hidden">
                        <label for="customCategory" class="block text-sm font-medium text-gray-700 mb-2">Nome da Nova Categoria</label>
                        <input type="text" id="customCategory" name="customCategory" 
                               value="<?= htmlspecialchars($data['customCategory'] ?? '') ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm sm:text-base"
                               placeholder="Digite o nome da nova categoria">
                        <p class="text-xs text-gray-500 mt-1">Esta categoria será criada automaticamente</p>
                    </div>
                </div>
                
                <!-- Descrição -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Descrição</label>
                    <textarea id="description" name="description" rows="4"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm sm:text-base"
                              placeholder="Descreva a foto (opcional)"><?= htmlspecialchars($data['description'] ?? $photo['description']) ?></textarea>
                </div>
                
                <!-- Informações da Foto -->
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 sm:p-4">
                    <h3 class="text-xs sm:text-sm font-medium text-gray-800 mb-2">Informações da Foto</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 text-xs sm:text-sm text-gray-600">
                        <div>
                            <span class="font-medium">Criada em:</span><br>
                            <?= date('d/m/Y H:i', strtotime($photo['created_at'])) ?>
                        </div>
                        <?php if (!empty($photo['updated_at']) && $photo['updated_at'] !== $photo['created_at']): ?>
                            <div>
                                <span class="font-medium">Atualizada em:</span><br>
                                <?= date('d/m/Y H:i', strtotime($photo['updated_at'])) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Aviso sobre Processamento -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 sm:p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-4 w-4 sm:h-5 sm:w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-xs sm:text-sm font-medium text-blue-800">Processamento Automático</h3>
                            <div class="mt-1 sm:mt-2 text-xs sm:text-sm text-blue-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Se uma nova imagem for selecionada, ela será redimensionada para 1920x1080 pixels</li>
                                    <li>A proporção original será mantida (sem distorção)</li>
                                    <li>A qualidade será otimizada para web</li>
                                    <li>A imagem atual será substituída pela nova</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Botões de Ação -->
                <div class="flex flex-col sm:flex-row justify-end space-y-3 sm:space-y-0 sm:space-x-4">
                    <a href="/photos/<?= $photo['id'] ?>" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition-colors text-sm sm:text-base text-center">
                        Cancelar
                    </a>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors text-sm sm:text-base">
                        Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('image');
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');

    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            preview.classList.add('hidden');
        }
    });

    // Drag & Drop
    const dropZone = fileInput.closest('.border-dashed');
    dropZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        dropZone.classList.add('border-blue-400', 'bg-blue-50');
    });
    
    dropZone.addEventListener('dragleave', function(e) {
        e.preventDefault();
        dropZone.classList.remove('border-blue-400', 'bg-blue-50');
    });
    
    dropZone.addEventListener('drop', function(e) {
        e.preventDefault();
        dropZone.classList.remove('border-blue-400', 'bg-blue-50');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            fileInput.dispatchEvent(new Event('change'));
        }
    });

    // Controle da categoria personalizada
    const categorySelect = document.getElementById('category');
    const customCategoryDiv = document.getElementById('customCategoryDiv');
    const customCategoryInput = document.getElementById('customCategory');
    
    categorySelect.addEventListener('change', function() {
        if (this.value === 'outra') {
            customCategoryDiv.classList.remove('hidden');
            customCategoryInput.focus();
        } else {
            customCategoryDiv.classList.add('hidden');
            customCategoryInput.value = '';
        }
    });
    
    // Validação do formulário
    document.getElementById('editForm').addEventListener('submit', function(e) {
        const titleInput = document.getElementById('title');
        const categorySelect = document.getElementById('category');
        const customCategoryInput = document.getElementById('customCategory');

        if (!titleInput.value.trim()) {
            e.preventDefault();
            showAlert('Por favor, digite um título para a foto.', 'error');
            return;
        }
        
        // Validar categoria personalizada
        if (categorySelect.value === 'outra') {
            if (!customCategoryInput.value.trim()) {
                e.preventDefault();
                showAlert('Por favor, digite o nome da nova categoria.', 'error');
                customCategoryInput.focus();
                return;
            }
            
            if (customCategoryInput.value.trim().length < 2) {
                e.preventDefault();
                showAlert('O nome da categoria deve ter pelo menos 2 caracteres.', 'error');
                customCategoryInput.focus();
                return;
            }
            
            if (customCategoryInput.value.trim().length > 50) {
                e.preventDefault();
                showAlert('O nome da categoria deve ter no máximo 50 caracteres.', 'error');
                customCategoryInput.focus();
                return;
            }
        }

        const submitBtn = e.target.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.textContent = 'Salvando...';
    });
});
</script>

<?php
$content = ob_get_clean();
$title = 'Editar Foto - ' . $photo['title'];
require_once __DIR__ . '/../layouts/main.php';
?>
