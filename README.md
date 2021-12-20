#  VERIFARMA

# contenido
Este proyecto posee dos funcionalidades crear y consultar farmacias mas cercanas del usuario mediante servicios API,
los cuales se encuentran en la siguiente ruta: app/Http/Controllers/, el controlador donde se encuentran es FarmaciasController.php la funcion usada para crear se encuentra en la funcion publica store la cual resive requests a traves del metodo post y para consultar farmacias fue usada la funcion publica index la cual resive requests a traves del metodo get

# clonar el repositorio

git clone https://github.com/manolo1800/verifarma.git

# instalacion 

para instalar, usar y alterear este software primero se requiere de la instalacion de composer https://getcomposer.org/
despues de haber instalado este programa debera realizar los siguientes pasos:

1 abrir terminal dentro del proyecto
2 ejecutar el comando composer install
3 cambiar el nombre del archivo .env.example a .env
4 ejecutar el comando php artisan key:generate
5 crear en su entorno local una base de datos llamada verifarma
6 ejecutar el comando php artisan migrate 

# uso de las apis

para acceder a las apis desde un entorno local se debe tener un cliente http puede usar soapUi o postman,para consumir estas apis primero se debe de  abrir una terminal dentro del proyecto y ejecutar el siguiente comando php artisan serve.

luego de haber activado el servidor local de laravel abra el cliente http y envie request con las siguientes url y parametros

-craecion de farmacias 
parametros:nombre,direccion,longitud y latitud
metodo:post
url:http://127.0.0.1:8000/api/Farmacia

-consultar farmacia mas cercana 
parametros:longitud y latitud
metodo:get
url:http://127.0.0.1:8000/api/Farmacia
