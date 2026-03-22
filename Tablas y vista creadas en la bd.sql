/**
TABLAS CREADAS EN LA BD 
postgresql
Script
**/

CREATE TABLE public.productos
(
    id serial NOT NULL,
    producto character varying(100) NOT NULL,
    descripcion text,
    activo boolean NOT NULL DEFAULT true,
    id_users bigint NOT NULL,
    fecha_ins timestamp without time zone NOT NULL DEFAULT now(),
    fecha_upd timestamp without time zone,
    PRIMARY KEY (id)
);

ALTER TABLE IF EXISTS public.productos
    OWNER to postgres;

GRANT ALL ON TABLE public.productos TO learn;

-------------------------------

CREATE TABLE public.categorias
(
    id smallserial NOT NULL,
    categoria character varying(100) NOT NULL,
    activo boolean NOT NULL DEFAULT true,
    id_users bigint NOT NULL,
    fecha_ins timestamp without time zone NOT NULL DEFAULT now(),
    fecha_upd timestamp without time zone,
    PRIMARY KEY (id)
);

ALTER TABLE IF EXISTS public.categorias
    OWNER to postgres;

GRANT ALL ON TABLE public.categorias TO learn;

-------------------------------

CREATE TABLE public.prod_cat
(
    id bigserial NOT NULL,
    id_productos integer NOT NULL,
    id_categorias smallint NOT NULL,
    activo boolean NOT NULL DEFAULT true,
    id_users bigint NOT NULL,
    fecha_ins timestamp without time zone NOT NULL DEFAULT now(),
    fecha_upd timestamp without time zone,
    PRIMARY KEY (id),
    CONSTRAINT fk_prod_cat_prod FOREIGN KEY (id_productos)
        REFERENCES public.productos (id) MATCH SIMPLE
        ON UPDATE RESTRICT
        ON DELETE RESTRICT
        NOT VALID,
    CONSTRAINT fk_prod_cat_cat FOREIGN KEY (id_categorias)
        REFERENCES public.categorias (id) MATCH SIMPLE
        ON UPDATE RESTRICT
        ON DELETE RESTRICT
        NOT VALID
);

ALTER TABLE IF EXISTS public.prod_cat
    OWNER to postgres;

GRANT ALL ON TABLE public.prod_cat TO learn;

COMMENT ON TABLE public.prod_cat
    IS 'Relaciona el productos con sus categorías';

-------------------------------

DROP VIEW IF EXISTS vw_productos_categorias;
CREATE OR REPLACE VIEW vw_productos_categorias AS
SELECT 
    -- 🔹 Campos de productos
    p.id,
    p.producto,
    p.descripcion,
    p.activo AS producto_activo,
    p.id_users AS producto_id_users,
    p.fecha_ins AS producto_fecha_ins,
    p.fecha_upd AS producto_fecha_upd,

    -- 🔹 Categorías concatenadas
    COALESCE(STRING_AGG(c.categoria, ', ' ORDER BY c.categoria), '') AS categorias,
    COALESCE(STRING_AGG(c.categoria, '<br>' ORDER BY c.categoria), '') AS categorias_br,

    -- 🔹 IDs de categorías
    COALESCE(STRING_AGG(c.id::text, ', '), '') AS categorias_ids,

    -- 🔹 Campos de la tabla pivot (agregados)
    COALESCE(STRING_AGG(pc.id::text, ', '), '') AS prod_cat_ids
    --COALESCE(STRING_AGG(pc.activo::text, ', '), '') AS prod_cat_activos,
    --COALESCE(STRING_AGG(pc.id_users::text, ', '), '') AS prod_cat_id_users,
    --COALESCE(STRING_AGG(pc.fecha_ins::text, ', '), '') AS prod_cat_fecha_ins,
    --COALESCE(STRING_AGG(pc.fecha_upd::text, ', '), '') AS prod_cat_fecha_upd

FROM productos p
LEFT JOIN prod_cat pc 
    ON pc.id_productos = p.id
    AND pc.activo = true

LEFT JOIN categorias c 
    ON c.id = pc.id_categorias
    AND c.activo = true

GROUP BY 
    p.id,
    p.producto,
    p.descripcion,
    p.activo,
    p.id_users,
    p.fecha_ins,
    p.fecha_upd;

GRANT SELECT ON TABLE public.vw_productos_categorias TO learn;

------------------------------- RELLENAMOS LOS REGISTROS

-- ============================================
-- 🔹 CATEGORÍAS (7)
-- ============================================

INSERT INTO categorias (categoria, activo, id_users, fecha_ins, fecha_upd) VALUES
('Tecnología', true, 1, NOW(), NOW()),
('Hogar', true, 1, NOW(), NOW()),
('Electrodomésticos', true, 1, NOW(), NOW()),
('Oficina', true, 1, NOW(), NOW()),
('Accesorios', true, 1, NOW(), NOW()),
('Gaming', true, 1, NOW(), NOW()),
('Audio', true, 1, NOW(), NOW());

-- ============================================
-- 🔹 PRODUCTOS (30)
-- ============================================

