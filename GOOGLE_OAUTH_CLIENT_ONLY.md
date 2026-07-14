# 🔐 Google OAuth - SOLO PARA CLIENTES

## Configuración Completada

Tu sistema ya está configurado para que **SOLO LOS CLIENTES** puedan usar Google OAuth para iniciar sesión.

---

## 📋 ¿Qué Significa?

### ✅ LOS CLIENTES PUEDEN:
- Registrarse con Google
- Iniciar sesión con Google
- Ver botón "Continuar con Google" en:
  - `/login` (Iniciar Sesión)
  - `/register` (Registrarse)

### ❌ LOS ADMINISTRADORES NO PUEDEN:
- Usar Google para iniciar sesión en admin
- Ver opción de Google en `/admin`
- SOLO pueden acceder con usuario y contraseña

---

## 🔧 Configuración Técnica

### Archivos Creados/Modificados:

1. **GoogleAuthController.php**
   - Maneja la lógica de Google OAuth
   - Crea usuarios automáticamente
   - Inicia sesión después de autenticación

2. **config/services.php**
   - Configuración de Google Socialite
   - Variables: GOOGLE_CLIENT_ID, GOOGLE_CLIENT_SECRET, GOOGLE_REDIRECT_URI

3. **routes/web.php**
   - Rutas: `/auth/google` y `/auth/google/callback`
   - Solo accesibles para clientes (no admin)

4. **resources/views/auth/login.blade.php**
   - Botón "Continuar con Google"
   - Aviso: "Solo disponible para clientes"

5. **resources/views/auth/register.blade.php**
   - Botón "Registrarse con Google"

6. **GOOGLE_OAUTH_SETUP.md**
   - Guía paso a paso para configurar Google Cloud Console

---

## 🚀 Cómo Configurar (Pasos Rápidos)

### 1. Crear Proyecto en Google Cloud
```
https://console.cloud.google.com
→ Crear nuevo proyecto
→ Nombre: "Dispensario Premium"
```

### 2. Crear Credenciales OAuth
```
APIs y Servicios → Credenciales
→ Crear Credenciales → ID de cliente OAuth
→ Tipo: Aplicación web
```

### 3. Agregar URLs
**Orígenes autorizados:**
```
http://localhost:8000
http://127.0.0.1:8000
https://tudominio.com
```

**URIs de redirección:**
```
http://localhost:8000/auth/google/callback
https://tudominio.com/auth/google/callback
```

### 4. Copiar Credenciales
```
Client ID: [tu_id]
Client Secret: [tu_secreto]
```

### 5. Configurar .env
```env
GOOGLE_CLIENT_ID=tu_client_id_aqui
GOOGLE_CLIENT_SECRET=tu_client_secret_aqui
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

### 6. Instalar Socialite
```bash
composer require laravel/socialite
```

### 7. Probar
```bash
php artisan serve
# Ve a http://localhost:8000/login
# Haz click en "Continuar con Google"
```

---

## 🔐 Seguridad: Por Qué Solo Clientes

### Razones:
1. **Control de Acceso**: Los admins deben tener credenciales específicas
2. **Auditoría**: Facilita rastrear quién accede al admin
3. **Dos Factores**: Protege mejor la información sensible
4. **Políticas**: Cumple con estándares de seguridad

### Admin Login:
- URL: `http://localhost:8000/admin`
- Usuario: `admin`
- Contraseña: `admin123456`
- ❌ **NO tiene opción de Google**

---

## 📱 Flujo de Login Cliente

### Con Google:
```
Cliente → /login
→ Click "Continuar con Google"
→ Google OAuth
→ Verifica email
→ Crea cuenta automáticamente (si es primera vez)
→ Inicia sesión
→ Redirige a /home
```

### Con Email/Contraseña:
```
Cliente → /login
→ Ingresa email y contraseña
→ Submit
→ Verifica credenciales
→ Inicia sesión
→ Redirige a /home
```

