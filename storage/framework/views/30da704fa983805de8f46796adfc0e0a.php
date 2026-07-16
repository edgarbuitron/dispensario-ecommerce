<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo $__env->yieldContent('meta_description', 'Dispensario Premium - Los mejores productos'); ?>">
    <meta name="keywords" content="<?php echo $__env->yieldContent('meta_keywords'); ?>">
    <meta property="og:title" content="<?php echo $__env->yieldContent('og_title', config('app.name')); ?>">
    <meta property="og:description" content="<?php echo $__env->yieldContent('og_description'); ?>">
    <meta property="og:image" content="<?php echo $__env->yieldContent('og_image'); ?>">
    <meta property="og:url" content="<?php echo e(url()->current()); ?>">
    
    <title><?php echo $__env->yieldContent('title', config('app.name')); ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            /* Marca */
            --color-black: #0a0a0a;
            --color-ink: #17181a;
            --color-accent: #2f5d3a;
            --color-accent-dark: #21422a;
            --color-accent-light: #e7f0e9;
            --color-danger: #dc3545;
            --color-warning: #b8860b;

            /* Superficie / texto */
            --color-bg: #ffffff;
            --color-surface: #ffffff;
            --color-surface-alt: #f7f7f5;
            --color-text: #1a1a1a;
            --color-text-muted: #6b6f76;
            --color-border: #e7e7e4;

            /* Tipografía */
            --font-sans: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;

            /* Espaciado */
            --space-1: 0.25rem;
            --space-2: 0.5rem;
            --space-3: 0.75rem;
            --space-4: 1rem;
            --space-6: 1.5rem;
            --space-8: 2rem;
            --space-12: 3rem;

            /* Radios y sombras */
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 16px;
            --radius-full: 999px;
            --shadow-sm: 0 1px 3px rgba(10, 10, 10, 0.06);
            --shadow-md: 0 6px 20px rgba(10, 10, 10, 0.08);
            --shadow-lg: 0 16px 40px rgba(10, 10, 10, 0.14);
            --transition: 0.2s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: var(--font-sans);
            font-size: 16px;
            color: var(--color-text);
            background-color: var(--color-bg);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, h4, h5, h6 {
            font-weight: 700;
            letter-spacing: -0.02em;
            line-height: 1.2;
            color: var(--color-black);
        }

        a {
            color: var(--color-accent);
            transition: color var(--transition);
        }

        a:hover {
            color: var(--color-accent-dark);
        }

        p {
            color: var(--color-text);
        }

        ::selection {
            background: var(--color-accent-light);
            color: var(--color-accent-dark);
        }

        :focus-visible {
            outline: 2px solid var(--color-accent);
            outline-offset: 2px;
        }

        /* Navbar */
        .navbar {
            background: var(--color-black);
            padding: 0.85rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: var(--shadow-md);
        }

        .navbar-brand {
            font-size: 1.35rem;
            font-weight: 800;
            color: #fff;
            letter-spacing: -0.02em;
            white-space: nowrap;
        }

        .navbar a {
            color: rgba(255, 255, 255, 0.82);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: color var(--transition);
        }

        .navbar a:hover {
            color: #fff;
        }

        .navbar .nav-links {
            display: flex;
            align-items: center;
            gap: 1.75rem;
            flex-wrap: wrap;
        }

        .navbar .cart-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            background: var(--color-accent);
            color: #fff !important;
            padding: 0.45rem 0.85rem;
            border-radius: var(--radius-full);
            font-weight: 600;
            font-size: 0.9rem;
        }

        .navbar .cart-pill:hover {
            background: var(--color-accent-dark);
        }

        #navSearchInput {
            font-family: var(--font-sans);
            border: 1px solid transparent;
        }

        #navSearchInput:focus-visible {
            outline: 2px solid var(--color-accent);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        footer {
            background: var(--color-black);
            color: rgba(255, 255, 255, 0.85);
            padding: var(--space-12) 0 var(--space-6);
            margin-top: var(--space-12);
        }

        footer h4 {
            color: #fff;
            font-size: 1rem;
            margin-bottom: var(--space-4);
        }

        footer a {
            color: rgba(255, 255, 255, 0.7) !important;
        }

        footer a:hover {
            color: #fff !important;
        }

        footer p {
            color: rgba(255, 255, 255, 0.65);
            font-size: 0.9rem;
        }

        /* Botones */
        .btn {
            padding: 0.7rem 1.4rem;
            border: 1px solid transparent;
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: all var(--transition);
            text-decoration: none;
            display: inline-block;
            font-family: var(--font-sans);
            font-weight: 600;
            font-size: 0.95rem;
        }

        .btn-primary {
            background: var(--color-accent);
            color: #fff;
        }

        .btn-primary:hover {
            background: var(--color-accent-dark);
            color: #fff;
        }

        .btn-secondary {
            background: #fff;
            color: var(--color-text);
            border-color: var(--color-border);
        }

        .btn-secondary:hover {
            background: var(--color-surface-alt);
            border-color: #d3d3ce;
        }

        .btn-danger {
            background: var(--color-danger);
            color: #fff;
        }

        .btn-danger:hover {
            background: #b52a37;
        }

        .btn-outline-danger {
            background: transparent;
            color: var(--color-danger);
            border-color: var(--color-danger);
        }

        .btn-outline-danger:hover {
            background: var(--color-danger);
            color: #fff;
        }

        /* Tarjetas y superficies */
        .card {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
        }

        /* Insignias */
        .badge-pill {
            display: inline-block;
            padding: 0.3rem 0.75rem;
            border-radius: var(--radius-full);
            font-size: 0.78rem;
            font-weight: 600;
        }

        .badge-success { background: var(--color-accent-light); color: var(--color-accent-dark); }
        .badge-warning { background: #fdf1d9; color: #8a6116; }
        .badge-danger { background: #fbe4e6; color: #a3212d; }
        .badge-muted { background: var(--color-surface-alt); color: var(--color-text-muted); }

        /* Alertas */
        .alert {
            padding: 1rem 1.25rem;
            margin: 1rem 0;
            border-radius: var(--radius-md);
            border: 1px solid transparent;
            font-size: 0.95rem;
        }

        .alert-success {
            background: var(--color-accent-light);
            color: var(--color-accent-dark);
            border-color: #cfe3d4;
        }

        .alert-error {
            background: #fbe4e6;
            color: #a3212d;
            border-color: #f3c4c8;
        }

        /* Formularios */
        input[type="text"], input[type="email"], input[type="password"], input[type="number"],
        input[type="tel"], input[type="date"], input[type="url"], select, textarea {
            font-family: var(--font-sans);
            font-size: 0.95rem;
            transition: border-color var(--transition), box-shadow var(--transition);
        }

        input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus,
        input[type="number"]:focus, input[type="tel"]:focus, input[type="date"]:focus,
        input[type="url"]:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--color-accent) !important;
            box-shadow: 0 0 0 3px var(--color-accent-light);
        }

        /* Utilidades */
        .text-muted { color: var(--color-text-muted); }
        .text-accent { color: var(--color-accent); }
    </style>

    <?php echo $__env->yieldPushContent('css'); ?>
