<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Блог Александра Ермакова</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400&family=Roboto:wght@100;300;400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/hero.css">

    <script src="js/hero.js"></script>
</head>
<body>

<section class="hero-section">
    <div class="hero-content">

        <svg class="hero-svg" xmlns="http://www.w3.org/2000/svg" width="208" height="202" version="1.1">
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

    <a href="#about" class="scroll-indicator">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="6 9 12 15 18 9"></polyline>
        </svg>
    </a>
<canvas id="wave-bg"></canvas>
</section>

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

</body>
</html>