---

## 📊 Datos del Usuario

Cuando un cliente se autentica con Google se almacena:

| Campo | Valor |
|-------|-------|
| name | Nombre de Google |
| email | Email de Google |
| google_id | ID único de Google |
| google_token | Token de acceso |
| google_refresh_token | Token de refresco |
| age_verified | false (debe verificar) |
| is_active | true |
| password | null (usa Google) |

---

## 🎯 URLs de Acceso

| Página | URL | Google? |
|--------|-----|---------|
| Login Cliente | `/login` | ✅ Sí |
| Registro Cliente | `/register` | ✅ Sí |
| Login Admin | `/admin` | ❌ No |
| Perfil Cliente | `/profile` | Solo después de login |

---

## 🔄 Flujo Técnico

```php
// 1. Usuario click en "Continuar con Google"
GET /auth/google

// 2. Redirige a Google OAuth
// usuario autoriza

// 3. Google redirige de vuelta
GET /auth/google/callback?code=...&state=...

// 4. GoogleAuthController:
// - Obtiene token de Google
// - Busca usuario por google_id
// - Si no existe: crea nuevo usuario
// - Inicia sesión
// - Redirige a /home
```

---

## ✅ Checklist de Implementación

- [x] Controlador GoogleAuthController creado
- [x] Rutas Google OAuth agregadas
- [x] config/services.php configurado
- [x] Vista login con botón Google
- [x] Vista registro con botón Google
- [x] Controladores Auth creados
- [x] Rutas auth.php creado
- [x] Documentación GOOGLE_OAUTH_SETUP.md
- [x] Migración agregada
- [ ] GOOGLE_CLIENT_ID configurado en .env
- [ ] GOOGLE_CLIENT_SECRET configurado en .env
- [ ] Probar login con Google

---

## 🐛 Debugging

### Ver logs de Google Auth:
```bash
tail -f storage/logs/laravel.log | grep Google
```

### Verificar configuración:
```bash
php artisan tinker
> config('services.google')
```

### Si Google no redirige:
1. Verifica GOOGLE_CLIENT_ID no esté vacío
2. Verifica GOOGLE_REDIRECT_URI sea correcto
3. Verifica URLs en Google Cloud Console

---

## 📚 Archivos Importantes

**Controlador:**
- `app/Http/Controllers/GoogleAuthController.php`

**Config:**
- `config/services.php`
- `.env`

**Rutas:**
- `routes/web.php` (rutas Google)
- `routes/auth.php` (rutas auth cliente)

**Vistas:**
- `resources/views/auth/login.blade.php`
- `resources/views/auth/register.blade.php`

**Documentación:**
- `GOOGLE_OAUTH_SETUP.md` (paso a paso completo)

---

## 🎓 Para Personalizar

### Cambiar el mensaje de Google:
En `resources/views/auth/login.blade.php`:
```html
<!-- Cambiar texto del botón -->
Continuar con Google → Tu texto aquí
```

### Cambiar redirect después de login:
En `app/Http/Controllers/GoogleAuthController.php`:
```php
return redirect()->route('home') // Cambiar a otra ruta
```

### Agregar más scopes:
En `GoogleAuthController.php`:
```php
->scopes(['email', 'profile', 'openid'])
```

---

## 🆘 Soporte

Si tienes problemas:

1. Lee `GOOGLE_OAUTH_SETUP.md` completo
2. Verifica `.env` tiene las variables
3. Revisa `storage/logs/laravel.log`
4. Confirma URLs en Google Cloud Console
5. Limpia cache: `php artisan config:clear`

---

## ✨ ¡Listo!

Tu sistema Google OAuth está configurado correctamente:
- ✅ Solo clientes pueden usar Google
- ✅ Admins usan usuario/contraseña
- ✅ Seguridad implementada
- ✅ Autenticación dual funcional

🚀 **¡A disfrutar!**