</head>
<body>
    <!-- WhatsApp Flotante -->
    <a href="https://wa.me/<?php echo e(str_replace(['+', ' ', '-'], '', config('app.whatsapp'))); ?>" 
       class="whatsapp-float" 
       target="_blank" 
       rel="noopener noreferrer"
       title="Contactar por WhatsApp">
        <svg viewBox="0 0 24 24" fill="currentColor">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.076 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421-7.403h-.004a9.87 9.87 0 00-4.905 1.347l-.384.214-.397-.013a10.282 10.282 0 00-1.447-.144c-5.395 0-9.795 4.365-9.795 9.745 0 1.735.372 3.465 1.009 5.045L2.323 24l5.396-1.786c1.546.792 3.259 1.227 5.003 1.227 5.351 0 9.737-4.363 9.737-9.745 0-2.614-.648-5.089-1.877-7.268-.596-.963-1.321-1.902-2.219-2.749a9.75 9.75 0 00-4.638-1.24z"/>
        </svg>
    </a>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="container" style="display: flex; justify-content: space-between; align-items: center; gap: 1.5rem; flex-wrap: wrap;">
            <a href="<?php echo e(route('home')); ?>" class="navbar-brand">🌿 Dispensario</a>

            <form method="GET" action="<?php echo e(route('catalog.index')); ?>" style="position: relative; flex: 1; min-width: 180px; max-width: 340px;">
                <input type="text" id="navSearchInput" name="search" autocomplete="off" placeholder="Buscar productos..."
                       value="<?php echo e(request('search')); ?>"
                       style="width: 100%; padding: 0.6rem 1rem; border-radius: var(--radius-full); border: none;">
                <div id="navSearchResults"
                     style="display: none; position: absolute; top: 110%; left: 0; right: 0; background: #fff; color: #333; border-radius: var(--radius-md); box-shadow: var(--shadow-lg); overflow: hidden; z-index: 50;"></div>
            </form>

            <div class="nav-links">
                <a href="<?php echo e(route('home')); ?>">Inicio</a>
                <a href="<?php echo e(route('catalog.index')); ?>">Catálogo</a>
                <!--<a href="<?php echo e(route('faq')); ?>">Preguntas</a>-->
                <a href="<?php echo e(route('contact')); ?>">Contacto</a>

                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('wishlist.index')); ?>">❤️ Favoritos</a>
                    <a href="<?php echo e(route('profile.index')); ?>">Perfil</a>
                    <a href="<?php echo e(route('orders.index')); ?>">Órdenes</a>
                    <form method="POST" action="<?php echo e(route('logout')); ?>" style="display:inline;">
                        <?php echo csrf_field(); ?>
                        <button type="submit" style="background:none; border:none; color:rgba(255,255,255,0.82); cursor:pointer; font:inherit;">Salir</button>
                    </form>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>">Iniciar Sesión</a>
                <?php endif; ?>

                <?php if(auth()->guard('admin')->check()): ?>
                    <a href="<?php echo e(route('admin.dashboard')); ?>">Admin</a>
                <?php else: ?>
                    <a href="<?php echo e(route('admin.login')); ?>">Admin</a>
                <?php endif; ?>

                <a href="<?php echo e(route('cart.index')); ?>" class="cart-pill">🛒 <span id="cart-count">0</span></a>
            </div>
        </div>
    </nav>

    <!-- Mensajes Flash -->
    <?php if($errors->any()): ?>
        <div class="container">
            <div class="alert alert-error">
                <ul>
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        </div>
    <?php endif; ?>

    <?php if(session('success')): ?>
        <div class="container">
            <div class="alert alert-success">
                <?php echo e(session('success')); ?>

            </div>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="container">
            <div class="alert alert-error">
                <?php echo e(session('error')); ?>

            </div>
        </div>
    <?php endif; ?>

    <!-- Contenido Principal -->
    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: var(--space-8);">
                <div>
                    <h4>🌿 Dispensario Premium</h4>
                    <p>Tu tienda de confianza con los mejores productos y servicio.</p>
                </div>
                <div>
                    <h4>Enlaces</h4>
                    <ul style="list-style: none; display: flex; flex-direction: column; gap: 0.5rem;">
                        <li><a href="<?php echo e(route('terms')); ?>">Términos y Condiciones</a></li>
                        <li><a href="<?php echo e(route('privacy')); ?>">Política de Privacidad</a></li>
                        <li><a href="<?php echo e(route('shipping')); ?>">Envíos</a></li>
                        <li><a href="<?php echo e(route('returns')); ?>">Devoluciones</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Contacto</h4>
                    <p style="margin-bottom: 0.35rem;">Email: <?php echo e(config('app.support_email')); ?></p>
                    <p>WhatsApp: <?php echo e(config('app.whatsapp')); ?></p>
                </div>
                <div>
                    <h4>Síguenos</h4>
                    <div style="display: flex; gap: 1rem;">
                        <a href="#">Instagram</a>
                        <a href="#">Facebook</a>
                    </div>
                </div>
            </div>

            <hr style="margin: var(--space-8) 0; border: none; border-top: 1px solid rgba(255,255,255,0.12);">

            <div style="text-align: center;">
                <p>&copy; <?php echo e(now()->year); ?> Dispensario Premium. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Modal Verificación de Edad -->
    <?php if(!auth()->check() && !session('age_verified')): ?>
        <div id="ageModal" style="display: flex; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(10,10,10,0.92); z-index: 2000; align-items: center; justify-content: center; padding: 1rem;">
            <div class="card" style="padding: 2.5rem 2rem; max-width: 400px; text-align: center;">
                <p style="font-size: 2.5rem; margin-bottom: 0.5rem;">🌿</p>
                <h2 style="margin-bottom: 0.5rem;">Verificación de Edad</h2>
                <p style="margin: 0.5rem 0 1.5rem; color: var(--color-text-muted);">Debes confirmar que tienes 18 años o más para acceder a este sitio.</p>

                <form method="POST" action="<?php echo e(route('age-gate.verify')); ?>">
                    <?php echo csrf_field(); ?>
                    <label style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; margin-bottom: 1.5rem; cursor: pointer; font-size: 0.9rem;">
                        <input type="checkbox" name="age_verified" required>
                        <span>Confirmo que tengo 18 años o más</span>
                    </label>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Continuar</button>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <style>
        .whatsapp-float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 20px;
            right: 20px;
            background-color: #25d366;
            color: white;
            border-radius: 50%;
            text-align: center;
            font-size: 30px;
            z-index: 999;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            transition: all 0.3s;
        }
        
        .whatsapp-float:hover {
            background-color: #20ba5a;
            transform: scale(1.1);
        }
        
        .whatsapp-float svg {
            width: 40px;
            height: 40px;
        }
    </style>

    <?php echo $__env->yieldPushContent('js'); ?>

    <script>
        // Actualizar contador del carrito
        function updateCartCount() {
            fetch('<?php echo e(route("cart.mini")); ?>')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('cart-count').textContent = data.count;
                });
        }
        
        updateCartCount();

        // Búsqueda rápida en el navbar
        (function () {
            const input = document.getElementById('navSearchInput');
            const results = document.getElementById('navSearchResults');
            let debounce;

            if (!input || !results) return;

            input.addEventListener('input', function () {
                clearTimeout(debounce);
                const q = input.value.trim();

                if (q.length < 2) {
                    results.style.display = 'none';
                    return;
                }

                debounce = setTimeout(function () {
                    fetch('<?php echo e(route("search")); ?>?q=' + encodeURIComponent(q))
                        .then((r) => r.json())
                        .then((data) => {
                            if (!data.results || data.results.length === 0) {
                                results.innerHTML = '<div style="padding: 1rem; color: #666;">Sin resultados</div>';
                                results.style.display = 'block';
                                return;
                            }

                            const esc = (s) => String(s).replace(/[&<>"']/g, (c) => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));

                            results.innerHTML = data.results.map(function (p) {
                                return '<a href="/product/' + encodeURIComponent(p.slug) + '" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; text-decoration: none; color: #333; border-bottom: 1px solid #eee;">' +
                                    (p.image ? '<img src="' + esc(p.image) + '" style="width: 36px; height: 36px; object-fit: cover; border-radius: 4px;">' : '<span style="width:36px;height:36px;display:flex;align-items:center;justify-content:center;">📦</span>') +
                                    '<span style="flex:1;">' + esc(p.name) + '</span>' +
                                    '<strong>' + esc(p.price) + '</strong>' +
                                    '</a>';
                            }).join('') + '<a href="<?php echo e(route("catalog.index")); ?>?search=' + encodeURIComponent(q) + '" style="display:block; text-align:center; padding:0.75rem; font-weight:600; text-decoration:none; color:#2f5d3a; background:#f7f7f5;">Ver todos los resultados</a>';
                            results.style.display = 'block';
                        });
                }, 250);
            });

            document.addEventListener('click', function (e) {
                if (!input.contains(e.target) && !results.contains(e.target)) {
                    results.style.display = 'none';
                }
            });
        })();

        // Dark mode
        if (localStorage.getItem('theme') === 'dark') {
            document.body.style.background = '#1a1a1a';
            document.body.style.color = '#fff';
        }
    </script>
</body>
</html>
<?php /**PATH C:\Users\cesar\Videos\proyectos\proyectos\dispensario-ecommerce\resources\views/layouts/client.blade.php ENDPATH**/ ?>