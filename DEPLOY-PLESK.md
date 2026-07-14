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

## Paso 0 — Antes de subir: correr los tests localmente

El proyecto tiene una suite de tests automatizados (`tests/Feature/`) que cubre login admin, rate limiting, formulario de contacto, hCaptcha y la gestión de usuarios/contraseñas. Correrla antes de cada deploy avisa si algún cambio rompió algo de esto:

```bash
php artisan test
# o:
composer test
```

Tienen que pasar todos en verde antes de subir cambios a producción. Corren en un par de segundos y no requieren conexión a internet (usan `Http::fake()` para hCaptcha y un verificador falso para el chequeo de contraseñas filtradas, así no dependen de servicios externos).

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

# La cookie de sesión del panel admin solo se manda por HTTPS.
# Requiere que el SSL ya esté activo (ver "SSL/HTTPS activo" en el checklist final), si no el login no va a persistir la sesión.
SESSION_SECURE_COOKIE=true

QUEUE_CONNECTION=database

# No hace falta tocar el SMTP acá — se configura desde el panel admin en el Paso 13.
# "log" es seguro mientras tanto: no manda emails, pero el mensaje de contacto
# siempre queda guardado en Admin > Consultas, así que no se pierde nada.
MAIL_MAILER=log
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

## Paso 13 — Configurar el email (SMTP + queue worker)

### 13.1 — Cargar el SMTP desde el panel admin

El `.env` queda con `MAIL_MAILER=log` (no manda emails, pero tampoco pierde nada). El servidor de correo real se carga así:

1. Entrar a `Admin → Configuración → Email`.
2. Completar host, usuario y contraseña de tu proveedor de correo. Puerto **465** y seguridad **SSL/TLS** ya vienen puestos por defecto (es lo más común).
3. Antes de guardar, usar el botón **"Enviar email de prueba"** — manda un correo real con los datos del formulario para confirmar que las credenciales funcionan.
4. Recién ahí, **"Guardar configuración de email"**. A partir de ese momento pisa lo que diga el `.env` automáticamente, sin tener que tocar el servidor por SSH.

### 13.2 — Poner a andar el queue worker

El email que se manda cuando alguien completa el formulario de contacto se procesa en segundo plano (no bloquea al visitante mientras espera). Para que efectivamente se envíe, tiene que haber un **worker** corriendo todo el tiempo en el servidor.

**1. Confirmar que `QUEUE_CONNECTION=database` está en el `.env`** (ya debería estar si seguiste el Paso 4).

**2. En Plesk → Programación de tareas (Scheduled Tasks / Cron Jobs), crear una tarea que mantenga el worker vivo.** La forma más simple sin depender de un proceso permanente es correr `queue:work --stop-when-empty` cada minuto:

```bash
* * * * * cd /var/www/vhosts/enrique.webparaguay.com/httpdocs && php artisan queue:work --stop-when-empty --tries=3 >> /dev/null 2>&1
```

Esto procesa lo que haya en cola y se apaga solo — se vuelve a ejecutar al minuto siguiente. Es menos eficiente que un worker permanente, pero no requiere que Plesk soporte procesos de larga duración (`supervisor`), que no todos los planes tienen.

**3. Si tu plan de Plesk sí soporta procesos permanentes** (revisar en "Node.js" / "Aplicaciones" del panel, o preguntarle al soporte de tu hosting), es mejor correr un worker persistente en vez del cron de arriba:

```bash
php artisan queue:work --tries=3
```

**4. Verificar que está funcionando:** completar el formulario de contacto del sitio y confirmar que llega el email (puede tardar hasta 1 minuto con el método de cron). Si no llega, revisar la tabla `failed_jobs` —

```bash
php artisan queue:failed
```

— ahí vas a ver el motivo exacto si algo falló (credenciales SMTP mal cargadas, servidor de correo caído, etc.). El mensaje de contacto en sí **nunca se pierde** aunque el email falle — siempre queda guardado en `Admin → Consultas`.

---

## Paso 14 — Configurar hCaptcha

1. Regístrate en https://hcaptcha.com
2. Crea un sitio para tu dominio
3. Obtén **Site Key** y **Secret Key**
4. Entra al panel admin → **Integraciones**
5. Pega las claves y activa hCaptcha

---

## Paso 15 — Configurar Google Analytics

1. Crea una propiedad GA4 en https://analytics.google.com
2. Obtén el **Measurement ID** (G-XXXXXXXXXX)
3. Panel admin → **Integraciones** → Google Analytics
4. Pega el ID y activa

---

## Paso 16 — Configurar Meta Pixel

1. Ve a https://business.facebook.com → Events Manager
2. Obtén el **Pixel ID**
3. Panel admin → **Integraciones** → Meta Pixel
4. Pega el ID y activa

---

## Paso 17 — Cambiar credenciales del administrador

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

O mejor: usar `Admin → Usuarios` para esto, sin necesidad de tocar el servidor por SSH.

---

## Paso 18 — Monitoreo (opcional pero recomendado)

Los dos se configuran desde `Admin → Integraciones`, sin tocar el servidor.

