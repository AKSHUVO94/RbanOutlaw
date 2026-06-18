<?php header("Content-type: text/css"); ?>
:root {
    --bg-color: #0d0d0d;
    --card-bg: #141414;
    --text-primary: #f5f5f7;
    --text-muted: #86868b;
    --accent: #d4af37; /* Matte Gold */
    --input-border: #2c2c2e;
}

* { box-sizing: border-box; margin: 0; padding: 0; }

body {
    background-color: var(--bg-color);
    color: var(--text-primary);
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
    letter-spacing: -0.02em;
}

header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.5rem 4rem;
    border-bottom: 1px solid var(--input-border);
    background: rgba(13, 13, 13, 0.8);
    backdrop-filter: blur(20px);
    position: sticky;
    top: 0;
    z-index: 100;
}

.logo { font-size: 1.3rem; font-weight: 800; text-transform: uppercase; letter-spacing: 3px; }
.logo span { color: var(--accent); }

nav a {
    color: var(--text-muted);
    text-decoration: none;
    margin-left: 2.5rem;
    font-size: 0.85rem;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    transition: color 0.3s;
}
nav a:hover, nav a.active { color: var(--text-primary); }

.container { max-width: 1200px; margin: 0 auto; padding: 4rem 2rem; }

/* Elegant Form Styling */
.auth-box {
    max-width: 420px;
    margin: 4rem auto;
    background: var(--card-bg);
    border: 1px solid var(--input-border);
    padding: 3rem 2.5rem;
    border-radius: 8px;
}
.form-group { margin-bottom: 1.5rem; }
.form-group label { display: block; font-size: 0.8rem; text-transform: uppercase; color: var(--text-muted); margin-bottom: 0.5rem; letter-spacing: 1px; }
.form-control {
    width: 100%;
    padding: 0.9rem;
    background: #1c1c1e;
    border: 1px solid var(--input-border);
    color: #fff;
    border-radius: 4px;
    font-size: 1rem;
    transition: border-color 0.3s;
}
.form-control:focus { border-color: var(--accent); outline: none; }

.btn-primary {
    display: block;
    width: 100%;
    padding: 1rem;
    background: var(--text-primary);
    color: var(--bg-color);
    border: none;
    border-radius: 4px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    cursor: pointer;
    transition: background 0.3s;
}
.btn-primary:hover { background: var(--accent); color: #000; }

/* Product Grid */
.grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 3rem; margin-top: 3rem; }
.card { background: var(--card-bg); border: 1px solid var(--input-border); border-radius: 6px; overflow: hidden; }
.card-img { width: 100%; height: 400px; object-fit: cover; filter: grayscale(20%); transition: filter 0.3s; }
.card:hover .card-img { filter: grayscale(0%); }
.card-body { padding: 1.5rem; }
.price { color: var(--accent); font-weight: 700; font-size: 1.1rem; }