INSERT INTO productos (producto, descripcion, activo, id_users, fecha_ins, fecha_upd) VALUES
('Mouse Logitech', 'Mouse inalámbrico', true, 1, NOW(), NOW()),
('Teclado Mecánico', 'Teclado RGB', true, 1, NOW(), NOW()),
('Monitor 24"', 'Full HD IPS', true, 1, NOW(), NOW()),
('Notebook Dell', 'Core i7 16GB RAM', true, 1, NOW(), NOW()),
('Auriculares Sony', 'Cancelación de ruido', true, 1, NOW(), NOW()),
('Parlantes Genius', '2.1 sonido envolvente', true, 1, NOW(), NOW()),
('Silla Gamer', 'Ergonómica', true, 1, NOW(), NOW()),
('Escritorio', 'Madera 120cm', true, 1, NOW(), NOW()),
('Impresora HP', 'Multifunción', true, 1, NOW(), NOW()),
('Router TP-Link', 'WiFi 6', true, 1, NOW(), NOW()),
('Smart TV 50"', '4K UHD', true, 1, NOW(), NOW()),
('Heladera Samsung', 'No Frost', true, 1, NOW(), NOW()),
('Microondas LG', 'Digital', true, 1, NOW(), NOW()),
('Cafetera', 'Automática', true, 1, NOW(), NOW()),
('Licuadora', '500W', true, 1, NOW(), NOW()),
('Ventilador', 'Pie 16"', true, 1, NOW(), NOW()),
('Aire Acondicionado', '3000 frigorías', true, 1, NOW(), NOW()),
('Tablet Samsung', '10 pulgadas', true, 1, NOW(), NOW()),
('Smartphone Xiaomi', '128GB', true, 1, NOW(), NOW()),
('Cargador USB', 'Carga rápida', true, 1, NOW(), NOW()),
('Cable HDMI', '2 metros', true, 1, NOW(), NOW()),
('Disco SSD', '1TB', true, 1, NOW(), NOW()),
('Memoria RAM', '16GB DDR4', true, 1, NOW(), NOW()),
('Webcam Logitech', 'Full HD', true, 1, NOW(), NOW()),
('Micrófono', 'Streaming', true, 1, NOW(), NOW()),
('Joystick', 'PC/PS5', true, 1, NOW(), NOW()),
('Consola Xbox', 'Series S', true, 1, NOW(), NOW()),
('Notebook Lenovo', 'Ryzen 5', true, 1, NOW(), NOW()),
('Proyector', 'HDMI', true, 1, NOW(), NOW()),
('Producto Sin Categoria', 'Este queda sin relación', true, 1, NOW(), NOW());

-- ============================================
-- 🔹 RELACIONES (prod_cat)
-- ============================================
-- Asumimos IDs consecutivos desde 1

INSERT INTO prod_cat (id_productos, id_categorias, activo, id_users, fecha_ins, fecha_upd) VALUES

-- Producto 1
(1, 1, true, 1, NOW(), NOW()),
(1, 5, true, 1, NOW(), NOW()),

-- Producto 2
(2, 1, true, 1, NOW(), NOW()),
(2, 4, true, 1, NOW(), NOW()),

-- Producto 3
(3, 1, true, 1, NOW(), NOW()),

-- Producto 4
(4, 1, true, 1, NOW(), NOW()),
(4, 4, true, 1, NOW(), NOW()),

-- Producto 5
(5, 7, true, 1, NOW(), NOW()),
(5, 5, true, 1, NOW(), NOW()),

-- Producto 6
(6, 7, true, 1, NOW(), NOW()),

-- Producto 7
(7, 6, true, 1, NOW(), NOW()),

-- Producto 8
(8, 2, true, 1, NOW(), NOW()),

-- Producto 9
(9, 4, true, 1, NOW(), NOW()),
(9, 1, true, 1, NOW(), NOW()),

-- Producto 10
(10, 1, true, 1, NOW(), NOW()),

-- Producto 11
(11, 3, true, 1, NOW(), NOW()),
(11, 7, true, 1, NOW(), NOW()),

-- Producto 12
(12, 3, true, 1, NOW(), NOW()),
(12, 2, true, 1, NOW(), NOW()),

-- Producto 13
(13, 3, true, 1, NOW(), NOW()),

-- Producto 14
(14, 3, true, 1, NOW(), NOW()),

-- Producto 15
(15, 3, true, 1, NOW(), NOW()),

-- Producto 16
(16, 2, true, 1, NOW(), NOW()),

-- Producto 17
(17, 3, true, 1, NOW(), NOW()),

-- Producto 18
(18, 1, true, 1, NOW(), NOW()),

-- Producto 19
(19, 1, true, 1, NOW(), NOW()),

-- Producto 20
(20, 5, true, 1, NOW(), NOW()),

-- Producto 21
(21, 5, true, 1, NOW(), NOW()),

-- Producto 22
(22, 1, true, 1, NOW(), NOW()),

-- Producto 23
(23, 1, true, 1, NOW(), NOW()),

-- Producto 24
(24, 1, true, 1, NOW(), NOW()),
(24, 4, true, 1, NOW(), NOW()),

-- Producto 25
(25, 7, true, 1, NOW(), NOW()),

-- Producto 26
(26, 6, true, 1, NOW(), NOW()),

-- Producto 27
(27, 6, true, 1, NOW(), NOW()),
(27, 1, true, 1, NOW(), NOW()),

-- Producto 28
(28, 1, true, 1, NOW(), NOW()),

-- Producto 29
(29, 1, true, 1, NOW(), NOW());

-- 🚨 Producto 30 queda SIN categoría (intencional)

