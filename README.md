# Dispensario Premium E-commerce

## Descripción
E-commerce profesional para dispensario desarrollado con Laravel 12 y PHP 8.3. Usa SQLite para desarrollo local y puede configurarse con MySQL 8 para otros entornos.

## Requisitos
- PHP 8.3 o superior
- Composer 2
- SQLite (incluido con PHP mediante `pdo_sqlite`) para desarrollo local; MySQL 8 es opcional
- Node.js y NPM (para assets)
- Git

## Instalación

### 1. Clonar o descargar el proyecto
```bash
git clone <repo-url>
cd dispensario-ecommerce
```

### 2. Instalar dependencias de PHP
```bash
composer install
```

### 3. Copiar archivo de configuración
```bash
cp .env.example .env
```

### 4. Generar clave de aplicación
```bash
php artisan key:generate
```

### 5. Configurar la base de datos
La plantilla `.env.example` usa SQLite y el archivo `database/database.sqlite` incluido. No necesitas instalar MySQL para ejecutar el proyecto localmente.

Para usar MySQL en cambio, configura `.env` así:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dispensario_ecommerce
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Crear la base de datos MySQL (solo si elegiste MySQL)
```bash
mysql -u root -p -e "CREATE DATABASE dispensario_ecommerce;"
```

### 7. Ejecutar migraciones
```bash
php artisan migrate
```

### 8. Ejecutar seeders (datos de prueba)
```bash
php artisan db:seed
```

### 9. Instalar dependencias de frontend
```bash
npm install
npm run build
```

### 10. Crear enlace de almacenamiento
```bash
php artisan storage:link
```

### 11. Iniciar servidor
```bash
php artisan serve
```

## Acceso al Proyecto

### Cliente
- URL: http://localhost:8000
- Email: cliente@test.com
- Contraseña: password123

### Panel Administrativo
- URL: http://localhost:8000/admin
- Usuario: admin
- Contraseña: admin123456

**Otros usuarios admin:**
- Usuario: manager, Contraseña: manager123456
- Usuario: operador, Contraseña: operador123456

## Estructura del Proyecto

```
dispensario-ecommerce/
├── app/
│   ├── Models/              # Modelos Eloquent
│   ├── Http/
│   │   ├── Controllers/     # Controladores
│   │   ├── Middleware/      # Middleware personalizado
│   │   └── Requests/        # Form Requests
│   ├── Services/            # Servicios de negocio
│   ├── Events/              # Eventos
│   ├── Listeners/           # Listeners
│   ├── Exports/             # Exports Excel
│   └── Mail/                # Clases de Mail
├── database/
│   ├── migrations/          # Migraciones
│   ├── seeders/             # Seeders
│   └── factories/           # Factories
├── resources/
│   ├── views/               # Vistas Blade
│   ├── css/                 # Estilos
│   └── js/                  # JavaScript
├── routes/                  # Rutas de la aplicación
├── config/                  # Configuración
├── storage/                 # Archivos de almacenamiento
└── tests/                   # Tests
```

## Funcionalidades Principales

### Cliente
- ✅ Autenticación con email/contraseña y Google OAuth
- ✅ Catálogo de productos con búsqueda y filtros
- ✅ Carrito de compras funcional
- ✅ Checkout con múltiples direcciones
- ✅ Pagos por transferencia bancaria
- ✅ Subida de comprobantes
- ✅ Seguimiento de órdenes
- ✅ Perfil y direcciones guardadas
- ✅ Historial de órdenes
- ✅ Descarga de facturas PDF

### Administrador
- ✅ Dashboard con estadísticas
- ✅ CRUD de productos
- ✅ CRUD de categorías y marcas
- ✅ Gestión de órdenes
- ✅ Aprobación/Rechazo de comprobantes
- ✅ Actualización de estados de orden
- ✅ Seguimiento y envíos
- ✅ Gestión de cupones
- ✅ Gestión de banners
- ✅ Configuración de cuentas bancarias
- ✅ Exportación de órdenes a Excel
- ✅ Auditoría de cambios

## Configuración de Google OAuth

1. Ir a Google Cloud Console
2. Crear nuevo proyecto
3. Crear credenciales OAuth 2.0
4. Descargar archivo JSON
5. Configurar en .env:
```
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

## Configuración de Email

Por defecto usa Mailtrap en development. Configurar en .env:
```
MAIL_MAILER=mailtrap
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=
MAIL_PASSWORD=
```

## Base de Datos

### Tablas Principales
- users (Clientes)
- admin_users (Administradores)
- products (Productos)
- categories (Categorías)
- brands (Marcas)
- product_images (Imágenes de productos)
- carts (Carritos)
- orders (Órdenes)
- order_items (Items de orden)
- order_proofs (Comprobantes de pago)
- order_tracking (Tracking de orden)
- order_shipments (Información de envío)
- addresses (Direcciones de clientes)
- coupons (Cupones de descuento)
- banners (Banners de inicio)
- bank_accounts (Cuentas bancarias)
- settings (Configuración)
- notifications (Notificaciones)
- audit_logs (Log de auditoría)

## Roles y Permisos

### Super Admin
- Acceso total al panel
- Puede eliminar productos y usuarios
- Gestión de otros admins

### Admin
- Gestión de productos, órdenes y clientes
- No puede eliminar productos

### Manager
- Visualización de reportes
- Gestión de órdenes pendientes

## SEO

- URLs amigables
- Meta etiquetas en productos
- Open Graph para redes sociales
- Sitemap generado automáticamente
- robots.txt configurado

## Optimizaciones

- ✅ Lazy loading de imágenes
- ✅ Compresión de imágenes
- ✅ Caché de productos
- ✅ Índices en base de datos
- ✅ Soft deletes en modelos críticos
- ✅ Full-text search

## Seguridad

- ✅ CSRF Protection
- ✅ XSS Protection
- ✅ SQL Injection Prevention
- ✅ Hash de contraseñas con bcrypt
- ✅ Validaciones en servidor
- ✅ Middleware de autenticación separado
- ✅ Rate limiting

## Testing

```bash
# Ejecutar todos los tests
php artisan test

# Con coverage
php artisan test --coverage
```

## Comandos Útiles

```bash
# Limpiar cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Generar sitemap
php artisan sitemap:generate

# Optimizar autoload
composer dump-autoload -o

# Crear nuevo usuario admin
php artisan tinker
> AdminUser::create(['username' => 'nuevo', 'email' => 'nuevo@test.com', 'name' => 'Nuevo Admin', 'password' => bcrypt('password123'), 'role' => 'admin'])
```

## Deployment

### Para Producción

1. Configurar variables de entorno:
```bash
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tudominio.com
```

2. Generar key único:
```bash
php artisan key:generate
```

3. Optimizar autoload:
```bash
composer install --optimize-autoloader --no-dev
```

4. Compilar assets:
```bash
npm run build
```

5. Ejecutar migraciones:
```bash
php artisan migrate --force
```

6. Configurar web server (Apache/Nginx)

## Soporte

Para reportar bugs o sugerencias, contactar a: soporte@dispensario.com

## Licencia

Propietario - Dispensario Premium 2024

## Autor

Desarrollado profesionalmente para Dispensario Premium

---

**Nota:** Este es un proyecto profesional listo para producción. Asegúrate de configurar todas las variables de entorno y pruebas antes de hacer deploy.