**Sentry (avisa cuando algo se rompe):**
1. Cuenta gratuita en [sentry.io](https://sentry.io/signup/), crear un proyecto tipo "Laravel".
2. Copiar el DSN (Settings → Client Keys / DSN del proyecto).
3. Pegarlo en `Admin → Integraciones → Sentry`, activar, y usar "Enviar evento de prueba" para confirmar que llega — revisar en sentry.io que apareció el evento de prueba.

**UptimeRobot (avisa si el sitio se cae):**
1. Cuenta gratuita en [uptimerobot.com](https://uptimerobot.com/signUp).
2. Copiar la "Main API Key" desde My Settings → API Settings.
3. Pegarla en `Admin → Integraciones → UptimeRobot`, probar la key, y usar "Crear monitor para este sitio" — crea automáticamente un monitor apuntado a la URL del sitio, chequeando cada 5 minutos.

---

## Checklist final

- [ ] `php artisan test` pasa en verde (Paso 0)
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
- [ ] `SESSION_SECURE_COOKIE=true` (solo después de confirmar que el SSL funciona)
- [ ] hCaptcha configurado (opcional pero recomendado)
- [ ] Sentry y UptimeRobot configurados (opcional pero recomendado — Paso 18)
- [ ] Cache de producción activada
- [ ] `npm audit` con 0 vulnerabilidades

---

## Actualizar el sitio ya desplegado (deploys posteriores)

Todo lo anterior es para la primera vez. Para subir cambios a un sitio que ya está andando, el flujo del día a día es este:

### Rutina normal

```bash
# 1. Local: correr los tests antes de subir nada
php artisan test

# 2. Local: si cambiaste CSS/JS, compilar
npm run build

# 3. Local: subir el código a git (sin public/build, ya está en .gitignore)
git push

# 4. Servidor (SSH): traer el código nuevo
cd /var/www/vhosts/enrique.webparaguay.com/httpdocs
git pull

# 5. Local: si compilaste assets nuevos, transferirlos por scp
#    (el servidor no tiene Node — nunca correr npm run build ahí)
scp -P 53931 -r public/build usuario@servidor:/ruta/httpdocs/public/

# 6. Servidor (SSH): limpiar cachés SIEMPRE que cambien rutas, config o vistas
php artisan route:clear && php artisan route:cache
php artisan config:clear
php artisan view:clear

# 7. Servidor (SSH): solo si hay migraciones nuevas
php artisan migrate --force
```

### ⚠️ El error que ya nos pasó una vez

Un cambio de código que agrega o modifica una ruta (por ejemplo, una sección nueva del admin) puede dar **Error 500 "Route not defined"** en el servidor aunque el código esté bien y el `git pull` haya traído todo — porque la ruta vieja quedó cacheada de un `route:cache` anterior. La solución es siempre `route:clear` antes de `route:cache`, nunca solo uno de los dos. Por eso el paso 6 de arriba no es opcional cuando el deploy toca `routes/web.php` o cualquier controlador/vista nueva.

### Qué NUNCA hacer en el servidor

- **No editar archivos directo en el servidor.** Todo cambio de código va por git — si se edita a mano en el servidor, el próximo `git pull` puede pisarlo o generar un conflicto silencioso.
- **No correr `npm run build` ni `npm install` en el servidor** — no tiene Node. Compilar siempre en local y subir `public/build/` por scp.
- **No correr `composer install` sin `--no-dev --optimize-autoloader`** en producción — instala herramientas de desarrollo innecesarias y un autoloader más lento.
- **No dejar `APP_DEBUG=true`** en producción ni por un momento para debuggear — expone rutas de archivos, variables de entorno y consultas SQL a cualquiera que provoque un error. Para ver el error real, usar `tail -100 storage/logs/laravel.log` en vez de prender el debug.

### Si algo sale mal después de un deploy

1. Ver el error real: `tail -100 storage/logs/laravel.log` (nunca prender `APP_DEBUG` para esto).
2. Si el error apunta a una ruta/vista que "no existe" pero el código está bien: limpiar cachés (ver más arriba) — es la causa más común.
3. Si el error persiste y es grave (el sitio no carga para nadie): volver al commit anterior que funcionaba —
   ```bash
   git log --oneline -5        # identificar el último commit bueno
   git checkout <hash-commit-anterior> -- .
   php artisan route:clear && php artisan route:cache && php artisan config:clear
   ```
   y recién ahí investigar con calma qué falló en el commit nuevo, en vez de debuggear en caliente con el sitio caído.
4. Si el problema es de datos (no de código) y el rollback de código no alcanza: restaurar desde el backup de Plesk (Backup Manager → restaurar).

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
- El mensaje en sí nunca se pierde — revisar primero `Admin → Consultas` para confirmar que al menos eso llegó.
- Verificar la configuración en `Admin → Configuración → Email` (usar el botón "Enviar email de prueba" ahí mismo — da el motivo exacto del error).
- Confirmar que el queue worker está corriendo (Paso 13.2) — sin worker, el email queda encolado pero nunca se procesa.
- Revisar `php artisan queue:failed` para ver los que fallaron y por qué.
- Ver `storage/logs/laravel.log` si nada de lo anterior explica el problema.

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
