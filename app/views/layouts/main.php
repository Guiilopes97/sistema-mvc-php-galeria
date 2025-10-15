<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Sistema MVC PHP' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#3B82F6',
                        secondary: '#6B7280',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="bg-blue-600 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="text-white text-lg sm:text-xl font-bold">Sistema MVC</a>
                </div>
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <a href="/" class="text-white hover:text-blue-200 px-2 sm:px-3 py-2 rounded-md text-xs sm:text-sm font-medium transition-colors">Home</a>
                    <a href="/photos" class="text-white hover:text-blue-200 px-2 sm:px-3 py-2 rounded-md text-xs sm:text-sm font-medium transition-colors">Fotos</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto py-4 sm:py-6 px-4 sm:px-6 lg:px-8">
        <!-- Flash Messages -->
        <?php if (isset($flash) && $flash['message']): ?>
            <div class="mb-4 p-4 rounded-md <?= $flash['type'] === 'success' ? 'bg-green-50 border border-green-200 text-green-800' : ($flash['type'] === 'error' ? 'bg-red-50 border border-red-200 text-red-800' : 'bg-blue-50 border border-blue-200 text-blue-800') ?>">
                <div class="flex justify-between items-center">
                    <span><?= htmlspecialchars($flash['message']) ?></span>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
        <?php endif; ?>

        <?= $content ?>
    </div>

    <script src="js/script.js"></script>
</body>
</html>
