<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Playfair+Display:wght@500;600&display=swap" rel="stylesheet">
<style>
    :root {
        color-scheme: light;
        --paper: #f5f4ef;
        --surface: #fbfaf7;
        --ink: #202923;
        --muted: #747a72;
        --green: #173b31;
        --green-dark: #102c25;
        --brass: #a8894f;
        --line: #dcdcd4;
        --danger: #9b493b;
    }

    * { box-sizing: border-box; }

    body {
        margin: 0;
        min-width: 320px;
        min-height: 100vh;
        background: var(--paper);
        color: var(--ink);
        font-family: 'DM Sans', sans-serif;
        font-size: 14px;
        -webkit-font-smoothing: antialiased;
    }

    a { color: inherit; }
    .shell { width: min(1180px, calc(100% - 56px)); margin: 0 auto; }

    .brand { display: inline-flex; align-items: center; gap: 12px; color: var(--ink); text-decoration: none; }
    .brand-mark { width: 36px; height: 36px; display: grid; place-items: center; border: 1px solid var(--brass); color: var(--green); font: 600 19px/1 'Playfair Display', Georgia, serif; }
    .brand-name { font-size: 10px; font-weight: 600; letter-spacing: 0.16em; text-transform: uppercase; }
    .site-header { border-bottom: 1px solid var(--line); background: var(--surface); }
    .site-nav { min-height: 72px; display: flex; align-items: center; justify-content: space-between; gap: 20px; }
    .site-nav form { margin: 0; }
    .login-header { padding-top: 30px; }

    .login-page { min-height: 100vh; display: flex; flex-direction: column; }
    .login-main { width: min(100% - 56px, 430px); flex: 1; display: flex; align-items: center; margin: 0 auto; padding: 54px 0; }
    .login-content { width: 100%; padding-left: 27px; border-left: 2px solid var(--brass); }
    .eyebrow { margin: 0 0 15px; color: var(--brass); font-size: 10px; font-weight: 600; letter-spacing: 0.19em; text-transform: uppercase; }
    h1, h2 { color: var(--ink); font-family: 'Playfair Display', Georgia, serif; font-weight: 500; letter-spacing: 0; }
    .login-title { margin: 0; font-size: 44px; line-height: 1.12; }
    .login-intro { margin: 13px 0 34px; color: var(--muted); font-size: 14px; }
    .login-footer { padding: 22px 0 26px; color: var(--muted); font-size: 10px; letter-spacing: 0.1em; text-align: center; text-transform: uppercase; }

    .page-main { padding: 52px 0 80px; }
    .page-heading { display: flex; align-items: end; justify-content: space-between; gap: 24px; }
    .page-heading h1 { margin: 0; font-size: 38px; line-height: 1.15; }
    .page-subtitle { margin: 9px 0 0; color: var(--muted); }
    .form-heading { margin-bottom: 34px; }
    .form-heading h1 { margin: 0; font-size: 36px; }

    .button {
        min-height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0 17px;
        border: 1px solid transparent;
        border-radius: 2px;
        font: 500 11px/1 'DM Sans', sans-serif;
        letter-spacing: 0.07em;
        text-decoration: none;
        text-transform: uppercase;
        cursor: pointer;
        transition: color 150ms ease, background 150ms ease, border-color 150ms ease;
    }

    .button:focus-visible, input:focus-visible, textarea:focus-visible { outline: 3px solid rgba(168, 137, 79, 0.38); outline-offset: 2px; }
    .button-primary { background: var(--green); color: #fff; }
    .button-primary:hover { background: var(--green-dark); color: #fff; }
    .button-secondary { border-color: var(--line); background: transparent; color: var(--ink); }
    .button-secondary:hover { border-color: var(--green); color: var(--green); }
    .button-danger { min-height: 34px; border-color: #e1c9c3; background: transparent; color: var(--danger); }
    .button-danger:hover { border-color: var(--danger); background: #f4e8e3; }
    .button-small { min-height: 34px; padding: 0 12px; }

    .notice { margin: 26px 0 0; padding: 13px 15px; border-left: 2px solid var(--green); background: #e9eee9; color: var(--green); font-size: 13px; }
    .notice-error { border-color: var(--danger); background: #f4e8e3; color: #78382e; }
    .table-scroll { margin-top: 38px; overflow-x: auto; border-top: 1px solid var(--line); }
    .products-table { width: 100%; min-width: 800px; border-collapse: collapse; text-align: left; }
    .products-table th { padding: 14px 13px; color: var(--muted); font-size: 9px; font-weight: 600; letter-spacing: 0.14em; text-transform: uppercase; }
    .products-table td { padding: 17px 13px; border-top: 1px solid var(--line); color: #535b54; font-size: 13px; vertical-align: middle; }
    .products-table tbody tr:hover { background: rgba(255, 255, 255, 0.52); }
    .products-table .product-id { color: var(--muted); font-size: 11px; }
    .products-table .product-name { color: var(--ink); font-weight: 600; }
    .products-table .product-description { max-width: 290px; color: var(--muted); }
    .products-table .product-price { color: var(--ink); white-space: nowrap; }
    .products-table .product-actions { text-align: right; white-space: nowrap; }
    .products-table .product-actions form { display: inline; margin: 0; }
    .empty-state { padding: 66px 20px; border-top: 1px solid var(--line); text-align: center; }
    .empty-state h2 { margin: 0 0 8px; font-size: 24px; }
    .empty-state p { margin: 0 0 22px; color: var(--muted); }

    .form-shell { width: min(100%, 690px); padding-top: 52px; }
    .breadcrumb { margin: 0 0 28px; color: var(--muted); font-size: 11px; }
    .breadcrumb a { color: var(--green); text-decoration: none; }
    .breadcrumb a:hover { text-decoration: underline; }
    .form-section { padding: 28px 0 30px; border-top: 1px solid var(--line); border-bottom: 1px solid var(--line); }
    .field { margin-bottom: 23px; }
    .field label { display: block; margin-bottom: 8px; color: #515951; font-size: 12px; font-weight: 500; }
    .field input, .field textarea { width: 100%; min-height: 46px; padding: 11px 12px; border: 1px solid var(--line); border-radius: 2px; background: var(--surface); color: var(--ink); font: inherit; font-size: 14px; resize: vertical; }
    .field input:focus, .field textarea:focus { border-color: var(--green); outline: none; box-shadow: 0 0 0 3px rgba(23, 59, 49, 0.09); }
    .field-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 20px; }
    .form-actions { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 22px; }
    .error-list { margin: 0; padding-left: 18px; }

    @media (max-width: 700px) {
        .shell { width: min(100% - 36px, 1180px); }
        .site-nav { min-height: 64px; }
        .page-main { padding-top: 38px; }
        .page-heading { align-items: start; flex-direction: column; }
        .page-heading h1 { font-size: 34px; }
        .table-scroll { margin-top: 26px; }
        .products-table { min-width: 0; }
        .products-table thead { position: absolute; width: 1px; height: 1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; }
        .products-table, .products-table tbody { display: block; width: 100%; }
        .products-table tbody tr { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px 18px; padding: 17px 0; border-top: 1px solid var(--line); }
        .products-table td { min-width: 0; display: flex; flex-direction: column; gap: 4px; padding: 0; border: 0; overflow-wrap: anywhere; }
        .products-table td::before { color: var(--muted); content: attr(data-label); font-size: 9px; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase; }
        .products-table .product-description, .products-table .product-actions { grid-column: 1 / -1; }
        .products-table .product-description { max-width: none; }
        .products-table .product-actions { flex-direction: row; justify-content: start; text-align: left; }
        .empty-state { padding: 48px 14px; }
        .form-shell { padding-top: 36px; }
    }

    @media (max-width: 440px) {
        .brand-name { font-size: 9px; }
        .login-header { padding-top: 20px; }
        .login-main { width: calc(100% - 42px); padding: 38px 0; }
        .login-content { padding-left: 20px; }
        .login-title { font-size: 39px; }
        .field-grid { grid-template-columns: 1fr; gap: 0; }
        .form-section { padding-top: 22px; }
    }
</style>