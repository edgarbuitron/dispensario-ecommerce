# Configuración de Google OAuth - SOLO PARA CLIENTES

## ⚠️ IMPORTANTE
Google OAuth está configurado **SOLO para clientes**. Los administradores NO pueden usar Google para iniciar sesión.

---

## Paso 1: Crear Proyecto en Google Cloud Console

1. Ir a https://console.cloud.google.com
2. Crear nuevo proyecto:
   - Nombre: "Dispensario Premium" (o el que uses)
   - Click en "Crear"

3. Esperar a que se cree el proyecto

---

## Paso 2: Crear Credenciales OAuth

1. En el panel izquierdo, ir a **APIs y Servicios → Credenciales**
2. Click en **"Crear Credenciales"** → **"ID de cliente de OAuth"**
3. Te pide que configures la **Pantalla de consentimiento**:

### Configurar Pantalla de Consentimiento (OAuth)

**Tipo de usuario:** "Externo"

**Información de la App:**
- Nombre de la app: "Dispensario Premium"
- Email de soporte: tu@email.com
- Datos de contacto del desarrollador: tu@email.com

**Scopes (Permisos):**
- Busca y agrega: `email`, `profile`, `openid`

**Usuarios de prueba:**
- Agrega tu email para probar

Guardar y continuar.

---

## Paso 3: Crear ID de Cliente OAuth

1. De nuevo en **Credenciales**, click en **"Crear Credenciales"**
2. Selecciona **"ID de cliente de OAuth"**
3. Tipo de aplicación: **"Aplicación web"**

**URIs de Origen Autorizados:**
```
http://localhost:8000
http://localhost:8000/
http://127.0.0.1:8000
http://127.0.0.1:8000/
```

**URIs de Redirección Autorizadas:**
```
http://localhost:8000/auth/google/callback
http://127.0.0.1:8000/auth/google/callback
```

Luego agrega tus URLs de producción también:
```
https://tudominio.com/auth/google/callback
```

Click en **"Crear"**

---

## Paso 4: Obtener Credenciales

Se abrirá un modal con:
- **Client ID**
- **Client Secret**

Copia ambos valores.

---

## Paso 5: Configurar en .env

En tu archivo `.env`, configura:

```env
GOOGLE_CLIENT_ID=tu_client_id_aqui
GOOGLE_CLIENT_SECRET=tu_client_secret_aqui
GOOGLE_REDIRECT_URI=http://localhost:8000/auth/google/callback
```

### Para Producción:
```env
GOOGLE_CLIENT_ID=tu_client_id_aqui
GOOGLE_CLIENT_SECRET=tu_client_secret_aqui
GOOGLE_REDIRECT_URI=https://tudominio.com/auth/google/callback
```

---

## Paso 6: Instalar Socialite (si aún no está instalado)

```bash
composer require laravel/socialite
```

---

## Paso 7: Probar

1. Inicia el servidor: `php artisan serve`
2. Ve a http://localhost:8000/login
3. Haz click en "Continuar con Google"
4. Completa la autenticación

---

## ✅ Verificación

Después del login con Google:
- ✅ Se crea automáticamente la cuenta del cliente
- ✅ Se guarda el email
- ✅ Se guarda el nombre
- ✅ Se inicia sesión automáticamente
- ✅ Se redirige a la página de inicio

---

## 🔐 Seguridad Importante

### Los Administradores NO Pueden Usar Google
- El login de admin está en `/admin`
- Solo acepta usuario y contraseña
- Esto es por seguridad

### Para Admin:
- Ir a: `http://localhost:8000/admin`
- Usuario: `admin`
- Contraseña: `admin123456`

---

## 🐛 Solución de Problemas

### Error: "Invalid Client ID"
- Verifica que el GOOGLE_CLIENT_ID esté correcto en .env
- Recarga la página (limpia cache)

### Error: "Redirect URI mismatch"
- Asegúrate que la URL en Google Console coincida exactamente
- Incluye el `/auth/google/callback` al final

### El botón de Google no aparece
- Verifica que GOOGLE_CLIENT_ID no esté vacío en .env
- El formulario debe cargar completamente

### No se crea la cuenta automáticamente
- Verifica la conexión a base de datos
- Revisa los logs: `storage/logs/laravel.log`

---

## 📱 URLs de Acceso

**Cliente Login:** `http://localhost:8000/login`
- Botón: "Continuar con Google"

**Cliente Registro:** `http://localhost:8000/register`
- Botón: "Registrarse con Google"

**Admin Login:** `http://localhost:8000/admin`
- NO tiene opción de Google (solo usuario/contraseña)

---

## 🔄 Datos que se Sincronizan de Google

Cuando un cliente se autentica con Google:
- ✅ Nombre completo
- ✅ Email
- ✅ Google ID (almacenado en BD)
- ✅ Google Token (para futuros accesos)

---

## 📚 Documentación Oficial

- Google OAuth: https://developers.google.com/identity/protocols/oauth2
- Laravel Socialite: https://laravel.com/docs/socialite

---

## ⚙️ Configuración del Usuario

Cuando un cliente se registra con Google:
- Se crea automáticamente en la tabla `users`
- `age_verified` = false (debe verificar edad)
- `is_active` = true
- `password` = null (usa Google para auth)

En la siguiente visita, si inicia con Google:
- Se actualiza automáticamente el token
- Inicia sesión directamente

---

## ¡Listo!

Tu sistema de Google OAuth para clientes está configurado correctamente.

Solo los clientes pueden usar Google.
Los administradores SOLO pueden usar usuario/contraseña.

🚀 ¡A disfrutar!
