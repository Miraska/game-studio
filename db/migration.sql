DROP DATABASE IF EXISTS gamestudio;
CREATE DATABASE gamestudio CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE gamestudio;

/* ---------- USERS ---------- */
CREATE TABLE users (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  name        VARCHAR(100)  NOT NULL,
  email       VARCHAR(120)  NOT NULL UNIQUE,
  password    VARCHAR(255)  NOT NULL,
  role        ENUM('user','admin') DEFAULT 'user',
  created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

/* ---------- COURSES ---------- */
CREATE TABLE courses (
  id          INT AUTO_INCREMENT PRIMARY KEY,
  title       VARCHAR(150)  NOT NULL,
  description TEXT          NOT NULL,
  price       INT           NOT NULL,       -- ₽
  lessons_cnt INT           DEFAULT 0,
  level       ENUM('junior','middle','senior','gamedesign') DEFAULT 'junior',
  image       VARCHAR(255)  DEFAULT 'images/courses/default.png',
  created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

/* ---------- ORDERS (покупка курсов) ---------- */
CREATE TABLE orders (
  id           INT AUTO_INCREMENT PRIMARY KEY,
  user_id      INT NOT NULL,
  course_id    INT NOT NULL,
  status       ENUM('pending','accepted','declined') DEFAULT 'pending',
  ordered_at   TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id)   REFERENCES users(id)   ON DELETE CASCADE,
  FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

/* ---------- REVIEWS ---------- */
CREATE TABLE reviews (
  id        INT AUTO_INCREMENT PRIMARY KEY,
  user_id   INT NOT NULL,
  course_id INT NOT NULL,
  text      TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id)   REFERENCES users(id)   ON DELETE CASCADE,
  FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE
);

/* ---------- DEMO‑ДАННЫЕ ---------- */
INSERT INTO users (name,email,password,role)
VALUES ('Админ','admin@demo.ru', SHA2('admin',256), 'admin');

INSERT INTO courses (title,description,price,lessons_cnt,level,image)
VALUES
 ('Unity – Junior','Базовый курс по Unity для начинающих',3500,6,'junior','images/courses/1.png'),
 ('Unity – Middle','Углублённый курс по Unity',4500,12,'middle','images/courses/2.jpeg'),
 ('Low Poly Игры','Создание low‑poly окружений',4000,8,'senior','images/courses/3.png');
