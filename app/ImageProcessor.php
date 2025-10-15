<?php

/**
 * Classe para processamento de imagens
 * Responsável por redimensionar e otimizar imagens
 */
class ImageProcessor {
    
    /**
     * Redimensionar imagem mantendo proporção
     * 
     * @param string $sourcePath Caminho da imagem original
     * @param string $destinationPath Caminho de destino
     * @param int $targetWidth Largura desejada
     * @param int $targetHeight Altura desejada
     * @param int $quality Qualidade JPEG (1-100)
     * @return bool
     */
    public static function resizeImage($sourcePath, $destinationPath, $targetWidth, $targetHeight, $quality = 85) {
        // Verificar se o arquivo existe
        if (!file_exists($sourcePath)) {
            throw new Exception('Arquivo de imagem não encontrado');
        }
        
        // Obter informações da imagem
        $imageInfo = getimagesize($sourcePath);
        if ($imageInfo === false) {
            throw new Exception('Arquivo não é uma imagem válida');
        }
        
        $originalWidth = $imageInfo[0];
        $originalHeight = $imageInfo[1];
        $mimeType = $imageInfo['mime'];
        
        // Criar imagem a partir do arquivo
        $sourceImage = self::createImageFromFile($sourcePath, $mimeType);
        if ($sourceImage === false) {
            throw new Exception('Não foi possível criar a imagem');
        }
        
        // Calcular novas dimensões mantendo proporção
        $dimensions = self::calculateDimensions($originalWidth, $originalHeight, $targetWidth, $targetHeight);
        
        // Criar nova imagem
        $newImage = imagecreatetruecolor($targetWidth, $targetHeight);
        
        // Preservar transparência para PNG
        if ($mimeType === 'image/png') {
            imagealphablending($newImage, false);
            imagesavealpha($newImage, true);
            $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
            imagefill($newImage, 0, 0, $transparent);
        } else {
            // Fundo branco para outros formatos
            $white = imagecolorallocate($newImage, 255, 255, 255);
            imagefill($newImage, 0, 0, $white);
        }
        
        // Redimensionar imagem
        imagecopyresampled(
            $newImage, $sourceImage,
            $dimensions['x'], $dimensions['y'], 0, 0,
            $dimensions['width'], $dimensions['height'],
            $originalWidth, $originalHeight
        );
        
        // Salvar imagem
        $result = self::saveImage($newImage, $destinationPath, $mimeType, $quality);
        
        // Limpar memória
        imagedestroy($sourceImage);
        imagedestroy($newImage);
        
        return $result;
    }
    
    /**
     * Criar imagem a partir do arquivo
     */
    private static function createImageFromFile($path, $mimeType) {
        switch ($mimeType) {
            case 'image/jpeg':
                return imagecreatefromjpeg($path);
            case 'image/png':
                return imagecreatefrompng($path);
            case 'image/gif':
                return imagecreatefromgif($path);
            case 'image/webp':
                return imagecreatefromwebp($path);
            default:
                return false;
        }
    }
    
    /**
     * Calcular dimensões mantendo proporção
     */
    private static function calculateDimensions($originalWidth, $originalHeight, $targetWidth, $targetHeight) {
        // Calcular proporção original
        $originalRatio = $originalWidth / $originalHeight;
        $targetRatio = $targetWidth / $targetHeight;
        
        if ($originalRatio > $targetRatio) {
            // Imagem mais larga - ajustar pela largura
            $newWidth = $targetWidth;
            $newHeight = $targetWidth / $originalRatio;
        } else {
            // Imagem mais alta - ajustar pela altura
            $newHeight = $targetHeight;
            $newWidth = $targetHeight * $originalRatio;
        }
        
        // Centralizar imagem
        $x = ($targetWidth - $newWidth) / 2;
        $y = ($targetHeight - $newHeight) / 2;
        
        return [
            'width' => $newWidth,
            'height' => $newHeight,
            'x' => $x,
            'y' => $y
        ];
    }
    
    /**
     * Salvar imagem
     */
    private static function saveImage($image, $path, $mimeType, $quality) {
        // Criar diretório se não existir
        $dir = dirname($path);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        switch ($mimeType) {
            case 'image/jpeg':
                return imagejpeg($image, $path, $quality);
            case 'image/png':
                return imagepng($image, $path, 9);
            case 'image/gif':
                return imagegif($image, $path);
            case 'image/webp':
                return imagewebp($image, $path, $quality);
            default:
                return false;
        }
    }
    
    /**
     * Validar arquivo de imagem
     */
    public static function validateImage($file) {
        $errors = [];
        
        // Verificar se é um upload válido
        if (!isset($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
            $errors[] = 'Arquivo não foi enviado corretamente';
            return $errors;
        }
        
        // Verificar erros de upload
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errors[] = 'Erro no upload: ' . self::getUploadErrorMessage($file['error']);
            return $errors;
        }
        
        // Verificar tamanho do arquivo (máximo 10MB)
        if ($file['size'] > 10 * 1024 * 1024) {
            $errors[] = 'Arquivo muito grande. Máximo permitido: 10MB';
        }
        
        // Verificar tipo MIME
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        
        if (!in_array($mimeType, $allowedTypes)) {
            $errors[] = 'Tipo de arquivo não permitido. Use: JPEG, PNG, GIF ou WebP';
        }
        
        // Verificar se é uma imagem válida
        $imageInfo = getimagesize($file['tmp_name']);
        if ($imageInfo === false) {
            $errors[] = 'Arquivo não é uma imagem válida';
        }
        
        return $errors;
    }
    
    /**
     * Obter mensagem de erro de upload
     */
    private static function getUploadErrorMessage($error) {
        switch ($error) {
            case UPLOAD_ERR_INI_SIZE:
                return 'Arquivo excede o tamanho máximo permitido pelo servidor';
            case UPLOAD_ERR_FORM_SIZE:
                return 'Arquivo excede o tamanho máximo permitido pelo formulário';
            case UPLOAD_ERR_PARTIAL:
                return 'Upload foi interrompido';
            case UPLOAD_ERR_NO_FILE:
                return 'Nenhum arquivo foi enviado';
            case UPLOAD_ERR_NO_TMP_DIR:
                return 'Diretório temporário não encontrado';
            case UPLOAD_ERR_CANT_WRITE:
                return 'Falha ao escrever arquivo no disco';
            case UPLOAD_ERR_EXTENSION:
                return 'Upload bloqueado por extensão';
            default:
                return 'Erro desconhecido';
        }
    }
    
    /**
     * Gerar nome único para arquivo
     */
    public static function generateUniqueFilename($originalName) {
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $filename = uniqid() . '_' . time() . '.' . $extension;
        return $filename;
    }
}
