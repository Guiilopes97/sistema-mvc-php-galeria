<?php

require_once __DIR__ . '/Model.php';
require_once __DIR__ . '/../ImageProcessor.php';

/**
 * Model Photo
 * Gerencia operações relacionadas às fotos
 */
class Photo extends Model {
    protected $table = 'photos';
    
    /**
     * Buscar fotos com paginação
     */
    public function getPaginated($page = 1, $perPage = 10, $category = null) {
        $offset = ($page - 1) * $perPage;
        
        // Construir query base
        $sql = "SELECT * FROM {$this->table}";
        $params = [];
        
        // Adicionar filtro de categoria se especificado
        if ($category) {
            $sql .= " WHERE category = :category";
            $params['category'] = $category;
        }
        
        $sql .= " ORDER BY created_at DESC";
        
        // Contar total de registros
        $countSql = str_replace("SELECT *", "SELECT COUNT(*) as total", $sql);
        $countSql = preg_replace('/ORDER BY.*$/', '', $countSql);
        
        $totalResult = $this->db->fetch($countSql, $params);
        $total = $totalResult['total'];
        
        // Buscar registros da página
        $sql .= " LIMIT :limit OFFSET :offset";
        $params['limit'] = $perPage;
        $params['offset'] = $offset;
        
        $photos = $this->db->fetchAll($sql, $params);
        
        return [
            'photos' => $photos,
            'total' => $total,
            'page' => $page,
            'perPage' => $perPage,
            'totalPages' => ceil($total / $perPage)
        ];
    }
    
    /**
     * Buscar todas as categorias
     */
    public function getCategories() {
        $sql = "SELECT DISTINCT category FROM {$this->table} WHERE category IS NOT NULL ORDER BY category";
        $result = $this->db->fetchAll($sql);
        
        return array_column($result, 'category');
    }
    
    /**
     * Buscar fotos por categoria
     */
    public function getByCategory($category, $page = 1, $perPage = 10) {
        return $this->getPaginated($page, $perPage, $category);
    }
    
    /**
     * Buscar foto por ID
     */
    public function find($id) {
        $sql = "SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id";
        return $this->db->fetch($sql, ['id' => $id]);
    }
    
    /**
     * Validar dados da foto
     */
    public function validate($data, $isUpdate = false, $isUpload = false) {
        $errors = [];
        
        // Validar título
        if (empty($data['title'])) {
            $errors[] = 'O título é obrigatório';
        } elseif (strlen($data['title']) < 3) {
            $errors[] = 'O título deve ter pelo menos 3 caracteres';
        } elseif (strlen($data['title']) > 255) {
            $errors[] = 'O título deve ter no máximo 255 caracteres';
        }
        
        // Validar URL da imagem (apenas se não for upload)
        if (!$isUpload && empty($data['image_url'])) {
            $errors[] = 'A URL da imagem é obrigatória';
        } elseif (!$isUpload && !empty($data['image_url']) && !filter_var($data['image_url'], FILTER_VALIDATE_URL)) {
            $errors[] = 'A URL da imagem deve ser válida';
        }
        
        // Validar categoria (opcional)
        if (!empty($data['category']) && strlen($data['category']) > 100) {
            $errors[] = 'A categoria deve ter no máximo 100 caracteres';
        }
        
        // Validar descrição (opcional)
        if (!empty($data['description']) && strlen($data['description']) > 1000) {
            $errors[] = 'A descrição deve ter no máximo 1000 caracteres';
        }
        
        return $errors;
    }
    
    /**
     * Criar foto
     */
    public function create($data) {
        // Adicionar timestamp de criação
        $data['created_at'] = date('Y-m-d H:i:s');
        
        return parent::create($data);
    }
    
    /**
     * Atualizar foto
     */
    public function update($id, $data) {
        // Adicionar timestamp de atualização
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return parent::update($id, $data);
    }
    
