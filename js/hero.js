// --- Анимация фона: Плывущая сетка треугольников ---
document.addEventListener("DOMContentLoaded", () => {
    const canvas = document.getElementById('wave-bg');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    let width, height, cols, rows;
    const spacing = 60;
    let time = 0;

    function resize() {
        width = canvas.width = canvas.offsetWidth;
        height = canvas.height = canvas.offsetHeight;
        cols = Math.ceil(width / spacing) + 1;
        rows = Math.ceil(height / spacing) + 1;
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

        for (let i = 0; i < cols; i++) {
            for (let j = 0; j < rows; j++) {
                let x = i * spacing;
                let baseY = j * spacing;

                let offset = Math.sin(x * 0.005 + time) * 20 + Math.cos(baseY * 0.005 + time * 0.8) * 15;
                let y1 = baseY + offset;

                let x2 = (i + 1) * spacing;
                let baseY2 = (j) * spacing;
                let y2 = baseY2 + Math.sin(x2 * 0.005 + time) * 20 + Math.cos(baseY2 * 0.005 + time * 0.8) * 15;

                let x3 = (i) * spacing;
                let baseY3 = (j + 1) * spacing; // ИСПРАВЛЕНО ЗДЕСЬ
                let y3 = baseY3 + Math.sin(x * 0.005 + time) * 20 + Math.cos(baseY3 * 0.005 + time * 0.8) * 15;

                let x4 = (i + 1) * spacing;
                let baseY4 = (j + 1) * spacing; // И ИСПРАВЛЕНО ЗДЕСЬ
                let y4 = baseY4 + Math.sin(x4 * 0.005 + time) * 20 + Math.cos(baseY4 * 0.005 + time * 0.8) * 15;

                ctx.beginPath();
                ctx.moveTo(x, y1);
                ctx.lineTo(x2, y2);
                ctx.lineTo(x3, y3);
                ctx.closePath();
                ctx.fill();
                ctx.stroke();

                ctx.beginPath();
                ctx.moveTo(x2, y2);
                ctx.lineTo(x4, y4);
                ctx.lineTo(x3, y3);
                ctx.closePath();
                ctx.fill();
                ctx.stroke();
            }
        }

        time += 0.02;
        requestAnimationFrame(animate);
    }

    animate();
});