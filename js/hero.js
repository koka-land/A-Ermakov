document.addEventListener("DOMContentLoaded", () => {
    const canvas = document.getElementById('wave-bg');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    let width, height, cols, rows, centerX, centerY;
    const spacing = 560;
    let time = 0;

    function resize() {
        width = canvas.width = canvas.offsetWidth;
        height = canvas.height = canvas.offsetHeight;

        centerX = width / 2;
        centerY = height / 2;

        cols = Math.ceil(width / spacing) + 4;
        rows = Math.ceil(height / spacing) + 4;
    }

    window.addEventListener('resize', resize);
    resize();

    // Функция для расчета смещения (ровные вертикали, плавная волна справа налево)
    function getPoint(x_base, y_base, time) {
        const dx = x_base - centerX;
        const dirX = dx < 0 ? -1 : 1;
        const pullX = Math.min(Math.abs(dx) / 400, 1);

        // Используем широкую и медленную фазу волны
        const waveX = Math.sin(x_base * 0.0015 + time) * 35;
        const offsetX = waveX * dirX * pullX;

        const dy = y_base - centerY;
        const dirY = dy < 0 ? -1 : 1;
        const pullY = Math.min(Math.abs(dy) / 400, 1);

        const waveY = Math.sin(x_base * 0.0015 + y_base * 0.001 + time) * 35;
        const offsetY = waveY * dirY * pullY;

        return {
            x: x_base + offsetX,
            y: y_base + offsetY
        };
    }

    function animate() {
        ctx.clearRect(0, 0, width, height);

        // МАГИЯ ЗДЕСЬ: Создаем радиальные градиенты для отрисовки
        // Радиус затухания зависит от размера экрана (0.7 от наибольшей стороны)
        const fadeRadius = Math.max(width, height) * 0.7;

        // 1. Градиент для обводки (линий)
        const strokeGradient = ctx.createRadialGradient(centerX, centerY, 0, centerX, centerY, fadeRadius);
        strokeGradient.addColorStop(0, 'rgba(38, 70, 83, 0.35)'); // В центре более явные
        strokeGradient.addColorStop(0.5, 'rgba(38, 70, 83, 0.1)'); // К середине прозрачнее
        strokeGradient.addColorStop(1, 'rgba(38, 70, 83, 0)');    // На краях полностью исчезают

        // 2. Градиент для заливки (треугольников)
        const fillGradient = ctx.createRadialGradient(centerX, centerY, 0, centerX, centerY, fadeRadius);
        fillGradient.addColorStop(0, 'rgba(38, 70, 83, 0.06)');
        fillGradient.addColorStop(1, 'rgba(38, 70, 83, 0)');

        ctx.lineWidth = 1;
        // Применяем градиенты вместо сплошных цветов
        ctx.strokeStyle = strokeGradient;
        ctx.fillStyle = fillGradient;

        const startX = centerX - Math.floor(cols / 2) * spacing - (spacing / 2);
        const startY = centerY - Math.floor(rows / 2) * spacing - (spacing / 2);

        for (let i = 0; i < cols; i++) {
            for (let j = 0; j < rows; j++) {

                let x1_base = startX + i * spacing;
                let y1_base = startY + j * spacing;
                let x2_base = startX + (i + 1) * spacing;
                let y2_base = startY + j * spacing;
                let x3_base = startX + i * spacing;
                let y3_base = startY + (j + 1) * spacing;
                let x4_base = startX + (i + 1) * spacing;
                let y4_base = startY + (j + 1) * spacing;

                let p1 = getPoint(x1_base, y1_base, time);
                let p2 = getPoint(x2_base, y2_base, time);
                let p3 = getPoint(x3_base, y3_base, time);
                let p4 = getPoint(x4_base, y4_base, time);

                ctx.beginPath();
                ctx.moveTo(p1.x, p1.y);
                ctx.lineTo(p2.x, p2.y);
                ctx.lineTo(p3.x, p3.y);
                ctx.closePath();
                ctx.fill();
                ctx.stroke();

                ctx.beginPath();
                ctx.moveTo(p2.x, p2.y);
                ctx.lineTo(p4.x, p4.y);
                ctx.lineTo(p3.x, p3.y);
                ctx.closePath();
                ctx.fill();
                ctx.stroke();
            }
        }

        // Замедленное время для вальяжной анимации
        time += 0.005;
        requestAnimationFrame(animate);
    }

    animate();
});