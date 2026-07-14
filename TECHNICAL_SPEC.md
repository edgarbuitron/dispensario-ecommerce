# Especificación Técnica - Dispensario E-commerce

## Información General
- **Proyecto:** Dispensario Premium E-commerce
- **Versión:** 1.0.0
- **Fecha:** 2024
- **Framework:** Laravel 12
- **PHP:** 8.3+
- **Database:** MySQL 8
- **Estado:** Producción

## Stack Tecnológico

### Backend
- Laravel 12.x
- PHP 8.3
- MySQL 8
- Laravel Breeze (Autenticación)
- Laravel Excel (Importación/Exportación)
- DomPDF (Generación de PDFs)
- Intervention Image (Procesamiento de imágenes)
- Socialite + Google OAuth

### Frontend
- Bootstrap 5
- JavaScript Vanilla
- Blade Templates
- Vite (Asset Bundling)

## Base de Datos - 24 Tablas

1. **users** - Clientes del sistema
   - Autenticación con email/contraseña o Google OAuth
   - Verificación de edad
   
2. **admin_users** - Administradores
   - Roles: super_admin, admin, manager
   - Logging de último acceso

3. **categories** - Categorías de productos
   - Soft deletes
   - SEO friendly URLs

4. **brands** - Marcas
   - Logo y website

5. **products** - Productos
   - Full-text search
   - Estados: available, low, out_of_stock, hidden
   - Productos nuevos y destacados

6. **product_images** - Imágenes de productos
   - Soporte para múltiples imágenes
   - Imagen primaria

7. **product_attributes** - Atributos de productos
   - Sabor, presentación, tipo

8. **carts** - Carritos de compra
   - Session-based y user-based

9. **cart_items** - Items del carrito
   - Sincronización de precios

10. **addresses** - Direcciones de envío
    - Múltiples direcciones por cliente
    - Dirección por defecto

11. **orders** - Órdenes/Pedidos
    - 8 estados posibles
    - Timestamps de transiciones de estado

12. **order_items** - Detalles de órdenes
    - Información congelada del producto

13. **order_tracking** - Seguimiento de órdenes
    - Timeline de estados

14. **order_proofs** - Comprobantes de pago
    - Estados: pending, approved, rejected

15. **order_shipments** - Información de envío
    - Número de guía
    - Carrier/Paquetería

16. **coupons** - Cupones de descuento
    - Tipos: percentage, fixed
    - Control de usos

17. **promotions** - Promociones
    - Por producto o categoría

18. **banners** - Banners del sitio
    - Posiciones: hero, secondary, bottom

19. **bank_accounts** - Cuentas bancarias
    - Múltiples cuentas

20. **settings** - Configuración del sistema
    - Por grupo (general, social, email, etc.)

21. **notifications** - Historial de notificaciones
    - Por canal: email, sms, notification

22. **audit_logs** - Logs de auditoría
    - Todas las acciones de admin

23. **password_reset_tokens** - Tokens de reset
    - Por Laravel

24. **sessions** - Sesiones
    - Por Laravel

## Modelos (22 Modelos)

### Clientes
- User
- Address

### Productos
- Product
- Category
- Brand
- ProductImage
- ProductAttribute

### Carrito y Órdenes
- Cart
- CartItem
- Order
- OrderItem
- OrderTracking
- OrderProof
- OrderShipment

### Administración
- AdminUser
- Coupon
- Promotion
- Banner
- BankAccount
- Setting
- Notification
- AuditLog

## Controladores (15 Controladores)

### Frontend (5 Controladores)
- HomeController
- CatalogController
- CartController
- OrderController
- ProfileController

### Admin (10 Controladores)
- Admin\AuthController
- Admin\DashboardController
- Admin\ProductController
- Admin\CategoryController
- Admin\BrandController
- Admin\OrderController
- Admin\CouponController
- Admin\BannerController
- Admin\SettingController

## Servicios (3 Servicios)

1. **CartService**
   - Gestión de carrito
   - Aplicación de cupones
   - Sincronización con BD

2. **OrderService**
   - Creación de órdenes
   - Gestión de estados
   - Subida de comprobantes
   - Aprobación/Rechazo de pagos

3. **ProductService**
   - Búsqueda de productos
   - Filtrado avanzado
   - Productos relacionados
   - Estadísticas

## Rutas (40+ Rutas)

### Públicas
- Inicio, about, contact, FAQ
- Catálogo, búsqueda, categorías, marcas
- Políticas legales

### Carrito y Checkout
- Agregar/editar/remover items
- Aplicar cupones
- Checkout
- Subida de comprobantes

### Perfil Cliente
- Datos personales
- Direcciones
- Órdenes
- Historial

### Admin
- Login/Logout
- Dashboard
- CRUD de productos
- CRUD de categorías/marcas
- Gestión de órdenes
- Cupones y banners
- Configuración

## Características

### Para Clientes

#### Autenticación
- Email y contraseña
- Google OAuth (sign up automático)
- Verificación de email
- Recuperar contraseña

