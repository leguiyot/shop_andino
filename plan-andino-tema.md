# Plan Andino -- Especificación Maestra del Tema

## Objetivo

Este documento define la arquitectura completa, el sistema de diseño, la
estructura de layout y la integración con WooCommerce necesarios para
desarrollar un tema profesional de WordPress orientado a ecommerce.

El objetivo del tema es:

-   Interfaz moderna de tienda
-   Grid de productos optimizado
-   Sistema de tarjetas de producto con hover
-   Sidebar con filtros
-   Header sticky con navegación avanzada
-   Diseño totalmente responsive
-   Alto rendimiento

Este documento funciona como guía para desarrollo manual o generación
asistida desde entornos como Visual Studio Code.

------------------------------------------------------------------------

# Nombre del Tema

planandino-shop

Ubicación:

/wp-content/themes/planandino-shop

------------------------------------------------------------------------

# Estructura de Carpetas del Tema

planandino-shop │ ├── style.css ├── functions.php ├── index.php ├──
header.php ├── footer.php ├── sidebar.php ├── page.php ├── single.php
├── screenshot.png │ ├── template-parts │ ├── header │ │ └──
navigation.php │ ├── footer │ │ └── footer-main.php │ └── components │
├── product-card.php │ └── breadcrumbs.php │ ├── assets │ ├── css │ │
├── main.css │ │ ├── layout.css │ │ ├── header.css │ │ ├── menu.css │ │
├── shop.css │ │ ├── product.css │ │ └── responsive.css │ │ │ ├── js │ │
├── main.js │ │ └── shop.js │ │ │ ├── fonts │ └── images │ └──
woocommerce ├── archive-product.php ├── content-product.php ├──
single-product.php ├── cart │ └── cart.php └── checkout └──
form-checkout.php

------------------------------------------------------------------------

# Encabezado del Tema (style.css)

/* Theme Name: Plan Andino Shop Autor: Plan Andino Versión: 1.0
Descripción: Tema personalizado para WooCommerce Text Domain: planandino
*/

------------------------------------------------------------------------

# Configuración Principal (functions.php)

Responsabilidades principales:

-   registrar soporte del tema
-   cargar archivos CSS
-   cargar scripts JS
-   registrar menús
-   registrar sidebar

Soportes necesarios:

add_theme_support('woocommerce'); add_theme_support('title-tag');
add_theme_support('post-thumbnails'); add_theme_support('custom-logo');

Menús:

-   menú principal
-   menú de footer

Sidebar:

-   widgets de tienda

------------------------------------------------------------------------

# Estructura Global del Layout

body ├ header │ ├ top-bar │ └ header-inner │ ├ logo │ ├ navegación │ └
iconos │ ├ main │ ├ encabezado de página │ └ layout de tienda │ ├
sidebar │ └ productos │ └ footer

------------------------------------------------------------------------

# Sistema de Contenedor

.container {

max-width:1280px; margin:auto; padding:0 20px;

}

------------------------------------------------------------------------

# Sistema de Header

Características:

-   comportamiento sticky
-   logo
-   navegación principal
-   icono de carrito
-   icono de búsqueda

CSS:

.site-header{

position:sticky; top:0; background:#ffffff; z-index:999;
border-bottom:1px solid #eee;

}

.header-inner{

display:flex; align-items:center; justify-content:space-between;
height:90px;

}

------------------------------------------------------------------------

# Navegación Principal

.main-menu{

display:flex; gap:35px; list-style:none;

}

.main-menu li{

position:relative;

}

------------------------------------------------------------------------

# Mega Menú

.mega-menu{

position:absolute; top:100%; left:0; width:100%; background:#fff;
display:grid; grid-template-columns:repeat(4,1fr); padding:40px;
box-shadow:0 10px 30px rgba(0,0,0,0.1); opacity:0; visibility:hidden;
transition:.3s;

}

.main-menu li:hover .mega-menu{

opacity:1; visibility:visible;

}

------------------------------------------------------------------------

# Layout de Tienda

.shop-layout{

display:grid; grid-template-columns:280px 1fr; gap:40px;

}

------------------------------------------------------------------------

# Sidebar de Filtros

.shop-sidebar{

position:sticky; top:120px;

}

Widgets soportados:

-   categorías
-   filtro por precio
-   filtro por atributos
-   búsqueda de productos
-   etiquetas

------------------------------------------------------------------------

# Grid de Productos

ul.products{

display:grid; grid-template-columns:repeat(4,1fr); gap:32px;
list-style:none; padding:0;

}

------------------------------------------------------------------------

# Estructura de Tarjeta de Producto

li.product-card

product-image product-overlay product-info

------------------------------------------------------------------------

# CSS de Tarjeta de Producto

.product-card{

position:relative; background:#fff; overflow:hidden; transition:.3s;

}

.product-card img{

width:100%; transition:transform .5s ease;

}

.product-card:hover img{

transform:scale(1.08);

}

------------------------------------------------------------------------

# Overlay del Producto

.product-overlay{

position:absolute; top:0; left:0; right:0; bottom:0;

background:rgba(0,0,0,.35);

display:flex; align-items:center; justify-content:center;

opacity:0; transition:.4s;

}

.product-card:hover .product-overlay{

opacity:1;

}

------------------------------------------------------------------------

# Información del Producto

.product-info{

text-align:center; padding:16px;

}

.product-title{

font-size:16px; font-weight:500;

}

.price{

font-size:14px;

}

------------------------------------------------------------------------

# Sistema de Diseño

Color principal:

#1abc9c

Paleta neutra:

#222 #333 #777 #f6f6f6 #ffffff

------------------------------------------------------------------------

# Tipografía

Fuente principal:

Heebo, sans-serif

Fallback:

Arial, sans-serif

Jerarquía:

h1 36px h2 28px h3 22px p 16px

------------------------------------------------------------------------

# Botones

.button{

background:#111; color:#fff; padding:12px 24px; transition:.3s;
border:none;

}

.button:hover{

background:#000;

}

------------------------------------------------------------------------

# Animaciones

Transiciones comunes:

transform opacity translateY scale

Ejemplo:

transition:all .3s ease;

------------------------------------------------------------------------

# Plantillas WooCommerce

archive-product.php

Contiene:

-   sidebar
-   loop de productos
-   paginación

content-product.php

Renderiza las tarjetas de producto

single-product.php

Diseño de página de producto individual

------------------------------------------------------------------------

# Breakpoints Responsive

Desktop:

> 1200px

Laptop:

1024px

Tablet:

768px

Mobile:

600px

Mobile pequeño:

480px

------------------------------------------------------------------------

# Reglas Responsive

Tablet:

grid de productos → 2 columnas

Mobile:

grid de productos → 1 columna

sidebar → se coloca arriba

------------------------------------------------------------------------

# Buenas Prácticas de Rendimiento

Usar:

-   imágenes optimizadas
-   CSS modular
-   carga diferida (lazy load)

Evitar:

-   librerías innecesarias
-   scripts pesados

------------------------------------------------------------------------

# Resultado Esperado

El tema debe permitir:

-   layout moderno de ecommerce
-   tarjetas de producto animadas
-   filtros en sidebar
-   header sticky
-   mega menú
-   integración total con WooCommerce

------------------------------------------------------------------------

# Uso

Colocar la carpeta del tema en:

/wp-content/themes/

Activar el tema desde el panel de administración de WordPress.

Instalar WooCommerce.

Cargar productos.
