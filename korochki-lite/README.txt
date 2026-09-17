Корочки.есть — облегчённая версия (запасной план на «4»)
Демонстрационный экзамен, 09.02.07

Стек: PHP 8 (PDO, без классов — обычные функции), MySQL, Bootstrap 5 (только CSS), чистый JS

=== Установка ===
1. Скопировать папку в htdocs (XAMPP) или domains (OpenServer)
2. Создать базу: phpMyAdmin -> Импорт -> sql/korochki_est.sql
   (или mysql -u root korochki_est < sql/korochki_est.sql)
3. При необходимости поправить доступ к БД в init.php (по умолчанию root без пароля)
4. Открыть http://localhost/korochki-lite/

=== Вход ===
Админ:        Admin / KorokNET
Пользователь: регистрация через форму на сайте

=== Чем отличается от полной версии (korochki.zip) ===
- Нет классов User/Request — вместо них includes/db.php с обычными функциями.
- Нет автозагрузки (spl_autoload_register) — db.php подключается через require в init.php.
- В админке нет пагинации (фильтр по статусу и флеш-сообщение остались).
- В header.php нет бургер-меню и bootstrap.bundle.min.js — простая навигация на flex-wrap.
- В main.js нет масок телефона/даты и автоскрытия уведомления — только слайдер.
- В style.css нет теней и hover-эффектов (fadeUp-анимация и адаптив 390px оставлены).
- Без изменений: includes/validators.php, logout.php, index.php.

Подробное объяснение каждого упрощения и честная оценка риска по баллам —
на странице «Запасной план (лёгкая версия, на «4»)» в index.html (курс).

=== Структура ===
init.php              - подключение к БД, общие данные ($courses, $payments, $statuses)
includes/db.php        - работа с БД: isLoginTaken, registerUser, attemptLogin,
                          createRequest, getRequestsByUser, addReview,
                          changeRequestStatus, getRequestsForAdmin
includes/             - шапка, подвал, валидаторы
assets/               - css (свои стили + bootstrap CSS), js (только слайдер), картинки
sql/                  - дамп базы (без created_at и индексов — не требуются ТЗ)

ER-диаграмму строить в phpMyAdmin -> Дизайнер (связь user_id -> users.id уже в дампе)
