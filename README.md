<img src="/public/assets/images/logoUT.png" alt="UPTech" width="100%"/> <br/>
<img src="https://www.biodiversidad.gob.mx/media/1/conabio/gubernamentales-MEDIOAMBIENTE.jpg" alt="upTech" height="100"/>

# PTL
### Client: GIZ / SEMARNAT
### Year: 2021
---

# Descripción
El sistema usa arquitectura Modelo Vista Controlador (MVC) que permite una mayor seguridad al no existir ningún acceso al sistema de archivos.
Se utilizó el framework Codeigniter 4, que una de sus mayores fortalezas es la seguridad de las aplicaciones.

El sistema de archivos está concentrado en 5 directorios priuncipales, de los cuales, sólo a uno de ellos (public) se tiene acceso público.
El nucleo de la herramienta está en el directorio app, Este directorio contiene toda la información de la herramienta así como los controladores (Controllers), las vistas (Views) y los modelos (Models), para u mejor entendimiento del código de programación, los directorios Views, Controllers y Models, mantienen la misma estructura de información, así pues, si un usuario llama al controlador directorio/controlador, el sistema lo busca en el directorio Controllers/directorio/controlador y sus vistas y modelos asociados estarán en los directorios Views/directorio y Models/directorio respectivamente.

Para el cotrol de acceso al sistema se utilizaron sesiones de php y el acceso a los controladores está restringido desde 
filtros del sistema, (Directorio Filters)

Las clases de cálculo de indicadores y emisiones están en el directorio Libraries.






# Requisitos
### Software
- Apache 2
- PHP 7.4
	- intl extension
	- dom extension
	- ext-curl extension
    - sudo a2enmod rewrite
- MariaDB 10.4 (Recomendado) o MySQL 5.7+
- Servidor de correo electrónico (Que permita enviar correos desde PHP)
- Composer

### Hardware

- Procesador con 2 nucleos (mínimo), 4 nucleos (recomendado)
- RAM 4GB (mínimo), 8GB (recomendado)
- 500GB de almacenamiento (SSD recomendado)

# Instalación CentOS

1. Instalar php
2. Instalar MySQL o MariaDB
3. Instalar el plugin php-mysqli
```
sudo yum install -y php php-mysqlnd
```
4. Instalar el plugin php-intl
```
yum install php-intl
```

5. Instalar postfix
```
dnf install postfix
```

6. Instalar mailx
```
 dnf install mailx
```

7. Editar el archivo /etc/postfix/main.cf y copiar el contenido del archivo main.cf contenido en el directorio initData

8. Editar la linea correspondientes a:
```
relayhost = [mail.ptl.semarnat.gob.mx]:465

```

9. Crear el archivo /etc/postfix/sasl_passwd y agregar las siguiente linea con la información correcta
```
[smtp.gmail.com]:587 somebooks@gmail.com:mipassword
```

10. Encriptar la contraseña con el comando
```
sudo postmap /etc/postfix/sasl_passwd
```

11. Cambiar permisos y propietario del archivo a root
```
sudo chown root:root /etc/postfix/sasl_passwd /etc/postfix/sasl_passwd.db
sudo chmod 0600 /etc/postfix/sasl_passwd /etc/postfix/sasl_passwd.db
```

12. Iniciar postfix
```
systemctl start postfix
```

13. Poner postfix como servicio
```
systemctl enable postfix
```



14. Copiar el repositorio en /var/www/ptl/
15. Crear una base de datos en MariaDB o MySQL
16. Crear un usuario para la base de datos con todos los privilegios
17. Crear un virtual host que apunte al directorio public del repositorio
```
<virtualhost *:80>
ServerName ptl.centos
ServerAlias ptl.centos
DocumentRoot /var/www/ptl/public
    <Directory /var/www/ptl/public>
        Options Indexes FollowSymLinks Includes ExecCGI
        AllowOverride All
        Require all granted
    </Directory>
ErrorLog /var/log/httpd/domain-name.com-error.log
CustomLog /var/log/httpd/domain-name.com-access.log combined
</virtualhost>

```
 referencia https://noviello.it/es/como-instalar-apache-virtual-hosts-en-centos-8/


18. Hacer una copia del archivo env con nombre .env
 * En la linea 23 cambiar la url base del sitio
```
 app.baseURL = 'http://mias.upt/'
```
 * Configurar el acceso a la base de datos en las líneas 54 a 58 (si el servidor es localhost utilizar la IP 127.0.0.1)
```
database.default.hostname = dbServer 
database.default.database = dbName
database.default.username = dbUser
database.default.password = dbPassword
```
 * Para etapa de pruebas: descomentar y cambiar la línea 17 por (Si  estás en modo development, los horarios de servicio están desactivados y se activa la barra de desarrollo de CI4)
```
CI_ENVIRONMENT = development
```
19. Hacer una copia del archivo app/Config/App.php.sample.php con nombre App.php
 * Cambar la baseURL en la línea 24 por el dominio asignado
20. dar permisos de escritura a todos los subdirectorios del directorio writable
```
chcon -t httpd_sys_content_t /var/www/ptl/writable/ -R

chmod -R 777 /var/www/ptl/writable/
```
21. Asignar el directorio /var/www/ptl/ al usuario apache y grupo apache
```
chown apache: /var/www/ptl/
```
22. Importar la base de datos contenida en el archivo initData/initDB.sql

# Instalación

1. Copiar el repositorio
2. Crear una base de datos en MariaDB o MySQL
3. Crear un usuario para la base de datos con todos los privilegios
4. Crear un dominio o subdominio que apunte al directorio public del repositorio
5. Hacer una copia del archivo env con nombre .env
 * En la linea 23 cambiar la url base del sitio
```
 app.baseURL = 'http://mias.upt/'
```
 * Configurar el acceso a la base de datos en las líneas 54 a 58 (si el servidor es localhost utilizar la IP 127.0.0.1)
```
database.default.hostname = dbServer 
database.default.database = dbName
database.default.username = dbUser
database.default.password = dbPassword
```
 * Para etapa de pruebas: descomentar y cambiar la línea 17 por (Si  estás en modo development, los horarios de servicio están desactivados y se activa la barra de desarrollo de CI4)
```
CI_ENVIRONMENT = development
```
6. Hacer una copia del archivo app/Config/App.php.sample.php con nombre App.php
 * Cambar la baseURL en la línea 24 por el dominio asignado
7. dar permisos de escritura a todos los subdirectorios del directorio writable
8. Importar la base de datos contenida en el archivo initData/initDB.sql
<!-- 9. Crear los llamados a las rutinas de mantenimiento diarias
 * En una consola correr el comando
 ```
 crontab -e
 ```
 * Agregar las siguientes lineas al final
 ```
 0 0 * * * php <Ruta donde se clonó el repositorio>/spark ets:cron00
 0 19 * * * php <Ruta donde se clonó el repositorio>/spark ets:cron19
 ```
 * Guardar los cambios en el archivo -->


Ingresar al sistema, el usuario inicial es administrator contraseña: 123456789


 
