<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8" />
    <title>StockSathi &mdash; Next-Gen ERP, Inventory, POS & Finance Platform</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="StockSathi is an ultra-fast, modern ERP suite for retail, wholesale and multi-warehouse operations. Featuring real-time stock control, barcode POS, double-entry accounting, and HR payroll." />
    <meta name="author" content="GSG Websoft" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico') }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Boxicons -->
    <link href="{{ asset('backend/assets/libs/boxicons/css/boxicons.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- Modern Tailwind & Custom Design Styles -->
    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --primary-light: #eef2ff;
            --secondary: #06b6d4;
            --accent: #8b5cf6;
            --dark: #090d16;
            --dark-card: #0f172a;
            --slate-850: #131d31;
            --border: #e2e8f0;
            --text-main: #0f172a;
            --text-muted: #64748b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            color: var(--text-main);
            background-color: #fafbfc;
            line-height: 1.6;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* Ambient Glow & Grid */
        .bg-grid-pattern {
            background-image: 
                radial-gradient(circle at 50% 0%, rgba(99, 102, 241, 0.12) 0%, rgba(250, 251, 252, 0) 55%),
                linear-gradient(to right, rgba(226, 232, 240, 0.5) 1px, transparent 1px),
                linear-gradient(to bottom, rgba(226, 232, 240, 0.5) 1px, transparent 1px);
            background-size: 100% 100%, 48px 48px, 48px 48px;
        }

        .container {
            width: 100%;
            max-width: 1240px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* Navbar */
        .nav-wrapper {
            position: sticky;
            top: 0;
            z-index: 100;
            backdrop-filter: blur(16px);
            background: rgba(255, 255, 255, 0.85);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            transition: all 0.25s ease;
        }

        .nav-wrapper.scrolled {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 10px 30px -10px rgba(15, 23, 42, 0.08);
        }

        .nav-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 76px;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .brand-logo img {
            height: 42px;
            width: auto;
            max-width: 190px;
            object-fit: contain;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 2rem;
            list-style: none;
        }

        .nav-link {
            color: #475569;
            text-decoration: none;
            font-weight: 500;
            font-size: 0.925rem;
            transition: color 0.2s ease;
            position: relative;
        }

        .nav-link:hover {
            color: var(--primary);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 0.85rem;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-weight: 600;
            font-size: 0.925rem;
            padding: 0.65rem 1.35rem;
            border-radius: 10px;
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            cursor: pointer;
            border: 1px solid transparent;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4f46e5 0%, #4338ca 100%);
            color: #ffffff !important;
            box-shadow: 0 4px 14px 0 rgba(79, 70, 229, 0.35);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px 0 rgba(79, 70, 229, 0.45);
        }

        .btn-ghost {
            color: #334155;
            background: #ffffff;
            border-color: #cbd5e1;
        }

        .btn-ghost:hover {
            border-color: #94a3b8;
            background: #f8fafc;
            transform: translateY(-1px);
        }

        .btn-white {
            background: #ffffff;
            color: var(--dark) !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .btn-white:hover {
            background: #f8fafc;
            transform: translateY(-2px);
        }

        /* Hero Section */
        .hero {
            padding: 4.5rem 0 5rem;
            text-align: center;
            position: relative;
        }

        .announcement-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            border-radius: 9999px;
            background: rgba(79, 70, 229, 0.08);
            border: 1px solid rgba(79, 70, 229, 0.2);
            color: var(--primary);
            font-size: 0.825rem;
            font-weight: 600;
            margin-bottom: 1.75rem;
        }

        .pulse-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.25);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.3); opacity: 0.7; }
        }

        .hero-headline {
            font-size: 3.85rem;
            font-weight: 800;
            letter-spacing: -0.04em;
            line-height: 1.1;
            color: var(--dark);
            max-width: 900px;
            margin: 0 auto 1.5rem;
        }

        .gradient-text {
            background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 50%, #8b5cf6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-desc {
            font-size: 1.25rem;
            color: #475569;
            max-width: 680px;
            margin: 0 auto 2.5rem;
            line-height: 1.6;
        }

        .hero-cta-group {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 2rem;
        }

        /* Demo Credentials Bar */
        .demo-bar {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 8px 18px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            font-size: 0.85rem;
            color: #475569;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
            margin-bottom: 3.5rem;
        }

        .demo-badge {
            background: #eef2ff;
            color: var(--primary);
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 0.75rem;
            text-transform: uppercase;
        }

        .copy-btn {
            background: #f1f5f9;
            border: none;
            color: #334155;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.75rem;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .copy-btn:hover {
            background: #e2e8f0;
            color: var(--primary);
        }

        /* Live Interactive Mockup Frame */
        .mockup-container {
            position: relative;
            max-width: 1120px;
            margin: 0 auto;
        }

        .mockup-glow {
            position: absolute;
            inset: -20px;
            background: radial-gradient(circle at 50% 50%, rgba(99, 102, 241, 0.22) 0%, rgba(6, 182, 212, 0.12) 40%, transparent 70%);
            filter: blur(40px);
            z-index: 1;
            pointer-events: none;
        }

        .browser-mockup {
            position: relative;
            z-index: 2;
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid rgba(203, 213, 225, 0.8);
            box-shadow: 
                0 25px 60px -15px rgba(15, 23, 42, 0.18),
                0 0 0 1px rgba(15, 23, 42, 0.05);
            overflow: hidden;
            text-align: left;
        }

        .browser-topbar {
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .browser-dots {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .browser-dot {
            width: 11px;
            height: 11px;
            border-radius: 50%;
        }

        .browser-address {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 4px 14px;
            font-family: 'JetBrains Mono', monospace;
            font-size: 0.775rem;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 8px;
            width: 380px;
            max-width: 100%;
        }

        /* Mockup Application View Inside */
        .app-preview {
            display: grid;
            grid-template-columns: 240px 1fr;
            min-height: 480px;
            background: #f8fafc;
        }

        .app-sidebar {
            background: #0f172a;
            color: #94a3b8;
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .app-sidebar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #ffffff;
            font-weight: 700;
            font-size: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .app-nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 0.85rem;
            font-weight: 500;
            color: #94a3b8;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .app-nav-item.active {
            background: rgba(79, 70, 229, 0.25);
            color: #a5b4fc;
            font-weight: 600;
        }

        .app-main {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1.25rem;
            background: #f1f5f9;
        }

        .app-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stat-cards-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
        }

        .mini-stat-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 1rem 1.15rem;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }

        .mini-stat-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .mini-stat-value {
            font-size: 1.35rem;
            font-weight: 800;
            color: #0f172a;
        }

        .mini-stat-trend {
            font-size: 0.725rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 3px;
            margin-top: 4px;
        }

        .trend-up { color: #10b981; }
        .trend-warn { color: #f59e0b; }

        .app-panels-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1rem;
        }

        .app-card {
            background: #ffffff;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            padding: 1.25rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }

        .app-card-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .mock-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.8rem;
        }

        .mock-table th {
            text-align: left;
            padding: 8px 10px;
            color: #64748b;
            font-weight: 600;
            border-bottom: 1px solid #e2e8f0;
        }

        .mock-table td {
            padding: 10px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
        }

        .status-pill {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 0.7rem;
            font-weight: 700;
        }

        .status-paid { background: #d1fae5; color: #065f46; }
        .status-transit { background: #dbeafe; color: #1e40af; }
        .status-alert { background: #fee2e2; color: #991b1b; }

        /* Clients / Partners Ribbon */
        .clients-ribbon {
            padding: 3rem 0;
            border-top: 1px solid #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
            background: #ffffff;
            text-align: center;
        }

        .clients-title {
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
            margin-bottom: 1.75rem;
        }

        .clients-grid {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 3.5rem;
            flex-wrap: wrap;
        }

        .clients-grid img {
            height: 32px;
            opacity: 0.45;
            filter: grayscale(100%);
            transition: all 0.25s ease;
        }

        .clients-grid img:hover {
            opacity: 1;
            filter: grayscale(0%);
            transform: scale(1.05);
        }

        /* Section Global */
        .section {
            padding: 6.5rem 0;
            position: relative;
        }

        .section-header {
            text-align: center;
            max-width: 720px;
            margin: 0 auto 4rem;
        }

        .section-tag {
            display: inline-block;
            font-size: 0.825rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: var(--primary);
            margin-bottom: 0.75rem;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: var(--dark);
            line-height: 1.2;
            margin-bottom: 1rem;
        }

        .section-desc {
            font-size: 1.125rem;
            color: #64748b;
            line-height: 1.6;
        }

        /* Features Bento Grid */
        .bento-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.75rem;
        }

        .bento-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 2.25rem;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
            display: flex;
            flex-direction: column;
        }

        .bento-card:hover {
            transform: translateY(-5px);
            border-color: rgba(79, 70, 229, 0.3);
            box-shadow: 0 20px 40px -15px rgba(79, 70, 229, 0.12);
        }

        .bento-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.65rem;
            margin-bottom: 1.5rem;
        }

        .icon-indigo { background: #eef2ff; color: #4f46e5; }
        .icon-cyan { background: #ecfeff; color: #0891b2; }
        .icon-emerald { background: #ecfdf5; color: #059669; }
        .icon-amber { background: #fffbeb; color: #d97706; }
        .icon-rose { background: #fff1f2; color: #e11d48; }
        .icon-purple { background: #faf5ff; color: #9333ea; }

        .bento-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.75rem;
        }

        .bento-desc {
            font-size: 0.95rem;
            color: #64748b;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            flex-grow: 1;
        }

        .bento-features {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            padding-top: 1rem;
            border-top: 1px solid #f1f5f9;
        }

        .bento-features li {
            font-size: 0.875rem;
            color: #334155;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .bento-features li i {
            color: #10b981;
            font-size: 1.1rem;
        }

        /* Interactive Showcase Tabs */
        .showcase-section {
            background: #ffffff;
            border-top: 1px solid #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
        }

        .tab-buttons {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-bottom: 3.5rem;
        }

        .tab-btn {
            background: #f1f5f9;
            border: 1px solid transparent;
            color: #475569;
            padding: 0.65rem 1.4rem;
            border-radius: 9999px;
            font-size: 0.925rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .tab-btn:hover {
            color: var(--dark);
            background: #e2e8f0;
        }

        .tab-btn.active {
            background: var(--dark);
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.2);
        }

        .tab-pane {
            display: none;
            grid-template-columns: 1fr 1fr;
            gap: 3.5rem;
            align-items: center;
        }

        .tab-pane.active {
            display: grid;
        }

        .showcase-content h3 {
            font-size: 2rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 1rem;
            letter-spacing: -0.02em;
        }

        .showcase-content p {
            font-size: 1.05rem;
            color: #475569;
            margin-bottom: 1.75rem;
            line-height: 1.7;
        }

        .showcase-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .showcase-list li {
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .list-icon {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: #eef2ff;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .showcase-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.05);
        }

        /* Stats Bar */
        .stats-strip {
            background: var(--dark);
            color: #ffffff;
            padding: 4.5rem 0;
            position: relative;
            overflow: hidden;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
            text-align: center;
        }

        .stat-item h3 {
            font-size: 3.25rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            margin-bottom: 0.35rem;
            background: linear-gradient(135deg, #a5b4fc 0%, #38bdf8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .stat-item p {
            color: #94a3b8;
            font-size: 1rem;
            font-weight: 500;
        }

        /* Pricing Section */
        .pricing-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            align-items: stretch;
        }

        .pricing-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            padding: 2.75rem 2.25rem;
            position: relative;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        .pricing-card.featured {
            border-color: var(--primary);
            box-shadow: 0 25px 50px -12px rgba(79, 70, 229, 0.22);
            transform: scale(1.03);
            background: #ffffff;
        }

        .popular-tag {
            position: absolute;
            top: -14px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, #4f46e5 0%, #6366f1 100%);
            color: #ffffff;
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 4px 14px;
            border-radius: 9999px;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.35);
        }

        .pricing-header h4 {
            font-size: 1.35rem;
            font-weight: 800;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .pricing-header p {
            color: #64748b;
            font-size: 0.925rem;
            margin-bottom: 1.5rem;
        }

        .pricing-amount {
            display: flex;
            align-items: baseline;
            gap: 4px;
            margin-bottom: 2rem;
        }

        .price-num {
            font-size: 3rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            color: var(--dark);
        }

        .price-period {
            color: #64748b;
            font-size: 0.95rem;
        }

        .pricing-features {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0.85rem;
            margin-bottom: 2.5rem;
            flex-grow: 1;
        }

        .pricing-features li {
            font-size: 0.925rem;
            color: #334155;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .pricing-features li i {
            color: #10b981;
            font-size: 1.15rem;
        }

        /* FAQ Accordion */
        .faq-grid {
            max-width: 820px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .faq-item {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            overflow: hidden;
            transition: all 0.2s ease;
        }

        .faq-question {
            padding: 1.35rem 1.5rem;
            font-weight: 700;
            color: var(--dark);
            font-size: 1.05rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            user-select: none;
        }

        .faq-answer {
            padding: 0 1.5rem 1.35rem;
            color: #475569;
            font-size: 0.95rem;
            line-height: 1.7;
            display: none;
        }

        .faq-item.open .faq-answer {
            display: block;
        }

        .faq-item.open .faq-icon {
            transform: rotate(180deg);
        }

        .faq-icon {
            transition: transform 0.2s ease;
            font-size: 1.35rem;
            color: #94a3b8;
        }

        /* Banner CTA */
        .cta-banner {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #312e81 100%);
            border-radius: 28px;
            padding: 4.5rem 3.5rem;
            color: #ffffff;
            text-align: center;
            position: relative;
            overflow: hidden;
            box-shadow: 0 30px 60px -15px rgba(15, 23, 42, 0.4);
            margin-bottom: 5rem;
        }

        .cta-banner-glow {
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.35) 0%, transparent 70%);
            top: -100px;
            right: -100px;
            pointer-events: none;
        }

        .cta-banner h2 {
            font-size: 2.75rem;
            font-weight: 800;
            letter-spacing: -0.03em;
            margin-bottom: 1.25rem;
        }

        .cta-banner p {
            font-size: 1.2rem;
            color: #cbd5e1;
            max-width: 620px;
            margin: 0 auto 2.5rem;
        }

        /* Footer */
        .footer {
            background: #090d16;
            color: #94a3b8;
            padding: 5rem 0 2.5rem;
            border-top: 1px solid #1e293b;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1.5fr;
            gap: 3.5rem;
            margin-bottom: 4rem;
        }

        .footer-logo {
            height: 38px;
            margin-bottom: 1.25rem;
        }

        .footer-col h5 {
            color: #ffffff;
            font-weight: 700;
            font-size: 0.95rem;
            margin-bottom: 1.25rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .footer-col ul {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .footer-col ul a {
            color: #94a3b8;
            text-decoration: none;
            font-size: 0.925rem;
            transition: color 0.2s ease;
        }

        .footer-col ul a:hover {
            color: #ffffff;
        }

        .footer-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 2rem;
            border-top: 1px solid #1e293b;
            font-size: 0.85rem;
        }

        /* Toast notification */
        .toast-notify {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: #0f172a;
            color: #ffffff;
            padding: 12px 20px;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.25);
            transform: translateY(100px);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            z-index: 1000;
        }

        .toast-notify.show {
            transform: translateY(0);
            opacity: 1;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .hero-headline { font-size: 3rem; }
            .bento-grid { grid-template-columns: 1fr; }
            .tab-pane { grid-template-columns: 1fr; }
            .pricing-grid { grid-template-columns: 1fr; }
            .pricing-card.featured { transform: none; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .footer-grid { grid-template-columns: 1fr 1fr; }
            .app-preview { grid-template-columns: 1fr; }
            .app-sidebar { display: none; }
            .stat-cards-grid { grid-template-columns: repeat(2, 1fr); }
            .app-panels-grid { grid-template-columns: 1fr; }
        }

        @media (max-width: 768px) {
            .nav-links { display: none; }
            .hero-headline { font-size: 2.35rem; }
            .hero-desc { font-size: 1.05rem; }
            .stats-grid { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr; }
            .footer-bottom { flex-direction: column; gap: 1rem; text-align: center; }
        }
    </style>
</head>

<body class="bg-grid-pattern">

    <!-- Top Navigation Bar -->
    <header class="nav-wrapper" id="navbar">
        <div class="container">
            <div class="nav-content">
                <a href="{{ url('/') }}" class="brand-logo">
                    <img src="{{ asset('backend/assets/images/logo-dark.png') }}" alt="StockSathi Logo" onerror="this.src='{{ asset('backend/assets/images/logo.svg') }}'">
                </a>

                <ul class="nav-links">
                    <li><a href="#features" class="nav-link">Features</a></li>
                    <li><a href="#showcase" class="nav-link">Live Modules</a></li>
                    <li><a href="#warehouses" class="nav-link">Multi-Warehouse</a></li>
                    <li><a href="#faq" class="nav-link">FAQ</a></li>
                </ul>

                <div class="nav-actions">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="btn btn-primary">
                                <i class="bx bxs-dashboard"></i> ERP Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-ghost">
                                <i class="bx bx-log-in"></i> Sign In
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="btn btn-primary">
                                    Get Started Free
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="announcement-pill">
                <span class="pulse-dot"></span>
                <span>StockSathi ERP &bull; Local & Cloud Ready</span>
            </div>

            <h1 class="hero-headline">
                The Operating System for <br>
                <span class="gradient-text">Inventory, POS & Commerce</span>
            </h1>

            <p class="hero-desc">
                Everything required to control warehouses, ring up sales at the counter, balance financial ledgers, and manage employee payroll &mdash; unified into one fast, intuitive dashboard.
            </p>

            <div class="hero-cta-group">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-primary" style="padding: 0.85rem 2rem; font-size: 1rem;">
                        <i class="bx bxs-dashboard fs-5"></i> Enter Control Center
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary" style="padding: 0.85rem 2rem; font-size: 1rem;">
                        <i class="bx bx-rocket fs-5"></i> Launch Demo Portal
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-ghost" style="padding: 0.85rem 1.85rem; font-size: 1rem;">
                            <i class="bx bx-user-plus fs-5"></i> Create New Account
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Instant One-Click Demo Credentials -->
            <div class="demo-bar">
                <span class="demo-badge">Instant Login</span>
                <span>Email: <strong>admin@stocksathi.com</strong></span>
                <span>&bull;</span>
                <span>Password: <strong>password</strong></span>
                <button class="copy-btn" onclick="copyCreds()">
                    <i class="bx bx-copy"></i> Copy
                </button>
            </div>

            <!-- Crisp Live Vector Preview Frame -->
            <div class="mockup-container">
                <div class="mockup-glow"></div>
                <div class="browser-mockup">
                    <div class="browser-topbar">
                        <div class="browser-dots">
                            <span class="browser-dot" style="background: #ef4444;"></span>
                            <span class="browser-dot" style="background: #f59e0b;"></span>
                            <span class="browser-dot" style="background: #10b981;"></span>
                        </div>
                        <div class="browser-address">
                            <i class="bx bx-lock-alt text-emerald-500" style="color: #10b981;"></i>
                            <span>https://stocksathi.local/dashboard</span>
                        </div>
                        <div class="d-flex gap-2">
                            <span class="badge" style="background: #e0e7ff; color: #4338ca; font-size: 0.7rem; font-weight: 700; padding: 4px 8px; border-radius: 6px;">v12.70 STABLE</span>
                        </div>
                    </div>

                    <!-- Application Interactive Look -->
                    <div class="app-preview">
                        <!-- Sidebar -->
                        <div class="app-sidebar">
                            <div class="app-sidebar-logo">
                                <i class="bx bx-cube-alt fs-4 text-primary" style="color: #818cf8;"></i>
                                <span>StockSathi ERP</span>
                            </div>

                            <div style="display: flex; flex-direction: column; gap: 4px;">
                                <div class="app-nav-item active">
                                    <i class="bx bxs-dashboard fs-5"></i>
                                    <span>Dashboard</span>
                                </div>
                                <div class="app-nav-item">
                                    <i class="bx bx-package fs-5"></i>
                                    <span>Products & Stock</span>
                                </div>
                                <div class="app-nav-item">
                                    <i class="bx bx-calculator fs-5"></i>
                                    <span>Point of Sale (POS)</span>
                                </div>
                                <div class="app-nav-item">
                                    <i class="bx bx-building fs-5"></i>
                                    <span>Warehouses & Bins</span>
                                </div>
                                <div class="app-nav-item">
                                    <i class="bx bx-cart-alt fs-5"></i>
                                    <span>Purchase Orders</span>
                                </div>
                                <div class="app-nav-item">
                                    <i class="bx bx-line-chart fs-5"></i>
                                    <span>Financial Ledger</span>
                                </div>
                                <div class="app-nav-item">
                                    <i class="bx bx-user-check fs-5"></i>
                                    <span>HR & Attendance</span>
                                </div>
                            </div>
                        </div>

                        <!-- Main Screen Content -->
                        <div class="app-main">
                            <!-- Top Bar inside app -->
                            <div class="app-header">
                                <div>
                                    <h4 style="font-weight: 800; color: #0f172a; font-size: 1.15rem; margin-bottom: 2px;">Good day, Admin User 👋</h4>
                                    <span style="font-size: 0.775rem; color: #64748b;">Central Enterprise Overview &bull; All 5 Warehouses Connected</span>
                                </div>
                                <div style="display: flex; gap: 8px;">
                                    <span class="status-pill status-paid" style="padding: 6px 12px; font-size: 0.75rem;">
                                        <i class="bx bx-wifi"></i> Live Sync Active
                                    </span>
                                </div>
                            </div>

                            <!-- Stat Cards -->
                            <div class="stat-cards-grid">
                                <div class="mini-stat-card">
                                    <div class="mini-stat-label">Total Revenue</div>
                                    <div class="mini-stat-value">&#8377;14,28,500</div>
                                    <div class="mini-stat-trend trend-up">
                                        <i class="bx bx-trending-up"></i> +14.2% vs last mo
                                    </div>
                                </div>
                                <div class="mini-stat-card">
                                    <div class="mini-stat-label">Active SKUs</div>
                                    <div class="mini-stat-value">2,840</div>
                                    <div class="mini-stat-trend trend-up">
                                        <i class="bx bx-check"></i> 99.8% in stock
                                    </div>
                                </div>
                                <div class="mini-stat-card">
                                    <div class="mini-stat-label">Today's POS Sales</div>
                                    <div class="mini-stat-value">184 bills</div>
                                    <div class="mini-stat-trend trend-up">
                                        <i class="bx bx-bolt-circle"></i> Avg: 22s checkout
                                    </div>
                                </div>
                                <div class="mini-stat-card">
                                    <div class="mini-stat-label">Low Stock Alerts</div>
                                    <div class="mini-stat-value" style="color: #ea580c;">4 items</div>
                                    <div class="mini-stat-trend trend-warn">
                                        <i class="bx bx-error-circle"></i> Reorder required
                                    </div>
                                </div>
                            </div>

                            <!-- Live Split Panels -->
                            <div class="app-panels-grid">
                                <!-- Recent Sales Orders Table -->
                                <div class="app-card">
                                    <div class="app-card-title">
                                        <span>Recent Outgoing Invoices</span>
                                        <span style="font-size: 0.75rem; color: var(--primary); font-weight: 600; cursor: pointer;">View All Orders &rarr;</span>
                                    </div>
                                    <table class="mock-table">
                                        <thead>
                                            <tr>
                                                <th>INVOICE #</th>
                                                <th>CUSTOMER</th>
                                                <th>AMOUNT</th>
                                                <th>STATUS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><span style="font-family: 'JetBrains Mono', monospace; font-weight: 600;">#INV-2026-081</span></td>
                                                <td>Apex Retail Corp</td>
                                                <td><strong>&#8377;24,500.00</strong></td>
                                                <td><span class="status-pill status-paid">Paid</span></td>
                                            </tr>
                                            <tr>
                                                <td><span style="font-family: 'JetBrains Mono', monospace; font-weight: 600;">#INV-2026-080</span></td>
                                                <td>Summit Wholesale</td>
                                                <td><strong>&#8377;61,200.50</strong></td>
                                                <td><span class="status-pill status-transit">Delivered</span></td>
                                            </tr>
                                            <tr>
                                                <td><span style="font-family: 'JetBrains Mono', monospace; font-weight: 600;">#INV-2026-079</span></td>
                                                <td>QuickMart Superstore</td>
                                                <td><strong>&#8377;8,900.00</strong></td>
                                                <td><span class="status-pill status-paid">Paid</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Warehouse Stock Distribution Preview -->
                                <div class="app-card">
                                    <div class="app-card-title">
                                        <span>Stock by Location</span>
                                    </div>
                                    <div style="display: flex; flex-direction: column; gap: 12px;">
                                        <div>
                                            <div style="display: flex; justify-content: space-between; font-size: 0.775rem; margin-bottom: 4px;">
                                                <span style="font-weight: 600;">Main Distribution Hub</span>
                                                <span style="color: #64748b;">76% capacity</span>
                                            </div>
                                            <div style="height: 6px; background: #e2e8f0; border-radius: 999px; overflow: hidden;">
                                                <div style="height: 100%; width: 76%; background: #4f46e5;"></div>
                                            </div>
                                        </div>

                                        <div>
                                            <div style="display: flex; justify-content: space-between; font-size: 0.775rem; margin-bottom: 4px;">
                                                <span style="font-weight: 600;">Downtown Retail Depot</span>
                                                <span style="color: #64748b;">42% capacity</span>
                                            </div>
                                            <div style="height: 6px; background: #e2e8f0; border-radius: 999px; overflow: hidden;">
                                                <div style="height: 100%; width: 42%; background: #06b6d4;"></div>
                                            </div>
                                        </div>

                                        <div>
                                            <div style="display: flex; justify-content: space-between; font-size: 0.775rem; margin-bottom: 4px;">
                                                <span style="font-weight: 600;">North Cold Storage</span>
                                                <span style="color: #64748b;">91% capacity</span>
                                            </div>
                                            <div style="height: 6px; background: #e2e8f0; border-radius: 999px; overflow: hidden;">
                                                <div style="height: 100%; width: 91%; background: #f59e0b;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trusted By Logos Strip -->
    <section class="clients-ribbon">
        <div class="container">
            <div class="clients-title">Engineered to Power Commercial Supply Chains & Retail Brands</div>
            <div class="clients-grid">
                <img src="{{ asset('backend/assets/images/landing/client/clients-logo-1.svg') }}" alt="Partner 1">
                <img src="{{ asset('backend/assets/images/landing/client/clients-logo-2.svg') }}" alt="Partner 2">
                <img src="{{ asset('backend/assets/images/landing/client/clients-logo-3.svg') }}" alt="Partner 3">
                <img src="{{ asset('backend/assets/images/landing/client/clients-logo-4.svg') }}" alt="Partner 4">
                <img src="{{ asset('backend/assets/images/landing/client/clients-logo-5.svg') }}" alt="Partner 5">
            </div>
        </div>
    </section>

    <!-- Bento Features Grid Section -->
    <section class="section" id="features">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Modular Powerhouse</span>
                <h2 class="section-title">Every Tool to Run Your Business with Pinpoint Accuracy</h2>
                <p class="section-desc">Eliminate disjointed spreadsheets and mismatched software. StockSathi connects every operational flow into a synchronized source of truth.</p>
            </div>

            <div class="bento-grid">
                <!-- Card 1: Multi-Warehouse -->
                <div class="bento-card">
                    <div class="bento-icon icon-indigo">
                        <i class="bx bx-building-house"></i>
                    </div>
                    <h3 class="bento-title">Physical Warehouse Mapping</h3>
                    <p class="bento-desc">Break down warehouses into Aisle &rarr; Rack &rarr; Bin storage slots. Staff locate items in seconds without guesswork.</p>
                    <ul class="bento-features">
                        <li><i class="bx bx-check-circle"></i> Granular Rack & Bin locators</li>
                        <li><i class="bx bx-check-circle"></i> Inter-facility stock transfers</li>
                        <li><i class="bx bx-check-circle"></i> Discrepancy & count adjustments</li>
                    </ul>
                </div>

                <!-- Card 2: POS Billing -->
                <div class="bento-card">
                    <div class="bento-icon icon-cyan">
                        <i class="bx bx-barcode-reader"></i>
                    </div>
                    <h3 class="bento-title">High-Velocity Barcode POS</h3>
                    <p class="bento-desc">Optimized for fast-paced retail checkout counters with sub-second barcode lookups and instant cash drawer management.</p>
                    <ul class="bento-features">
                        <li><i class="bx bx-check-circle"></i> USB & Wireless scanner support</li>
                        <li><i class="bx bx-check-circle"></i> ESC/POS thermal receipt printing</li>
                        <li><i class="bx bx-check-circle"></i> Real-time inventory decrement</li>
                    </ul>
                </div>

                <!-- Card 3: Batch & Expiry -->
                <div class="bento-card">
                    <div class="bento-icon icon-amber">
                        <i class="bx bx-layer"></i>
                    </div>
                    <h3 class="bento-title">Batches & Expiry Control</h3>
                    <p class="bento-desc">Protect your margins from spoilage. Assign lot numbers, track manufacturing dates, and receive automated expiration alerts.</p>
                    <ul class="bento-features">
                        <li><i class="bx bx-check-circle"></i> Automated FIFO inventory dispatch</li>
                        <li><i class="bx bx-check-circle"></i> Perishable item expiry warnings</li>
                        <li><i class="bx bx-check-circle"></i> Lot tracing for warranty recalls</li>
                    </ul>
                </div>

                <!-- Card 4: Accounting & Ledger -->
                <div class="bento-card">
                    <div class="bento-icon icon-rose">
                        <i class="bx bx-wallet-alt"></i>
                    </div>
                    <h3 class="bento-title">Double-Entry Financials</h3>
                    <p class="bento-desc">Automatic journal entries whenever items are bought, sold, or returned. Generate real-time Profit & Loss statements on demand.</p>
                    <ul class="bento-features">
                        <li><i class="bx bx-check-circle"></i> Standard Chart of Accounts (COA)</li>
                        <li><i class="bx bx-check-circle"></i> Multi-tier GST & Sales tax support</li>
                        <li><i class="bx bx-check-circle"></i> Supplier & customer debt ledgers</li>
                    </ul>
                </div>

                <!-- Card 5: Purchase Flow -->
                <div class="bento-card">
                    <div class="bento-icon icon-purple">
                        <i class="bx bx-git-branch"></i>
                    </div>
                    <h3 class="bento-title">Procurement Workflow</h3>
                    <p class="bento-desc">Control company spending from Purchase Requisition through Purchase Order approval to Vendor Payment settlement.</p>
                    <ul class="bento-features">
                        <li><i class="bx bx-check-circle"></i> Requisition &rarr; PO &rarr; Bill conversion</li>
                        <li><i class="bx bx-check-circle"></i> Supplier partial payment handling</li>
                        <li><i class="bx bx-check-circle"></i> Purchase return with debit notes</li>
                    </ul>
                </div>

                <!-- Card 6: HR & Payroll -->
                <div class="bento-card">
                    <div class="bento-icon icon-emerald">
                        <i class="bx bx-user-check"></i>
                    </div>
                    <h3 class="bento-title">HR & Employee Payroll</h3>
                    <p class="bento-desc">Integrated human resources management. Track daily staff attendance, department roles, and disburse monthly pay slips effortlessly.</p>
                    <ul class="bento-features">
                        <li><i class="bx bx-check-circle"></i> Employee profiles & designations</li>
                        <li><i class="bx bx-check-circle"></i> Daily attendance logs</li>
                        <li><i class="bx bx-check-circle"></i> Automated salary generation</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Interactive Live Module Showcase -->
    <section class="section showcase-section" id="showcase">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Feature Spotlight</span>
                <h2 class="section-title">Designed with Real-World Workflows in Mind</h2>
                <p class="section-desc">Click between business operations below to see how StockSathi simplifies day-to-day complexity.</p>
            </div>

            <!-- Tab Buttons -->
            <div class="tab-buttons">
                <button class="tab-btn active" onclick="switchTab('tab-pos')">
                    <i class="bx bx-calculator"></i> Point of Sale
                </button>
                <button class="tab-btn" onclick="switchTab('tab-warehouse')">
                    <i class="bx bx-building"></i> Multi-Warehouse
                </button>
                <button class="tab-btn" onclick="switchTab('tab-accounting')">
                    <i class="bx bx-line-chart"></i> Accounting Ledger
                </button>
                <button class="tab-btn" onclick="switchTab('tab-hr')">
                    <i class="bx bx-user"></i> HR & Payroll
                </button>
            </div>

            <!-- Tab 1: POS -->
            <div class="tab-pane active" id="tab-pos">
                <div class="showcase-content">
                    <h3>Fast Counter Checkout Engineered for Rush Hours</h3>
                    <p>When customer lines grow long, seconds count. StockSathi POS gives cashiers a sleek, distraction-free interface with keyboard shortcuts, quick cash buttons, and instant thermal receipt printing.</p>
                    <ul class="showcase-list">
                        <li>
                            <span class="list-icon"><i class="bx bx-check"></i></span>
                            <div>
                                <strong>Instant Barcode Ringing</strong>
                                <p style="font-size: 0.9rem; color: #64748b; margin-top: 2px;">Items scanned immediately appear in the cart with current pricing, taxes, and applied volume discounts.</p>
                            </div>
                        </li>
                        <li>
                            <span class="list-icon"><i class="bx bx-check"></i></span>
                            <div>
                                <strong>Flexible Payment Splits</strong>
                                <p style="font-size: 0.9rem; color: #64748b; margin-top: 2px;">Accept partial cash, digital payments (UPI / Card), or account credit in a single order.</p>
                            </div>
                        </li>
                        <li>
                            <span class="list-icon"><i class="bx bx-check"></i></span>
                            <div>
                                <strong>Thermal Receipt & Invoice Engine</strong>
                                <p style="font-size: 0.9rem; color: #64748b; margin-top: 2px;">Configurable ESC/POS thermal printing for retail, plus standard A4 PDF invoices for wholesale.</p>
                            </div>
                        </li>
                    </ul>
                    <a href="{{ route('login') }}" class="btn btn-primary">Try POS Interface &rarr;</a>
                </div>

                <div class="showcase-box">
                    <div style="border-bottom: 1px solid #e2e8f0; padding-bottom: 12px; margin-bottom: 16px; display: flex; justify-content: space-between; align-items: center;">
                        <span style="font-weight: 700; color: #0f172a;"><i class="bx bx-receipt text-primary"></i> POS Terminal #01</span>
                        <span class="status-pill status-paid">READY</span>
                    </div>
                    <div style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 14px; margin-bottom: 14px;">
                        <div style="font-family: 'JetBrains Mono', monospace; font-size: 0.8rem; color: #64748b; margin-bottom: 8px;">
                            SCAN BARCODE: [ 8901030384721 ]
                        </div>
                        <div style="display: flex; justify-content: space-between; font-weight: 700; font-size: 0.95rem;">
                            <span>Premium Wireless Headset &times; 2</span>
                            <span>&#8377;1,799.00</span>
                        </div>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 0.875rem;">
                        <span style="color: #64748b;">Subtotal:</span>
                        <strong>&#8377;1,799.00</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 0.875rem;">
                        <span style="color: #64748b;">Tax (GST 18%):</span>
                        <strong>&#8377;323.82</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding-top: 10px; border-top: 1px solid #e2e8f0; font-size: 1.15rem; font-weight: 800; color: #0f172a;">
                        <span>Total Payable:</span>
                        <span style="color: #4f46e5;">&#8377;2,122.82</span>
                    </div>
                </div>
            </div>

            <!-- Tab 2: Warehouse -->
            <div class="tab-pane" id="tab-warehouse">
                <div class="showcase-content">
                    <h3>Physical Mapping from Facilities down to Storage Bins</h3>
                    <p>Managing inventory across multiple branches doesn't have to cause discrepancies. Map every warehouse physically into identifiable rows, racks, and shelf bins.</p>
                    <ul class="showcase-list">
                        <li>
                            <span class="list-icon"><i class="bx bx-check"></i></span>
                            <div>
                                <strong>Inter-Branch Stock Transfers</strong>
                                <p style="font-size: 0.9rem; color: #64748b; margin-top: 2px;">Initiate transfers between central distribution centers and retail stores with transit tracking.</p>
                            </div>
                        </li>
                        <li>
                            <span class="list-icon"><i class="bx bx-check"></i></span>
                            <div>
                                <strong>Stock Adjustment Audits</strong>
                                <p style="font-size: 0.9rem; color: #64748b; margin-top: 2px;">Record physical count variances, breakage, or losses with mandatory supervisor remarks.</p>
                            </div>
                        </li>
                    </ul>
                    <a href="{{ route('login') }}" class="btn btn-primary">Explore Warehouse Features &rarr;</a>
                </div>

                <div class="showcase-box">
                    <div style="font-weight: 700; margin-bottom: 14px;">Physical Location Hierarchy</div>
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <div style="padding: 12px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <div style="font-weight: 700; font-size: 0.9rem;">Warehouse North #01</div>
                                <div style="font-size: 0.775rem; color: #64748b;">Primary Logistics Hub &bull; 1,200 sq.m</div>
                            </div>
                            <span class="status-pill status-paid">5 Racks</span>
                        </div>
                        <div style="padding: 12px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; display: flex; align-items: center; justify-content: space-between; margin-left: 20px;">
                            <div>
                                <div style="font-weight: 700; font-size: 0.9rem;">Rack B-04 (Electronics)</div>
                                <div style="font-size: 0.775rem; color: #64748b;">4 Shelf Levels</div>
                            </div>
                            <span class="status-pill status-transit">16 Bins</span>
                        </div>
                        <div style="padding: 12px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; display: flex; align-items: center; justify-content: space-between; margin-left: 40px;">
                            <div>
                                <div style="font-weight: 700; font-size: 0.9rem;">Bin B-04-02</div>
                                <div style="font-size: 0.775rem; color: #64748b;">Holding SKU: HD-AUDIO-BT</div>
                            </div>
                            <span class="status-pill status-paid">48 in Stock</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 3: Accounting -->
            <div class="tab-pane" id="tab-accounting">
                <div class="showcase-content">
                    <h3>Double-Entry Bookkeeping Built Directly Into Operations</h3>
                    <p>Forget manual exports into external accounting tools. Every sales order, purchase invoice, customer payment, and vendor reimbursement creates balanced debit and credit ledger entries automatically.</p>
                    <ul class="showcase-list">
                        <li>
                            <span class="list-icon"><i class="bx bx-check"></i></span>
                            <div>
                                <strong>Real-Time Profit & Loss (P&L)</strong>
                                <p style="font-size: 0.9rem; color: #64748b; margin-top: 2px;">Instantly compute Cost of Goods Sold (COGS), gross margins, operational expenses, and net profit.</p>
                            </div>
                        </li>
                        <li>
                            <span class="list-icon"><i class="bx bx-check"></i></span>
                            <div>
                                <strong>Tax & GST Filings</strong>
                                <p style="font-size: 0.9rem; color: #64748b; margin-top: 2px;">Automated tax calculation, tax slabs, and exportable audit trail for tax filing compliance.</p>
                            </div>
                        </li>
                    </ul>
                    <a href="{{ route('login') }}" class="btn btn-primary">View Financial Dashboard &rarr;</a>
                </div>

                <div class="showcase-box">
                    <div style="font-weight: 700; margin-bottom: 12px;">P&L Summary (Current Quarter)</div>
                    <div style="display: flex; flex-direction: column; gap: 8px; font-size: 0.9rem;">
                        <div style="display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid #e2e8f0;">
                            <span style="color: #64748b;">Total Sales Revenue:</span>
                            <strong>&#8377;18,45,000.00</strong>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid #e2e8f0;">
                            <span style="color: #64748b;">Cost of Goods Sold (COGS):</span>
                            <span style="color: #ef4444;">-&#8377;9,82,000.00</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid #e2e8f0; font-weight: 700;">
                            <span>Gross Margin:</span>
                            <span style="color: #10b981;">&#8377;8,63,000.00 (46.8%)</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid #e2e8f0;">
                            <span style="color: #64748b;">Operating Expenses:</span>
                            <span style="color: #ef4444;">-&#8377;2,21,500.00</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding-top: 10px; font-size: 1.1rem; font-weight: 800;">
                            <span>Net Profit:</span>
                            <span style="color: #4f46e5;">+&#8377;6,41,500.00</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 4: HR & Payroll -->
            <div class="tab-pane" id="tab-hr">
                <div class="showcase-content">
                    <h3>Keep Employees, Attendance & Payroll in Sync</h3>
                    <p>Manage employee records, roles, departmental structures, daily attendance records, and monthly payroll deductions without third-party HR subscriptions.</p>
                    <ul class="showcase-list">
                        <li>
                            <span class="list-icon"><i class="bx bx-check"></i></span>
                            <div>
                                <strong>Department & Designation Hierarchies</strong>
                                <p style="font-size: 0.9rem; color: #64748b; margin-top: 2px;">Assign staff to departments (Sales, Warehouse, Accounts) with custom access permissions.</p>
                            </div>
                        </li>
                        <li>
                            <span class="list-icon"><i class="bx bx-check"></i></span>
                            <div>
                                <strong>One-Click Payslip Generation</strong>
                                <p style="font-size: 0.9rem; color: #64748b; margin-top: 2px;">Calculate basic salaries, bonuses, and attendance deductions with downloadable payslips.</p>
                            </div>
                        </li>
                    </ul>
                    <a href="{{ route('login') }}" class="btn btn-primary">Manage HR Modules &rarr;</a>
                </div>

                <div class="showcase-box">
                    <div style="font-weight: 700; margin-bottom: 14px;">Today's Attendance Status</div>
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; text-align: center; margin-bottom: 16px;">
                        <div style="background: #ffffff; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0;">
                            <div style="font-size: 1.35rem; font-weight: 800; color: #10b981;">32</div>
                            <div style="font-size: 0.75rem; color: #64748b;">Present</div>
                        </div>
                        <div style="background: #ffffff; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0;">
                            <div style="font-size: 1.35rem; font-weight: 800; color: #f59e0b;">2</div>
                            <div style="font-size: 0.75rem; color: #64748b;">On Leave</div>
                        </div>
                        <div style="background: #ffffff; padding: 12px; border-radius: 10px; border: 1px solid #e2e8f0;">
                            <div style="font-size: 1.35rem; font-weight: 800; color: #64748b;">0</div>
                            <div style="font-size: 0.75rem; color: #64748b;">Late</div>
                        </div>
                    </div>
                    <div style="font-size: 0.8rem; color: #64748b; text-align: center;">
                        <i class="bx bx-check-double text-success"></i> September Payroll Ready for Processing
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Strip -->
    <section class="stats-strip">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <h3>99.98%</h3>
                    <p>Stock Count Precision</p>
                </div>
                <div class="stat-item">
                    <h3>&lt; 0.2s</h3>
                    <p>Barcode Scanning Latency</p>
                </div>
                <div class="stat-item">
                    <h3>57</h3>
                    <p>Built-in System Migrations</p>
                </div>
                <div class="stat-item">
                    <h3>100%</h3>
                    <p>Local & Self-Hosted Control</p>
                </div>
            </div>
        </div>
    </section>



    <!-- FAQ Accordion -->
    <section class="section" id="faq" style="background: #ffffff; border-top: 1px solid #e2e8f0;">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Got Questions?</span>
                <h2 class="section-title">Frequently Asked Questions</h2>
                <p class="section-desc">Common questions regarding local setup, hardware compatibility, and deployment.</p>
            </div>

            <div class="faq-grid">
                <div class="faq-item open">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>Can StockSathi run completely offline on a local network?</span>
                        <i class="bx bx-chevron-down faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        Yes, absolutely. StockSathi is fully self-hosted. You can run it on your local intranet (such as via Laragon, Apache, or Docker) with zero internet dependency, ensuring total data privacy and zero cloud downtime.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>What hardware is supported for POS cashier counters?</span>
                        <i class="bx bx-chevron-down faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        StockSathi works seamlessly with standard USB and Bluetooth barcode/QR scanners, 58mm and 80mm ESC/POS thermal receipt printers, electronic cash drawers, and touch-screen POS monitors.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>How does the physical warehouse Rack and Bin system work?</span>
                        <i class="bx bx-chevron-down faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        You can configure warehouse layouts into specific Racks (e.g., Aisle 2, Rack B) and subdivide each rack into individual Bins. Products are assigned bin locations so warehouse pickers know exact physical coordinates for every SKU.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>Do I need to purchase web hosting or a domain separately?</span>
                        <i class="bx bx-chevron-down faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        No, you don't! Every StockSathi cloud package includes a free custom domain (.com, .in, or .co.in), enterprise NVMe cloud hosting, free SSL encryption, and automated daily backups with zero setup fees. Alternatively, if you want local-only offline deployment on your own server or computers, StockSathi can also be installed directly on-premise.
                    </div>
                </div>

                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <span>How are user access permissions controlled?</span>
                        <i class="bx bx-chevron-down faq-icon"></i>
                    </div>
                    <div class="faq-answer">
                        The platform includes a robust Spatie Role-Based Access Control (RBAC) engine. You can create custom roles (e.g. Cashier, Warehouse Manager, Accountant) with granular view, edit, and delete permissions for each module.
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Banner -->
    <section style="padding: 2rem 0;">
        <div class="container">
            <div class="cta-banner">
                <div class="cta-banner-glow"></div>
                <h2>Take Full Control of Your Stock Today</h2>
                <p>Log in with the local admin account to test inventory transfers, barcode billing, financial ledger balance, and HR management in real time.</p>
                <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                    <a href="{{ route('login') }}" class="btn btn-white" style="padding: 0.85rem 2.25rem; font-size: 1rem; font-weight: 700;">
                        <i class="bx bx-log-in fs-5"></i> Sign In to Dashboard
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-ghost" style="background: rgba(255,255,255,0.12); color: #ffffff; border-color: rgba(255,255,255,0.25); padding: 0.85rem 2rem; font-size: 1rem;">
                            Create New Account
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <img src="{{ asset('backend/assets/images/logo-light.png') }}" alt="StockSathi Logo" class="footer-logo" onerror="this.src='{{ asset('backend/assets/images/logo-light.svg') }}'">
                    <p style="font-size: 0.9rem; line-height: 1.7; color: #64748b; max-width: 320px; margin-bottom: 1.5rem;">
                        The complete enterprise suite for inventory management, high-speed POS, multi-warehouse logistics, accounting, and employee payroll.
                    </p>
                    <div style="display: flex; gap: 8px;">
                        <span class="status-pill status-paid" style="background: rgba(16, 185, 129, 0.15); color: #34d399; font-size: 0.75rem;">
                            <i class="bx bx-check-shield"></i> Laravel 12 &bull; PHP 8.3 &bull; MySQL 9
                        </span>
                    </div>
                </div>

                <div class="footer-col">
                    <h5>Modules</h5>
                    <ul>
                        <li><a href="#features">Inventory & Batches</a></li>
                        <li><a href="#showcase">Barcode POS</a></li>
                        <li><a href="#features">Warehouses & Bins</a></li>
                        <li><a href="#features">Purchases & PO</a></li>
                        <li><a href="#features">Double-Entry Ledger</a></li>
                        <li><a href="#features">HR & Attendance</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h5>Access</h5>
                    <ul>
                        <li><a href="{{ route('login') }}">Admin Login</a></li>
                        <li><a href="{{ route('register') }}">Register Store</a></li>
                        <li><a href="#faq">Support &amp; FAQ</a></li>
                        <li><a href="{{ url('/dashboard') }}">ERP Dashboard</a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h5>Local Server</h5>
                    <div style="background: rgba(255, 255, 255, 0.04); border: 1px solid rgba(255, 255, 255, 0.08); padding: 1rem; border-radius: 12px;">
                        <div style="color: #ffffff; font-weight: 700; font-size: 0.85rem; margin-bottom: 4px;">Local Environment Active</div>
                        <div style="font-size: 0.775rem; color: #94a3b8; font-family: 'JetBrains Mono', monospace;">http://127.0.0.1:8000/</div>
                        <div style="font-size: 0.75rem; color: #64748b; margin-top: 6px;">Admin: admin@stocksathi.com</div>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} StockSathi ERP. All rights reserved. Crafted for scalable, modern operations.</p>
                <div style="display: flex; gap: 1.5rem;">
                    <a href="#" style="color: #64748b; text-decoration: none;">Privacy Policy</a>
                    <a href="#" style="color: #64748b; text-decoration: none;">Terms of Service</a>
                    <a href="#" style="color: #64748b; text-decoration: none;">System Architecture</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Toast Notification -->
    <div id="toast" class="toast-notify">
        <i class="bx bx-check-circle text-success" style="color: #34d399; font-size: 1.25rem;"></i>
        <span>Credentials copied to clipboard!</span>
    </div>

    <!-- Scripts -->
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function () {
            const nav = document.getElementById('navbar');
            if (window.scrollY > 20) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });

        // Tab switcher
        function switchTab(tabId) {
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('active'));

            const targetPane = document.getElementById(tabId);
            if (targetPane) {
                targetPane.classList.add('active');
            }

            event.currentTarget.classList.add('active');
        }

        // FAQ accordion toggle
        function toggleFaq(el) {
            const parent = el.closest('.faq-item');
            parent.classList.toggle('open');
        }

        // Copy credentials helper
        function copyCreds() {
            const text = "Email: admin@stocksathi.com | Password: password";
            navigator.clipboard.writeText(text).then(function() {
                const toast = document.getElementById('toast');
                toast.classList.add('show');
                setTimeout(function() {
                    toast.classList.remove('show');
                }, 2500);
            });
        }
    </script>
</body>

</html>
