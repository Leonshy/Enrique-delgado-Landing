# Guía de despliegue en Plesk
## Landing Enrique Delgado — El Psicólogo del Cambio

---

## Requisitos previos

| Requisito | Versión mínima | Notas |
|-----------|---------------|-------|
| PHP | 8.2+ | 8.2 recomendado |
| MySQL | 8.0+ | |
| Composer | 2.x | Instalado globalmente |
| Node.js | 18+ | Solo para compilar assets |
| mod_rewrite | — | Habilitado en Apache |

### Extensiones PHP requeridas
- `pdo_mysql`
- `mbstring`
- `openssl`
- `tokenizer`
- `xml`
- `ctype`
- `fileinfo`
- `curl`
- `zip`

---

## Paso 1 — Crear base de datos MySQL en Plesk

1. Entra a Plesk → **Bases de datos** → **Agregar base de datos**
2. Nombre de la BD: `enrique_delgado`
3. Crea un usuario de BD con contraseña segura
4. Anota: `host`, `database`, `username`, `password`

---

## Paso 2 — Subir archivos al servidor

### Opción A — Git (recomendado)
```bash
# Conéctate al servidor por SSH
cd /var/www/vhosts/enriquedelgado.com/
git clone <url-del-repositorio> httpdocs_temp
```

### Opción B — FTP / Administrador de archivos Plesk
Sube todo el contenido del proyecto (excluyendo `node_modules/` y `.git/`).

**IMPORTANTE:** Los archivos deben quedar en un directorio FUERA de `httpdocs`, por ejemplo:
```
/var/www/vhosts/enriquedelgado.com/laravel/
```

---

## Paso 3 — Configurar Document Root hacia /public

1. En Plesk → **Dominios** → `enriquedelgado.com` → **Configuración de alojamiento**
2. Cambia el **Directorio raíz del documento** a:
   ```
   /var/www/vhosts/enriquedelgado.com/laravel/public
   ```
3. Guarda y espera que se aplique.

---

## Paso 4 — Configurar el archivo .env

```bash
cd /var/www/vhosts/enriquedelgado.com/laravel/
cp .env.example .env
nano .env  # o usa el editor de Plesk
```

Completa estos valores:

```env
APP_NAME="Enrique Delgado — El Psicólogo del Cambio"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://enriquedelgado.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=enrique_delgado
DB_USERNAME=tu_usuario_bd
DB_PASSWORD=tu_password_bd

MAIL_MAILER=smtp
MAIL_HOST=mail.enriquedelgado.com
MAIL_PORT=587
MAIL_USERNAME=contacto@enriquedelgado.com
MAIL_PASSWORD=tu_password_mail
MAIL_FROM_ADDRESS="contacto@enriquedelgado.com"
MAIL_FROM_NAME="Enrique Delgado"
```

---

## Paso 5 — Generar APP_KEY

```bash
php artisan key:generate
```

---

## Paso 6 — Instalar dependencias PHP

```bash
composer install --optimize-autoloader --no-dev
```

---

## Paso 7 — Compilar assets frontend

Si Node.js está disponible en el servidor:
```bash
npm ci
npm run build
```

Si no está disponible, compila en local y sube la carpeta `public/build/` al servidor.

---

## Paso 8 — Ejecutar migraciones

```bash
php artisan migrate --force
```

---

## Paso 9 — Ejecutar seeders

```bash
php artisan db:seed --force
```

---

## Paso 10 — Crear storage link

```bash
php artisan storage:link
```

Esto crea el enlace simbólico `public/storage → storage/app/public`.

---

## Paso 11 — Permisos de carpetas

```bash
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
chown -R www-data:www-data storage/
chown -R www-data:www-data bootstrap/cache/
```

> En Plesk el usuario puede ser `psaserv`, `apache` o el usuario del dominio. Verifica con `ps aux | grep apache`.

---

## Paso 12 — Optimización para producción

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

---

## Paso 13 — Configurar hCaptcha

