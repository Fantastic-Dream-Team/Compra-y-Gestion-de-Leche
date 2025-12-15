CREATE DATABASE donjoaquin;
USE donjoaquin;

CREATE TABLE productores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    finca VARCHAR(255) NOT NULL,
    foto VARCHAR(255) NOT NULL,  
    ubicacion VARCHAR(255) NOT NULL,
    especialidad VARCHAR(255) NOT NULL,
    produccion VARCHAR(50) NOT NULL,  
    salud_animal VARCHAR(100) NOT NULL,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE usuarios_productor (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_productor INT NOT NULL,
    nombre_usuario VARCHAR(35) NOT NULL UNIQUE,
    contrasenia VARCHAR(255) NOT NULL,
    codigo_productor VARCHAR(30) UNIQUE,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_productor) REFERENCES productores(id) ON DELETE CASCADE
);

CREATE TABLE entregas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_usuario_productor INT NOT NULL,
    litros DECIMAL(10,2) NOT NULL,
    calidad VARCHAR(50) NOT NULL,
    fecha DATE NOT NULL,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,  
    FOREIGN KEY (id_usuario_productor) REFERENCES usuarios_productor(id) ON DELETE CASCADE
);

-- Comentario: Nueva tabla para categorías de productos (e.g., Quesos, Yogurts, Mousse). Esto permite categorizar dinámicamente.
CREATE TABLE categorias_productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE,  -- e.g., 'Quesos'
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Comentario: Nueva tabla para productos. Cada producto tiene nombre, descripción, imagen y referencia a categoría.
CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categoria_id INT NOT NULL,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT NOT NULL,
    imagen VARCHAR(255) NOT NULL,  -- Ruta relativa, e.g., 'assets/images/Productos/queso-brie.jpg'
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (categoria_id) REFERENCES categorias_productos(id) ON DELETE CASCADE
);

-- Comentario: Nueva tabla para tipos de posts (e.g., 'blog' o 'receta'). Similar a categorías.
CREATE TABLE tipos_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE,  -- e.g., 'Blog', 'Receta'
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Comentario: Nueva tabla para posts de blog/recetas. Cada post tiene título, contenido, imagen y tipo.
CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo_id INT NOT NULL,
    titulo VARCHAR(200) NOT NULL,
    contenido TEXT NOT NULL,
    imagen VARCHAR(255) NOT NULL,  -- Ruta relativa, e.g., 'assets/images/post/queso-artesanal.jpg'
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tipo_id) REFERENCES tipos_posts(id) ON DELETE CASCADE
);

-- Comentario: Inserts de ejemplo para categorías de productos (basado en tu wireframe estático).
INSERT INTO categorias_productos (nombre) VALUES ('Quesos'), ('Yogurts'), ('Mousse');

-- Comentario: Inserts de ejemplo para productos (basado en tu contenido estático; ajusta rutas de imágenes si cambian).
INSERT INTO productos (categoria_id, nombre, descripcion, imagen) VALUES
(1, 'Brie Artesanal', 'Queso blando de corteza florida, cremoso y con delicado sabor a nuez.', 'assets/images/Productos/queso-brie.jpg'),
(1, 'Camembert Tradicional', 'Textura cremosa y aroma intenso. Perfecto para derretir o disfrutar solo.', 'assets/images/Productos/queso-camembert.jpg'),
(1, 'Queso Fresco de Vaca', 'Suave, ligeramente salado. Ideal para ensaladas, tacos y postres.', 'assets/images/Productos/queso-fresco.jpg'),
(1, 'Gouda Ahumado', 'Curado y ahumado naturalmente con madera de encino. Sabor profundo.', 'assets/images/Productos/queso-gouda.jpg'),
(2, 'Yogur con Fresa', 'Yogur cremoso batido con trozos de fresa fresca natural.', 'assets/images/Productos/yogur-fresa.jpg'),
(2, 'Yogur Griego Frutos Rojos', 'Extra espeso con mermelada casera de frutos del bosque.', 'assets/images/Productos/yogur-frutosrojos.jpg'),
(2, 'Yogur Natural Entero', '100% natural, sin azúcar añadida. Ideal para desayunos saludables.', 'assets/images/Productos/yogur-natural.jpg'),
(2, 'Yogur Cremoso Vainilla', 'Sabor suave a vainilla bourbon. Perfecto como postre ligero.', 'assets/images/Productos/yogur-vainilla.jpg'),
(3, 'Mousse de Fresa', 'Delicado mousse de yogur natural con fresas frescas y miel.', 'assets/images/Productos/mousse-fresa.jpg'),
(3, 'Mousse de Vainilla', 'Crema suave de vainilla con caramelo artesanal por encima.', 'assets/images/Productos/mousse-vainilla.jpg'),
(3, 'Mousse de Mora Azul', 'Intenso sabor a mora silvestre. ¡Nuestro best-seller!', 'assets/images/Productos/mousse-mora.jpg'),
(3, 'Mousse de Chocolate', 'Chocolate amargo 70% con crema de leche fresca. Irresistible.', 'assets/images/Productos/mousse-chocolate.jpg');

-- Comentario: Inserts de ejemplo para tipos de posts.
INSERT INTO tipos_posts (nombre) VALUES ('Blog'), ('Receta');

-- Comentario: Inserts de ejemplo para posts (basado en tu Blog.html estático; ajusta contenido/imágenes).
INSERT INTO posts (tipo_id, titulo, contenido, imagen) VALUES
(2, 'Yogur Casero con Frutas', 'Ingredientes: yogur, frutas frescas... Pasos: Mezcla todo.', 'assets/images/post/yogur-casero-frutas.jpg'),
(1, 'Beneficios de los Lácteos', 'Los lácteos aportan calcio y proteínas...', 'assets/images/post/beneficios-lacteos.jpg'),
(2, 'Pastel de Queso', 'Receta fácil para un pastel cremoso...', 'assets/images/post/pastel-queso.jpg'),
(1, 'Historia de la Leche', 'Desde las vacas hasta tu mesa...', 'assets/images/post/historia-leche.jpg'),
(2, 'Batido de Yogur', 'Refrescante y nutritivo...', 'assets/images/post/batido-yogur.jpg');