<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Dispensario Premium - Los mejores productos')">
    <meta name="keywords" content="@yield('meta_keywords')">
    <meta property="og:title" content="@yield('og_title', config('app.name'))">
    <meta property="og:description" content="@yield('og_description')">
    <meta property="og:image" content="@yield('og_image')">
    <meta property="og:url" content="{{ url()->current() }}">
    
    <title>@yield('title', config('app.name'))</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary: #000;
            --secondary: #1a1a1a;
            --accent: #ffffff;
            --light: #f5f5f5;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            background-color: #fff;
            line-height: 1.6;
        }
        
        .navbar {
            background: #000;
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff;
        }
        
        .navbar a {
            color: #fff;
            text-decoration: none;
            margin: 0 1rem;
            transition: opacity 0.3s;
        }
        
        .navbar a:hover {
            opacity: 0.7;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }
        
        footer {
            background: #000;
            color: #fff;
            padding: 2rem;
            margin-top: 4rem;
        }
        
        .btn {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }
        
        .btn-primary {
            background: #000;
            color: #fff;
        }
        
        .btn-primary:hover {
            background: #333;
        }
        
        .alert {
            padding: 1rem;
            margin: 1rem 0;
            border-radius: 4px;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
    
    @stack('css')
</head>
<body>
    <!-- WhatsApp Flotante -->
    <a href="https://wa.me/{{ str_replace(['+', ' ', '-'], '', config('app.whatsapp')) }}" 
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
        <div class="container" style="display: flex; justify-content: space-between; align-items: center;">
            <a href="{{ route('home') }}" class="navbar-brand">🌿 Dispensario</a>
            
            <div style="display: flex; gap: 2rem;">
                <a href="{{ route('home') }}">Inicio</a>
                <a href="{{ route('catalog.index') }}">Catálogo</a>
                <a href="{{ route('faq') }}">Preguntas</a>
                <a href="{{ route('contact') }}">Contacto</a>
                
                @auth
                    <a href="{{ route('profile.index') }}">Perfil</a>
                    <a href="{{ route('orders.index') }}">Órdenes</a>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                        @csrf
                        <button type="submit" style="background:none; border:none; color:#fff; cursor:pointer;">Salir</button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Iniciar Sesión</a>
                @endauth
                
                <a href="{{ route('cart.index') }}">🛒 <span id="cart-count">0</span></a>
            </div>
        </div>
    </nav>

    <!-- Mensajes Flash -->
    @if ($errors->any())
        <div class="container">
            <div class="alert alert-error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    @if (session('success'))
        <div class="container">
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="container">
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Contenido Principal -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem;">
                <div>
                    <h4>Sobre Nosotros</h4>
                    <p>Dispensario Premium es tu tienda de confianza con los mejores productos y servicio.</p>
                </div>
                <div>
                    <h4>Enlaces</h4>
                    <ul style="list-style: none;">
                        <li><a href="{{ route('terms') }}" style="color: #fff;">Términos y Condiciones</a></li>
                        <li><a href="{{ route('privacy') }}" style="color: #fff;">Política de Privacidad</a></li>
                        <li><a href="{{ route('shipping') }}" style="color: #fff;">Envíos</a></li>
                        <li><a href="{{ route('returns') }}" style="color: #fff;">Devoluciones</a></li>
                    </ul>
                </div>
                <div>
                    <h4>Contacto</h4>
                    <p>Email: {{ config('app.support_email') }}</p>
                    <p>WhatsApp: {{ config('app.whatsapp') }}</p>
                </div>
                <div>
                    <h4>Síguenos</h4>
                    <a href="#" style="color: #fff; margin-right: 1rem;">Instagram</a>
                    <a href="#" style="color: #fff;">Facebook</a>
                </div>
            </div>
            
            <hr style="margin: 2rem 0; border-color: #333;">
            
            <div style="text-align: center;">
                <p>&copy; 2024 Dispensario Premium. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Modal Verificación de Edad -->
    @if (!auth()->check() && !session('age_verified'))
        <div id="ageModal" style="display: flex; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 2000; align-items: center; justify-content: center;">
            <div style="background: #fff; padding: 2rem; border-radius: 8px; max-width: 400px; text-align: center;">
                <h2>⚠️ Verificación de Edad</h2>
                <p style="margin: 1rem 0; color: #666;">Debes confirmar que tienes 18 años o más para acceder a este sitio.</p>
                
                <form method="POST" action="{{ route('age-gate.verify') }}">
                    @csrf
                    <label style="display: flex; align-items: center; justify-content: center; margin: 1rem 0; cursor: pointer;">
                        <input type="checkbox" name="age_verified" required>
                        <span style="margin-left: 0.5rem;">Confirmo que tengo 18 años o más</span>
                    </label>
                    <button type="submit" class="btn btn-primary" style="width: 100%;">Continuar</button>
                </form>
            </div>
        </div>
    @endif

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

    @stack('js')

    <script>
        // Actualizar contador del carrito
        function updateCartCount() {
            fetch('{{ route("cart.mini") }}')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('cart-count').textContent = data.count;
                });
        }
        
        updateCartCount();
        
        // Dark mode
        if (localStorage.getItem('theme') === 'dark') {
            document.body.style.background = '#1a1a1a';
            document.body.style.color = '#fff';
        }
    </script>
</body>
</html>
