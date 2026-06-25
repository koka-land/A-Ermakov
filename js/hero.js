// --- Анимация фона: Плывущая сетка треугольников ---
document.addEventListener("DOMContentLoaded", () => {
    const canvas = document.getElementById('wave-bg');
    if (!canvas) return; // Если canvas нет на странице, скрипт не упадет с ошибкой

    const ctx = canvas.getContext('2d');
    let width, height, cols, rows;
    const spacing = 60; // Расстояние между точками (размер треугольников)
    let time = 0;

    // Функция изменения размера холста под окно
    function resize() {
        width = canvas.width = canvas.offsetWidth;
        height = canvas.height = canvas.offsetHeight;
        cols = Math.ceil(width / spacing) + 1;
        rows = Math.ceil(height / spacing) + 1;
    }
    window.addEventListener('resize', resize);
    resize();

    // Основной цикл отрисовки
    function animate() {
        ctx.clearRect(0, 0, width, height);

        // Твои цвета
        const lineColor = 'rgba(38, 70, 83, 0.25)'; // #264653 с прозрачностью
        const fillColor = 'rgba(38, 70, 83, 0.05)';  // Очень легкая заливка

        ctx.lineWidth = 1;
        ctx.strokeStyle = lineColor;
        ctx.fillStyle = fillColor;

        // Рисуем треугольники
        for (let i = 0; i < cols; i++) {
            for (let j = 0; j < rows; j++) {
                // Базовые координаты
                let x = i * spacing;
                let y = j * spacing;

                // Добавляем "волну" с помощью синусоиды
                let offset = Math.sin(x * 0.005 + time) * 20 + Math.cos(y * 0.005 + time * 0.8) * 15;
                let y1 = y + offset;

                // Координаты соседних точек (с их собственными волнами)
                let x2 = (i + 1) * spacing;
                let y2 = (j) * spacing + Math.sin(x2 * 0.005 + time) * 20 + Math.cos(y * 0.005 + time * 0.8) * 15;

                let x3 = (i) * spacing;
                let y3 = (j + 1) * spacing + Math.sin(x * 0.005 + time) * 20 + Math.cos(y3 * 0.005 + time * 0.8) * 15;

                let x4 = (i + 1) * spacing;
                let y4 = (j + 1) * spacing + Math.sin(x4 * 0.005 + time) * 20 + Math.cos(y4 * 0.005 + time * 0.8) * 15;

                // Рисуем первый треугольник
                ctx.beginPath();
                ctx.moveTo(x, y1);
                ctx.lineTo(x2, y2);
                ctx.lineTo(x3, y3);
                ctx.closePath();
                ctx.fill();
                ctx.stroke();

                // Рисуем второй треугольник
                ctx.beginPath();
                ctx.moveTo(x2, y2);
                ctx.lineTo(x4, y4);
                ctx.lineTo(x3, y3);
                ctx.closePath();
                ctx.fill();
                ctx.stroke();
            }
        }

        time += 0.02; // Скорость волны
        requestAnimationFrame(animate);
    }

    animate();
});