    /**
     * Buscar fotos aleatórias
     */
    public function getRandom($limit = 5) {
        $sql = "SELECT * FROM {$this->table} ORDER BY RAND() LIMIT :limit";
        return $this->db->fetchAll($sql, ['limit' => $limit]);
    }
    
    /**
     * Buscar fotos mais recentes
     */
    public function getRecent($limit = 5) {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC LIMIT :limit";
        return $this->db->fetchAll($sql, ['limit' => $limit]);
    }
    
    /**
     * Fazer upload de foto
     */
    public function uploadPhoto($file, $title, $description = '', $category = '') {
        // Validar arquivo
        $errors = ImageProcessor::validateImage($file);
        if (!empty($errors)) {
            throw new Exception(implode(', ', $errors));
        }
        
        // Validar dados
        $data = [
            'title' => $title,
            'description' => $description,
            'category' => $category
        ];
        
        $validationErrors = $this->validate($data, false, true);
        if (!empty($validationErrors)) {
            throw new Exception(implode(', ', $validationErrors));
        }
        
        // Gerar nome único para o arquivo
        $filename = ImageProcessor::generateUniqueFilename($file['name']);
        $uploadPath = __DIR__ . '/../../public/uploads/photos/' . $filename;
        
        // Redimensionar e salvar imagem (1920x1080)
        $success = ImageProcessor::resizeImage(
            $file['tmp_name'],
            $uploadPath,
            1920,
            1080,
            85
        );
        
        if (!$success) {
            throw new Exception('Erro ao processar a imagem');
        }
        
        // Salvar no banco de dados
        $data['image_url'] = '/uploads/photos/' . $filename;
        $data['created_at'] = date('Y-m-d H:i:s');
        
        return $this->db->insert($this->table, $data);
    }
    
    /**
     * Deletar foto e arquivo
     */
    public function delete($id) {
        // Buscar foto para obter o caminho do arquivo
        $photo = $this->find($id);
        if (!$photo) {
            throw new Exception('Foto não encontrada');
        }
        
        // Deletar arquivo físico
        if (!empty($photo['image_url'])) {
            $filePath = __DIR__ . '/../../public' . $photo['image_url'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
        
        // Deletar do banco de dados
        return parent::delete($id);
    }
    
    /**
     * Atualizar foto com nova imagem
     */
    public function updatePhotoWithImage($id, $file, $title, $description = '', $category = '') {
        // Buscar foto atual
        $currentPhoto = $this->find($id);
        if (!$currentPhoto) {
            throw new Exception('Foto não encontrada');
        }
        
        // Validar arquivo
        $errors = ImageProcessor::validateImage($file);
        if (!empty($errors)) {
            throw new Exception(implode(', ', $errors));
        }
        
        // Validar dados
        $data = [
            'title' => $title,
            'description' => $description,
            'category' => $category
        ];
        
        $validationErrors = $this->validate($data, true, true);
        if (!empty($validationErrors)) {
            throw new Exception(implode(', ', $validationErrors));
        }
        
        // Gerar nome único para o novo arquivo
        $filename = ImageProcessor::generateUniqueFilename($file['name']);
        $uploadPath = __DIR__ . '/../../public/uploads/photos/' . $filename;
        
        // Redimensionar e salvar nova imagem
        $success = ImageProcessor::resizeImage(
            $file['tmp_name'],
            $uploadPath,
            1920,
            1080,
            85
        );
        
        if (!$success) {
            throw new Exception('Erro ao processar a nova imagem');
        }
        
        // Deletar arquivo antigo
        if (!empty($currentPhoto['image_url'])) {
            $oldFilePath = __DIR__ . '/../../public' . $currentPhoto['image_url'];
            if (file_exists($oldFilePath)) {
                unlink($oldFilePath);
            }
        }
        
        // Atualizar dados no banco
        $data['image_url'] = '/uploads/photos/' . $filename;
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        return $this->update($id, $data);
    }
}
