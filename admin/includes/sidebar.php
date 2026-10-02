/* ========================================= */
/* --- АДМИНКА: стили страниц входа, списка и редактора --- */
/* Подключается после style.css (и dashboard.css там, где есть окно) */
/* ========================================= */


/* ========================================= */
/* --- ВХОД (login.php) --- */
/* ========================================= */
.login-box {
    max-width: 360px;
    width: 90%;
    background: #fff;
    border-radius: 16px;
    padding: 36px 32px;
    box-shadow: 0 10px 30px rgba(12, 42, 54, 0.08);
}

.login-box h1 {
    font-size: 1.3rem;
    margin: 0 0 20px;
    color: var(--text-primary);
}

.login-box input {
    width: 100%;
    padding: 12px 14px;
    margin-bottom: 14px;
    border: 1px solid rgba(12, 42, 54, 0.15);
    border-radius: 10px;
    font-family: var(--font-main);
    font-size: 0.95rem;
    box-sizing: border-box;
}

.login-box button {
    width: 100%;
    padding: 12px;
    border: none;
    border-radius: 10px;
    background: var(--text-primary);
    color: #fff;
    font-family: var(--font-main); /* кнопки не наследуют шрифт сами */
    font-weight: 700;
    font-size: 0.95rem;
    cursor: pointer;
}

.login-error {
    color: #e76f51;
    font-size: 0.85rem;
    margin: -6px 0 14px;
}

.back-to-site {
    display: block;
    text-align: center;
    margin-top: 16px;
    color: var(--text-secondary);
    font-size: 0.85rem;
    text-decoration: none;
    opacity: 0.75;
}

.back-to-site:hover {
    opacity: 1;
}


/* ========================================= */
/* --- ДАШБОРД (dashboard.php) --- */
/* ========================================= */
.stat-card {
    background: #fff;
    border-radius: 14px;
    padding: 20px 22px;
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.stat-value {
    font-family: 'Montserrat', sans-serif;
    font-weight: 700;
    font-size: 2rem;
    color: var(--text-primary);
}

.stat-value.published { color: #2a9d8f; }
.stat-value.draft { color: #f4a261; }

.stat-label {
    font-size: 0.85rem;
    color: var(--text-secondary);
}

.quick-actions {
    display: flex;
    gap: 12px;
    margin-bottom: 36px;
}

.btn.secondary {
    background: #fff;
    color: var(--text-primary);
    border: 1px solid rgba(12, 42, 54, 0.15);
}

.section-title {
    font-size: 1.05rem;
    color: var(--text-primary);
    margin: 0 0 14px;
}


/* ========================================= */
/* --- СПИСОК МАТЕРИАЛОВ (materials.php) --- */
/* ========================================= */
.wrap {
    max-width: 900px;
    margin: 0 auto;
    padding: 40px 32px;
}

/* Для дашборда — на всю доступную ширину окна, без узкой колонки */
.wrap.wrap-full {
    max-width: none;
}

.wrap h1 {
    font-size: 1.5rem;
    margin: 0;
}

.top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}

.btn {
    background: var(--text-primary);
    color: #fff;
    padding: 10px 18px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
}

.wrap table {
    width: 100%;
    border-collapse: collapse;
    background: #fff;
    border-radius: 14px;
    overflow: hidden;
}

.wrap th,
.wrap td {
    text-align: left;
    padding: 14px 16px;
    border-bottom: 1px solid rgba(12, 42, 54, 0.06);
    font-size: 0.92rem;
}

.wrap th {
    color: var(--text-secondary);
    font-weight: 600;
    font-size: 0.8rem;
    text-transform: uppercase;
    letter-spacing: 0.03em;
}

.status {
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
}

.status.draft {
    background: rgba(244, 162, 97, 0.15);
    color: #f4a261;
}

.status.published {
    background: rgba(42, 157, 143, 0.15);
    color: #2a9d8f;
}

a.row-link {
    color: var(--text-primary);
    text-decoration: none;
    font-weight: 600;
}

.empty {
    padding: 40px;
    text-align: center;
    color: var(--text-secondary);
}

.logout {
    color: var(--text-secondary);
    font-size: 0.85rem;
    text-decoration: none;
    margin-left: 16px;
}


/* ========================================= */
/* --- РЕДАКТОР (editor.php) --- */
/* ========================================= */
.editor-topbar {
    background: #fff;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 32px;
    border-bottom: 1px solid rgba(12, 42, 54, 0.06);
    flex-shrink: 0;
}

.editor-topbar input[type="text"] {
    font-family: var(--font-main);
    font-size: 1.1rem;
    font-weight: 700;
    border: none;
    outline: none;
    color: var(--text-primary);
    width: 60%;
}

.editor-topbar input[type="text"]::placeholder {
    color: rgba(12, 42, 54, 0.3);
}

.actions {
    display: flex;
    gap: 10px;
    align-items: center;
}

.actions select,
.actions button {
    font-family: var(--font-main);
    font-size: 0.85rem;
    padding: 9px 14px;
    border-radius: 8px;
    border: 1px solid rgba(12, 42, 54, 0.15);
    background: #fff;
    cursor: pointer;
}

.actions button.primary {
    background: var(--text-primary);
    color: #fff;
    border: none;
    font-weight: 600;
}

#save-status {
    font-size: 0.8rem;
    color: var(--text-secondary);
    margin-right: 6px;
}

.editor-wrap {
    max-width: 720px;
    margin: 40px auto 100px;
    padding: 0 20px;
}

.codex-editor {
    font-family: var(--font-main);
}

a.back {
    color: var(--text-secondary);
    text-decoration: none;
    font-size: 0.85rem;
    margin-right: 16px;
}