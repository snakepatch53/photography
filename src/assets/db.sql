-- empresa
DROP TABLE IF EXISTS info;

CREATE TABLE info (
    info_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    info_name VARCHAR(100),
    info_email VARCHAR(30),
    info_services TEXT
) ENGINE = InnoDB;

INSERT INTO
    info
VALUES
    (
        1,
        "Photography",
        "info@gmail.com",
        "Albums de Fotografia.."
    );

-- contact
DROP TABLE IF EXISTS contact;

CREATE TABLE contact (
    contact_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    contact_name VARCHAR(100),
    contact_link VARCHAR(100),
    contact_icon VARCHAR(50),
    contact_color VARCHAR(50)
) ENGINE = InnoDB;

-- user
DROP TABLE IF EXISTS user;

CREATE TABLE user (
    user_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    user_name VARCHAR(100),
    user_photo VARCHAR(100),
    user_user VARCHAR(100),
    user_pass VARCHAR(100),
    user_type INT(1)
) ENGINE = InnoDB;

INSERT INTO
    user
VALUES
    (
        1,
        "Administrador",
        null,
        "admin",
        "admin",
        1
    ),
    (
        2,
        "Root",
        null,
        "hhfpro",
        "p9SMez&2Fe0A",
        1
    );

-- client
DROP TABLE IF EXISTS client;

CREATE TABLE client (
    client_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    client_name VARCHAR(100),
    client_phone VARCHAR(12),
    client_photo VARCHAR(100),
    client_fb TEXT,
    client_mail VARCHAR(60),
    client_descr TEXT,
    client_create VARCHAR(40)
) ENGINE = InnoDB;

-- category
DROP TABLE IF EXISTS category;

CREATE TABLE category (
    category_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    category_name VARCHAR(50),
    category_descr TEXT,
    category_photo VARCHAR(100)
) ENGINE = InnoDB;

-- album
DROP TABLE IF EXISTS album;

CREATE TABLE album (
    album_id INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    album_name VARCHAR(50),
    album_descr TEXT,
    album_create VARCHAR(40),
    album_photo VARCHAR(100),
    album_path TEXT,
    album_photos_picked JSON,
    category_id INT,
    client_id INT,
    FOREIGN KEY (category_id) REFERENCES category (category_id) ON DELETE CASCADE,
    FOREIGN KEY (client_id) REFERENCES client (client_id) ON DELETE CASCADE
) ENGINE = InnoDB;