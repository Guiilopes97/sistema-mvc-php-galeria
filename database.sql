-- Script SQL para criar o banco de dados e tabela de exemplo
-- Execute este script no seu servidor MySQL

-- Criar banco de dados
CREATE DATABASE IF NOT EXISTS sistema_mvc CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Usar o banco de dados
USE sistema_mvc;


-- Criar tabela de produtos (exemplo adicional)
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_name (name),
    INDEX idx_price (price)
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Inserir alguns produtos de exemplo
INSERT INTO products (name, description, price, stock) VALUES 
('Notebook Dell', 'Notebook Dell Inspiron 15 3000, Intel Core i5, 8GB RAM, 256GB SSD', 2500.00, 10),
('Mouse Logitech', 'Mouse óptico sem fio Logitech M705', 89.90, 50),
('Teclado Mecânico', 'Teclado mecânico RGB com switches Cherry MX', 450.00, 25),
('Monitor Samsung', 'Monitor LED 24" Full HD Samsung', 899.90, 15),
('Webcam HD', 'Webcam HD 1080p com microfone integrado', 199.90, 30);

-- Criar tabela de fotos
CREATE TABLE IF NOT EXISTS photos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    image_url VARCHAR(500) NOT NULL,
    category VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_category (category),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Inserir fotos de exemplo
INSERT INTO photos (title, description, image_url, category) VALUES 
('Pôr do Sol na Praia', 'Um belo pôr do sol fotografado na praia de Copacabana, Rio de Janeiro. As cores vibrantes do céu se refletem nas águas calmas do oceano.', 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400&h=300&fit=crop', 'Natureza'),
('Arranha-céus Modernos', 'Vista panorâmica dos arranha-céus da cidade de São Paulo durante o pôr do sol. A arquitetura moderna se destaca contra o céu colorido.', 'https://images.unsplash.com/photo-1449824913935-59a10b8d2000?w=400&h=300&fit=crop', 'Arquitetura'),
('Floresta Amazônica', 'Imagem da densa vegetação da Floresta Amazônica, mostrando a biodiversidade única desta região. Árvores centenárias e vegetação exuberante.', 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=400&h=300&fit=crop', 'Natureza'),
('Café da Manhã', 'Delicioso café da manhã com frutas frescas, pães artesanais e café gourmet. Uma refeição nutritiva e saborosa para começar o dia.', 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=400&h=300&fit=crop', 'Culinária'),
('Tecnologia Futurista', 'Conceito de tecnologia futurista com elementos de inteligência artificial e realidade virtual. Representa a evolução tecnológica.', 'https://images.unsplash.com/photo-1518709268805-4e9042af2176?w=400&h=300&fit=crop', 'Tecnologia'),
('Montanhas Nevadas', 'Paisagem deslumbrante das montanhas cobertas de neve. Picos altos e vales profundos criam uma vista espetacular da natureza.', 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=400&h=300&fit=crop', 'Natureza'),
('Arte Urbana', 'Mural colorido em uma parede urbana, representando a cultura e expressão artística das cidades. Grafite moderno com cores vibrantes.', 'https://images.unsplash.com/photo-1541961017774-22349e4a1262?w=400&h=300&fit=crop', 'Arte'),
('Espaço Sideral', 'Imagem impressionante do espaço sideral com nebulosas coloridas e estrelas distantes. A vastidão do universo em toda sua beleza.', 'https://images.unsplash.com/photo-1446776653964-20c1d3a81b06?w=400&h=300&fit=crop', 'Ciência'),
('Cidade Noturna', 'Vista noturna de uma grande cidade com luzes brilhantes e tráfego. Os edifícios iluminados criam um espetáculo visual impressionante.', 'https://images.unsplash.com/photo-1519501025264-65ba15a82390?w=400&h=300&fit=crop', 'Arquitetura'),
('Animais Selvagens', 'Leão majestoso em seu habitat natural na savana africana. A força e beleza dos animais selvagens em seu ambiente natural.', 'https://images.unsplash.com/photo-1546182990-dffeafbe841d?w=400&h=300&fit=crop', 'Animais'),
('Música e Arte', 'Instrumentos musicais clássicos em um estúdio de gravação. A harmonia entre diferentes instrumentos criando melodias únicas.', 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=400&h=300&fit=crop', 'Música'),
('Viagem e Aventura', 'Mochileiro em uma trilha montanhosa com vista panorâmica. A liberdade e aventura de explorar novos lugares e culturas.', 'https://images.unsplash.com/photo-1551632811-561732d1e306?w=400&h=300&fit=crop', 'Viagem'),
('Culinária Gourmet', 'Prato gourmet elaborado com ingredientes frescos e apresentação artística. A arte culinária em sua forma mais refinada.', 'https://images.unsplash.com/photo-1565299624946-b28f40a0ca4b?w=400&h=300&fit=crop', 'Culinária'),
('Esportes Radicais', 'Surfista pegando uma onda perfeita no oceano. A emoção e adrenalina dos esportes radicais em contato com a natureza.', 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=400&h=300&fit=crop', 'Esportes'),
('Arquitetura Histórica', 'Construção histórica com arquitetura clássica e detalhes ornamentais. A beleza e grandiosidade da arquitetura do passado.', 'https://images.unsplash.com/photo-1449824913935-59a10b8d2000?w=400&h=300&fit=crop', 'Arquitetura'),
('Flores Exóticas', 'Jardim com flores exóticas e coloridas em plena floração. A diversidade e beleza da natureza em suas formas mais delicadas.', 'https://images.unsplash.com/photo-1416879595882-3373a0480b5b?w=400&h=300&fit=crop', 'Natureza'),
('Tecnologia Moderna', 'Dispositivos tecnológicos modernos em um ambiente clean e minimalista. A evolução da tecnologia em design elegante.', 'https://images.unsplash.com/photo-1518709268805-4e9042af2176?w=400&h=300&fit=crop', 'Tecnologia'),
('Cultura e Tradição', 'Celebração cultural tradicional com danças e trajes típicos. A riqueza das tradições e costumes de diferentes povos.', 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400&h=300&fit=crop', 'Cultura'),
('Paisagem Rural', 'Cenário bucólico do campo com plantações e animais. A simplicidade e paz da vida rural em harmonia com a natureza.', 'https://images.unsplash.com/photo-1500382017468-9049fed747ef?w=400&h=300&fit=crop', 'Natureza'),
('Moda e Estilo', 'Ensaios fotográficos de moda com looks modernos e criativos. A expressão artística através da moda e estilo pessoal.', 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=400&h=300&fit=crop', 'Moda');
