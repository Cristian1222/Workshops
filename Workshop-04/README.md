# Workshop 03 - MVC
1. Copie la carpeta a `C:\xampp\htdocs\`.
2. Inicie Apache y MySQL en XAMPP.
3. Importe `database_setup.sql` desde phpMyAdmin.
4. Revise las credenciales en `app/Config/database.php`.
5. Abra `http://localhost/Workshop-03-MVC/public/`.

## Arquitectura
- `app/Models`: acceso a datos y consultas SQL.
- `app/Views`: interfaz HTML y presentación.
- `app/Controllers`: recibe solicitudes, valida y coordina modelos y vistas.
- `app/Config`: configuración de PDO.
- `app/Core`: clase base, redirecciones y mensajes.
- `public/index.php`: punto de entrada y enrutador.

El script crea las tablas `users`, `careers` y `courses`, nombres coherentes con los modelos. Haga una copia de seguridad de su base de datos antes de importar el SQL si ya tiene información que desea conservar.
