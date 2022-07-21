Requisitos
Git 
Composer 
PHP 7.4.3 o superior 
MySQL 8.0.22 o superior
Especificaciones
Laravel 8.83.19
Instalación
git clone https://github.com/albertopinilla/backend.git
cd backend
composer install
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
En .env agregar 
ALERT_MIN_PRODUCT=numero_minimo_de_stock_por_producto_para_enviar_alerta
Configurar correo electronico smtp, para el caso se uso mailtrap
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="notificaciones@mystock.com"
MAIL_FROM_NAME="Notificación Stock"
configurar base de datos en .env
DB_CONNECTION=mysql 
DB_HOST=direccion_ip 
DB_PORT=3306
DB_DATABASE=nombre_base_de_datos
DB_USERNAME=usuario DB_PASSWORD=contraseña
Cambiar en driver a queue_conection a database en el .env
QUEUE_CONNECTION=database
php artisan config:cache
php artisan migrate --seed
php artisan serve
