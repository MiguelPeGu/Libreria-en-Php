DROP TABLE IF EXISTS LIBROS;

CREATE TABLE LIBROS (
                        ID INT AUTO_INCREMENT PRIMARY KEY,
                        TITULO VARCHAR(50),
                        AUTOR VARCHAR(50),
                        PVP DECIMAL(6,2)
);

INSERT INTO LIBROS (TITULO, AUTOR, PVP) VALUES
                                            ('El Quijote', 'Cervantes', 33.76),
                                            ('Cien años de soledad', 'Gabriel García Márquez', 20.00),
                                            ('El criptonomicon', 'Cervantes', 54.00);
