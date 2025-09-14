# Api-Sol 🟢

Sistema de gestión de ingresos y gastos con API REST en PHP y base de datos MySQL.

---

## 🗓 Fecha
- T6 14.09.25 → Script base de datos MySQL  
- T7 14.09.25 → API REST version 1.0  

---

## 📂 Estructura del proyecto

sol_api/
├── config/
│ └── db.php
├── endpoints/
│ ├── auth.php
│ ├── categorias.php
│ ├── movimientos.php
│ └── perfil.php
├── README.md
└── ...

yaml
Copiar código

---

## 🛠 Base de Datos MySQL (T6)

Tablas principales:

### **usuarios**
| id | nombre | apellido | email | telefono | password |
|----|--------|---------|-------|---------|---------|

### **perfil**
| id | usuario_id | telefono | direccion |

### **categorias**
| id | nombre | tipo |
- tipo = `ingreso` / `gasto`

### **movimientos**
| id | usuario_id | categoria_id | monto | fecha | notas |

**Relaciones:**
- `perfil.usuario_id` → `usuarios.id`  
- `movimientos.usuario_id` → `usuarios.id`  
- `movimientos.categoria_id` → `categorias.id`  

---

## 🚀 API REST v1.0 (T7)

**Base URL:** `http://localhost/sol_api/endpoints/`

| Recurso | Acción | Método | Parámetros / Body | Ejemplo JSON | Descripción |
|---------|--------|--------|-----------------|---------------|------------|
| `auth.php` | register | POST | `nombre, apellido, email, password` | `{"nombre":"Daniel","apellido":"Parco","email":"daniel2@example.com","password":"123456"}` | Registrar usuario |
| `auth.php` | list | GET | — | — | Listar usuarios |
| `categorias.php` | — | GET | — | — | Listar categorías |
| `movimientos.php` | add | POST | `usuario_id, categoria_id, monto, fecha, notas` | `{"usuario_id":1,"categoria_id":1,"monto":200.50,"fecha":"2025-09-14 20:00:00","notas":"Cena"}` | Agregar movimiento |
| `movimientos.php` | list | GET | `usuario_id` | — | Listar movimientos de un usuario |

---
