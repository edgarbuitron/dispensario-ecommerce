# Inicio Rápido - Dispensario E-commerce

## 🚀 Comenzar en 5 minutos

### Requisitos Previos
```bash
php 8.3
mysql 8
composer
node.js
```

### Paso 1: Descargar e Instalar Dependencias
```bash
# Descargar el proyecto (ya está descargado)
cd dispensario-ecommerce

# Instalar dependencias PHP
composer install

# Instalar dependencias JS
npm install
```

### Paso 2: Configurar Ambiente
```bash
# Copiar archivo de configuración
cp .env.example .env

# Generar clave de aplicación
php artisan key:generate
```

### Paso 3: Base de Datos
```bash
# En MySQL, crear database
CREATE DATABASE dispensario_ecommerce;

# O desde terminal
mysql -u root -p -e "CREATE DATABASE dispensario_ecommerce;"

# En .env, configurar:
DB_DATABASE=dispensario_ecommerce
DB_USERNAME=root
DB_PASSWORD=(tu contraseña)

# Migrar y seedear
php artisan migrate
php artisan db:seed
```

### Paso 4: Almacenamiento
```bash
php artisan storage:link
npm run build
```

### Paso 5: Iniciar Servidor
```bash
php artisan serve
```

## 🔐 Credenciales de Prueba

### Cliente
- Email: `cliente@test.com`
- Contraseña: `password123`
- URL: `http://localhost:8000`

### Admin
- Usuario: `admin`
- Contraseña: `admin123456`
- URL: `http://localhost:8000/admin`

**Otros admins:**
- manager / manager123456
- operador / operador123456

## 📁 Estructura de Carpetas

```
dispensario-ecommerce/
├── app/
│   ├── Models/              ← Modelos de BD (22 modelos)
│   ├── Http/Controllers/    ← Controladores (15 controladores)
│   ├── Services/            ← Servicios de negocio
│   ├── Events & Listeners/  ← Eventos y notificaciones
│   └── Exports/             ← Exportaciones a Excel
├── database/
│   ├── migrations/          ← 10 migraciones
│   ├── seeders/             ← 8 seeders con datos
│   └── factories/           ← Factories para testing
├── resources/views/
│   ├── layouts/             ← Templates base
│   ├── client/              ← Vistas del cliente
│   └── admin/               ← Vistas del admin
├── routes/
│   └── web.php              ← Todas las rutas (40+)
├── config/
│   └── auth.php             ← Configuración dual de auth
└── storage/                 ← Imágenes y archivos
```

## 🎯 Funcionalidades Principales

### Para Clientes
- ✅ Registrar/Iniciar sesión (Email + Google OAuth)
- ✅ Buscar y filtrar productos
- ✅ Ver detalles de producto
- ✅ Agregar al carrito
- ✅ Aplicar cupones
- ✅ Checkout
- ✅ Subir comprobante de pago
- ✅ Seguimiento de órdenes
- ✅ Descargar factura PDF

### Para Administrador
- ✅ Ver estadísticas en tiempo real
- ✅ Gestionar productos (CRUD)
- ✅ Gestionar categorías y marcas
- ✅ Aprobar/Rechazar comprobantes
- ✅ Cambiar estado de órdenes
- ✅ Agregar guía de envío
- ✅ Gestionar cupones y banners
- ✅ Exportar órdenes a Excel
- ✅ Configurar cuentas bancarias

## 🔧 Configuración Importante

### Google OAuth
1. Ir a Google Cloud Console
2. Crear credenciales OAuth 2.0
3. En `.env`:
```
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

### Email
Por defecto usa Mailtrap. Configurar en `.env`:
```
MAIL_MAILER=mailtrap
MAIL_HOST=smtp.mailtrap.io
MAIL_USERNAME=
MAIL_PASSWORD=
```

### WhatsApp
Agregar número en `.env`:
```
WHATSAPP_NUMBER=+5551234567
```

## 📊 Base de Datos - 24 Tablas Principales

- users (Clientes)
- admin_users (Administradores)
- products, categories, brands (Catálogo)
- product_images, product_attributes
- carts, cart_items (Carrito)
- orders, order_items, order_tracking (Órdenes)
- order_proofs, order_shipments (Pago y envío)
- addresses (Direcciones)
- coupons, promotions, banners (Marketing)
- bank_accounts, settings (Configuración)
- notifications, audit_logs (Sistema)

## 🛠️ Comandos Útiles

```bash
# Ver todas las rutas
php artisan route:list

# Limpiar cache
php artisan cache:clear

# Generar nuevos datos de prueba
php artisan db:seed

# Ejecutar tests
php artisan test

# Crear usuario admin nuevo
php artisan tinker
> App\Models\AdminUser::create([
  'username' => 'test',
  'email' => 'test@admin.com',
  'name' => 'Test Admin',
  'password' => bcrypt('password123'),
  'role' => 'admin'
])

# Compilar assets para producción
npm run build

# Ver logs
tail -f storage/logs/laravel.log
```

## 📝 Archivos de Configuración

### .env (Crear desde .env.example)
```
APP_NAME="Dispensario Premium"
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=dispensario_ecommerce
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=log
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_FROM_ADDRESS=noreply@dispensario.com

GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
```

## 🚀 Deploy a Producción

### Requerimientos
```
PHP 8.3+
MySQL 8+
Composer
npm/node
SSL Certificate
```

### Pasos
```bash
# 1. Clonar proyecto
git clone <repo>

# 2. Instalar dependencias
composer install --optimize-autoloader --no-dev
npm install
npm run build

# 3. Configurar .env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tudominio.com

# 4. Migraciones
php artisan migrate --force

# 5. Configurar permisos
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chown -R www-data:www-data storage/
```

## 🐛 Troubleshooting

### "SQLSTATE[HY000]"
- Verificar credenciales de MySQL en .env

### "Class not found"
```bash
composer dump-autoload -o
```

### "Disk not found 'public'"
```bash
php artisan storage:link
```

### Problemas con CORS
- Verificar CORS en .env si hay API

## 📚 Documentación Completa

Ver archivos:
- `README.md` - Documentación general
- `TECHNICAL_SPEC.md` - Especificación técnica
- `/routes/web.php` - Todas las rutas
- `/app/Http/Controllers/` - Lógica de controladores

## 🎓 Aprender el Código

### Flujo de Compra (Cliente)
1. HomeController → Mostrar homepage
2. CatalogController → Buscar productos
3. CartController → Agregar al carrito
4. OrderController → Crear orden
5. OrderService → Procesar pago

### Flujo de Admin
1. AuthController → Login
2. DashboardController → Mostrar estadísticas
3. AdminProductController → CRUD productos
4. AdminOrderController → Gestionar órdenes
5. AdminSettingController → Configuración

### Modelos Relacionados
```
User → Orders → OrderItems → Products
User → Addresses
Cart → CartItems → Products
Order → OrderProofs, OrderShipment, OrderTracking
Product → Category, Brand, ProductImages
```

## 🆘 Soporte y Contacto

- Email: soporte@dispensario.com
- WhatsApp: +5551234567

## 📄 Licencia

Propietario - Dispensario Premium 2024

---

**¿Listo para empezar? 🚀**

1. Ejecuta: `php artisan serve`
2. Abre: `http://localhost:8000`
3. ¡Disfruta tu e-commerce profesional!