#### Catálogo
- Búsqueda full-text
- Filtros: categoría, marca, precio, disponibilidad
- Ordenamiento: nuevo, precio, nombre
- Paginación
- Productos relacionados
- Imágenes optimizadas

#### Carrito
- Agregar/editar/remover
- Actualizar cantidades
- Aplicar cupones
- Persistencia entre sesiones

#### Checkout
- Múltiples direcciones
- Selección de método de pago
- Resumen de orden
- Notas especiales

#### Pagos
- Visualización de cuentas bancarias
- Referencia de pago
- Subida de comprobante
- Confirmación

#### Órdenes
- Ver todas las órdenes
- Seguimiento en tiempo real
- Timeline de estados
- Información de envío
- Descarga de factura PDF

#### Perfil
- Actualizar datos personales
- Gestionar direcciones
- Ver historial

### Para Administrador

#### Dashboard
- Estadísticas en tiempo real
- Gráficas de ventas
- Órdenes pendientes
- Clientes recientes
- Categorías populares

#### Productos
- CRUD completo
- Múltiples imágenes
- Atributos (sabor, presentación, tipo)
- SEO (title, description, keywords)
- Estados de stock
- Productos nuevos/destacados
- Búsqueda y filtros

#### Categorías y Marcas
- CRUD completo
- Imágenes/Logos
- Ordenamiento
- Activación/Desactivación

#### Órdenes
- Listado con búsqueda
- Filtros por estado y fecha
- Aprobación de comprobantes
- Actualización de estados
- Agregar información de envío
- Exportación a Excel
- Descarga de facturas

#### Cupones
- CRUD completo
- Tipos: porcentaje, monto fijo
- Validaciones
- Límites de uso

#### Banners
- CRUD completo
- Posiciones en el sitio
- Fechas de vigencia
- Imágenes optimizadas

#### Configuración
- Datos generales
- Redes sociales
- Email
- Cuentas bancarias
- Ajustes de envío
- Impuestos

#### Auditoría
- Log de todas las acciones
- IP y user agent
- Cambios registrados

## Seguridad

✅ CSRF Protection
✅ XSS Prevention
✅ SQL Injection Prevention (Prepared Statements)
✅ Hash de contraseñas (Bcrypt)
✅ Validaciones en servidor y cliente
✅ Autenticación de sesión separada
✅ Rate limiting
✅ Soft deletes para datos críticos
✅ Auditoría de cambios
✅ Encriptación de datos sensibles

## Optimizaciones

✅ Lazy loading de imágenes
✅ Compresión de imágenes automática
✅ Caché de productos
✅ Índices en BD (full-text)
✅ Eager loading de relaciones
✅ Queries optimizadas
✅ Minificación de assets
✅ CDN ready

## Email

- Notificaciones de órdenes
- Cambios de estado
- Recuperación de contraseña
- Confirmación de email

## APIs Integradas

- Google OAuth 2.0
- Laravel Socialite
- DomPDF para generación de PDFs
- Intervention Image para procesamiento
- Laravel Excel para exportación

## Archivos Principales

### Migraciones (10)
- users, admin_users, categories, brands
- products, product_images, product_attributes
- carts, cart_items
- addresses
- orders, order_items, order_tracking, order_proofs, order_shipments
- coupons, promotions, banners
- bank_accounts, settings, notifications, audit_logs

### Seeders (8)
- CategorySeeder, BrandSeeder, ProductSeeder
- UserSeeder, AdminUserSeeder
- BankAccountSeeder, SettingSeeder
- BannerSeeder, CouponSeeder

### Factories
- UserFactory

### Vistas (20+)
- Layouts base (client, admin)
- Página de inicio
- Catálogo y producto
- Carrito y checkout
- Perfil y órdenes
- Admin dashboard
- Admin CRUD templates

### Controladores (15)
- 5 controladores públicos
- 10 controladores admin

### Servicios (3)
- CartService, OrderService, ProductService

### Eventos y Listeners (4)
- OrderCreated, OrderStatusChanged eventos
- Listeners para notificaciones por email

### Exports
- OrdersExport para Excel

## Pruebas

- Unit tests para servicios
- Feature tests para rutas
- Tests de autenticación
- Tests de carrito

## Deployment

- Compatible con cPanel, Plesk, SSH
- Configuración de .htaccess
- Variables de entorno seguras
- Backups automáticos

## Futuras Mejoras Preparadas

El sistema está preparado para:
- Integración con Stripe
- Integración con MercadoPago
- Integración con PayPal
- App móvil Flutter
- API REST
- Notificaciones Push
- WhatsApp automático
- Programa de puntos
- Facturación electrónica

## Documentación

- README.md completo
- Comentarios en código
- Docstrings en funciones

## Licencia

Propietario - Dispensario Premium 2024

---

**Total de archivos:** 75+
**Total de líneas de código:** 15,000+
**Tiempo de desarrollo:** Profesional
**Estado:** Producción Ready
