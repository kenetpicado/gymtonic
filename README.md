
# gymtonic

Este proyecto es una aplicación diseñada para la administración eficiente de un gimnasio. Permite gestionar clientes, planes de membresía, así como el registro detallado de ingresos, egresos y otros aspectos relevantes para el funcionamiento diario del gimnasio. Con una interfaz intuitiva, esta aplicación simplifica la gestión y organización de datos cruciales para el negocio.

## 🚀 Instalación

Sigue estos pasos para instalar y ejecutar el proyecto en tu máquina local:

1. Clona este repositorio: `git clone https://github.com/kenetpicado/gymtonic.git`

2. Ve al directorio del proyecto: `cd gymtonic`

3. Instala las dependencias: `composer install` y `npm install`

4. Crea un archivo `.env` y copia el contenido del archivo `.env.example` en él, luego configura las variables de entorno necesarias para la conexión a la base de datos.

5. Ejecuta `php artisan key:generate`

6. Ejecuta `php artisan migrate`

## 📦 Uso

- Inicia la aplicación en modo de desarrollo: `php artisan serve` y `npm run dev`
- Compila y minifica los archivos para producción: `npm run build`

## 🛠️ Construido con
- 🐘 [Laravel](https://laravel.com/): Un framework de PHP para crear aplicaciones web.

- 🚀 [Inertia.js](https://inertiajs.com/): Un stack de middleware que permite a los desarrolladores de Laravel crear aplicaciones de una sola página sin renunciar a las ventajas de las aplicaciones tradicionales basadas en el servidor.

- 💚 [Vue.js](https://vuejs.org/): Un framework de JavaScript para construir interfaces de usuario interactivas y reactivas.

- 🎨 [Tailwind CSS](https://tailwindcss.com/): Un framework de CSS utilitario altamente personalizable para crear diseños rápidos y modernos.

- ⚡️ [Vite](https://vitejs.dev/): Un bundler rápido y liviano para aplicaciones web modernas en JavaScript.

Estas tecnologías han sido fundamentales en el desarrollo de este proyecto y han proporcionado una base sólida para construir una aplicación web eficiente y con una excelente experiencia de usuario.

## 🤝 Contribución

¡Las contribuciones son bienvenidas! Para contribuir al proyecto, sigue estos pasos:

1. Haz un fork del repositorio.
2. Crea una nueva rama: `git checkout -b feature/nueva-funcionalidad`
3. Realiza los cambios y haz commit: `git commit -am 'Agrega una nueva funcionalidad'`
4. Haz push a la rama: `git push origin feature/nueva-funcionalidad`
5. Envía un Pull Request.

## 📋 Licencia

Este proyecto se encuentra bajo la [Licencia MIT](https://opensource.org/licenses/MIT).