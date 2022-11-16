# PTLOC
PTLOC es una prueba tecnica desarrollada por Carlos Gutierrez 2022.11.16, el backend esta contruido con Laravel y frontend con Angular.

## Intrucciones de instalación 
- Desde la consola de comandos clonar repositorio: `git clone https://github.com/cgutierr3z/ptloc.git`
- Entrar en carpeta ptloc/api-rest-library: `cd ptloc/api-rest-library`
- Ejecutar `composer install`
- Desde el motor gestor de base de datos preferido importar el script ubicado en `/api-rest-library/script-db-library.sql` para crear la base de datos.
- Ejecutar `php artisan serve` para levantar el servidor backend: http://localhost:8000.
- En otra consola de comandos, entrar en carpeta ptloc/front-library: `cd ptloc/front-library`
- Ejecutar `npm install`
- Ejecutar `ng serve` para levantar servidor del frontend en: http://localhost:4200

## Requerimientos FrontEnd
- node v10.14.2
- npm v6.4.1
- Angular CLI version 7.1.3
## Requerimientos Backend
- Apache/2.4.53
- mariadb Ver 15.1 Distrib 10.7.3-MariaDB
- PHP Version 7.4.29

# Licencia
- Copyright 2022 Carlos Gutierrez cgutierrez@utp.edu.co
- Este software está publicado bajo licencia [GNU GENERAL PUBLIC LICENSE Version 3](LICENSE)
