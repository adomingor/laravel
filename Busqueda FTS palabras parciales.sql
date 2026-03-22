                    PARA INVENTORY ITEMS POR EJEMPLO

SELECT * 
FROM inventory_items
WHERE 
  -- Búsqueda Normal (Prefijos)
  to_tsvector('simple', unaccent(concat(name, ' ', description))) 
    @@ to_tsquery('simple', regexp_replace(unaccent('esponj progra'), '\s+', ':* | ', 'g') || ':*')
  OR 
  -- Búsqueda Reversa (Sufijos)
  to_tsvector('simple', reverse(unaccent(concat(name, ' ', description)))) 
    @@ to_tsquery('simple', regexp_replace(reverse(unaccent('tos tazo')), '\s+', ':* | ', 'g') || ':*');

------------------------------------------------------------------------------------
                            Idea general!!!!!
------------------------------------------------------------------------------------
1- Crear un campo en las tablas que se quiera usar este tipo de búsqueda que se llame busca_fts por ejemplo en todas las tablas para no cambiar en el controlador si el crud está personalizado

2- Crear un indice para q la búsqueda sea rápida (o solo crear un indice y al campo rellenarlo con las palabras normal y con reverse)
            -- Índice para prefijos (comienzo de palabra)
            CREATE INDEX idx_fts_simple ON mi_tabla 
            USING GIN (to_tsvector('simple', busca_fts));


3- A ese campo rellenarlo con los datos de las columnas que quiero tanto un trigger cuando se hace un insert o delete
    Ej. 
        update inventory_items set busca_fts = to_tsvector(unaccent(concat (name , ' ', description, reverse(name), ' ', reverse(description))))

            consulta simplificada
        select * from inventory_items 
        where busca_fts @@ to_tsquery('simple', regexp_replace(unaccent(cast(concat('tos tazo espon', ' ', reverse('tos tazo espon')) as text)), '\s+', ':* | ', 'g') || ':*')        

4- Se creo una función para la consulta

CREATE OR REPLACE FUNCTION busca_fts(
    tabla_ejemplo anyelement, 
    palabras_busqueda text
)
RETURNS SETOF anyelement AS $$
DECLARE
    tsquery_final text;
    nombre_tabla text := quote_ident(pg_typeof(tabla_ejemplo)::text);
BEGIN
    -- Generamos el tsquery usando tu regex y concatenando el reverso
    tsquery_final := regexp_replace(
                        unaccent(
                            concat(palabras_busqueda, ' ', reverse(palabras_busqueda))
                        ), 
                        '\s+', ':* | ', 'g'
                     ) || ':*';

    -- Ejecutamos la consulta dinámica sobre la columna busca_fts
    RETURN QUERY EXECUTE format(
        'SELECT * FROM %s WHERE busca_fts @@ to_tsquery(''simple'', %L)', 
        nombre_tabla, 
        tsquery_final
    );
END;
$$ LANGUAGE plpgsql;

Modo se uso
SELECT * FROM busca_fts(NULL::inventory_items, 'tazo vainilla tos');

5- Creación del trigger para mantener el campo de búsqueda

CREATE OR REPLACE FUNCTION trg_busca_fts_inventory_items()
RETURNS trigger AS $$
BEGIN
    NEW.busca_fts := to_tsvector('simple', 
        unaccent(
            concat(
                NEW.name, ' ', 
                NEW.description, ' ', 
                reverse(NEW.name), ' ', 
                reverse(NEW.description)
            )
        )
    );
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trg_inventory_items_busca_fts
BEFORE INSERT OR UPDATE ON public.inventory_items
FOR EACH ROW
EXECUTE FUNCTION trg_busca_fts_inventory_items();
