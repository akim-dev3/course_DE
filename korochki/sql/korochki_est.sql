-- База для портала "Корочки.есть"
-- Импортировать через phpMyAdmin или mysql -u root korochki_est < korochki_est.sql

CREATE DATABASE IF NOT EXISTS korochki_est DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE korochki_est;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    login VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    fio VARCHAR(150) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    course VARCHAR(120) NOT NULL,
    start_date DATE NOT NULL,
    payment VARCHAR(40) NOT NULL,
    status VARCHAR(30) NOT NULL DEFAULT 'Новая',
    review TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- индексы под фильтрацию в админке (модуль 3)
CREATE INDEX idx_status ON requests(status);
CREATE INDEX idx_course ON requests(course);
