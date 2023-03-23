<h1 align="center">Laravel Rooms</h1>
<p align="center">Proyecto de laravel implementando websockets con <a href="https://soketi.app/" target="_blank" class="font-semibold text-blue-500">Soketi</a></p>

## Requerimientos

Para que el proyecto funcione sin errores es necesario tener instalado **[Soketi]('https://docs.soketi.app/getting-started/installation/cli-installation')**.

- php 8.1
- laravel 10.x

## Instalación

```bash
# Clonar el repositorio
git clone https://github.com/dcyar/laravel-rooms

# Ingresar a la carpeta del proyecto
cd laravel-rooms

# Instalar las dependencias de composer
composer install

# Instalar las dependencias de npm
npm install && npm run build
```

## Levantar la aplicación

```bash
# Levantar soketi
soketi start
```

## Capturas
Vista de bienvenida

![Welcome](/demo/welcome.png)

Vista para crear salas

![Create Room](/demo/create-room.png)

Vista de lista de salas

![Rooms List](/demo/rooms-list.png)

Vista de chat

![Chat](/demo/chat.png)