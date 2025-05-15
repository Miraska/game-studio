-- Создание базы данных
CREATE DATABASE IF NOT EXISTS gamestudio CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE gamestudio;

-- Таблица пользователей
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'instructor', 'student') DEFAULT 'student',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_active BOOLEAN DEFAULT TRUE
);

-- Таблица курсов
CREATE TABLE courses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    lessons_count INT NOT NULL,
    level ENUM('beginner', 'intermediate', 'advanced') NOT NULL,
    image_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_active BOOLEAN DEFAULT TRUE
);

-- Таблица уроков
CREATE TABLE lessons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    course_id INT NOT NULL,
    title VARCHAR(100) NOT NULL,
    content TEXT NOT NULL,
    order_number INT NOT NULL,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

-- Таблица покупок курсов
CREATE TABLE purchases (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    course_id INT NOT NULL,
    purchase_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    price_paid DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

-- Таблица отзывов
CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    course_id INT NOT NULL,
    rating INT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

-- Вставка тестовых данных
INSERT INTO users (username, email, password, role) VALUES 
('admin', 'admin@gamestudio.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('instructor1', 'instructor1@gamestudio.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'instructor'),
('student1', 'student1@gamestudio.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student');

INSERT INTO courses (title, description, price, lessons_count, level, image_path) VALUES
('Unity - Junior', 'Базовый курс по Unity для начинающих', 3500.00, 6, 'beginner', '1.png'),
('Unity - Middle', 'Продвинутый курс по Unity', 4500.00, 8, 'intermediate', '2.jpeg'),
('Unity - Senior', 'Профессиональный курс по Unity', 5500.00, 12, 'advanced', '3.webp');

INSERT INTO lessons (course_id, title, content, order_number) VALUES
(1, 'Введение в Unity', 'Основные понятия и интерфейс Unity', 1),
(1, 'Создание первого проекта', 'Создание простой 2D игры', 2),
(2, 'Продвинутые техники', 'Оптимизация и продвинутые скрипты', 1),
(3, 'Профессиональная разработка', 'Создание коммерческих проектов', 1);

INSERT INTO purchases (user_id, course_id, price_paid) VALUES
(3, 1, 3500.00),
(3, 2, 4500.00);

INSERT INTO reviews (user_id, course_id, rating, comment) VALUES
(3, 1, 5, 'Отличный курс для начинающих!'),
(3, 2, 4, 'Много полезной информации, но некоторые темы сложные');