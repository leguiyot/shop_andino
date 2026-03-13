# Plan Andino Shop - Tema WordPress

Un tema WordPress completo basado en el diseño Bridge, especializado para tiendas en línea con WooCommerce.

## 📋 Características

### 🎨 Diseño
- **Estilo Bridge**: Replica exactamente el diseño visual de Bridge
- **Header pegajoso**: Con efecto blur backdrop-filter
- **Navegación fluida**: Altura de 85px con efecto hover
- **Diseño responsivo**: Optimizado para todos los dispositivos
- **Grid moderno**: Sistema de cuadrícula CSS Grid y Flexbox

### 🛍️ E-commerce
- **Integración WooCommerce completa**
- **Grid de productos**: 4 columnas responsivas con efectos hover
- **Páginas de producto individual**: Layout completo con galería
- **Carrito AJAX**: Actualización dinámica sin recargar página
- **Filtros avanzados**: Por categoría, precio, etiquetas
- **Vista rápida**: Modal de producto sin salir de la página
- **Lista de deseos**: Funcionalidad localStorage

### ⚡ Rendimiento
- **CSS modular**: 6 archivos CSS organizados por función
- **JavaScript optimizado**: Funciones throttled y eventos pasivos
- **Imágenes optimizadas**: object-fit y lazy loading
- **Backdrop-filter**: Efectos modernos de blur
- **Minimalismo**: Código limpio y eficiente

### 📱 Responsivo
- **Móvil primero**: Diseño mobile-first
- **Breakpoints inteligentes**: 5 niveles de responsividad
- **Menu hamburguesa**: Navegación móvil deslizante
- **Touch optimizado**: Para dispositivos táctiles

## 🚀 Instalación

### Requisitos Previos
- WordPress 5.0+
- PHP 7.4+
- WooCommerce 5.0+
- XAMPP (para desarrollo local)

### Pasos de Instalación

1. **Descargar el tema**
   ```bash
   # Navegar a la carpeta de temas de WordPress
   cd c:\xampp\htdocs\tu-sitio\wp-content\themes\
   
   # Copiar la carpeta del tema
   cp -r "c:\xampp\htdocs\Shop Plan Andino\planandino-shop" ./
   ```

2. **Activar el tema**
   - Ir al admin de WordPress
   - Appearance > Themes
   - Activar "Plan Andino Shop"

3. **Instalar WooCommerce**
   - Plugins > Add New
   - Buscar "WooCommerce"
   - Instalar y activar
   - Seguir el wizard de configuración

4. **Configurar widgets**
   - Appearance > Widgets
   - Arrastrar widgets al área "Shop Sidebar"

## 📁 Estructura de Archivos

```
planandino-shop/
├── assets/
│   ├── css/
│   │   ├── header.css      # Header y navegación
│   │   ├── layout.css      # Layout general
│   │   ├── menu.css        # Menús y navegación
│   │   ├── product.css     # Páginas de producto
│   │   ├── responsive.css  # Media queries
│   │   └── shop.css        # Páginas de tienda
│   └── js/
│       ├── main.js         # Funcionalidad general
│       └── shop.js         # Funcionalidad de tienda
├── template-parts/
│   ├── content-post.php    # Template de posts
│   └── page-header.php     # Header de páginas
├── woocommerce/
│   ├── archive-product.php # Página de tienda
│   ├── content-product.php # Loop de productos
│   └── single-product.php  # Producto individual
├── functions.php           # Funciones del tema
├── header.php             # Header principal
├── footer.php             # Footer principal
├── index.php              # Página de inicio
├── page.php               # Páginas estáticas
├── sidebar-shop.php       # Sidebar de tienda
├── sidebar.php            # Sidebar general
├── single.php             # Posts individuales
└── style.css              # Hoja de estilos principal
```

## ⚙️ Configuración

### Menús
1. **Crear menú principal**
   - Appearance > Menus
   - Create a new menu: "Main Menu"
   - Assign to "Primary Menu" location

### Widgets
El tema incluye las siguientes áreas de widgets:
- **Sidebar**: Barra lateral general
- **Shop Sidebar**: Barra lateral de tienda
- **Footer Widget Area**: Área de widgets del footer

### Personalización
- **Logo**: Customizer > Site Identity
- **Colores**: Variables CSS en style.css
- **Breadcrumbs**: Se pueden habilitar/deshabilitar

## 🎨 Personalización CSS

### Variables Principales
```css
:root {
    --primary-color: #e6ae48;
    --primary-hover: #d19b3e;
    --text-color: #333;
    --text-light: #666;
    --border-color: rgba(0, 0, 0, 0.1);
    --container-width: 1280px;
    --header-height: 85px;
}
```

