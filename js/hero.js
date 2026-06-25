// --- Анимация фона: Радиальная деформация из центра ---
document.addEventListener("DOMContentLoaded", () => {
    const canvas = document.getElementById('wave-bg');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    let width, height, cols, rows;
    const spacing = 560;
    let time = 0;

    // Сила, с которой волна будет растягивать квадрат в центре
    const amplitude = 30;

    function resize() {
        width = canvas.width = canvas.offsetWidth;
        height = canvas.height = canvas.offsetHeight;
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

        // НАХОДИМ ТОЧНЫЙ ЦЕНТР ЭКРАНА
        const cx = width / 2;
        const cy = height / 2;

        const startX = -spacing;
        const startY = -spacing;

        for (let i = 0; i < cols; i++) {
            for (let j = 0; j < rows; j++) {

                // Базовые координаты для 4-х углов
                let x1_base = startX + i * spacing;
                let y1_base = startY + j * spacing;

                let x2_base = startX + (i + 1) * spacing;
                let y2_base = startY + j * spacing;

                let x3_base = startX + i * spacing;
                let y3_base = startY + (j + 1) * spacing;

                let x4_base = startX + (i + 1) * spacing;
                let y4_base = startY + (j + 1) * spacing;

                // ВЫЧИСЛЯЕМ СМЕЩЕНИЕ ДЛЯ КАЖДОЙ ИЗ 4-Х ТОЧЕК
                let p1 = getRadialWave(x1_base, y1_base, cx, cy, time, amplitude);
                let p2 = getRadialWave(x2_base, y2_base, cx, cy, time, amplitude);
                let p3 = getRadialWave(x3_base, y3_base, cx, cy, time, amplitude);
                let p4 = getRadialWave(x4_base, y4_base, cx, cy, time, amplitude);

                // Первый треугольник
                ctx.beginPath();
                ctx.moveTo(p1.x, p1.y);
                ctx.lineTo(p2.x, p2.y);
                ctx.lineTo(p3.x, p3.y);
                ctx.closePath();
                ctx.fill();
                ctx.stroke();

                // Второй треугольник
                ctx.beginPath();
                ctx.moveTo(p2.x, p2.y);
                ctx.lineTo(p4.x, p4.y);
                ctx.lineTo(p3.x, p3.y);
                ctx.closePath();
                ctx.fill();
                ctx.stroke();
            }
        }

        time += 0.02; // Скорость пульса
        requestAnimationFrame(animate);
    }

    // ФУНКЦИЯ РАДИАЛЬНОЙ ВОЛНЫ
    function getRadialWave(x, y, cx, cy, time, amp) {
        // 1. Считаем вектор от центра экрана до нашей точки
        let dx = x - cx;
        let dy = y - cy;

        // 2. Считаем расстояние от центра до точки (радиус)
        let radius = Math.sqrt(dx * dx + dy * dy);
        radius = Math.max(radius, 0.001); // Защита от деления на 0 в самом центре

        // 3. Создаем волну, которая зависит от РАССТОЯНИЯ (расходится кругами)
        // 0.01 - частота колец волны. 3 - скорость расходения.
        let wave = Math.sin(radius * 0.01 - time * 3) * amp;

        // 4. Нормализуем вектор (делаем его длину равной 1)
        let dirX = dx / radius;
        let dirY = dy / radius;

        // 5. Сдвигаем точку по направлению от центра на величину волны
        return {
            x: x + dirX * wave,
            y: y + dirY * wave
        };
    }

    animate();
});