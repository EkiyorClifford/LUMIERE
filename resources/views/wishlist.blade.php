<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Wishlist | LUMIÈRE</title>
    <meta name="description" content="Your curated selection of LUMIÈRE pieces.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400;1,500&family=Jost:wght@200;300;400;500;600&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --gold:       #C9A84C;
            --gold-light: #E8C97A;
            --gold-dim:   rgba(201,168,76,0.10);
            --gold-border:rgba(201,168,76,0.22);
            --cream:      #F9F6F0;
            --ivory:      #F2EDE4;
            --charcoal:   #141414;
            --charcoal-2: #1E1E21;
            --warm-gray:  #8A8580;
            --border:     rgba(28,28,28,0.09);
            --border-md:  rgba(28,28,28,0.14);
            --text-dim:   rgba(28,28,28,0.38);
        }

        html { scroll-behavior: smooth; }
        body {
            font-family: 'Jost', sans-serif;
            background: var(--cream);
            color: var(--charcoal);
            overflow-x: hidden;
            min-height: 100vh;
        }

        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: var(--cream); }
        ::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 4px; }
        ::selection { background: var(--gold); color: #fff; }

        /* ── NAV ── */
        #main-nav {
            position: fixed; top: 0; left: 0; width: 100%; z-index: 50;
            padding: 20px 48px;
            display: flex; justify-content: space-between; align-items: center;
            background: rgba(249,246,240,0.96);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            transition: padding 0.4s, box-shadow 0.4s;
        }
        #main-nav.scrolled { padding: 14px 48px; box-shadow: 0 1px 24px rgba(0,0,0,0.05); }
        .nav-logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.35rem; letter-spacing: 0.22em;
            color: var(--charcoal); text-decoration: none;
            transition: color 0.3s;
        }
        .nav-logo:hover { color: var(--gold); }
        .nav-links { display: flex; gap: 36px; }
        .nav-link {
            font-size: 0.62rem; letter-spacing: 0.18em;
            color: rgba(28,28,28,0.5); text-decoration: none;
            position: relative; font-weight: 300;
            transition: color 0.3s;
        }
        .nav-link:hover, .nav-link.active { color: var(--charcoal); }
        .nav-link::after {
            content: ''; position: absolute; bottom: -3px; left: 0;
            width: 0; height: 1px; background: var(--gold);
            transition: width 0.3s;
        }
        .nav-link:hover::after, .nav-link.active::after { width: 100%; }
        .nav-icons { display: flex; align-items: center; gap: 20px; }
        .nav-icon-btn {
            color: rgba(28,28,28,0.5); font-size: 0.9rem;
            background: none; border: none; cursor: pointer;
            transition: color 0.3s; position: relative;
        }
        .nav-icon-btn:hover { color: var(--gold); }
        .cart-count {
            position: absolute; top: -5px; right: -6px;
            width: 14px; height: 14px; border-radius: 50%;
            background: var(--gold); color: #fff;
            font-size: 0.48rem; font-weight: 600;
            display: flex; align-items: center; justify-content: center;
        }

        /* ── PAGE HERO ── */
        .page-hero {
            padding-top: 120px;
            padding-bottom: 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        /* Decorative background texture */
        .page-hero::before {
            content: '';
            position: absolute; top: 0; left: 50%; transform: translateX(-50%);
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(201,168,76,0.06) 0%, transparent 65%);
            pointer-events: none;
        }

        .hero-eyebrow {
            font-size: 0.58rem; letter-spacing: 0.42em;
            color: var(--gold); font-weight: 300;
            display: block; margin-bottom: 14px;
            animation: fadeUp 0.6s ease 0.1s both;
        }
        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.4rem, 5vw, 4rem);
            font-weight: 400; color: var(--charcoal);
            letter-spacing: 0.04em; line-height: 1.1;
            margin-bottom: 6px;
            animation: fadeUp 0.6s ease 0.18s both;
        }
        .hero-subtitle {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic; font-weight: 300;
            font-size: clamp(1.2rem, 2.5vw, 1.7rem);
            color: var(--warm-gray);
            animation: fadeUp 0.6s ease 0.24s both;
        }
        .hero-rule {
            width: 0; height: 1px; background: var(--gold);
            margin: 24px auto 0;
            animation: ruleGrow 0.8s ease 0.4s forwards;
        }
        @keyframes ruleGrow { to { width: 48px; } }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(18px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Count pill */
        .count-pill {
            display: inline-flex; align-items: center; gap: 6px;
            margin-top: 20px; margin-bottom: 0;
            padding: 6px 16px;
            border: 1px solid var(--gold-border);
            font-size: 0.62rem; letter-spacing: 0.18em;
            color: var(--warm-gray); font-weight: 300;
            animation: fadeUp 0.6s ease 0.32s both;
        }
        .count-pill strong { color: var(--gold); font-weight: 500; }

        /* ── TOOLBAR ── */
        .toolbar {
            max-width: 1200px; margin: 40px auto 0;
            padding: 0 40px;
            display: flex; justify-content: space-between; align-items: center;
            flex-wrap: wrap; gap: 14px;
            animation: fadeUp 0.6s ease 0.38s both;
        }
        .toolbar-left { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }

        .filter-pill {
            padding: 7px 16px;
            border: 1px solid var(--border-md);
            background: transparent;
            font-family: 'Jost', sans-serif;
            font-size: 0.6rem; letter-spacing: 0.16em;
            color: var(--text-dim); cursor: pointer;
            transition: all 0.25s;
        }
        .filter-pill:hover { border-color: var(--gold); color: var(--charcoal); }
        .filter-pill.active {
            background: var(--charcoal); border-color: var(--charcoal); color: #fff;
        }

        .toolbar-right { display: flex; align-items: center; gap: 10px; }

        .sort-select {
            background: transparent;
            border: 1px solid var(--border-md);
            font-family: 'Jost', sans-serif;
            font-size: 0.6rem; letter-spacing: 0.12em;
            color: var(--text-dim); padding: 7px 12px;
            outline: none; cursor: pointer;
            transition: border-color 0.25s;
            -webkit-appearance: none;
        }
        .sort-select:focus { border-color: var(--gold); }

        .btn-share {
            display: flex; align-items: center; gap: 7px;
            padding: 7px 16px;
            border: 1px solid var(--gold-border);
            background: transparent; cursor: pointer;
            font-family: 'Jost', sans-serif;
            font-size: 0.6rem; letter-spacing: 0.18em;
            color: var(--gold);
            transition: background 0.25s, color 0.25s;
        }
        .btn-share:hover { background: var(--gold-dim); }
        .btn-share i { font-size: 0.7rem; }

        .btn-cart-all {
            display: flex; align-items: center; gap: 7px;
            padding: 7px 18px;
            background: var(--charcoal); border: none; cursor: pointer;
            font-family: 'Jost', sans-serif;
            font-size: 0.6rem; letter-spacing: 0.18em;
            color: #fff; position: relative; overflow: hidden;
            transition: color 0.3s;
        }
        .btn-cart-all::before {
            content: ''; position: absolute; inset: 0;
            background: var(--gold);
            transform: translateX(-100%);
            transition: transform 0.4s cubic-bezier(0.4,0,0.2,1);
        }
        .btn-cart-all:hover::before { transform: translateX(0); }
        .btn-cart-all span, .btn-cart-all i { position: relative; z-index: 1; }
        .btn-cart-all i { font-size: 0.72rem; }

        /* ── WISHLIST GRID ── */
        .wishlist-grid {
            max-width: 1200px; margin: 36px auto 0;
            padding: 0 40px 80px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 28px;
        }
        @media(max-width: 1000px) { .wishlist-grid { grid-template-columns: repeat(2,1fr); } }
        @media(max-width: 640px)  { .wishlist-grid { grid-template-columns: 1fr; padding: 0 20px 60px; } }

        /* ── WISHLIST CARD ── */
        .wish-card {
            background: #fff;
            border: 1px solid var(--border);
            position: relative;
            animation: cardIn 0.5s ease both;
            transition: box-shadow 0.35s, transform 0.35s;
        }
        .wish-card:hover {
            box-shadow: 0 20px 60px rgba(0,0,0,0.08);
            transform: translateY(-3px);
        }
        .wish-card:nth-child(1) { animation-delay: 0.05s; }
        .wish-card:nth-child(2) { animation-delay: 0.12s; }
        .wish-card:nth-child(3) { animation-delay: 0.19s; }
        .wish-card:nth-child(4) { animation-delay: 0.26s; }
        .wish-card:nth-child(5) { animation-delay: 0.33s; }
        @keyframes cardIn {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Card image */
        .card-img-wrap {
            position: relative; overflow: hidden;
            aspect-ratio: 3/3.5; background: var(--ivory);
        }
        .card-img {
            width: 100%; height: 100%; object-fit: cover;
            transition: transform 0.7s cubic-bezier(0.25,0.46,0.45,0.94);
            display: block;
        }
        .wish-card:hover .card-img { transform: scale(1.05); }

        /* Remove button */
        .btn-remove {
            position: absolute; top: 12px; right: 12px;
            width: 32px; height: 32px; border-radius: 50%;
            background: rgba(255,255,255,0.9);
            backdrop-filter: blur(6px);
            border: none; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            color: rgba(28,28,28,0.4); font-size: 0.72rem;
            transition: background 0.25s, color 0.25s, transform 0.25s;
            opacity: 0; transform: scale(0.8);
        }
        .wish-card:hover .btn-remove { opacity: 1; transform: scale(1); }
        .btn-remove:hover { background: #fff; color: #c0392b; }

        /* Date added badge */
        .date-badge {
            position: absolute; bottom: 12px; left: 12px;
            background: rgba(249,246,240,0.92);
            backdrop-filter: blur(6px);
            padding: 4px 10px;
            font-size: 0.55rem; letter-spacing: 0.16em;
            color: var(--warm-gray); font-weight: 300;
        }

        /* Collection badge */
        .collection-badge {
            position: absolute; top: 12px; left: 12px;
            background: var(--charcoal);
            color: rgba(255,255,255,0.85);
            padding: 4px 10px;
            font-size: 0.52rem; letter-spacing: 0.18em;
            font-weight: 300;
        }

        /* Card body */
        .card-body { padding: 20px 22px 22px; }

        .card-collection {
            font-size: 0.56rem; letter-spacing: 0.28em;
            color: var(--gold); font-weight: 400;
            display: block; margin-bottom: 5px;
        }
        .card-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.05rem; font-weight: 400;
            color: var(--charcoal); margin-bottom: 3px;
            letter-spacing: 0.02em;
        }
        .card-variant {
            font-size: 0.65rem; color: var(--warm-gray);
            font-weight: 300; letter-spacing: 0.06em;
            margin-bottom: 16px;
        }

        /* Price row */
        .price-row {
            display: flex; align-items: baseline;
            gap: 10px; margin-bottom: 18px;
        }
        .price-main {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem; font-weight: 400; color: var(--charcoal);
        }
        .price-old {
            font-size: 0.75rem; color: rgba(28,28,28,0.3);
            text-decoration: line-through; font-weight: 300;
        }
        .price-save {
            font-size: 0.58rem; color: var(--gold);
            letter-spacing: 0.1em; font-weight: 400;
            background: var(--gold-dim); padding: 2px 7px;
        }

        /* Stock indicator */
        .stock-row {
            display: flex; align-items: center; gap: 6px;
            margin-bottom: 18px;
        }
        .stock-dot {
            width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0;
        }
        .stock-dot.in   { background: #4CAF7D; }
        .stock-dot.low  { background: #D4924A; animation: pulseDot 1.8s ease infinite; }
        .stock-dot.out  { background: #E05252; }
        @keyframes pulseDot {
            0%,100%{ opacity:1; } 50%{ opacity:0.35; }
        }
        .stock-label { font-size: 0.62rem; color: var(--warm-gray); font-weight: 300; letter-spacing: 0.08em; }
        .stock-label.low  { color: #D4924A; }
        .stock-label.out  { color: #E05252; }

        /* Card actions */
        .card-actions { display: flex; gap: 8px; }

        .btn-add-cart {
            flex: 1; padding: 11px 14px;
            background: var(--charcoal); border: none; cursor: pointer;
            font-family: 'Jost', sans-serif;
            font-size: 0.62rem; letter-spacing: 0.2em; color: #fff;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            position: relative; overflow: hidden; transition: color 0.3s;
        }
        .btn-add-cart::before {
            content: ''; position: absolute; inset: 0;
            background: var(--gold);
            transform: translateY(100%);
            transition: transform 0.35s cubic-bezier(0.4,0,0.2,1);
        }
        .btn-add-cart:hover::before { transform: translateY(0); }
        .btn-add-cart span, .btn-add-cart i { position: relative; z-index: 1; }
        .btn-add-cart i { font-size: 0.7rem; }
        .btn-add-cart:disabled {
            background: rgba(28,28,28,0.12); cursor: not-allowed; color: rgba(28,28,28,0.3);
        }
        .btn-add-cart:disabled::before { display: none; }

        .btn-quick-view {
            width: 40px; height: 40px;
            border: 1px solid var(--border-md);
            background: transparent; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            color: var(--text-dim); font-size: 0.72rem;
            transition: border-color 0.25s, color 0.25s, background 0.25s;
        }
        .btn-quick-view:hover { border-color: var(--gold); color: var(--gold); background: var(--gold-dim); }

        .btn-move-bespoke {
            width: 40px; height: 40px;
            border: 1px solid var(--border-md);
            background: transparent; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            color: var(--text-dim); font-size: 0.72rem;
            transition: border-color 0.25s, color 0.25s, background 0.25s;
        }
        .btn-move-bespoke:hover { border-color: var(--gold); color: var(--gold); background: var(--gold-dim); }

        /* ── EMPTY STATE ── */
        #empty-state {
            display: none;
            text-align: center;
            padding: 100px 40px;
            max-width: 500px; margin: 0 auto;
            animation: fadeUp 0.6s ease both;
        }
        .empty-icon {
            width: 80px; height: 80px;
            border: 1px solid var(--gold-border);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 28px;
        }
        .empty-icon i { color: var(--gold); font-size: 1.6rem; }
        .empty-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem; font-weight: 400;
            color: var(--charcoal); margin-bottom: 10px;
        }
        .empty-sub {
            font-size: 0.8rem; color: var(--warm-gray);
            font-weight: 300; line-height: 1.7; margin-bottom: 32px;
        }
        .btn-browse {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 13px 28px;
            background: var(--charcoal); color: #fff; border: none;
            font-family: 'Jost', sans-serif;
            font-size: 0.62rem; letter-spacing: 0.22em;
            cursor: pointer; text-decoration: none;
            position: relative; overflow: hidden; transition: color 0.3s;
        }
        .btn-browse::before {
            content: ''; position: absolute; inset: 0;
            background: var(--gold); transform: translateX(-100%);
            transition: transform 0.4s cubic-bezier(0.4,0,0.2,1);
        }
        .btn-browse:hover::before { transform: translateX(0); }
        .btn-browse span, .btn-browse i { position: relative; z-index: 1; }

        /* ── SHARE DRAWER ── */
        #share-drawer {
            position: fixed; bottom: 0; left: 0; right: 0; z-index: 100;
            background: #fff;
            border-top: 1px solid var(--border-md);
            padding: 32px 48px;
            transform: translateY(100%);
            transition: transform 0.45s cubic-bezier(0.4,0,0.2,1);
            box-shadow: 0 -20px 60px rgba(0,0,0,0.08);
        }
        #share-drawer.open { transform: translateY(0); }
        #share-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,0.2);
            z-index: 99; display: none;
        }
        #share-overlay.show { display: block; }

        .drawer-head {
            display: flex; justify-content: space-between; align-items: center;
            margin-bottom: 24px;
        }
        .drawer-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem; font-weight: 400;
        }
        .drawer-close {
            background: none; border: none; cursor: pointer;
            color: var(--warm-gray); font-size: 1rem;
            transition: color 0.2s;
        }
        .drawer-close:hover { color: var(--charcoal); }

        .share-options { display: flex; gap: 12px; flex-wrap: wrap; }
        .share-opt {
            display: flex; align-items: center; gap: 10px;
            padding: 12px 20px;
            border: 1px solid var(--border-md);
            cursor: pointer; font-family: 'Jost', sans-serif;
            font-size: 0.68rem; letter-spacing: 0.12em;
            color: var(--charcoal); background: transparent;
            transition: border-color 0.25s, background 0.25s;
        }
        .share-opt:hover { border-color: var(--gold); background: var(--gold-dim); }
        .share-opt i { color: var(--gold); font-size: 0.85rem; }

        .share-link-row {
            margin-top: 20px; display: flex; gap: 0;
            border-bottom: 1px solid var(--border-md);
        }
        .share-link-input {
            flex: 1; border: none; background: transparent;
            font-family: 'Jost', sans-serif; font-size: 0.78rem;
            font-weight: 300; color: var(--warm-gray);
            padding: 10px 0; outline: none;
            letter-spacing: 0.04em;
        }
        .btn-copy {
            background: none; border: none; cursor: pointer;
            font-family: 'Jost', sans-serif; font-size: 0.6rem;
            letter-spacing: 0.2em; color: var(--gold);
            transition: opacity 0.2s; padding-left: 12px;
        }
        .btn-copy:hover { opacity: 0.7; }

        /* ── QUICK VIEW MODAL ── */
        #qv-modal {
            position: fixed; inset: 0; z-index: 200;
            display: none; align-items: center; justify-content: center;
            padding: 24px;
        }
        #qv-modal.show { display: flex; }
        #qv-overlay {
            position: absolute; inset: 0;
            background: rgba(0,0,0,0.5);
            backdrop-filter: blur(4px);
        }
        .qv-inner {
            position: relative; z-index: 1;
            background: var(--cream);
            max-width: 820px; width: 100%;
            display: grid; grid-template-columns: 1fr 1fr;
            animation: modalIn 0.4s cubic-bezier(0.34,1.2,0.64,1) both;
        }
        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.95) translateY(20px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }
        @media(max-width:640px){ .qv-inner { grid-template-columns: 1fr; } }
        .qv-img { width: 100%; aspect-ratio: 3/4; object-fit: cover; display: block; }
        .qv-body { padding: 40px 36px; display: flex; flex-direction: column; justify-content: center; }
        .qv-close {
            position: absolute; top: 14px; right: 14px;
            width: 32px; height: 32px; border-radius: 50%;
            background: rgba(255,255,255,0.9); border: none; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            color: var(--charcoal); font-size: 0.72rem;
            transition: background 0.2s;
        }
        .qv-close:hover { background: #fff; }

        /* ── TOAST ── */
        #toast {
            position: fixed; bottom: 28px; left: 50%; transform: translateX(-50%) translateY(80px);
            z-index: 300;
            background: var(--charcoal); color: #fff;
            padding: 13px 22px;
            display: flex; align-items: center; gap: 10px;
            font-size: 0.72rem; letter-spacing: 0.06em; font-weight: 300;
            border-left: 2px solid var(--gold);
            opacity: 0;
            transition: transform 0.4s cubic-bezier(0.34,1.56,0.64,1), opacity 0.4s;
            white-space: nowrap;
        }
        #toast.show { transform: translateX(-50%) translateY(0); opacity: 1; }
        #toast i { color: var(--gold); }

        /* ── RECOMMENDED ── */
        .rec-section {
            background: var(--ivory);
            padding: 72px 40px;
        }
        .rec-inner { max-width: 1200px; margin: 0 auto; }
        .rec-header {
            display: flex; justify-content: space-between; align-items: flex-end;
            margin-bottom: 36px;
        }
        .rec-eyebrow {
            font-size: 0.58rem; letter-spacing: 0.32em; color: var(--gold);
            font-weight: 300; display: block; margin-bottom: 6px;
        }
        .rec-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem; font-weight: 400; color: var(--charcoal);
        }
        .rec-link {
            font-size: 0.6rem; letter-spacing: 0.2em; color: var(--warm-gray);
            text-decoration: none; border-bottom: 1px solid rgba(28,28,28,0.15);
            transition: color 0.3s;
        }
        .rec-link:hover { color: var(--gold); }

        .rec-grid {
            display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;
        }
        @media(max-width:900px){ .rec-grid { grid-template-columns: repeat(2,1fr); } }

        .rec-card {
            cursor: pointer; position: relative;
        }
        .rec-img-wrap { overflow: hidden; aspect-ratio: 3/4; background: var(--cream); margin-bottom: 14px; }
        .rec-img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.6s ease; }
        .rec-card:hover .rec-img { transform: scale(1.04); }
        .rec-collection { font-size: 0.55rem; letter-spacing: 0.24em; color: var(--gold); margin-bottom: 4px; }
        .rec-name { font-family: 'Playfair Display', serif; font-size: 0.9rem; color: var(--charcoal); margin-bottom: 3px; }
        .rec-price { font-size: 0.78rem; color: var(--charcoal); font-weight: 300; }
        .btn-rec-wish {
            position: absolute; top: 10px; right: 10px;
            width: 30px; height: 30px; border-radius: 50%;
            background: rgba(255,255,255,0.88); border: none; cursor: pointer;
            display: flex; align-items: center; justify-content: center;
            color: rgba(28,28,28,0.4); font-size: 0.68rem;
            opacity: 0; transform: scale(0.7);
            transition: opacity 0.25s, transform 0.25s, color 0.25s;
        }
        .rec-card:hover .btn-rec-wish { opacity: 1; transform: scale(1); }
        .btn-rec-wish:hover { color: var(--gold); }

        /* ── FOOTER ── */
        footer {
            background: var(--charcoal);
            padding: 28px 48px;
            display: flex; justify-content: space-between; align-items: center;
            flex-wrap: wrap; gap: 12px;
        }
        .footer-logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem; letter-spacing: 0.2em;
            color: rgba(255,255,255,0.6); text-decoration: none;
        }
        .footer-copy {
            font-size: 0.58rem; color: rgba(255,255,255,0.2);
            letter-spacing: 0.12em;
        }
        .footer-socials { display: flex; gap: 16px; }
        .footer-socials a {
            color: rgba(255,255,255,0.3); font-size: 0.85rem;
            transition: color 0.3s; text-decoration: none;
        }
        .footer-socials a:hover { color: var(--gold); }
    </style>
