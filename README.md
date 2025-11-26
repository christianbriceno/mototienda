# 🛵 Mototienda - Sistema de Gestión de Inventario y Ventas

**Christian Briceño - Desarrollador Backend Laravel**
* **Perfil Profesional:** www.linkedin.com/in/christian-briceño-b59085139
* **Portafolio (GitHub):** https://github.com/christianbriceno/mototienda

---

## 📝 Descripción del Proyecto

**Mototienda** es un sistema de administración web completo, diseñado para gestionar el ciclo de ventas, inventario y usuarios de una tienda de repuestos de motocicletas.

Este proyecto fue desarrollado con **Laravel** y se enfoca en la implementación de una arquitectura de backend robusta, segura y bien estructurada, utilizando **Laravel Filament** para el panel de administración.

### Módulos y Funcionalidades Principales

El sistema abarca las siguientes áreas de negocio, demostrando capacidad para manejar lógica financiera, administrativa y de datos:

* **Panel de Administración:** Toda la gestión se realiza a través de la interfaz moderna y funcional de **Laravel Filament**.
* **Gestión de Datos Masiva:** Utilización de **acciones de Filament** para **cargar y descargar archivos XLSX** en el módulo de Presentaciones, permitiendo la actualización eficiente de datos de inventario.
* **Ventas y Finanzas:** Módulos de **Pedidos**, **Facturas**, **Métodos de Pago** y manejo de **Tasas de Cambio** para transacciones multidivisa.
* **Clientes:** Gestión detallada de **Clientes** (incluyendo el módulo de **Sexos** para datos demográficos).
* **Inventario:** Gestión de la **Tienda** y las **Presentaciones**.
* **Administración Central:**
    * **Usuarios**, **Roles** y **Permisos** (RBAC).
    * **Notificaciones** internas del sistema.
    * **ActivityLog** (Registro de Actividad) para auditoría.

---

## 🛠️ Stack Tecnológico y Arquitectura

Este proyecto demuestra un dominio del ecosistema moderno de Laravel y las mejores prácticas de desarrollo.

### Tecnologías Principales

* **Lenguaje:** **PHP 8.1**
* **Framework:** **Laravel 10**
* **Base de Datos:** **PostgreSQL**
* **Frontend (UI/UX):** **Laravel Filament** (Panel de Administración) y **Bootstrap 5**.
* **Dependencias:** **Composer**

### Diferenciadores y Buenas Prácticas (Keywords Clave)

| Característica | Detalle | Habilidad Demostrada |
| :--- | :--- | :--- |
| **Panel Admin Avanzado** | Interfaz de administración desarrollada íntegramente con **Laravel Filament**, incluyendo **acciones para manejo de XLSX**. | Eficiencia, manejo de datos masivos e integración de librerías. |
| **Control de Acceso (RBAC)** | Uso de **Spatie Laravel Permission** para gestión granular de **Roles** y **Permisos**. | Seguridad y control de acceso crítico. |
| **Auditoría** | Implementación del módulo **ActivityLog** (Spatie) para el seguimiento de todas las acciones del usuario. | Trazabilidad y cumplimiento. |
| **Calidad de Código** | Aplicación de **Principios SOLID** en la estructura de *Service Classes* y lógica de negocio. | Mantenibilidad y escalabilidad. |
| **DevOps** | Experiencia en la configuración de entornos con **Docker** (Laravel Sail) y despliegue a producción con **Laravel Forge**. | Gestión completa del ciclo de vida del software. |

---

## 🚀 Instalación y Configuración Local

Sigue estos pasos para poner en marcha el proyecto en tu entorno de desarrollo.

### Requisitos

Necesitas tener **PHP**, **Composer** y una instancia de base de datos **PostgreSQL** o un entorno **Docker** configurado.

### 1. Clonar el Repositorio

```bash
git clone [https://github.com/christianbriceno/mototienda.git](https://github.com/christianbriceno/mototienda.git)

cd mototienda
```

### 2. Instalación de Dependencias

```bash
composer install
```

### 3. Configuración del Entorno (.env)
Crea el archivo de configuración y genera la clave de aplicación:

```bash
cp .env.example .env
php artisan key:generate
```

### Importante: Asegúrate de configurar correctamente las credenciales de conexión a tu base de datos PostgreSQL en el archivo .env.

```bash
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=mototienda_db
DB_USERNAME=tu_usuario_pg
DB_PASSWORD=tu_password_pg

SUPER_ADMIN_NAME="Admin"
SUPER_ADMIN_EMAIL="admin@mototienda.com"
SUPER_ADMIN_PASSWORD="password"

CONSUMIDOR_FINAL_NAME="Consumidor Final"
CONSUMIDOR_FINAL_LAST_NAME=""
CONSUMIDOR_FINAL_IDENTIFICATION_CARD="0000000"
CONSUMIDOR_FINAL_ADDRESS=""
CONSUMIDOR_FINAL_EMAIL=""
CONSUMIDOR_FINAL_PHONE=""
```

### 4. Ejecutar Migraciones y Seeding
Este paso crea todas las tablas y ejecuta el seeder que configura los roles y crea el usuario Administrador inicial.

```bash
php artisan migrate:fresh --seed
```

### 5. Ejecutar la Aplicación

```bash
php artisan serve

npm run dev
```

## 🤝 Créditos
Este proyecto fue desarrollado por Christian Briceño como parte de su portafolio de desarrollo backend.
