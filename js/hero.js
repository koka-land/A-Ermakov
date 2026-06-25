// --- Анимация фона: Векторная волна (как в SR6) ---
document.addEventListener("DOMContentLoaded", () => {
    const canvas = document.getElementById('wave-bg');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    let width, height, cols, rows;
    const spacing = 560;
    let time = 0;

    // МАГИЯ ЗДЕСЬ: Угол наклона движения волны (в радианах).
    // 15 градусов от вертикали дают тот самый эффект "под кривым"
    const waveAngle = 15 * (Math.PI / 180);
    const sinAngle = Math.sin(waveAngle);
    const cosAngle = Math.cos(waveAngle);

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

        const startX = -spacing;
        const startY = -spacing;

        for (let i = 0; i < cols; i++) {
            for (let j = 0; j < rows; j++) {

                // Базовые координаты для 4-х точек квадрата
                let x1_base = startX + i * spacing;
                let y1_base = startY + j * spacing;

                let x2_base = startX + (i + 1) * spacing;
                let y2_base = startY + j * spacing;

                let x3_base = startX + i * spacing;
                let y3_base = startY + (j + 1) * spacing;

                let x4_base = startX + (i + 1) * spacing;
                let y4_base = startY + (j + 1) * spacing;

                // Считаем высоту волны для каждой точки
                let wave1 = Math.sin(x1_base * 0.005 + time) * 35 + Math.cos(y1_base * 0.005 + time * 0.8) * 25;
                let wave2 = Math.sin(x2_base * 0.005 + time) * 35 + Math.cos(y2_base * 0.005 + time * 0.8) * 25;
                let wave3 = Math.sin(x3_base * 0.005 + time) * 35 + Math.cos(y3_base * 0.005 + time * 0.8) * 25;
                let wave4 = Math.sin(x4_base * 0.005 + time) * 35 + Math.cos(y4_base * 0.005 + time * 0.8) * 25;

                // ПРИМЕНЯЕМ ВЕКТОР: разбиваем волну на X и Y смещение
                // Точка смещается не просто вверх, а по диагонали под углом 15 градусов
                let fx1 = x1_base + (sinAngle * wave1);
                let fy1 = y1_base + (cosAngle * wave1);

                let fx2 = x2_base + (sinAngle * wave2);
                let fy2 = y2_base + (cosAngle * wave2);

                let fx3 = x3_base + (sinAngle * wave3);
                let fy3 = y3_base + (cosAngle * wave3);

                let fx4 = x4_base + (sinAngle * wave4);
                let fy4 = y4_base + (cosAngle * wave4);

                // Первый треугольник
                ctx.beginPath();
                ctx.moveTo(fx1, fy1);
                ctx.lineTo(fx2, fy2);
                ctx.lineTo(fx3, fy3);
                ctx.closePath();
                ctx.fill();
                ctx.stroke();

                // Второй треугольник
                ctx.beginPath();
                ctx.moveTo(fx2, fy2);
                ctx.lineTo(fx4, fy4);
                ctx.lineTo(fx3, fy3);
                ctx.closePath();
                ctx.fill();
                ctx.stroke();
            }
        }

        time += 0.008;
        requestAnimationFrame(animate);
    }

    animate();
});