</head>
<body>

    <!-- NAV -->
    <nav id="main-nav">
        <a href="{{ route('home') }}" class="nav-logo">LUMIÈRE</a>
        <div class="nav-links">
            <a href="{{ route('collections') }}" class="nav-link">COLLECTIONS</a>
            <a href="{{ route('shop') }}" class="nav-link">SHOP</a>
            <a href="{{ route('home') }}#about" class="nav-link">ABOUT</a>
            <a href="{{ route('contact') }}" class="nav-link">CONTACT</a>
        </div>
        <div class="nav-icons">
            <button class="nav-icon-btn" title="Wishlist"><i class="fa-solid fa-heart" style="color:var(--gold)"></i></button>
            <button class="nav-icon-btn" title="Account"><i class="fa-regular fa-user"></i></button>
            <button class="nav-icon-btn" title="Cart" style="position:relative" onclick="window.location.href='{{ route('cart.index') }}'">
                <i class="fa-solid fa-bag-shopping"></i>
                <span class="cart-count" id="cart-count">0</span>
            </button>
        </div>
    </nav>

    <!-- SHARE OVERLAY + DRAWER -->
    <div id="share-overlay" onclick="closeShare()"></div>
    <div id="share-drawer">
        <div class="drawer-head">
            <span class="drawer-title">Share Your Wishlist</span>
            <button class="drawer-close" onclick="closeShare()"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="share-options">
            <button class="share-opt" onclick="showToast('Link copied to clipboard','fa-solid fa-check');closeShare()">
                <i class="fa-solid fa-link"></i> Copy Link
            </button>
            <button class="share-opt" onclick="showToast('Opening email…','fa-solid fa-envelope');closeShare()">
                <i class="fa-solid fa-envelope"></i> Email Wishlist
            </button>
            <button class="share-opt" onclick="showToast('Opening WhatsApp…','fa-brands fa-whatsapp');closeShare()">
                <i class="fa-brands fa-whatsapp"></i> WhatsApp
            </button>
            <button class="share-opt" onclick="showToast('Copied for Instagram','fa-brands fa-instagram');closeShare()">
                <i class="fa-brands fa-instagram"></i> Instagram
            </button>
            <button class="share-opt" onclick="showToast('Saved as PDF','fa-solid fa-file-pdf');closeShare()">
                <i class="fa-solid fa-file-pdf"></i> Save as PDF
            </button>
        </div>
        <div class="share-link-row">
            <input class="share-link-input" id="share-link" value="https://lumiere.com/wishlist/isabelle-moreau-A3X9K" readonly>
            <button class="btn-copy" onclick="showToast('Link copied','fa-solid fa-check')">COPY</button>
        </div>
    </div>

    <!-- QUICK VIEW MODAL -->
    <div id="qv-modal">
        <div id="qv-overlay" onclick="closeQV()"></div>
        <div class="qv-inner">
            <img id="qv-img" class="qv-img" src="" alt="">
            <div class="qv-body">
                <span style="font-size:0.55rem;letter-spacing:0.28em;color:var(--gold);display:block;margin-bottom:8px" id="qv-collection">L'ÉCLAT</span>
                <h2 style="font-family:'Playfair Display',serif;font-size:1.5rem;font-weight:400;margin-bottom:6px" id="qv-name">—</h2>
                <p style="font-size:0.7rem;color:var(--warm-gray);font-weight:300;margin-bottom:16px" id="qv-variant">—</p>
                <div style="width:32px;height:1px;background:var(--gold);margin-bottom:20px"></div>
                <p style="font-size:0.8rem;color:var(--warm-gray);font-weight:300;line-height:1.75;margin-bottom:24px" id="qv-desc">—</p>
                <div style="font-family:'Playfair Display',serif;font-size:1.4rem;color:var(--charcoal);margin-bottom:24px" id="qv-price">—</div>
                <button class="btn-add-cart" style="width:100%" onclick="addToCart(currentQV); closeQV();">
                    <i class="fa-solid fa-bag-shopping"></i>
                    <span>ADD TO CART</span>
                </button>
            </div>
            <button class="qv-close" onclick="closeQV()"><i class="fa-solid fa-xmark"></i></button>
        </div>
    </div>

    <!-- TOAST -->
    <div id="toast"><i id="toast-icon" class="fa-solid fa-check"></i><span id="toast-msg">Done</span></div>

    <!-- PAGE HERO -->
    <div class="page-hero">
        <span class="hero-eyebrow">YOUR CURATION</span>
        <h1 class="hero-title">Wishlist</h1>
        <p class="hero-subtitle">Pieces saved for the right moment</p>
        <div class="hero-rule"></div>
        <div class="count-pill">
            <i class="fa-solid fa-heart" style="color:var(--gold);font-size:0.6rem"></i>
            <span><strong id="wish-count">5</strong> pieces saved</span>
        </div>
    </div>

    <!-- TOOLBAR -->
    <div class="toolbar">
        <div class="toolbar-left">
            <div class="filter-pill active" onclick="filterWish('all',this)">ALL</div>
            <div class="filter-pill" onclick="filterWish('ring',this)">RINGS</div>
            <div class="filter-pill" onclick="filterWish('necklace',this)">NECKLACES</div>
            <div class="filter-pill" onclick="filterWish('earrings',this)">EARRINGS</div>
            <div class="filter-pill" onclick="filterWish('bracelet',this)">BRACELETS</div>
        </div>
        <div class="toolbar-right">
            <select class="sort-select" onchange="sortWish(this.value)">
                <option value="date">DATE ADDED</option>
                <option value="price-asc">PRICE: LOW–HIGH</option>
                <option value="price-desc">PRICE: HIGH–LOW</option>
                <option value="name">NAME A–Z</option>
            </select>
            <button class="btn-share" onclick="openShare()">
                <i class="fa-solid fa-share-nodes"></i> <span>SHARE</span>
            </button>
            <button class="btn-cart-all" onclick="addAllToCart()">
                <i class="fa-solid fa-bag-shopping"></i>
                <span>ADD ALL TO CART</span>
            </button>
        </div>
    </div>

    <!-- WISHLIST GRID -->
    <div class="wishlist-grid" id="wishlist-grid">
        <!-- Cards injected by JS -->
    </div>

    <!-- EMPTY STATE (hidden by default) -->
    <div id="empty-state">
        <div class="empty-icon"><i class="fa-regular fa-heart"></i></div>
        <h2 class="empty-title">Your wishlist is empty</h2>
        <p class="empty-sub">
            Save pieces you love while browsing — they'll be waiting here whenever you're ready.
        </p>
        <a href="{{ route('shop') }}" class="btn-browse">
            <span>EXPLORE THE COLLECTION</span>
            <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>

    <!-- RECOMMENDED -->
    <div class="rec-section">
        <div class="rec-inner">
            <div class="rec-header">
                <div>
                    <span class="rec-eyebrow">YOU MAY ALSO LOVE</span>
                    <h2 class="rec-title">Curated for You</h2>
                </div>
                <a href="{{ route('shop') }}" class="rec-link">VIEW ALL PIECES</a>
            </div>
            <div class="rec-grid">
                @foreach($recommendedProducts as $product)
                <div class="rec-card" onclick="window.location.href='{{ route('product.show', $product) }}'">
                    <div class="rec-img-wrap">
                        <img src="{{ $product->primaryImage?->image_url ?? 'https://images.unsplash.com/photo-1605100804763-247f67b3557e?q=80&w=800&auto=format&fit=crop' }}" class="rec-img" alt="{{ $product->name }}">
                    </div>
                    <button class="btn-rec-wish" data-product-id="{{ $product->id }}" onclick="event.stopPropagation();addToCart({{ $product->id }}, null, 1)">
                        <i class="fa-solid fa-bag-shopping"></i>
                    </button>
                    <span class="rec-collection">{{ $product->collection?->name ?? 'LUMIÈRE' }}</span>
                    <div class="rec-name">{{ $product->name }}</div>
                    <div class="rec-price">€{{ number_format($product->price, 2) }}</div>
                </div>
                @endforeach
                @if($recommendedProducts->count() < 4)
                    @for($i = $recommendedProducts->count(); $i < 4; $i++)
                    <div class="rec-card opacity-50">
                        <div class="rec-img-wrap">
                            <img src="https://images.unsplash.com/photo-1605100804763-247f67b3557e?q=80&w=800&auto=format&fit=crop" class="rec-img" alt="Coming Soon">
                        </div>
                        <span class="rec-collection">LUMIÈRE</span>
                        <div class="rec-name">More Coming Soon</div>
                        <div class="rec-price">--</div>
                    </div>
                    @endfor
                @endif
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer>
        <a href="{{ route('home') }}" class="footer-logo">LUMIÈRE</a>
        <p class="footer-copy">© 2026 Lumière Jewelry · Crafted with elegance in Paris</p>
        <div class="footer-socials">
            <a href="#"><i class="fa-brands fa-instagram"></i></a>
            <a href="#"><i class="fa-brands fa-pinterest"></i></a>
            <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
        </div>
    </footer>

    @php
        $wishlistItemsForJson = $items->map(function ($item) {
            $product = $item->product;
            $stock = $product->variants->isEmpty() ? 1 : (int) $product->variants->sum('stock');

            return [
                'id' => $product->id,
                'productId' => $product->id,
                'category' => strtolower((string) $product->category),
                'collection' => $product->collection?->name ?? 'LUMIERE',
                'name' => $product->name,
                'variant' => $product->variants->pluck('label')->filter()->join(' / ') ?: 'Standard',
                'desc' => $product->description ?? '',
                'price' => (float) $product->price,
                'oldPrice' => null,
                'img' => $product->primaryImage?->image_url ?? 'https://images.unsplash.com/photo-1617038220319-276d3cfab638?q=80&w=1200&auto=format&fit=crop',
                'stock' => $stock <= 0 ? 'out' : ($stock <= 2 ? 'low' : 'in'),
                'stockLabel' => $stock <= 0 ? 'Out of stock' : ($stock <= 2 ? "Only {$stock} left" : 'In stock'),
                'dateAdded' => $item->created_at ? 'Added '.$item->created_at->format('M j, Y') : 'Saved',
                'badge' => $stock <= 0 ? null : ($stock <= 2 ? 'LAST FEW' : null),
                'url' => route('product.show', $product),
            ];
        })->values();
    @endphp

    <script>
        // ── DATA ──
        const wishItems = @json($wishlistItemsForJson);
        let filtered = [...wishItems];
        let cartCount = 0;
        let currentQV = null;

        function getCsrfToken() {
            return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';
        }

        function setCartCount(count) {
            cartCount = count || 0;
            document.getElementById('cart-count').textContent = cartCount;
        }

        function refreshCartCount() {
            fetch('/api/cart/count', { headers: { 'Accept': 'application/json' } })
                .then(response => response.json())
                .then(data => setCartCount(data.count || 0))
                .catch(error => console.error('Error updating cart count:', error));
        }

        // ── RENDER ──
        function renderWishlist(items) {
            const grid = document.getElementById('wishlist-grid');
            const empty = document.getElementById('empty-state');
            document.getElementById('wish-count').textContent = items.length;

            if (items.length === 0) {
                grid.style.display = 'none';
                empty.style.display = 'block';
                return;
            }
            grid.style.display = 'grid';
            empty.style.display = 'none';

            grid.innerHTML = items.map((item, i) => {
                const discount = item.oldPrice ? Math.round((1 - item.price / item.oldPrice) * 100) : 0;
                const isOut = item.stock === 'out';
                return `
                <div class="wish-card" data-id="${item.id}" data-cat="${item.category}" style="animation-delay:${i * 0.07}s">
                    <div class="card-img-wrap">
                        <img class="card-img" src="${item.img}" alt="${item.name}" loading="lazy">
                        ${item.badge ? `<div class="collection-badge">${item.badge}</div>` : ''}
                        <div class="date-badge">${item.dateAdded}</div>
                        <button class="btn-remove" onclick="removeItem(${item.id})" title="Remove from wishlist">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <span class="card-collection">${item.collection}</span>
                        <h3 class="card-name"><a href="${item.url}" style="color:inherit;text-decoration:none">${item.name}</a></h3>
                        <p class="card-variant">${item.variant}</p>
                        <div class="price-row">
                            <span class="price-main">€${item.price.toLocaleString()}</span>
                            ${item.oldPrice ? `<span class="price-old">€${item.oldPrice.toLocaleString()}</span><span class="price-save">SAVE ${discount}%</span>` : ''}
                        </div>
                        <div class="stock-row">
                            <div class="stock-dot ${item.stock}"></div>
                            <span class="stock-label ${item.stock === 'in' ? '' : item.stock}">${item.stockLabel}</span>
                        </div>
                        <div class="card-actions">
                            <button class="btn-add-cart" ${isOut ? 'disabled' : ''} onclick="addToCart(${item.id})">
                                <i class="fa-solid fa-bag-shopping"></i>
                                <span>${isOut ? 'OUT OF STOCK' : 'ADD TO CART'}</span>
                            </button>
                            <button class="btn-quick-view" title="Quick view" onclick="openQV(${item.id})">
                                <i class="fa-regular fa-eye"></i>
                            </button>
                            <button class="btn-move-bespoke" title="Request bespoke version" onclick="showToast('Opening bespoke consultation…','fa-solid fa-wand-magic-sparkles')">
                                <i class="fa-solid fa-wand-magic-sparkles"></i>
                            </button>
                        </div>
                    </div>
                </div>`;
            }).join('');
        }

        // ── REMOVE ──
        async function removeItem(id) {
            const card = document.querySelector(`[data-id="${id}"]`);
            if (!card) return;
            card.style.transition = 'opacity 0.3s, transform 0.3s';
            card.style.opacity = '0';
            card.style.transform = 'scale(0.95) translateY(-8px)';

            try {
                const response = await fetch('{{ route('wishlist.remove') }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken(),
                    },
                    body: JSON.stringify({ product_id: id }),
                });

                if (!response.ok) throw new Error('Failed to remove item');

                const idx = wishItems.findIndex(i => i.id === id);
                if (idx > -1) wishItems.splice(idx, 1);
                filtered = filtered.filter(i => i.id !== id);
                renderWishlist(filtered);
                showToast('Removed from wishlist', 'fa-regular fa-heart');
            } catch (error) {
                card.style.opacity = '1';
                card.style.transform = '';
                console.error('Error removing from wishlist:', error);
                showToast('Could not remove item', 'fa-solid fa-circle-exclamation');
            }
        }

        // ── ADD TO CART ──
        async function addToCart(id) {
            const item = wishItems.find(i => i.id === id);
            if (!item || item.stock === 'out') return;

            try {
                const response = await fetch('{{ route('api.cart.add') }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': getCsrfToken(),
                    },
                    body: JSON.stringify({
                        product_id: item.productId,
                        quantity: 1,
                    }),
                });

                if (!response.ok) throw new Error('Failed to add item to cart');

                const data = await response.json();
                setCartCount(data.cart_count || cartCount + 1);
                showToast(`${item.name} added to cart`, 'fa-solid fa-bag-shopping');
            } catch (error) {
                console.error('Error adding to cart:', error);
                showToast('Could not add item to cart', 'fa-solid fa-circle-exclamation');
            }
        }

        async function addAllToCart() {
            const addable = filtered.filter(i => i.stock !== 'out');
            if (addable.length === 0) { showToast('No available pieces to add', 'fa-solid fa-circle-exclamation'); return; }

            try {
                for (const item of addable) {
                    const response = await fetch('{{ route('api.cart.add') }}', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': getCsrfToken(),
                        },
                        body: JSON.stringify({
                            product_id: item.productId,
                            quantity: 1,
                        }),
                    });

                    if (!response.ok) throw new Error('Failed to add item to cart');

                    const data = await response.json();
                    if (typeof data.cart_count !== 'undefined') {
                        setCartCount(data.cart_count || 0);
                    }
                }

                showToast(`${addable.length} pieces added to cart`, 'fa-solid fa-bag-shopping');
            } catch (error) {
                console.error('Error adding wishlist to cart:', error);
                showToast('Could not add all items', 'fa-solid fa-circle-exclamation');
            }
        }

        // ── FILTER ──
        function filterWish(cat, el) {
            document.querySelectorAll('.filter-pill').forEach(p => p.classList.remove('active'));
            el.classList.add('active');
            filtered = cat === 'all' ? [...wishItems] : wishItems.filter(i => i.category === cat);
            renderWishlist(filtered);
        }

        // ── SORT ──
        function sortWish(val) {
            if (val === 'price-asc')  filtered.sort((a,b) => a.price - b.price);
            if (val === 'price-desc') filtered.sort((a,b) => b.price - a.price);
            if (val === 'name')       filtered.sort((a,b) => a.name.localeCompare(b.name));
            if (val === 'date')       filtered.sort((a,b) => b.id - a.id);
            renderWishlist(filtered);
        }

        // ── SHARE ──
        function openShare() {
            document.getElementById('share-drawer').classList.add('open');
            document.getElementById('share-overlay').classList.add('show');
        }
        function closeShare() {
            document.getElementById('share-drawer').classList.remove('open');
            document.getElementById('share-overlay').classList.remove('show');
        }

        // ── QUICK VIEW ──
        function openQV(id) {
            const item = wishItems.find(i => i.id === id);
            if (!item) return;
            currentQV = id;
            document.getElementById('qv-img').src = item.img;
            document.getElementById('qv-collection').textContent = item.collection;
            document.getElementById('qv-name').textContent = item.name;
            document.getElementById('qv-variant').textContent = item.variant;
            document.getElementById('qv-desc').textContent = item.desc;
            document.getElementById('qv-price').textContent = `€${item.price.toLocaleString()}`;
            const modal = document.getElementById('qv-modal');
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }
        function closeQV() {
            document.getElementById('qv-modal').classList.remove('show');
            document.body.style.overflow = '';
            currentQV = null;
        }

        // ── TOAST ──
        let toastTimer;
        function showToast(msg, iconClass = 'fa-solid fa-check') {
            clearTimeout(toastTimer);
            document.getElementById('toast-msg').textContent = msg;
            document.getElementById('toast-icon').className = iconClass;
            const t = document.getElementById('toast');
            t.classList.add('show');
            toastTimer = setTimeout(() => t.classList.remove('show'), 2800);
        }

        // ── NAV SCROLL ──
        window.addEventListener('scroll', () => {
            document.getElementById('main-nav').classList.toggle('scrolled', window.scrollY > 40);
        });

        // ── INIT ──
        renderWishlist(filtered);
        refreshCartCount();
    </script>
</body>
</html>
