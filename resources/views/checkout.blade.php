<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout | LUMIÈRE</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;1,300;1,400;1,500&family=Jost:wght@200;300;400;500;600&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --gold:       #C9A84C;
            --gold-light: #E8C97A;
            --gold-dim:   rgba(201,168,76,0.12);
            --cream:      #F9F6F0;
            --ivory:      #F2EDE4;
            --charcoal:   #1C1C1C;
            --mid:        #2C2C2C;
            --warm-gray:  #8A8580;
            --border:     rgba(28,28,28,0.10);
            --border-md:  rgba(28,28,28,0.14);
        }

        html { scroll-behavior: smooth; }
        body {
            font-family: 'Jost', sans-serif;
            background: var(--cream);
            color: var(--charcoal);
            min-height: 100vh;
        }

        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: var(--cream); }
        ::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 4px; }
        ::selection { background: var(--gold); color: #fff; }

        /* ─── NAV ─── */
        nav {
            position: sticky;
            top: 0;
            z-index: 50;
            background: rgba(249,246,240,0.96);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border);
            padding: 18px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .nav-logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.35rem;
            letter-spacing: 0.22em;
            color: var(--charcoal);
            text-decoration: none;
        }
        .nav-secure {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 0.62rem;
            letter-spacing: 0.22em;
            color: var(--warm-gray);
            font-weight: 300;
        }
        .nav-secure i { color: var(--gold); font-size: 0.7rem; }

        /* ─── MAIN LAYOUT ─── */
        .checkout-layout {
            display: grid;
            grid-template-columns: 1fr 420px;
            gap: 0;
            max-width: 1180px;
            margin: 0 auto;
            min-height: calc(100vh - 62px);
        }
        @media (max-width: 960px) {
            .checkout-layout { grid-template-columns: 1fr; }
            .order-panel { order: -1; }
        }

        /* ─── LEFT — FORM PANEL ─── */
        .form-panel {
            padding: 52px 60px 80px 40px;
            border-right: 1px solid var(--border);
        }
        @media (max-width: 960px) {
            .form-panel { padding: 36px 24px; border-right: none; }
        }

        /* ─── BREADCRUMB STEPS ─── */
        .step-breadcrumb {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 44px;
        }
        .crumb {
            font-size: 0.6rem;
            letter-spacing: 0.22em;
            font-weight: 300;
            color: rgba(28,28,28,0.28);
            cursor: pointer;
            transition: color 0.3s;
        }
        .crumb.active { color: var(--charcoal); }
        .crumb.done   { color: var(--gold); cursor: pointer; }
        .crumb.done:hover { opacity: 0.75; }
        .crumb-sep { color: rgba(28,28,28,0.18); font-size: 0.55rem; }

        /* ─── ACCORDION SECTIONS ─── */
        .acc-section {
            border-bottom: 1px solid var(--border);
            overflow: hidden;
        }
        .acc-section:first-of-type { border-top: 1px solid var(--border); }

        .acc-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 22px 0;
            cursor: default;
        }
        .acc-header.clickable { cursor: pointer; }
        .acc-header.clickable:hover .acc-edit { opacity: 1; }

        .acc-left { display: flex; align-items: center; gap: 16px; }

        .acc-num {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            border: 1px solid var(--border-md);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.62rem;
            font-weight: 400;
            color: rgba(28,28,28,0.4);
            transition: background 0.3s, border-color 0.3s, color 0.3s;
            flex-shrink: 0;
        }
        .acc-num.active {
            background: var(--charcoal);
            border-color: var(--charcoal);
            color: #fff;
        }
        .acc-num.done {
            background: var(--gold);
            border-color: var(--gold);
            color: #fff;
        }

        .acc-title {
            font-family: 'Playfair Display', serif;
            font-size: 1rem;
            font-weight: 400;
            color: rgba(28,28,28,0.35);
            transition: color 0.3s;
            letter-spacing: 0.03em;
        }
        .acc-title.active { color: var(--charcoal); }

        .acc-summary {
            font-size: 0.7rem;
            color: var(--warm-gray);
            font-weight: 300;
            letter-spacing: 0.04em;
            line-height: 1.6;
            display: none;
        }

        .acc-edit {
            font-size: 0.58rem;
            letter-spacing: 0.22em;
            color: var(--gold);
            opacity: 0;
            transition: opacity 0.3s;
            font-weight: 300;
        }

        .acc-body {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s cubic-bezier(0.4,0,0.2,1);
        }
        .acc-body.open { max-height: 1000px; }
        .acc-body-inner { padding-bottom: 32px; }

        /* ─── FORM FIELDS ─── */
        .field-group { margin-bottom: 24px; }
        .field-label {
            display: block;
            font-size: 0.58rem;
            letter-spacing: 0.28em;
            color: rgba(28,28,28,0.4);
            margin-bottom: 9px;
            font-weight: 300;
        }
        .field-wrap {
            position: relative;
            display: flex;
            align-items: center;
            border-bottom: 1px solid var(--border-md);
            transition: border-color 0.3s;
        }
        .field-wrap:focus-within { border-bottom-color: var(--gold); }
        .field-wrap i {
            color: rgba(28,28,28,0.25);
            font-size: 0.72rem;
            margin-right: 11px;
            transition: color 0.3s;
        }
        .field-wrap:focus-within i { color: var(--gold); }
        .lux-input {
            flex: 1;
            border: none;
            background: transparent;
            outline: none;
            padding: 10px 0;
            font-family: 'Jost', sans-serif;
            font-size: 0.84rem;
            font-weight: 300;
            color: var(--charcoal);
            letter-spacing: 0.03em;
        }
        .lux-input::placeholder { color: rgba(28,28,28,0.22); }
        .lux-select {
            flex: 1;
            border: none;
            background: transparent;
            outline: none;
            padding: 10px 0;
            font-family: 'Jost', sans-serif;
            font-size: 0.84rem;
            font-weight: 300;
            color: var(--charcoal);
            -webkit-appearance: none;
            cursor: pointer;
        }
        .lux-select option { background: var(--cream); }

        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; }

        /* ─── SHIPPING OPTIONS ─── */
        .shipping-opts { display: flex; flex-direction: column; gap: 10px; margin-bottom: 28px; }
        .ship-opt {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 18px;
            border: 1px solid var(--border-md);
            cursor: pointer;
            transition: border-color 0.25s, background 0.25s;
            position: relative;
        }
        .ship-opt:hover { border-color: rgba(201,168,76,0.4); }
        .ship-opt.selected { border-color: var(--gold); background: var(--gold-dim); }
        .ship-opt input { display: none; }
        .ship-radio {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            border: 1px solid var(--border-md);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: border-color 0.25s;
        }
        .ship-opt.selected .ship-radio { border-color: var(--gold); }
        .ship-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--gold);
            transform: scale(0);
            transition: transform 0.25s cubic-bezier(0.34,1.56,0.64,1);
        }
        .ship-opt.selected .ship-dot { transform: scale(1); }
        .ship-info { flex: 1; }
        .ship-name { font-size: 0.78rem; font-weight: 400; color: var(--charcoal); letter-spacing: 0.04em; }
        .ship-eta  { font-size: 0.65rem; color: var(--warm-gray); font-weight: 300; margin-top: 2px; }
        .ship-price { font-size: 0.78rem; color: var(--charcoal); font-weight: 300; letter-spacing: 0.04em; }
        .ship-price.free { color: var(--gold); }

        /* ─── CARD VISUAL ─── */
        .card-visual-wrap {
            perspective: 1000px;
            margin-bottom: 28px;
            height: 140px;
        }
        .card-visual {
            width: 100%;
            max-width: 320px;
            height: 140px;
            margin: 0 auto;
            position: relative;
            transform-style: preserve-3d;
            transition: transform 0.7s cubic-bezier(0.4,0,0.2,1);
        }
        .card-visual.flipped { transform: rotateY(180deg); }
        .card-face {
            position: absolute;
            inset: 0;
            border-radius: 10px;
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
            padding: 20px 24px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .card-front {
            background: linear-gradient(135deg, #2a2a2a 0%, #1a1a1a 60%, #141414 100%);
            position: relative;
            overflow: hidden;
        }
        .card-front::before {
            content: '';
            position: absolute;
            top: -30px; right: -30px;
            width: 160px; height: 160px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(201,168,76,0.15) 0%, transparent 70%);
        }
        .card-back {
            background: linear-gradient(135deg, #1a1a1a 0%, #2a2a2a 100%);
            transform: rotateY(180deg);
        }
        .card-chip {
            width: 30px;
            height: 22px;
            border-radius: 4px;
            background: linear-gradient(135deg, var(--gold-light), var(--gold));
            position: relative;
            overflow: hidden;
        }
        .card-chip::after {
            content: '';
            position: absolute;
            top: 50%; left: 0; right: 0;
            height: 1px;
            background: rgba(0,0,0,0.2);
            transform: translateY(-50%);
        }
        .card-number-disp {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.1rem;
            letter-spacing: 0.18em;
            color: rgba(255,255,255,0.75);
            font-weight: 300;
        }
        .card-bottom { display: flex; justify-content: space-between; align-items: flex-end; }
        .card-holder-label { font-size: 0.5rem; letter-spacing: 0.2em; color: rgba(255,255,255,0.3); font-family: 'Jost', sans-serif; margin-bottom: 3px; }
        .card-holder-name  { font-size: 0.72rem; letter-spacing: 0.08em; color: rgba(255,255,255,0.75); font-family: 'Jost', sans-serif; font-weight: 300; }
        .card-brand-logo { font-family: 'Cormorant Garamond', serif; font-style: italic; color: var(--gold); font-size: 0.75rem; letter-spacing: 0.1em; opacity: 0.7; }

        .cvv-strip { height: 32px; background: rgba(255,255,255,0.07); margin-bottom: 16px; }
        .cvv-box {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 10px;
        }
        .cvv-label { font-size: 0.58rem; letter-spacing: 0.18em; color: rgba(255,255,255,0.3); font-family: 'Jost', sans-serif; }
        .cvv-val { font-family: 'Cormorant Garamond', serif; font-size: 1rem; color: rgba(255,255,255,0.65); letter-spacing: 0.15em; }

        /* card field number formatting */
        .card-num-field { letter-spacing: 0.15em; font-family: 'Jost', sans-serif; }

        /* ─── PAYMENT METHOD TABS ─── */
        .pay-tabs { display: flex; gap: 10px; margin-bottom: 24px; }
        .pay-tab {
            flex: 1;
            padding: 11px 10px;
            border: 1px solid var(--border-md);
            background: transparent;
            cursor: pointer;
            font-family: 'Jost', sans-serif;
            font-size: 0.62rem;
            letter-spacing: 0.18em;
            color: rgba(28,28,28,0.45);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            transition: border-color 0.25s, color 0.25s, background 0.25s;
        }
        .pay-tab i { font-size: 0.85rem; }
        .pay-tab.active {
            border-color: var(--charcoal);
            color: var(--charcoal);
            background: rgba(28,28,28,0.03);
        }

        /* ─── CONTINUE BUTTON ─── */
        .btn-continue {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 15px 36px;
            background: var(--charcoal);
            color: #fff;
            border: none;
            font-family: 'Jost', sans-serif;
            font-size: 0.64rem;
            letter-spacing: 0.28em;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: color 0.35s;
            margin-top: 8px;
        }
        .btn-continue::before {
            content: '';
            position: absolute;
            inset: 0;
            background: var(--gold);
            transform: translateX(-100%);
            transition: transform 0.4s cubic-bezier(0.4,0,0.2,1);
        }
        .btn-continue:hover::before { transform: translateX(0); }
        .btn-continue span { position: relative; z-index: 1; }
        .btn-continue i  { position: relative; z-index: 1; font-size: 0.7rem; }

        /* Place order — gold version */
        .btn-place {
            width: 100%;
            padding: 17px;
            background: var(--gold);
            color: #fff;
            border: none;
            font-family: 'Jost', sans-serif;
            font-size: 0.64rem;
            letter-spacing: 0.28em;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: color 0.35s;
            margin-top: 8px;
        }
        .btn-place::before {
            content: '';
            position: absolute;
            inset: 0;
            background: #A8862E;
            transform: translateY(100%);
            transition: transform 0.4s cubic-bezier(0.4,0,0.2,1);
        }
        .btn-place:hover::before { transform: translateY(0); }
        .btn-place span { position: relative; z-index: 1; }

        /* ─── RIGHT — ORDER PANEL ─── */
        .order-panel {
            background: var(--ivory);
            padding: 52px 36px 60px;
            position: sticky;
            top: 62px;
            height: calc(100vh - 62px);
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }
        @media (max-width: 960px) {
            .order-panel { position: static; height: auto; padding: 32px 24px; border-bottom: 1px solid var(--border); }
        }

        .order-title {
            font-family: 'Playfair Display', serif;
            font-size: 0.95rem;
            letter-spacing: 0.12em;
            font-weight: 400;
            color: var(--charcoal);
            margin-bottom: 28px;
        }

        /* Order items */
        .order-items { display: flex; flex-direction: column; gap: 18px; margin-bottom: 28px; }
        .order-item { display: flex; gap: 14px; align-items: center; }
        .item-img-wrap {
            position: relative;
            flex-shrink: 0;
        }
        .item-img {
            width: 64px;
            height: 64px;
            object-fit: cover;
            display: block;
        }
        .item-qty {
            position: absolute;
            top: -7px;
            right: -7px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: var(--charcoal);
            color: #fff;
            font-size: 0.58rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 400;
        }
        .item-name {
            font-family: 'Playfair Display', serif;
            font-size: 0.82rem;
            font-weight: 400;
            color: var(--charcoal);
            margin-bottom: 3px;
        }
        .item-variant { font-size: 0.65rem; color: var(--warm-gray); font-weight: 300; letter-spacing: 0.06em; }
        .item-price { margin-left: auto; font-size: 0.82rem; color: var(--charcoal); font-weight: 300; white-space: nowrap; }

        /* Promo code */
        .promo-wrap {
            display: flex;
            gap: 0;
            border-bottom: 1px solid var(--border-md);
            margin-bottom: 24px;
        }
        .promo-input {
            flex: 1;
            border: none;
            background: transparent;
            outline: none;
            padding: 10px 0;
            font-family: 'Jost', sans-serif;
            font-size: 0.78rem;
            font-weight: 300;
            color: var(--charcoal);
            letter-spacing: 0.04em;
        }
        .promo-input::placeholder { color: rgba(28,28,28,0.25); letter-spacing: 0.1em; font-size: 0.7rem; }
        .promo-btn {
            background: none;
            border: none;
            font-family: 'Jost', sans-serif;
            font-size: 0.6rem;
            letter-spacing: 0.22em;
            color: var(--gold);
            cursor: pointer;
            padding-left: 12px;
            transition: opacity 0.2s;
        }
        .promo-btn:hover { opacity: 0.7; }
        .promo-success {
            font-size: 0.62rem;
            color: var(--gold);
            letter-spacing: 0.12em;
            margin-bottom: 12px;
            display: none;
        }

        /* Totals */
        .totals { margin-top: auto; }
        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 9px 0;
            border-bottom: 1px solid var(--border);
        }
        .total-row:last-child { border-bottom: none; }
        .total-label { font-size: 0.68rem; letter-spacing: 0.1em; color: var(--warm-gray); font-weight: 300; }
        .total-value { font-size: 0.78rem; color: var(--charcoal); font-weight: 300; }
        .total-row.grand .total-label { font-family: 'Playfair Display', serif; color: var(--charcoal); font-size: 0.9rem; letter-spacing: 0.04em; font-weight: 400; }
        .total-row.grand .total-value { font-family: 'Playfair Display', serif; font-size: 1.1rem; color: var(--charcoal); font-weight: 400; }
        .discount-val { color: var(--gold) !important; }

        /* Trust badges */
        .trust-badges {
            display: flex;
            justify-content: center;
            gap: 18px;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }
        .trust-badge {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.58rem;
            letter-spacing: 0.12em;
            color: rgba(28,28,28,0.35);
            font-weight: 300;
        }
        .trust-badge i { color: var(--gold); font-size: 0.72rem; }

        /* ─── GIFT MESSAGE ─── */
        .gift-toggle {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            margin-bottom: 16px;
        }
        .toggle-track {
            width: 32px;
            height: 17px;
            border-radius: 17px;
            border: 1px solid var(--border-md);
            position: relative;
            transition: background 0.3s, border-color 0.3s;
        }
        .toggle-track.on { background: var(--gold); border-color: var(--gold); }
        .toggle-thumb {
            position: absolute;
            top: 2px;
            left: 2px;
            width: 11px;
            height: 11px;
            border-radius: 50%;
            background: rgba(28,28,28,0.3);
            transition: transform 0.3s cubic-bezier(0.34,1.56,0.64,1), background 0.3s;
        }
        .toggle-track.on .toggle-thumb { transform: translateX(15px); background: #fff; }
        .toggle-label { font-size: 0.7rem; letter-spacing: 0.14em; color: var(--charcoal); font-weight: 300; }

        .gift-area {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.4s cubic-bezier(0.4,0,0.2,1);
        }
        .gift-area.open { max-height: 200px; }
        .gift-textarea {
            width: 100%;
            border: 1px solid var(--border-md);
            background: rgba(249,246,240,0.6);
            padding: 12px 14px;
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-weight: 300;
            font-size: 0.9rem;
            color: var(--charcoal);
            outline: none;
            resize: none;
            transition: border-color 0.3s;
            letter-spacing: 0.02em;
            line-height: 1.6;
        }
        .gift-textarea:focus { border-color: var(--gold); }
        .gift-textarea::placeholder { color: rgba(28,28,28,0.22); font-style: italic; }

        /* ─── CONFIRMATION STATE ─── */
        #confirmation {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 100;
            background: var(--cream);
            align-items: center;
            justify-content: center;
            flex-direction: column;
            overflow: hidden;
        }
        #confirmation.show { display: flex; }

        /* Gold particle burst */
        .particles {
            position: fixed;
            inset: 0;
            pointer-events: none;
            z-index: 101;
        }
        .particle {
            position: absolute;
            width: 3px;
            height: 3px;
            border-radius: 50%;
            background: var(--gold);
            opacity: 0;
        }

        .confirm-inner {
            position: relative;
            z-index: 102;
            text-align: center;
            max-width: 500px;
            padding: 40px 32px;
            animation: confirmIn 0.7s cubic-bezier(0.34,1.2,0.64,1) 0.2s both;
        }
        @keyframes confirmIn {
            from { opacity: 0; transform: translateY(30px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        .confirm-seal {
            width: 80px;
            height: 80px;
            margin: 0 auto 32px;
            animation: sealPop 0.6s cubic-bezier(0.34,1.56,0.64,1) 0.4s both;
        }
        @keyframes sealPop {
            from { transform: scale(0) rotate(-20deg); opacity: 0; }
            to   { transform: scale(1) rotate(0); opacity: 1; }
        }

        .confirm-eyebrow {
            font-size: 0.6rem;
            letter-spacing: 0.35em;
            color: var(--gold);
            font-weight: 300;
            display: block;
            margin-bottom: 12px;
        }
        .confirm-title {
            font-family: 'Cormorant Garamond', serif;
            font-style: italic;
            font-weight: 300;
            font-size: 2.8rem;
            line-height: 1.15;
            color: var(--charcoal);
            margin-bottom: 16px;
        }
        .confirm-rule {
            width: 48px;
            height: 1px;
            background: var(--gold);
            margin: 0 auto 20px;
        }
        .confirm-body {
            font-size: 0.82rem;
            color: var(--warm-gray);
            font-weight: 300;
            line-height: 1.7;
            margin-bottom: 36px;
            letter-spacing: 0.02em;
        }
        .confirm-order-ref {
            display: inline-block;
            background: var(--ivory);
            padding: 10px 22px;
            font-size: 0.65rem;
            letter-spacing: 0.2em;
            color: var(--charcoal);
            margin-bottom: 36px;
            font-weight: 300;
        }
        .confirm-order-ref strong { color: var(--gold); font-weight: 400; }

        .confirm-actions { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
        .btn-outline-dark {
            padding: 13px 28px;
            border: 1px solid rgba(28,28,28,0.2);
            background: transparent;
            font-family: 'Jost', sans-serif;
            font-size: 0.6rem;
            letter-spacing: 0.24em;
            color: var(--charcoal);
            cursor: pointer;
            transition: background 0.3s, color 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        .btn-outline-dark:hover { background: var(--charcoal); color: #fff; }

        /* ─── FIELD ANIMATIONS on open ─── */
        .acc-body.open .field-group {
            animation: fieldFade 0.4s ease both;
        }
        .acc-body.open .field-group:nth-child(1) { animation-delay: 0.05s; }
        .acc-body.open .field-group:nth-child(2) { animation-delay: 0.10s; }
        .acc-body.open .field-group:nth-child(3) { animation-delay: 0.15s; }
        .acc-body.open .field-group:nth-child(4) { animation-delay: 0.20s; }
        .acc-body.open .field-group:nth-child(5) { animation-delay: 0.25s; }
        .acc-body.open .field-group:nth-child(6) { animation-delay: 0.30s; }
        @keyframes fieldFade {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Error state */
        .field-error {
            font-size: 0.58rem;
            color: #c0392b;
            letter-spacing: 0.1em;
            margin-top: 5px;
            display: none;
        }
        .field-error.show { display: block; }
        @keyframes shake {
            0%,100% { transform: translateX(0); }
            25%     { transform: translateX(-5px); }
            75%     { transform: translateX(5px); }
        }
        .shake { animation: shake 0.35s ease; }
    </style>
</head>
<body>

<!-- NAV -->
<nav>
    <a href="lumiere.html" class="nav-logo">LUMIÈRE</a>
    <div class="nav-secure">
        <i class="fa-solid fa-lock-keyhole"></i>
        SECURE CHECKOUT
    </div>
</nav>

<!-- CONFIRMATION OVERLAY -->
<div id="confirmation">
    <canvas class="particles" id="particle-canvas"></canvas>
    <div class="confirm-inner">
        <!-- Wax seal SVG -->
        <div class="confirm-seal">
            <svg viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="40" cy="40" r="38" fill="none" stroke="#C9A84C" stroke-width="0.8" stroke-dasharray="3 4"/>
                <circle cx="40" cy="40" r="30" fill="#C9A84C" opacity="0.08"/>
                <circle cx="40" cy="40" r="22" fill="none" stroke="#C9A84C" stroke-width="0.6"/>
                <text x="40" y="37" text-anchor="middle" font-family="Cormorant Garamond, serif" font-size="9" fill="#C9A84C" letter-spacing="2" font-style="italic">LUMIÈRE</text>
                <path d="M29 45 L36 52 L52 36" stroke="#C9A84C" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" fill="none" opacity="0.8"/>
            </svg>
        </div>
        <span class="confirm-eyebrow">ORDER CONFIRMED</span>
        <h2 class="confirm-title">Merci,<br>your piece awaits</h2>
        <div class="confirm-rule"></div>
        <p class="confirm-body">
            Your order has been received and our atelier is preparing it with care.<br>
            A confirmation has been sent to your email address.
        </p>
        <div class="confirm-order-ref">
            ORDER REFERENCE &nbsp;·&nbsp; <strong id="order-ref">LM-2026-0847</strong>
        </div>
        <div class="confirm-actions">
            <a href="lumiere.html" class="btn-outline-dark">RETURN TO LUMIÈRE</a>
            <a href="#" class="btn-outline-dark" style="background:var(--gold);color:#fff;border-color:var(--gold);">TRACK MY ORDER</a>
        </div>
    </div>
</div>

<!-- MAIN -->
<div class="checkout-layout">

    <!-- ════════════════════════════
         LEFT — FORM
    ════════════════════════════ -->
    <div class="form-panel">

        <!-- Breadcrumb -->
        <div class="step-breadcrumb">
            <span class="crumb done" id="crumb-1" onclick="goStep(1)">CONTACT</span>
            <span class="crumb-sep">›</span>
            <span class="crumb" id="crumb-2">SHIPPING</span>
            <span class="crumb-sep">›</span>
            <span class="crumb" id="crumb-3">PAYMENT</span>
        </div>

        <!-- ── STEP 1: CONTACT ── -->
        <div class="acc-section" id="acc-1">
            <div class="acc-header" id="acc-hdr-1">
                <div class="acc-left">
                    <div class="acc-num active" id="num-1">1</div>
                    <div>
                        <div class="acc-title active" id="title-1">Contact</div>
                        <div class="acc-summary" id="sum-1"></div>
                    </div>
                </div>
                <span class="acc-edit" id="edit-1">EDIT</span>
            </div>
            <div class="acc-body open" id="body-1">
                <div class="acc-body-inner">
                    <div class="grid-2">
                        <div class="field-group">
                            <label class="field-label">FIRST NAME *</label>
                            <div class="field-wrap">
                                <input type="text" class="lux-input" id="c-fname" placeholder="Isabelle" autocomplete="given-name">
                            </div>
                            <p class="field-error" id="c-fname-err">Required.</p>
                        </div>
                        <div class="field-group">
                            <label class="field-label">LAST NAME *</label>
                            <div class="field-wrap">
                                <input type="text" class="lux-input" id="c-lname" placeholder="Moreau" autocomplete="family-name">
                            </div>
                            <p class="field-error" id="c-lname-err">Required.</p>
                        </div>
                    </div>
                    <div class="field-group">
                        <label class="field-label">EMAIL ADDRESS *</label>
                        <div class="field-wrap">
                            <i class="fa-regular fa-envelope"></i>
                            <input type="email" class="lux-input" id="c-email" placeholder="you@example.com" autocomplete="email">
                        </div>
                        <p class="field-error" id="c-email-err">Please enter a valid email.</p>
                    </div>
                    <div class="field-group">
                        <label class="field-label">PHONE <span style="color:rgba(28,28,28,0.25)">(optional, for delivery updates)</span></label>
                        <div class="field-wrap">
                            <i class="fa-regular fa-phone"></i>
                            <input type="tel" class="lux-input" id="c-phone" placeholder="+33 6 00 00 00 00" autocomplete="tel">
                        </div>
                    </div>

                    <!-- Gift toggle -->
                    <div class="field-group">
                        <div class="gift-toggle" onclick="toggleGift()">
                            <div class="toggle-track" id="gift-track">
                                <div class="toggle-thumb"></div>
                            </div>
                            <span class="toggle-label">THIS IS A GIFT</span>
                        </div>
                        <div class="gift-area" id="gift-area">
                            <textarea class="gift-textarea" id="gift-msg" rows="3"
                                      placeholder="Add a personal message… it will be printed on a card inside the gift box."
                                      style="margin-top:8px;"></textarea>
                        </div>
                    </div>

                    <button class="btn-continue" onclick="nextStep(1)">
                        <span>CONTINUE TO SHIPPING</span>
                        <i class="fa-regular fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- ── STEP 2: SHIPPING ── -->
        <div class="acc-section" id="acc-2">
            <div class="acc-header" id="acc-hdr-2">
                <div class="acc-left">
                    <div class="acc-num" id="num-2">2</div>
                    <div>
                        <div class="acc-title" id="title-2">Shipping</div>
                        <div class="acc-summary" id="sum-2"></div>
                    </div>
                </div>
                <span class="acc-edit" id="edit-2">EDIT</span>
            </div>
            <div class="acc-body" id="body-2">
                <div class="acc-body-inner">
                    <div class="field-group">
                        <label class="field-label">ADDRESS LINE 1 *</label>
                        <div class="field-wrap">
                            <i class="fa-regular fa-location-dot"></i>
                            <input type="text" class="lux-input" id="s-addr1" placeholder="12 Rue de la Paix" autocomplete="address-line1">
                        </div>
                        <p class="field-error" id="s-addr1-err">Required.</p>
                    </div>
                    <div class="field-group">
                        <label class="field-label">ADDRESS LINE 2</label>
                        <div class="field-wrap">
                            <i class="fa-regular fa-building"></i>
                            <input type="text" class="lux-input" id="s-addr2" placeholder="Apartment, suite, etc." autocomplete="address-line2">
                        </div>
                    </div>
                    <div class="grid-2 field-group">
                        <div>
                            <label class="field-label">CITY *</label>
                            <div class="field-wrap">
                                <input type="text" class="lux-input" id="s-city" placeholder="Paris" autocomplete="address-level2">
                            </div>
                            <p class="field-error" id="s-city-err">Required.</p>
                        </div>
                        <div>
                            <label class="field-label">POSTAL CODE *</label>
                            <div class="field-wrap">
                                <input type="text" class="lux-input" id="s-zip" placeholder="75001" autocomplete="postal-code">
                            </div>
                            <p class="field-error" id="s-zip-err">Required.</p>
                        </div>
                    </div>
                    <div class="field-group">
                        <label class="field-label">COUNTRY *</label>
                        <div class="field-wrap">
                            <i class="fa-regular fa-globe"></i>
                            <select class="lux-select" id="s-country" autocomplete="country">
                                <option value="">Select country…</option>
                                <option value="FR" selected>France</option>
                                <option value="GB">United Kingdom</option>
                                <option value="DE">Germany</option>
                                <option value="IT">Italy</option>
                                <option value="ES">Spain</option>
                                <option value="US">United States</option>
                                <option value="AE">United Arab Emirates</option>
                                <option value="NG">Nigeria</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <p class="field-error" id="s-country-err">Required.</p>
                    </div>

                    <!-- Shipping methods -->
                    <div class="field-group">
                        <label class="field-label" style="margin-bottom:14px;">SHIPPING METHOD</label>
                        <div class="shipping-opts">
                            <label class="ship-opt selected" id="ship-std" onclick="selectShip('std', this)">
                                <input type="radio" name="shipping" value="std" checked>
                                <div class="ship-radio"><div class="ship-dot"></div></div>
                                <div class="ship-info">
                                    <div class="ship-name">Standard Delivery</div>
                                    <div class="ship-eta">5–8 business days · Signature required</div>
                                </div>
                                <span class="ship-price free">FREE</span>
                            </label>
                            <label class="ship-opt" id="ship-exp" onclick="selectShip('exp', this)">
                                <input type="radio" name="shipping" value="exp">
                                <div class="ship-radio"><div class="ship-dot"></div></div>
                                <div class="ship-info">
                                    <div class="ship-name">Express Delivery</div>
                                    <div class="ship-eta">2–3 business days · Fully insured</div>
                                </div>
                                <span class="ship-price">€45</span>
                            </label>
                            <label class="ship-opt" id="ship-prv" onclick="selectShip('prv', this)">
                                <input type="radio" name="shipping" value="prv">
                                <div class="ship-radio"><div class="ship-dot"></div></div>
                                <div class="ship-info">
                                    <div class="ship-name">Private Courier</div>
                                    <div class="ship-eta">Next day · White-glove delivery</div>
                                </div>
                                <span class="ship-price">€120</span>
                            </label>
                        </div>
                    </div>

                    <button class="btn-continue" onclick="nextStep(2)">
                        <span>CONTINUE TO PAYMENT</span>
                        <i class="fa-regular fa-arrow-right"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- ── STEP 3: PAYMENT ── -->
        <div class="acc-section" id="acc-3">
            <div class="acc-header" id="acc-hdr-3">
                <div class="acc-left">
                    <div class="acc-num" id="num-3">3</div>
                    <div>
                        <div class="acc-title" id="title-3">Payment</div>
                        <div class="acc-summary" id="sum-3"></div>
                    </div>
                </div>
            </div>
            <div class="acc-body" id="body-3">
                <div class="acc-body-inner">

                    <!-- Payment method tabs -->
                    <div class="pay-tabs field-group">
                        <button class="pay-tab active" id="pay-card" onclick="switchPay('card')">
                            <i class="fa-regular fa-credit-card"></i> CARD
                        </button>
                        <button class="pay-tab" id="pay-paypal" onclick="switchPay('paypal')">
                            <i class="fa-brands fa-paypal"></i> PAYPAL
                        </button>
                        <button class="pay-tab" id="pay-apple" onclick="switchPay('apple')">
                            <i class="fa-brands fa-apple"></i> PAY
                        </button>
                    </div>

                    <!-- Card payment -->
                    <div id="card-form">
                        <!-- Card visual -->
                        <div class="card-visual-wrap field-group">
                            <div class="card-visual" id="card-visual">
                                <div class="card-face card-front">
                                    <div style="display:flex;justify-content:space-between;align-items:flex-start;">
                                        <div class="card-chip"></div>
                                        <span class="card-brand-logo" id="card-brand">VISA</span>
                                    </div>
                                    <div class="card-number-disp" id="card-num-disp">•••• &nbsp;•••• &nbsp;•••• &nbsp;••••</div>
                                    <div class="card-bottom">
                                        <div>
                                            <div class="card-holder-label">CARD HOLDER</div>
                                            <div class="card-holder-name" id="card-name-disp">YOUR NAME</div>
                                        </div>
                                        <div style="text-align:right;">
                                            <div class="card-holder-label">EXPIRES</div>
                                            <div class="card-holder-name" id="card-exp-disp">MM / YY</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-face card-back">
                                    <div class="cvv-strip"></div>
                                    <div class="cvv-box">
                                        <span class="cvv-label">CVV</span>
                                        <span class="cvv-val" id="cvv-disp">•••</span>
                                    </div>
                                    <div style="margin-top:auto;">
                                        <div class="card-holder-label" style="font-size:0.5rem;letter-spacing:0.18em;color:rgba(255,255,255,0.2);">LUMIÈRE FINE JEWELRY · SECURED BY SSL</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="field-group">
                            <label class="field-label">CARD NUMBER *</label>
                            <div class="field-wrap">
                                <i class="fa-regular fa-credit-card"></i>
                                <input type="text" class="lux-input card-num-field" id="p-cardnum"
                                       placeholder="1234 5678 9012 3456"
                                       maxlength="19" inputmode="numeric" autocomplete="cc-number">
                            </div>
                            <p class="field-error" id="p-cardnum-err">Enter a valid 16-digit card number.</p>
                        </div>
                        <div class="field-group">
                            <label class="field-label">CARDHOLDER NAME *</label>
                            <div class="field-wrap">
                                <i class="fa-regular fa-user"></i>
                                <input type="text" class="lux-input" id="p-name" placeholder="As it appears on your card" autocomplete="cc-name">
                            </div>
                            <p class="field-error" id="p-name-err">Required.</p>
                        </div>
                        <div class="grid-2 field-group">
                            <div>
                                <label class="field-label">EXPIRY *</label>
                                <div class="field-wrap">
                                    <i class="fa-regular fa-calendar"></i>
                                    <input type="text" class="lux-input" id="p-exp" placeholder="MM / YY" maxlength="7" inputmode="numeric" autocomplete="cc-exp">
                                </div>
                                <p class="field-error" id="p-exp-err">Invalid expiry.</p>
                            </div>
                            <div>
                                <label class="field-label">CVV *</label>
                                <div class="field-wrap">
                                    <i class="fa-regular fa-lock"></i>
                                    <input type="text" class="lux-input" id="p-cvv" placeholder="•••" maxlength="4" inputmode="numeric" autocomplete="cc-csc"
                                           onfocus="flipCard(true)" onblur="flipCard(false)">
                                </div>
                                <p class="field-error" id="p-cvv-err">Required.</p>
                            </div>
                        </div>
                    </div>

                    <!-- PayPal placeholder -->
                    <div id="paypal-form" style="display:none;" class="field-group">
                        <div style="border:1px solid var(--border-md);padding:32px;text-align:center;">
                            <i class="fa-brands fa-paypal" style="font-size:2rem;color:#003087;margin-bottom:12px;display:block;"></i>
                            <p style="font-size:0.75rem;color:var(--warm-gray);font-weight:300;line-height:1.6;">You'll be redirected to PayPal to complete your payment securely after reviewing your order.</p>
                        </div>
                    </div>

                    <!-- Apple Pay placeholder -->
                    <div id="apple-form" style="display:none;" class="field-group">
                        <div style="border:1px solid var(--border-md);padding:32px;text-align:center;">
                            <i class="fa-brands fa-apple" style="font-size:2rem;color:var(--charcoal);margin-bottom:12px;display:block;"></i>
                            <p style="font-size:0.75rem;color:var(--warm-gray);font-weight:300;line-height:1.6;">Tap the button below to authenticate with Face ID or Touch ID and complete your purchase.</p>
                        </div>
                    </div>

                    <!-- Billing same as shipping -->
                    <div class="gift-toggle field-group" onclick="toggleBilling()" style="margin-bottom:4px;">
                        <div class="toggle-track on" id="billing-track">
                            <div class="toggle-thumb"></div>
                        </div>
                        <span class="toggle-label">BILLING ADDRESS SAME AS SHIPPING</span>
                    </div>

                    <!-- Place order -->
                    <div class="field-group" style="margin-top:24px;">
                        <button class="btn-place" onclick="placeOrder()">
                            <span>PLACE ORDER &nbsp;✦</span>
                        </button>
                        <p style="font-size:0.6rem;color:rgba(28,28,28,0.3);letter-spacing:0.1em;text-align:center;margin-top:12px;line-height:1.7;font-weight:300;">
                            By placing your order you agree to our <a href="#" style="color:var(--gold);text-decoration:none;">Terms of Service</a> and <a href="#" style="color:var(--gold);text-decoration:none;">Privacy Policy</a>.<br>
                            Your card will be charged <strong id="charge-amount" style="font-weight:400;color:var(--charcoal);">€4,795.00</strong> upon confirmation.
                        </p>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- /form-panel -->

    <!-- ════════════════════════════
         RIGHT — ORDER SUMMARY
    ════════════════════════════ -->
    <div class="order-panel">
        <h2 class="order-title">Your Order</h2>

        <!-- Items -->
        <div class="order-items">
            <div class="order-item">
                <div class="item-img-wrap">
                    <img src="https://images.unsplash.com/photo-1605100804763-247f67b3557e?q=80&w=200&auto=format&fit=crop" class="item-img" alt="Signature Ring">
                    <span class="item-qty">1</span>
                </div>
                <div style="flex:1;">
                    <div class="item-name">Lumière Signature Ring</div>
                    <div class="item-variant">18k Gold · Size 52 · Diamond</div>
                </div>
                <span class="item-price">€4,500</span>
            </div>
            <div class="order-item">
                <div class="item-img-wrap">
                    <img src="https://images.unsplash.com/photo-1603561591411-07134e719f5d?q=80&w=200&auto=format&fit=crop" class="item-img" alt="Lotus Earrings">
                    <span class="item-qty">1</span>
                </div>
                <div style="flex:1;">
                    <div class="item-name">Lotus Drop Earrings</div>
                    <div class="item-variant">Gold with Pearl</div>
                </div>
                <span class="item-price">€890</span>
            </div>
        </div>

        <!-- Promo code -->
        <div class="promo-wrap">
            <input type="text" class="promo-input" id="promo-input" placeholder="PROMO CODE">
            <button class="promo-btn" onclick="applyPromo()">APPLY</button>
        </div>
        <p class="promo-success" id="promo-success">✦ Code LUMIERE10 applied — 10% discount</p>

        <!-- Gift wrapping add-on -->
        <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 0;border-bottom:1px solid var(--border);margin-bottom:0;">
            <div>
                <div style="font-size:0.72rem;color:var(--charcoal);font-weight:300;letter-spacing:0.04em;">Luxury Gift Wrapping</div>
                <div style="font-size:0.62rem;color:var(--warm-gray);font-weight:300;margin-top:2px;">Signature Lumière box with ribbon</div>
            </div>
            <div style="display:flex;align-items:center;gap:12px;">
                <span style="font-size:0.72rem;color:var(--warm-gray);font-weight:300;">+€25</span>
                <div class="toggle-track" id="wrap-track" onclick="toggleWrap(this)" style="cursor:pointer;flex-shrink:0;">
                    <div class="toggle-thumb"></div>
                </div>
            </div>
        </div>

        <!-- Totals -->
        <div class="totals" style="margin-top:24px;">
            <div class="total-row">
                <span class="total-label">SUBTOTAL</span>
                <span class="total-value" id="t-subtotal">€5,390</span>
            </div>
            <div class="total-row" id="t-discount-row" style="display:none;">
                <span class="total-label">DISCOUNT (10%)</span>
                <span class="total-value discount-val" id="t-discount">−€539</span>
            </div>
            <div class="total-row" id="t-ship-row">
                <span class="total-label">SHIPPING</span>
                <span class="total-value" id="t-ship">FREE</span>
            </div>
            <div class="total-row" id="t-wrap-row" style="display:none;">
                <span class="total-label">GIFT WRAPPING</span>
                <span class="total-value">€25</span>
            </div>
            <div class="total-row" style="padding-top:14px;border-top:1px solid var(--border-md);border-bottom:none;">
                <span class="total-label">VAT (20%)</span>
                <span class="total-value" id="t-vat">€898</span>
            </div>
            <div class="total-row grand" style="padding-top:16px;border-top:1px solid var(--border-md);">
                <span class="total-label">TOTAL</span>
                <span class="total-value" id="t-total">€5,390</span>
            </div>
        </div>

        <!-- Trust badges -->
        <div class="trust-badges">
            <div class="trust-badge"><i class="fa-regular fa-shield-check"></i> INSURED</div>
            <div class="trust-badge"><i class="fa-regular fa-rotate-left"></i> 30-DAY RETURNS</div>
            <div class="trust-badge"><i class="fa-regular fa-gem"></i> CERTIFIED</div>
        </div>
    </div>

</div><!-- /checkout-layout -->


<script>
    // ─────────────────────────────────────
    // STATE
    // ─────────────────────────────────────
    const state = {
        currentStep: 1,
        shipping: 'std', // std | exp | prv
        shippingCost: 0,
        discount: false,
        giftWrap: false,
        billing: true,
        payMethod: 'card',
    };

    const BASE   = 5390;
    const VAT    = 0.20;
    const SHIP   = { std: 0, exp: 45, prv: 120 };
    const PROMO  = 'LUMIERE10';

    // ─────────────────────────────────────
    // ACCORDION STEPS
    // ─────────────────────────────────────
    function openStep(n) {
        for (let i = 1; i <= 3; i++) {
            const body   = document.getElementById(`body-${i}`);
            const num    = document.getElementById(`num-${i}`);
            const title  = document.getElementById(`title-${i}`);
            const hdr    = document.getElementById(`acc-hdr-${i}`);
            const edit   = document.getElementById(`edit-${i}`);
            const sum    = document.getElementById(`sum-${i}`);
            const crumb  = document.getElementById(`crumb-${i}`);

            if (i === n) {
                body.classList.add('open');
                num.classList.add('active');
                num.classList.remove('done');
                num.textContent = i;
                title.classList.add('active');
                sum.style.display = 'none';
                hdr.classList.remove('clickable');
                if (edit) edit.style.opacity = '0';
                if (crumb) { crumb.classList.add('active'); crumb.classList.remove('done'); }
            } else if (i < n) {
                body.classList.remove('open');
                num.classList.remove('active');
                num.classList.add('done');
                num.innerHTML = '<i class="fa-solid fa-check" style="font-size:0.5rem;"></i>';
                title.classList.remove('active');
                sum.style.display = 'block';
                hdr.classList.add('clickable');
                if (edit) { edit.style.display = 'inline'; }
                hdr.onclick = () => goStep(i);
                if (crumb) { crumb.classList.remove('active'); crumb.classList.add('done'); }
            } else {
                body.classList.remove('open');
                num.classList.remove('active','done');
                num.textContent = i;
                title.classList.remove('active');
                sum.style.display = 'none';
                hdr.classList.remove('clickable');
                if (crumb) { crumb.classList.remove('active','done'); }
            }
        }
        state.currentStep = n;
        updateTotal();
    }

    function goStep(n) { openStep(n); }

    // ─────────────────────────────────────
    // VALIDATION + NEXT
    // ─────────────────────────────────────
    function clearErr(id) { const e = document.getElementById(id); if (e) e.classList.remove('show'); }
    function showErr(id) { const e = document.getElementById(id); if (e) e.classList.add('show'); }
    function val(id) { return (document.getElementById(id)?.value || '').trim(); }

    function nextStep(from) {
        // Clear all errors first
        document.querySelectorAll('.field-error').forEach(e => e.classList.remove('show'));

        if (from === 1) {
            let ok = true;
            if (!val('c-fname'))                              { showErr('c-fname-err'); ok = false; }
            if (!val('c-lname'))                              { showErr('c-lname-err'); ok = false; }
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(val('c-email'))) { showErr('c-email-err'); ok = false; }
            if (!ok) return;
            // Set summary
            document.getElementById('sum-1').textContent = `${val('c-fname')} ${val('c-lname')} · ${val('c-email')}`;
            openStep(2);

        } else if (from === 2) {
            let ok = true;
            if (!val('s-addr1'))   { showErr('s-addr1-err');   ok = false; }
            if (!val('s-city'))    { showErr('s-city-err');    ok = false; }
            if (!val('s-zip'))     { showErr('s-zip-err');     ok = false; }
            if (!val('s-country')) { showErr('s-country-err'); ok = false; }
            if (!ok) return;
            const ship = document.querySelector('.ship-opt.selected .ship-name')?.textContent || 'Standard';
            document.getElementById('sum-2').innerHTML = `${val('s-addr1')}, ${val('s-city')}<br>${ship}`;
            openStep(3);
        }
    }

    // ─────────────────────────────────────
    // SHIPPING SELECTION
    // ─────────────────────────────────────
    function selectShip(type, el) {
        document.querySelectorAll('.ship-opt').forEach(o => o.classList.remove('selected'));
        el.classList.add('selected');
        state.shipping = type;
        state.shippingCost = SHIP[type];
        const shipEl = document.getElementById('t-ship');
        shipEl.textContent = state.shippingCost === 0 ? 'FREE' : `€${state.shippingCost}`;
        shipEl.className = 'total-value' + (state.shippingCost === 0 ? '' : '');
        updateTotal();
    }

    // ─────────────────────────────────────
    // PROMO CODE
    // ─────────────────────────────────────
    function applyPromo() {
        const code = document.getElementById('promo-input').value.trim().toUpperCase();
        const successEl = document.getElementById('promo-success');
        if (code === PROMO) {
            state.discount = true;
            successEl.style.display = 'block';
            document.getElementById('t-discount-row').style.display = 'flex';
            updateTotal();
        } else {
            successEl.style.display = 'none';
            document.getElementById('promo-input').classList.add('shake');
            setTimeout(() => document.getElementById('promo-input').classList.remove('shake'), 400);
        }
    }

    // ─────────────────────────────────────
    // GIFT WRAP TOGGLE
    // ─────────────────────────────────────
    function toggleWrap(track) {
        track.classList.toggle('on');
        state.giftWrap = track.classList.contains('on');
        document.getElementById('t-wrap-row').style.display = state.giftWrap ? 'flex' : 'none';
        updateTotal();
    }

    // ─────────────────────────────────────
    // GIFT MESSAGE TOGGLE
    // ─────────────────────────────────────
    function toggleGift() {
        const track = document.getElementById('gift-track');
        const area  = document.getElementById('gift-area');
        track.classList.toggle('on');
        area.classList.toggle('open');
    }

    // ─────────────────────────────────────
    // BILLING TOGGLE
    // ─────────────────────────────────────
    function toggleBilling() {
        const track = document.getElementById('billing-track');
        track.classList.toggle('on');
        state.billing = track.classList.contains('on');
    }

    // ─────────────────────────────────────
    // PAYMENT METHOD TABS
    // ─────────────────────────────────────
    function switchPay(method) {
        ['card','paypal','apple'].forEach(m => {
            document.getElementById(`pay-${m}`).classList.toggle('active', m === method);
            document.getElementById(`${m}-form`).style.display = m === method ? 'block' : 'none';
        });
        state.payMethod = method;
    }

    // ─────────────────────────────────────
    // CARD VISUAL — live updates
    // ─────────────────────────────────────
    const cardNumIn  = document.getElementById('p-cardnum');
    const cardNameIn = document.getElementById('p-name');
    const cardExpIn  = document.getElementById('p-exp');
    const cvvIn      = document.getElementById('p-cvv');

    cardNumIn.addEventListener('input', function() {
        // Strip non-digits, cap at 16
        let v = this.value.replace(/\D/g,'').slice(0,16);
        // Format as groups of 4 separated by single space → max 19 chars, matching maxlength
        this.value = v.match(/.{1,4}/g)?.join(' ') ?? v;
        // Card visual display — pad remainder with bullets
        const disp = v.padEnd(16,'•').match(/.{1,4}/g).join(' ');
        document.getElementById('card-num-disp').textContent = disp;
        // Brand detection
        const brand = v[0] === '4' ? 'VISA' : v[0] === '5' ? 'MASTERCARD' : (v.startsWith('34') || v.startsWith('37')) ? 'AMEX' : '—';
        document.getElementById('card-brand').textContent = brand;
    });

    cardNameIn.addEventListener('input', function() {
        const v = this.value.toUpperCase() || 'YOUR NAME';
        document.getElementById('card-name-disp').textContent = v;
    });

    cardExpIn.addEventListener('input', function() {
        let v = this.value.replace(/\D/g,'');
        if (v.length >= 2) v = v.slice(0,2) + ' / ' + v.slice(2,4);
        this.value = v;
        document.getElementById('card-exp-disp').textContent = this.value || 'MM / YY';
    });

    cvvIn.addEventListener('input', function() {
        const v = this.value.replace(/\D/g,'').slice(0,4);
        this.value = v;
        document.getElementById('cvv-disp').textContent = '•'.repeat(v.length) || '•••';
    });

    function flipCard(flip) {
        document.getElementById('card-visual').classList.toggle('flipped', flip);
    }

    // ─────────────────────────────────────
    // TOTAL CALCULATION
    // ─────────────────────────────────────
    function updateTotal() {
        let subtotal = BASE;
        let discount = 0;
        if (state.discount) { discount = Math.round(subtotal * 0.1); }
        const afterDiscount = subtotal - discount;
        const ship = state.shippingCost;
        const wrap = state.giftWrap ? 25 : 0;
        const vat  = Math.round((afterDiscount + ship + wrap) * VAT);
        const total = afterDiscount + ship + wrap;

        document.getElementById('t-subtotal').textContent  = `€${subtotal.toLocaleString()}`;
        document.getElementById('t-discount').textContent  = `−€${discount.toLocaleString()}`;
        document.getElementById('t-ship').textContent      = ship === 0 ? 'FREE' : `€${ship}`;
        document.getElementById('t-vat').textContent       = `€${vat.toLocaleString()}`;
        document.getElementById('t-total').textContent     = `€${total.toLocaleString()}`;
        document.getElementById('charge-amount').textContent = `€${total.toLocaleString()}.00`;
    }

    // ─────────────────────────────────────
    // PLACE ORDER
    // ─────────────────────────────────────
    function placeOrder() {
        document.querySelectorAll('.field-error').forEach(e => e.classList.remove('show'));

        if (state.payMethod === 'card') {
            let ok = true;
            const rawNum = val('p-cardnum').replace(/\s/g,'');
            if (rawNum.length < 15) { showErr('p-cardnum-err'); ok = false; }
            if (!val('p-name'))     { showErr('p-name-err');    ok = false; }
            if (val('p-exp').length < 7) { showErr('p-exp-err'); ok = false; }
            if (!val('p-cvv'))      { showErr('p-cvv-err');     ok = false; }
            if (!ok) return;
        }

        // Generate order ref
        const ref = 'LM-2026-' + Math.floor(1000 + Math.random() * 9000);
        document.getElementById('order-ref').textContent = ref;

        // Show confirmation
        const conf = document.getElementById('confirmation');
        conf.classList.add('show');
        spawnParticles();
    }

    // ─────────────────────────────────────
    // PARTICLE BURST
    // ─────────────────────────────────────
    function spawnParticles() {
        const canvas = document.getElementById('particle-canvas');
        const ctx    = canvas.getContext('2d');
        canvas.width  = window.innerWidth;
        canvas.height = window.innerHeight;

        const cx = canvas.width / 2;
        const cy = canvas.height / 2;

        const particles = Array.from({length: 60}, () => ({
            x: cx, y: cy,
            vx: (Math.random() - 0.5) * 14,
            vy: (Math.random() - 0.5) * 14,
            r: Math.random() * 3 + 1,
            life: 1,
            decay: Math.random() * 0.02 + 0.015,
            color: Math.random() > 0.5 ? '#C9A84C' : '#E8C97A',
        }));

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            let alive = false;
            particles.forEach(p => {
                if (p.life <= 0) return;
                alive = true;
                p.x += p.vx;
                p.y += p.vy;
                p.vy += 0.15; // gravity
                p.life -= p.decay;
                ctx.globalAlpha = Math.max(0, p.life);
                ctx.beginPath();
                ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
                ctx.fillStyle = p.color;
                ctx.fill();
            });
            ctx.globalAlpha = 1;
            if (alive) requestAnimationFrame(animate);
        }
        animate();
    }

    // ─────────────────────────────────────
    // INIT
    // ─────────────────────────────────────
    updateTotal();
</script>
</body>
</html>