### Colores del Tema
- **Primario**: `#e6ae48` (Dorado)
- **Primario Hover**: `#d19b3e` (Dorado oscuro)
- **Texto**: `#333` (Gris oscuro)
- **Texto secundario**: `#666` (Gris medio)
- **Bordes**: `rgba(0, 0, 0, 0.1)` (Gris transparente)

## 🛠️ Funcionalidades JavaScript

### Menú Móvil
```javascript
// Auto-generación de menú móvil
initMobileMenu();
```

### Búsqueda AJAX
```javascript
// Búsqueda en tiempo real
initAjaxSearch();
```

### Carrito Dinámico
```javascript
// Actualización automática del contador
updateCartCount();
```

### Vista Rápida
```javascript
// Modal de producto sin recargar página
openQuickViewModal(productId);
```

## 🔧 Funciones del Tema

### Soporte de Características
```php
// Miniaturas de post
add_theme_support('post-thumbnails');

// Menús dinámicos
add_theme_support('menus');

// WooCommerce
add_theme_support('woocommerce');

// Logo personalizado
add_theme_support('custom-logo');
```

### Áreas de Widgets
```php
register_sidebar(array(
    'name' => 'Shop Sidebar',
    'id' => 'shop-sidebar',
    'description' => 'Widgets para páginas de tienda'
));
```

### Walker de Menú Personalizado
```php
class PlanAndino_Walker_Nav_Menu extends Walker_Nav_Menu {
    // Implementación personalizada
}
```

## 📱 Breakpoints Responsivos

```css
/* Móviles extra pequeños */
@media (max-width: 480px) { }

/* Móviles */
@media (max-width: 576px) { }

/* Tablets */
@media (max-width: 768px) { }

/* Tablets grandes */
@media (max-width: 992px) { }

/* Desktop */
@media (max-width: 1200px) { }
```

## 🚀 Optimización

### Rendimiento
- **CSS crítico**: Estilos importantes inline
- **JavaScript diferido**: Scripts no críticos en footer
- **Imágenes optimizadas**: WebP cuando sea posible
- **Caché de navegador**: Headers apropiados

### SEO
- **Estructura semántica**: HTML5 semantic tags
- **Breadcrumbs**: Navegación estructurada
- **Schema markup**: Datos estructurados para productos
- **Meta tags**: Optimizados para redes sociales

## 🐛 Resolución de Problemas

### Problemas Comunes

1. **El menú móvil no funciona**
   - Verificar que main.js esté cargando
   - Comprobar errores de JavaScript en consola

2. **Los productos no se muestran**
   - Verificar que WooCommerce esté activado
   - Comprobar que existan productos publicados

3. **Los estilos no se aplican**
   - Limpiar caché del navegador
   - Verificar que los archivos CSS existan

4. **Backdrop-filter no funciona**
   - Navegador no compatible (IE, Safari antiguo)
   - Usar fallback con background rgba

### Depuración
```php
// Activar modo debug en wp-config.php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```

## 🔄 Actualizaciones

### Registro de Versiones

#### v1.0.0 (Actual)
- ✅ Diseño Bridge completo
- ✅ Integración WooCommerce
- ✅ Sistema responsivo
- ✅ Menu móvil hamburguesa
- ✅ Efectos hover y animaciones
- ✅ Breadcrumbs personalizados
- ✅ Grid de productos 4 columnas
- ✅ Página de producto individual
- ✅ Filtros de tienda
- ✅ JavaScript optimizado

#### Próximas Versiones
- 🔄 Modo oscuro
- 🔄 Constructor de páginas
- 🔄 Más layouts de producto
- 🔄 Integración con redes sociales
- 🔄 Optimizaciones adicionales

## 👥 Contribución

### Reportar Bugs
1. Crear un issue en el repositorio
2. Incluir detalles del error
3. Pasos para reproducir
4. Capturas de pantalla si aplica

### Contribuir Código
1. Fork del repositorio
2. Crear rama feature
3. Commit de cambios
4. Pull request con descripción detallada

## 📄 Licencia

Este tema está bajo Licencia GPL v2 o posterior.

## 📞 Soporte

### Recursos Útiles
- [Documentación de WordPress](https://developer.wordpress.org/)
- [Documentación de WooCommerce](https://woocommerce.com/documentation/)
- [CSS Grid Guide](https://css-tricks.com/snippets/css/complete-guide-grid/)
- [JavaScript ES6 Features](https://es6-features.org/)

### Contacto
- Email: soporte@planandino.com
- Documentación: [docs.planandino.com](http://docs.planandino.com)
- Demo: [demo.planandino.com](http://demo.planandino.com)

---

**Plan Andino Shop** - Un tema WordPress profesional para e-commerce con diseño Bridge, desarrollado con las mejores prácticas y tecnologías modernas.

Made with ❤️ for WordPress & WooCommerce