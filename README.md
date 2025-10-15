# 📸 Sistema MVC PHP - Galeria de Fotos

[![PHP](https://img.shields.io/badge/PHP-7.4+-777BB4?style=flat-square&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-5.7+-4479A1?style=flat-square&logo=mysql&logoColor=white)](https://mysql.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=flat-square&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-green?style=flat-square)](LICENSE)

Um sistema completo de galeria de fotos desenvolvido em PHP seguindo o padrão MVC (Model-View-Controller) com MySQL. Inclui funcionalidades de upload, redimensionamento automático de imagens, paginação e interface moderna com Tailwind CSS.

## ✨ Características Principais

- 🏗️ **Arquitetura MVC** - Separação clara entre Model, View e Controller
- 📤 **Upload de Imagens** - Suporte a múltiplos formatos (JPEG, PNG, GIF, WebP)
- 🔄 **Redimensionamento Automático** - Imagens redimensionadas para 1920x1080 mantendo proporção
- 📱 **Interface Responsiva** - Design moderno com Tailwind CSS adaptado para mobile
- 🔍 **Filtros por Categoria** - Organização e navegação por categorias
- 📄 **Paginação** - 10 fotos por página com navegação
- 🖼️ **Modal de Visualização** - Expansão de fotos com descrição completa
- ⌨️ **Navegação por Teclado** - Setas para navegar entre fotos
- ✏️ **CRUD Completo** - Criar, visualizar, editar e excluir fotos
- 🏷️ **Categorias Personalizadas** - Sistema "Outra" para criar novas categorias
- 🔒 **Segurança** - Proteção contra SQL injection e XSS
- 📊 **APIs JSON** - Endpoints para integração

## 🚀 Demonstração

### Funcionalidades Principais
- **Galeria de Fotos**: Visualização em grid responsivo
- **Upload Inteligente**: Drag & drop com preview
- **Modal Interativo**: Visualização expandida com navegação
- **Filtros Dinâmicos**: Organização por categorias
- **Paginação Moderna**: Navegação fluida entre páginas
- **Edição Completa**: Modificar fotos existentes
- **Exclusão Segura**: Confirmação antes de remover
- **Categorias Flexíveis**: Sistema "Outra" para categorias personalizadas

## 📋 Pré-requisitos

- **PHP 7.4+** com extensões:
  - PDO
  - GD (para processamento de imagens)
  - FileInfo
- **MySQL 5.7+** ou **MariaDB 10.2+**
- **Apache** com mod_rewrite habilitado
- **Composer** (opcional, para dependências)

## 🛠️ Instalação

### 1. Clone o repositório
```bash
git clone https://github.com/guiilopes97/sistema-mvc-php-galeria.git
cd sistema-mvc-php-galeria
```

### 2. Configure o banco de dados
```bash
# Crie um banco de dados MySQL
mysql -u root -p -e "CREATE DATABASE sistema_mvc CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Execute o script SQL
mysql -u root -p sistema_mvc < database.sql
```

### 3. Configure as credenciais
Edite o arquivo `config/database.php`:
```php
private $host = 'localhost';
private $dbname = 'sistema_mvc';
private $username = 'seu_usuario';
private $password = 'sua_senha';
```

### 4. Configure o servidor web

#### Apache (Virtual Host)
```apache
<VirtualHost *:80>
    ServerName galeria.local
    DocumentRoot /caminho/para/projeto/public
    
    <Directory /caminho/para/projeto/public>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

#### Nginx
```nginx
server {
    listen 80;
    server_name galeria.local;
    root /caminho/para/projeto/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

### 5. Permissões
```bash
# Dê permissões de escrita para uploads
chmod 755 public/uploads/photos/
```

## 📁 Estrutura do Projeto

```
sistema-mvc-php-galeria/
├── 📁 app/
│   ├── 📁 controllers/          # Controllers da aplicação
│   │   ├── Controller.php       # Controller base
│   │   ├── HomeController.php   # Página inicial
│   │   └── PhotoController.php  # Gerenciamento de fotos
│   ├── 📁 models/              # Models (camada de dados)
│   │   ├── Model.php           # Model base
│   │   └── Photo.php           # Model de fotos
│   ├── 📁 views/               # Templates (camada de apresentação)
│   │   ├── 📁 layouts/         # Layouts
│   │   │   └── main.php        # Layout principal
│   │   ├── 📁 photos/          # Views de fotos
│   │   │   ├── index.php       # Lista de fotos
│   │   │   ├── create.php      # Upload de fotos
│   │   │   ├── show.php        # Visualização individual
│   │   │   └── edit.php        # Edição de fotos
│   │   └── home.php            # Página inicial
│   ├── ImageProcessor.php      # Processamento de imagens
│   └── autoload.php            # Autoloader de classes
├── 📁 config/
│   └── database.php            # Configuração do banco
├── 📁 public/
│   ├── 📁 uploads/             # Arquivos enviados
│   │   └── 📁 photos/          # Fotos processadas
│   ├── 📁 js/
│   │   └── script.js           # JavaScript customizado
│   ├── index.php              # Ponto de entrada
│   └── .htaccess              # Configurações Apache
├── database.sql               # Script do banco de dados
├── index.php                 # Arquivo de entrada
├── .htaccess                 # Configurações de segurança
└── README.md                 # Este arquivo
```

## 🎯 Funcionalidades Detalhadas

### 📤 Upload de Imagens
- **Formatos Suportados**: JPEG, PNG, GIF, WebP
- **Tamanho Máximo**: 10MB por arquivo
- **Redimensionamento**: Automático para 1920x1080
- **Preservação**: Mantém proporção original
- **Qualidade**: Otimizada para web (85%)

### 🖼️ Galeria de Fotos
- **Grid Responsivo**: 1-4 colunas conforme dispositivo
- **Paginação**: 10 fotos por página
- **Filtros**: Por categoria
- **Modal**: Visualização expandida
- **Navegação**: Teclado e mouse
- **Edição**: Modificar fotos existentes
- **Exclusão**: Remover com confirmação
- **Categorias**: Sistema "Outra" para categorias personalizadas

### ✏️ Gerenciamento de Fotos
- **Edição Completa**: Modificar título, descrição, categoria e imagem
- **Substituição de Imagem**: Upload de nova imagem mantendo dados existentes
- **Categorias Personalizadas**: Sistema "Outra" para criar novas categorias
- **Validação**: Validação client-side e server-side
- **Confirmação**: Confirmação antes de excluir fotos
- **Feedback**: Mensagens de sucesso/erro em tempo real

### 🔒 Segurança
- **SQL Injection**: Proteção via PDO prepared statements
- **XSS**: Sanitização com `htmlspecialchars()`
- **Upload**: Validação de tipo e tamanho
- **Diretórios**: Proteção via .htaccess
- **Execução**: Bloqueio de scripts em uploads
- **Confirmação**: Validação de exclusões destrutivas

## 🌐 APIs Disponíveis

### Listar Fotos
```http
GET /api/photos?page=1&per_page=10&category=Natureza
```

### Listar Categorias
```http
GET /api/photos/categories
```

### Resposta JSON
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": "Pôr do Sol na Praia",
      "description": "Um belo pôr do sol...",
      "image_url": "/uploads/photos/uniqueid_timestamp.jpg",
      "category": "Natureza",
      "created_at": "2024-01-15 10:30:00"
    }
  ],
  "pagination": {
    "current_page": 1,
    "total_pages": 5,
    "total_records": 50,
    "per_page": 10
  }
}
```

## 🎨 Personalização

### Adicionando Novas Categorias
```sql
INSERT INTO photos (title, description, image_url, category) 
VALUES ('Nova Foto', 'Descrição', '/path/to/image.jpg', 'Nova Categoria');
```

### Modificando Dimensões
Edite `app/models/Photo.php`:
```php
// Linha 177-181
$success = ImageProcessor::resizeImage(
    $file['tmp_name'],
    $uploadPath,
    1920,  // Largura
    1080,  // Altura
    85     // Qualidade
);
```

### Customizando Interface
- **Cores**: Edite `app/views/layouts/main.php` (configuração Tailwind)
- **Layout**: Modifique templates em `app/views/`
- **Estilos**: Adicione CSS customizado
- **Responsividade**: Ajuste breakpoints Tailwind (sm, md, lg, xl)

### Responsividade Mobile
- **Breakpoints**: sm (640px+), md (768px+), lg (1024px+), xl (1280px+)
- **Grid Adaptativo**: 1 coluna mobile → 4 colunas desktop
- **Botões Touch**: Tamanhos otimizados para toque
- **Navegação**: Menu adaptado para telas pequenas
- **Formulários**: Layouts empilhados em mobile

## 🧪 Testes

### Teste de Upload
1. Acesse `/photos/create`
2. Selecione uma imagem
3. Preencha título e categoria
4. Verifique redimensionamento

### Teste de Modal
1. Acesse `/photos`
2. Clique em qualquer foto
3. Use setas do teclado para navegar
4. Teste botões de ação

### Teste de Edição
1. Acesse `/photos/{id}`
2. Clique em "Editar Foto"
3. Modifique título, categoria ou imagem
4. Teste categoria "Outra" com nome personalizado
5. Salve as alterações

### Teste de Exclusão
1. Acesse `/photos/{id}`
2. Clique em "Remover Foto"
3. Confirme a exclusão
4. Verifique se a foto foi removida

## 🚀 Deploy

### Produção
1. Configure servidor web (Apache/Nginx)
2. Ajuste permissões de diretórios
3. Configure SSL/HTTPS
4. Otimize configurações PHP
5. Configure backup do banco

### Docker (Opcional)
```dockerfile
FROM php:7.4-apache
RUN docker-php-ext-install pdo pdo_mysql gd
COPY . /var/www/html/
RUN chmod -R 755 /var/www/html/public/uploads/
```

## 📝 Changelog

### v1.0.0 (2024-01-15)
- ✨ Upload de imagens com redimensionamento
- 🎨 Interface moderna com Tailwind CSS
- 📱 Design responsivo para mobile
- 🔍 Filtros por categoria
- 📄 Paginação
- 🖼️ Modal de visualização
- ⌨️ Navegação por teclado
- ✏️ Funcionalidades de edição/exclusão
- 🏷️ Sistema de categorias personalizadas
- 🔒 Implementação de segurança
- 📊 APIs JSON

## 📄 Licença

Este projeto está licenciado sob a **MIT License** - veja o arquivo [LICENSE](LICENSE) para detalhes.

## 👨‍💻 Autor

**Guilherme Lopes de Oliveira**
- GitHub: [@Guiilopes97](https://github.com/Guiilopes97)
- LinkedIn: [Guilherme Lopes de Oliveira](https://www.linkedin.com/in/guilherme-lopes-de-oliveira/)
- Email: glopes.tech@gmail.com

<div align="center">

**⭐ Se este projeto foi útil, considere dar uma estrela! ⭐**

</div>
