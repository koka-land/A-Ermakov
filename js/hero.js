// --- Анимация фона: Диагональная сетка без пустот ---
document.addEventListener("DOMContentLoaded", () => {
    const canvas = document.getElementById('wave-bg');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    let width, height, cols, rows;
    const spacing = 500; // Твой увеличенный размер
    let time = 0;

    function resize() {
        width = canvas.width = canvas.offsetWidth;
        height = canvas.height = canvas.offsetHeight;
        // Добавили +2 вместо +1, так как сетка теперь смещена и нам нужен запас
        cols = Math.ceil(width / spacing) + 2;
        rows = Math.ceil(height / spacing) + 2;
    }
    window.addEventListener('resize', resize);
    resize();

    function animate() {
        ctx.clearRect(0, 0, width, height);

        const lineColor = 'rgba(38, 70, 83, 0.25)';
        const fillColor = 'rgba(38, 70, 83, 0.05)';

        ctx.lineWidth = 1;
        ctx.strokeStyle = lineColor;
        ctx.fillStyle = fillColor;

        // ИСКЛЮЧИТЕЛЬНО ВАЖНО: начинаем рисовать ЗА пределами экрана
        const startX = -spacing;
        const startY = -spacing;

        for (let i = 0; i < cols; i++) {
            for (let j = 0; j < rows; j++) {

                // МАГИЯ ДИАГОНАЛИ: смещаем каждый нечетный ряд наполовину
                let isOddRow = (j % 2 !== 0);
                let isNextRowOdd = ((j + 1) % 2 !== 0);

                let rowShift = isOddRow ? spacing / 2 : 0;
                let nextRowShift = isNextRowOdd ? spacing / 2 : 0;

                // Базовые координаты текущего ряда
                let baseY = startY + j * spacing;
                let nextBaseY = startY + (j + 1) * spacing;

                // Текущая точка (верхний левый угол треугольника)
                let x = startX + i * spacing + rowShift;
                let offset = Math.sin(x * 0.005 + time) * 35 + Math.cos(baseY * 0.005 + time * 0.8) * 25;
                let y1 = baseY + offset;

                // Соседняя точка справа (верхний правый угол)
                let x2 = startX + (i + 1) * spacing + rowShift;
                let offset2 = Math.sin(x2 * 0.005 + time) * 35 + Math.cos(baseY * 0.005 + time * 0.8) * 25;
                let y2 = baseY + offset2;

                // Точка снизу слева (нижний левый угол) - УЖЕ С УЧЕТОМ СДВИГА СЛЕДУЮЩЕГО РЯДА
                let x3 = startX + i * spacing + nextRowShift;
                let offset3 = Math.sin(x3 * 0.005 + time) * 35 + Math.cos(nextBaseY * 0.005 + time * 0.8) * 25;
                let y3 = nextBaseY + offset3;

                // Точка снизу справа (нижний правый угол)
                let x4 = startX + (i + 1) * spacing + nextRowShift;
                let offset4 = Math.sin(x4 * 0.005 + time) * 35 + Math.cos(nextBaseY * 0.005 + time * 0.8) * 25;
                let y4 = nextBaseY + offset4;

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

        time += 0.0006; // Твоя замедленная скорость
        requestAnimationFrame(animate);
    }

    animate();
});