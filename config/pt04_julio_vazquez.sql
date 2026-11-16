-- Crea la base de datos solo si todavía no existe.
CREATE DATABASE IF NOT EXISTS `pt04_julio_vazquez`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

-- Selecciona la base de datos donde se crearán la tabla y los datos de ejemplo.
USE `pt04_julio_vazquez`;

-- Asegura la codificación correcta de acentos, símbolos y del signo del euro.
SET NAMES utf8mb4;

-- Eliminar la tabla previa si existe para limpiar tablas huérfanas.
-- Esta instrucción queda desactivada para conservar los datos ya guardados.
--  DROP TABLE IF EXISTS `articles`;

-- Crea la tabla de artículos si aún no existe.
CREATE TABLE IF NOT EXISTS `articles` (
    -- Identificador numérico único que aumenta automáticamente.
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    -- Nombre de la joya, con un máximo de 255 caracteres.
    `titol` VARCHAR(255) NOT NULL,
    -- Descripción de la joya: material, acabado, etc.
    `cos` TEXT NOT NULL,
    -- Precio de venta en euros.
    `preu` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    -- URL de la imagen principal de la joya.
    `imatge` VARCHAR(500) NULL DEFAULT NULL,
    -- Impide guardar dos artículos con el mismo título.
    UNIQUE KEY `uq_articles_titol` (`titol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Inserta las joyas de muestra y actualiza sus datos si el título ya existe.
-- ON DUPLICATE KEY UPDATE mantiene la inicialización idempotente:
-- Database::inicialize() ejecuta este archivo en cada petición.
INSERT INTO `articles` (`titol`, `cos`, `preu`, `imatge`) VALUES
('Anillo Solitario Diamond Sparkle', 'Anillo solitario en oro blanco de 18 quilates con diamante central de 0,50 quilates y engaste de cuatro garras. Acabado pulido brillante y talla ajustable.', 450.00, 'https://images.unsplash.com/photo-1605100804763-247f67b3557e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'),
('Pulsera Rígida Titanio Black', 'Pulsera rígida de titanio con acabado negro mate y cierre de presión. Diseño minimalista, ligero y resistente al desgaste.', 290.00, 'https://images.unsplash.com/photo-1573408301185-9146fe634ad0?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'),
('Anillo Compromiso Gold Royale', 'Anillo de compromiso en oro amarillo de 18 quilates con diamante talla esmeralda y acabado brillante. Presentación en estuche de terciopelo.', 1250.00, 'https://images.unsplash.com/photo-1598560917807-1bae44bd2be8?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'),
('Collar Perlas Aurora', 'Collar de perlas cultivadas de agua dulce con cierre de plata de ley 925. Perlas de tono marfil y brillo natural, ideal para ocasiones especiales.', 180.00, 'https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'),
('Pendientes Gota Esmeralda', 'Pendientes de gota en oro rosa de 18 quilates con piedra central facetada y halo de circonitas. Cierre de presión seguro y acabado pulido.', 620.00, 'https://images.unsplash.com/photo-1629224316810-9d8805b95e76?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'),
('Anillo Triple Halo', 'Anillo en oro rosa de 18 quilates con tres halos de diamantes talla brillante. Diseño elegante y luminoso para el día a día.', 890.00, 'https://images.unsplash.com/photo-1631982690223-8aa4be0a2497?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'),
('Brazalete Cadena Marina', 'Brazalete de plata de ley 925 con eslabones tipo marino y cierre de mosquetón. Acabado pulido y longitud ajustable.', 95.00, 'https://images.unsplash.com/photo-1602173574767-37ac01994b2a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'),
('Collar Luna de Plata', 'Collar de plata de ley 925 con colgante en forma de corazón y circonitas blancas. Cadena fina ajustable de 40 a 45 centímetros.', 140.00, 'https://images.unsplash.com/photo-1588444837495-c6cfeb53f32d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'),
('Aretes Estrella Brillante', 'Aretes en oro blanco de 18 quilates con zafiros azules en forma de gota y circonitas laterales. Cierre de tornillo y acabado de alto brillo.', 380.00, 'https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'),
('Sortija Vintage Rubí', 'Sortija de estilo vintage en oro rosa de 18 quilates con piedra central rosa y halo de diamantes. Pieza inspirada en diseños clásicos.', 740.00, 'https://images.unsplash.com/photo-1603561591411-07134e71a2a9?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'),
('Pulsera Tejida Oro', 'Pulsera de eslabones tejidos en oro de 18 quilates con acabado brillante y cierre de seguridad. Textura flexible y elegante.', 1050.00, 'https://images.unsplash.com/photo-1611591437281-460bfbe1220a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'),
('Collar Zafiro Eterno', 'Collar en plata de ley con colgante redondo de diamantes y cadena de eslabones finos. Incluye certificado de autenticidad.', 1480.00, 'https://images.unsplash.com/photo-1598560917505-59a3ad559071?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'),
('Pendientes Aro Clásico', 'Pendientes de aro en oro de 18 quilates con acabado pulido. Diámetro medio y cierre de bisagra, ligeros y cómodos.', 45.00, 'https://images.unsplash.com/photo-1617038220319-276d3cfab638?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'),
('Anillo Sencillo Platino', 'Anillo de platino de 950 milésimas con acabado mate y perfil redondeado. Diseño unisex y atemporal.', 520.00, 'https://images.unsplash.com/photo-1627293509201-cd0c780043e6?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'),
('Gargantilla Perla Blanca', 'Gargantilla con colgante de perla blanca y cadena dorada ajustable. Cierre de langosta y acabado elegante.', 210.00, 'https://images.unsplash.com/photo-1611085583191-a3b181a88401?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'),
('Brazalete Esclava Oro', 'Brazalete estilo esclava en oro de 18 quilates con acabado pulido y apertura lateral. Diseño sólido y atemporal.', 980.00, 'https://images.unsplash.com/photo-1611591437281-460bfbe1220a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'),
('Anillo Eternity Diamantes', 'Anillo eternity en oro blanco de 18 quilates con diamantes talla brillante en todo el contorno. Montura de garras y acabado de lujo.', 2100.00, 'https://images.unsplash.com/photo-1605100804763-247f67b3557e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'),
('Pendientes Coral Mediterráneo', 'Pendientes en oro de 18 quilates con piedras azules en forma de corazón. Cierre de gancho y acabado artesanal.', 430.00, 'https://images.unsplash.com/photo-1630019852942-f89202989a59?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'),
('Colgante Trébol Diamante', 'Colgante en oro amarillo de 18 quilates con piedra central verde y cadena de eslabones. Incluye cadena de 45 centímetros.', 340.00, 'https://images.unsplash.com/photo-1599643477877-530eb83abc8e?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'),
('Anillo Ópalo Mágico', 'Anillo en oro rosa de 18 quilates con ópalo de fuego en talla cabujón. Cada piedra tiene un juego de colores único.', 560.00, 'https://images.unsplash.com/photo-1603561591411-07134e71a2a9?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'),
('Pulsera Charm Personalizada', 'Pulsera de plata de ley 925 con cadena de bolas y espacio para charms personalizados. Cierre de mosquetón y longitud ajustable.', 75.00, 'https://images.unsplash.com/photo-1596944924616-7b38e7cfac36?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'),
('Collar Cadena Veneciana', 'Collar de cadena veneciana en oro de 18 quilates con acabado pulido. Longitud de 50 centímetros y cierre de langosta.', 870.00, 'https://images.unsplash.com/photo-1601121141461-9d6647bca1ed?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'),
('Aretes Perla Clásica', 'Aretes con perla cultivada de tono blanco y acabado dorado. Cierre de presión y diseño atemporal.', 320.00, 'https://images.unsplash.com/photo-1617038260897-41a1f14a8ca0?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80'),
('Anillo Zafiro Imperial', 'Anillo en oro de 18 quilates con piedra central rosa en talla cojín y halo de diamantes. Pieza exclusiva con certificado gemológico.', 1750.00, 'https://images.unsplash.com/photo-1603561591411-07134e71a2a9?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80')
ON DUPLICATE KEY UPDATE
    `cos` = VALUES(`cos`),
    `preu` = VALUES(`preu`),
    `imatge` = VALUES(`imatge`);
