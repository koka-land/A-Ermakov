<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Блог Александра Ермакова</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400&family=Roboto:wght@100;300;400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/hero.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>

<section class="hero-section" id="intro-screen">
    <div class="hero-content">

        <svg class="hero-svg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 208 202" version="1.1">
          <g class="layer">
            <title>Layer 1</title>
            <g transform="rotate(-90 170 170)" stroke-width="6" fill="none">
              <circle stroke-dashoffset="400" stroke-dasharray="362" stroke="#264653" r="90" cy="100" cx="240"></circle>
              <circle stroke-dashoffset="382" stroke-dasharray="362" stroke="#264653" r="95" cy="100" cx="240"></circle>
            </g>
          </g>
          <g class="layer">
            <title>Layer 2</title>
            <line y2="130" y1="2" x2="100" x1="100" stroke-width="6" stroke="#264653"></line>
            <line y2="130" y1="2" x2="105" x1="105" stroke-width="5" stroke="#264653"></line>
          </g>
          <g class="layer">
            <title>Layer 3</title>
            <line y2="90" y1="90" x2="35" x1="100" stroke-width="6" stroke="#264653"></line>
            <line y2="95" y1="95" x2="35" x1="100" stroke-width="5" stroke="#264653"></line>
          </g>
          <g class="layer">
            <title>Layer 4</title>
            <g transform="rotate(-90 170 170)" stroke-width="6" fill="none">
              <circle stroke-dashoffset="218" stroke-dasharray="100 300" stroke="#264653" r="90" cy="120" cx="240"></circle>
              <circle stroke-dashoffset="218" stroke-dasharray="110 300" stroke="#264653" r="95" cy="120" cx="240"></circle>
            </g>
          </g>
          <g class="layer">
            <title>Layer 47</title>
            <g transform="rotate(-90 170 170)" stroke-width="6" fill="none">
              <circle stroke-dashoffset="0" stroke-dasharray="100 600" stroke="#264653" r="90" cy="120" cx="240"></circle>
              <circle stroke-dashoffset="5" stroke-dasharray="110 600" stroke="#264653" r="95" cy="120" cx="240"></circle>
            </g>
          </g>
          <g class="layer">
            <title>Layer 5</title>
            <line y2="198" y1="2" x2="115" x1="115" stroke-width="6" stroke="#264653"></line>
            <line y2="198" y1="2" x2="120" x1="120" stroke-width="5" stroke="#264653"></line>
          </g>
          <g class="layer">
            <title>Layer 6</title>
            <line y2="90" y1="90" x2="160" x1="120" stroke-width="6" stroke="#264653"></line>
            <line y2="95" y1="95" x2="160" x1="120" stroke-width="5" stroke="#264653"></line>
          </g>
        </svg>

        <h1 class="hero-title" id="animated-title">Александр Ермаков</h1>
        <p class="hero-subtitle">Блог учителя информатики, робототехники и программирования</p>
    </div>

    <a role="button" tabindex="0" class="scroll-indicator" id="enter-dash-btn" style="cursor: pointer;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="6 9 12 15 18 9"></polyline>
        </svg>
    </a>
<canvas id="wave-bg"></canvas>
</section>

<section class="dashboard-section" id="dashboard-screen" style="display: none;">

        <!-- ДОБАВЛЕН КОНТЕЙНЕР-БОКС -->
        <div class="dashboard-container">

            <!-- Боковое меню -->
            <aside class="sidebar">
                <div class="logo-mini">
                    <span class="logo-icon">AE</span>

                </div>

                <nav class="sidebar-nav">
                    <a href="#" class="nav-item active">
    <span class="material-symbols-rounded nav-icon">home</span>
    <span class="nav-text">Главная</span>
</a>

<a href="#" class="nav-item">
    <span class="material-symbols-rounded nav-icon">menu_book</span>
    <span class="nav-text">Курсы</span>
</a>

<a href="#" class="nav-item">
    <span class="material-symbols-rounded nav-icon">calendar_today</span>
    <span class="nav-text">Расписание</span>
</a>


<a href="#" class="nav-item settings-item">
    <span class="material-symbols-rounded nav-icon">display_settings</span>
    <span class="nav-text">Настройки</span>
</a>
                </nav>
            </aside>

            <!-- Основной контент дашборда -->
            <main class="dashboard-content">
                <header class="dashboard-header">
                    <!-- Левая часть: Приветствие -->
                    <div class="header-greeting">
                        <h2>Привет, Александр! 👋</h2>
                        <p>Чем займемся сегодня?</p>
                    </div>

                    <!-- Правая часть: Инструменты и профиль -->
                    <div class="header-actions">

                        <!-- Строка поиска -->
                        <div class="search-container">
                            <svg class="search-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"></circle>
                                <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                            </svg>
                            <input type="text" class="search-input" placeholder="Поиск курсов и материалов...">
                        </div>

                        <!-- Кнопка уведомлений -->
                        <button class="action-btn notification-btn">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                            </svg>
                            <span class="notification-badge"></span>
                        </button>

                        <!-- Профиль пользователя -->
                        <div class="user-profile">
                            <div class="avatar-placeholder">АЕ</div>
                            <!-- Если есть картинка, используйте тег img ниже: -->
                            <!-- <img src="images/avatar.jpg" alt="Александр Ермаков" class="profile-avatar"> -->
                            <div class="profile-info">
                                <span class="profile-name">Александр Е.</span>
                                <span class="profile-role">Преподаватель</span>
                            </div>
                            <svg class="dropdown-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="6 9 12 15 18 9"></polyline>
                            </svg>
                        </div>

                    </div>
                </header>

                <!-- Сетка для виджетов -->
                <div class="dashboard-grid">
                    <!-- Сюда будем добавлять карточки -->
                </div>
            </main>

        </div> <!-- Конец .dashboard-container -->

</section>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const introScreen = document.getElementById('intro-screen');
        const dashboardScreen = document.getElementById('dashboard-screen');
        // Обновляем ID на тот, который мы только что повесили на стрелочку
        const enterBtn = document.getElementById('enter-dash-btn');

        if (!sessionStorage.getItem('introSeen')) {
            // Дашборд спрятан внизу.
            dashboardScreen.style.display = 'flex';

            // Ждем клика по стрелочке
            enterBtn.addEventListener('click', () => {
                sessionStorage.setItem('introSeen', 'true');

                // Запускаем анимацию разъезда
                introScreen.classList.add('slide-out');
                dashboardScreen.classList.add('slide-in');

                // Ждем 1.2 секунды и скрываем заставку
                setTimeout(() => {
                    introScreen.style.display = 'none';
                }, 1200);
            });

        } else {
            // Если обновили страницу
            introScreen.style.display = 'none';

            dashboardScreen.classList.add('no-transition');
            dashboardScreen.style.display = 'flex';
            dashboardScreen.classList.add('slide-in');
        }
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const titleElement = document.getElementById('animated-title');
        const text = titleElement.textContent;
        titleElement.innerHTML = '';

        text.split('').forEach((char, index) => {
            const span = document.createElement('span');
            if (char === ' ') {
                span.innerHTML = '&nbsp;';
            } else {
                span.textContent = char;
                span.classList.add('char');
                // Задержку уменьшили, так как логотип больше не анимируется (начинаем с 0.2с)
                span.style.animationDelay = `${0.2 + (index * 0.05)}s`;
            }
            titleElement.appendChild(span);
        });
    });
</script>

<script src="js/hero.js"></script>

</body>
</html>