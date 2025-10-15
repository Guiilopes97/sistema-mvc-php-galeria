<?php

require_once __DIR__ . '/Controller.php';
require_once __DIR__ . '/../models/Photo.php';

/**
 * Controller Photo
 * Gerencia as ações relacionadas às fotos
 */
class PhotoController extends Controller {
    private $photoModel;
    
    public function __construct() {
        $this->photoModel = new Photo();
    }
    
    /**
     * Listar todas as fotos com paginação
     */
    public function index() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $category = isset($_GET['category']) ? $_GET['category'] : null;
        
        $result = $this->photoModel->getPaginated($page, 10, $category);
        $categories = $this->photoModel->getCategories();
        
        $flash = $this->getFlashMessage();
        
        $this->view('photos/index', [
            'photos' => $result['photos'],
            'pagination' => [
                'current' => $result['page'],
                'total' => $result['totalPages'],
                'totalRecords' => $result['total']
            ],
            'categories' => $categories,
            'selectedCategory' => $category,
            'flash' => $flash
        ]);
    }
    
    /**
     * Mostrar foto específica
     */
    public function show($id) {
        $photo = $this->photoModel->find($id);
        
        if (!$photo) {
            $this->setFlashMessage('Foto não encontrada!', 'error');
            $this->redirect('/photos');
            return;
        }
        
        // Buscar fotos relacionadas (mesma categoria)
        $relatedPhotos = [];
        if (!empty($photo['category'])) {
            $relatedResult = $this->photoModel->getByCategory($photo['category'], 1, 4);
            $relatedPhotos = array_filter($relatedResult['photos'], function($p) use ($id) {
                return $p['id'] != $id;
            });
        }
        
        $this->view('photos/show', [
            'photo' => $photo,
            'relatedPhotos' => array_slice($relatedPhotos, 0, 3)
        ]);
    }
    
    /**
     * Buscar fotos por categoria
     */
    public function category($category) {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        
        $result = $this->photoModel->getByCategory($category, $page, 10);
        $categories = $this->photoModel->getCategories();
        
        if (empty($result['photos'])) {
            $this->setFlashMessage("Nenhuma foto encontrada na categoria '{$category}'", 'info');
            $this->redirect('/photos');
            return;
        }
        
        $this->view('photos/index', [
            'photos' => $result['photos'],
            'pagination' => [
                'current' => $result['page'],
                'total' => $result['totalPages'],
                'totalRecords' => $result['total']
            ],
            'categories' => $categories,
            'selectedCategory' => $category
        ]);
    }
    
    /**
     * API: Buscar fotos (JSON)
     */
    public function api() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $category = isset($_GET['category']) ? $_GET['category'] : null;
        $perPage = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
        
        $result = $this->photoModel->getPaginated($page, $perPage, $category);
        
        $this->json([
            'success' => true,
            'data' => $result['photos'],
            'pagination' => [
                'current_page' => $result['page'],
                'total_pages' => $result['totalPages'],
                'total_records' => $result['total'],
                'per_page' => $result['perPage']
            ]
        ]);
    }
    
    /**
     * API: Buscar categorias (JSON)
     */
    public function categories() {
        $categories = $this->photoModel->getCategories();
        
        $this->json([
            'success' => true,
            'data' => $categories
        ]);
    }
    
    /**
     * Mostrar formulário de upload
     */
    public function create() {
        $categories = $this->photoModel->getCategories();
        
        $this->view('photos/create', [
            'categories' => $categories
        ]);
    }
    
    /**
     * Processar upload de foto
     */
    public function store() {
        if (!$this->isPost()) {
            $this->redirect('/photos');
            return;
        }
        
        $data = $this->getPostData();
        
        // Verificar se arquivo foi enviado
        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            $this->setFlashMessage('Erro: Nenhuma imagem foi enviada ou houve erro no upload.', 'error');
            $this->redirect('/photos/create');
            return;
        }
        
        try {
            // Processar categoria personalizada
            $category = $data['category'] ?? '';
            if ($category === 'outra' && !empty($data['customCategory'])) {
                $category = trim($data['customCategory']);
            }
            
            $photoId = $this->photoModel->uploadPhoto(
                $_FILES['image'],
                $data['title'] ?? '',
                $data['description'] ?? '',
                $category
            );
            
            $this->setFlashMessage('Foto enviada com sucesso!', 'success');
            $this->redirect('/photos');
            
        } catch (Exception $e) {
            $categories = $this->photoModel->getCategories();
            $this->view('photos/create', [
                'errors' => [$e->getMessage()],
                'data' => $data,
                'categories' => $categories
            ]);
        }
    }
    
    /**
     * Mostrar formulário de edição
     */
    public function edit($id) {
        $photo = $this->photoModel->find($id);
        
        if (!$photo) {
            $this->setFlashMessage('Foto não encontrada!', 'error');
            $this->redirect('/photos');
            return;
        }
        
        $categories = $this->photoModel->getCategories();
        
        $this->view('photos/edit', [
            'photo' => $photo,
            'categories' => $categories
        ]);
    }
    
    /**
     * Processar atualização de foto
     */
    public function update($id) {
        if (!$this->isPost()) {
            $this->redirect('/photos/' . $id);
            return;
        }
        
        $photo = $this->photoModel->find($id);
        
        if (!$photo) {
            $this->setFlashMessage('Foto não encontrada!', 'error');
            $this->redirect('/photos');
            return;
        }
        
        $data = $this->getPostData();
        
        try {
            // Processar categoria personalizada
            $category = $data['category'] ?? '';
            if ($category === 'outra' && !empty($data['customCategory'])) {
                $category = trim($data['customCategory']);
            }
            
            // Verificar se nova imagem foi enviada
            $hasNewImage = isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK;
            
            if ($hasNewImage) {
                // Upload de nova imagem
                $photoId = $this->photoModel->updatePhotoWithImage(
                    $id,
                    $_FILES['image'],
                    $data['title'] ?? '',
                    $data['description'] ?? '',
                    $category
                );
            } else {
                // Apenas atualizar dados (sem nova imagem)
                $updateData = [
                    'title' => $data['title'] ?? '',
                    'description' => $data['description'] ?? '',
                    'category' => $category,
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                
                $this->photoModel->update($id, $updateData);
            }
            
            $this->setFlashMessage('Foto atualizada com sucesso!', 'success');
            $this->redirect('/photos/' . $id);
            
        } catch (Exception $e) {
            $categories = $this->photoModel->getCategories();
            $this->view('photos/edit', [
                'photo' => $photo,
                'errors' => [$e->getMessage()],
                'data' => $data,
                'categories' => $categories
            ]);
        }
    }
    
    /**
     * Deletar foto
     */
    public function delete($id) {
        if (!$this->isPost()) {
            $this->redirect('/photos/' . $id);
            return;
        }
        
        $photo = $this->photoModel->find($id);
        
        if (!$photo) {
            $this->setFlashMessage('Foto não encontrada!', 'error');
            $this->redirect('/photos');
            return;
        }
        
        try {
            $this->photoModel->delete($id);
            $this->setFlashMessage('Foto removida com sucesso!', 'success');
            $this->redirect('/photos');
            
        } catch (Exception $e) {
            $this->setFlashMessage('Erro ao remover foto: ' . $e->getMessage(), 'error');
            $this->redirect('/photos/' . $id);
        }
    }
}
