# 🛒 Supermercado Coromoto

Sistema de gestión de supermercado desarrollado en PHP con MySQL.

## 📁 Estructura del Proyecto

```
SupermercadoCoromoto/
├── 📄 index.php                 # Página principal
├── 📄 categorias.php            # Lista de todas las categorías
├── 📄 categoria_detalle.php     # Productos por categoría
├── 📄 admin.js                  # JavaScript para panel admin
├── 📄 carrito.js                # JavaScript para funcionalidad del carrito
├── 📁 administrador/            # Panel de administración
│   ├── admin.php               # Dashboard principal
│   ├── db.php                  # Conexión a base de datos
│   ├── agregar_producto.php    # Formulario agregar producto
│   ├── guardar_producto.php    # Procesar nuevo producto
│   ├── listar_productos.php    # Lista de productos
│   ├── tabla_producto.php      # Tabla HTML de productos
│   ├── eliminar_producto.php   # Eliminar productos
│   └── imagenes/               # Imágenes de productos
├── 📁 usuarios/                 # Sistema de usuarios
│   ├── registro.php            # Registro de usuarios
│   ├── login.php               # Inicio de sesión
│   └── logout.php              # Cerrar sesión
├── 📁 carrito/                  # Sistema de carrito
│   ├── carrito.php             # Vista del carrito
│   ├── agregar_carrito.php     # Agregar al carrito
│   ├── quitar_producto.php     # Quitar del carrito
│   ├── vaciar_carrito.php      # Vaciar carrito
│   ├── finalizar_compra.php    # Procesar compra
│   └── gracias.php             # Página de agradecimiento
├── 📁 templates/                # Plantillas reutilizables
│   ├── cabecera.php            # Header y navegación
│   └── footer.php              # Footer
├── 📁 css/                      # Estilos CSS
├── 📁 img/                      # Imágenes del sitio
│   └── logo.png                # Logo del supermercado
└── 📁 contacto/                 # Página de contacto
    ├── contacto.html           # Formulario de contacto
    └── contacto.css            # Estilos de contacto
```

## 🚀 Características Principales

### ✨ Sistema de Categorías Dinámico
- **15 categorías** de productos predefinidas
- **Navegación intuitiva** con menú desplegable
- **Páginas dinámicas** para cada categoría
- **Iconos específicos** para cada tipo de producto

### 🛍️ Gestión de Productos
- **CRUD completo** (Crear, Leer, Actualizar, Eliminar)
- **Subida de imágenes** automática
- **Categorización** por tipo de producto
- **Control de stock** en tiempo real

### 👥 Sistema de Usuarios
- **Registro** de nuevos usuarios
- **Inicio de sesión** seguro
- **Panel de administración** para admins
- **Sesiones** persistentes

### 🛒 Carrito de Compras
- **Agregar/quitar** productos
- **Cantidades** dinámicas
- **Cálculo automático** de totales
- **Proceso de compra** completo

### 🎨 Interfaz Moderna
- **Bootstrap 5.3** para diseño responsive
- **Remix Icons** para iconografía
- **Animaciones** suaves y profesionales
- **UX optimizada** para móviles

## 🛠️ Tecnologías Utilizadas

- **Backend:** PHP 8.x con PDO
- **Base de Datos:** MySQL/MariaDB
- **Frontend:** HTML5, CSS3, JavaScript ES6+
- **Framework CSS:** Bootstrap 5.3
- **Iconos:** Remix Icons
- **Servidor:** XAMPP (Apache + MySQL)

## 📊 Base de Datos

### Tablas Principales:
- **`usuario`** - Credenciales de acceso
- **`cliente`** - Información personal de usuarios
- **`producto`** - Catálogo de productos
- **`categoria`** - Categorías de productos
- **`carrito`** - Productos en carrito por usuario

## 🔧 Instalación

1. **Clonar** el proyecto en tu servidor web
2. **Importar** la base de datos `tiendaonline.sql`
3. **Configurar** la conexión en `administrador/db.php`
4. **Asegurar** permisos de escritura en `administrador/imagenes/`

## 🎯 Funcionalidades Destacadas

- ✅ **Sistema de categorías** completamente dinámico
- ✅ **Gestión de productos** con imágenes
- ✅ **Carrito de compras** funcional
- ✅ **Panel de administración** completo
- ✅ **Sistema de usuarios** seguro
- ✅ **Diseño responsive** para todos los dispositivos
- ✅ **Navegación intuitiva** con breadcrumbs
- ✅ **Mensajes de estado** con SweetAlert2

## 📱 Compatibilidad

- ✅ **Desktop** (Windows, macOS, Linux)
- ✅ **Tablets** (iPad, Android)
- ✅ **Móviles** (iPhone, Android)
- ✅ **Navegadores modernos** (Chrome, Firefox, Safari, Edge)

---

**Desarrollado con ❤️ para Supermercado Coromoto** 