1. Regístrate en https://hcaptcha.com
2. Crea un sitio para tu dominio
3. Obtén **Site Key** y **Secret Key**
4. Entra al panel admin → **Integraciones**
5. Pega las claves y activa hCaptcha

---

## Paso 14 — Configurar Google Analytics

1. Crea una propiedad GA4 en https://analytics.google.com
2. Obtén el **Measurement ID** (G-XXXXXXXXXX)
3. Panel admin → **Integraciones** → Google Analytics
4. Pega el ID y activa

---

## Paso 15 — Configurar Meta Pixel

1. Ve a https://business.facebook.com → Events Manager
2. Obtén el **Pixel ID**
3. Panel admin → **Integraciones** → Meta Pixel
4. Pega el ID y activa

---

## Paso 16 — Cambiar credenciales del administrador

⚠️ **OBLIGATORIO antes de ir a producción.**

1. Accede al panel: `https://enriquedelgado.com/admin`
2. Email: `admin@enriquedelgado.com` / Contraseña: `password`
3. Cambia la contraseña desde la base de datos o crea un comando:

```bash
php artisan tinker
# Dentro de tinker:
$user = \App\Models\User::where('email', 'admin@enriquedelgado.com')->first();
$user->password = \Illuminate\Support\Facades\Hash::make('nueva_contraseña_segura');
$user->save();
exit
```

---

## Checklist final

- [ ] Document Root apunta a `/public`
- [ ] `.env` configurado correctamente
- [ ] `APP_DEBUG=false` en producción
- [ ] `APP_KEY` generada
- [ ] Base de datos MySQL conectada
- [ ] Migraciones ejecutadas
- [ ] Seeders ejecutados
- [ ] `storage:link` creado
- [ ] Permisos de storage correctos
- [ ] Assets compilados (`public/build/` existe)
- [ ] Email configurado y probado
- [ ] Contraseña admin cambiada
- [ ] SSL/HTTPS activo (Let's Encrypt en Plesk)
- [ ] hCaptcha configurado (opcional pero recomendado)
- [ ] Cache de producción activada
- [ ] `npm audit` con 0 vulnerabilidades

---

## Errores comunes y solución

### Error 500 en producción
```bash
# Ver logs:
tail -100 storage/logs/laravel.log
# O habilitar temporalmente:
# APP_DEBUG=true en .env
```

### "No application encryption key has been specified"
```bash
php artisan key:generate
```

### Las imágenes no cargan
```bash
php artisan storage:link
# Verificar que public/storage sea un symlink válido
ls -la public/storage
```

### Error de permisos en storage
```bash
chmod -R 775 storage/ bootstrap/cache/
```

### Formulario no envía email
- Verificar configuración MAIL en `.env`
- Probar con `MAIL_MAILER=log` primero
- Ver `storage/logs/laravel.log`

### El panel admin redirige al login en bucle
- Verificar que SESSION_DRIVER esté en `file` (no database)
- Verificar permisos de `storage/framework/sessions/`

### Assets no cargan (CSS/JS)
- Verificar que `public/build/` existe
- Si no está: ejecutar `npm run build` localmente y subir la carpeta
- Verificar `ASSET_URL` en `.env` si hay CDN

---

## Estructura de archivos en el servidor

```
/var/www/vhosts/enriquedelgado.com/
├── laravel/                     ← Raíz del proyecto (NO accesible por web)
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── public/                  ← Document Root en Plesk
│   │   ├── build/               ← Assets compilados
│   │   ├── storage → ...        ← Symlink
│   │   ├── .htaccess
│   │   └── index.php
│   ├── resources/
│   ├── routes/
│   ├── storage/
│   ├── vendor/
│   └── .env                     ← NUNCA en git
```

---

## Accesos iniciales (cambiar en producción)

| Dato | Valor |
|------|-------|
| URL Admin | https://enriquedelgado.com/admin |
| Email admin | admin@enriquedelgado.com |
| Password inicial | password |
| WhatsApp ejemplo | +595 981 000000 |
| Email contacto | contacto@enriquedelgado.com |
