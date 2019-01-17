<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii2 restaurante API</h1>
    <br>
</p>



FRAMEWORK
---------
- Yii2.
- Se han utilizado las clases propias del Framework especialmente adaptadas para el desarrollo de API REST: ActiveRecord como modelos y ActiveController como controladores.



DISEÑO
------
- Cumple con el estándar HATEOAS (en las respuestas de la API se devuelven los links a los recursos relacionados).
- Diseñado de acuerdo a MVC (sin vistas porque es una API).
- La API permite sucesivas versiones:
  + Los controladores y los modelos propios de cada versión están en: app\modules\v{i}\ (app\modules\v1\ para la versión 1)
  + Los modelos comunes a todas las versiones están en: app\models\

- Se han utilizado las clases predefinidas de Yii para los modelos (ActiveRecord) y para los controladores (ActiveController).
- Los modelos de versión heredan de los modelos comunes para aprovechar todos sus atributos y métodos.



ESTRUCTURA
----------
- Modelo. Se ha dividido en 2 partes:
  + app\models --> donde se han incluido las características propias del negocio: validación de campos y relaciones entre los datos.
  + app\modules\v1\models --> Esta parte controla la presentación de los datos y, por ello, tiene una estructura de versiones.

- Controladores. Se han incluido en la parte versionable (app\modules\v1\controllers) porque son la presentación de los datos.



ARBOL DE DIRECTORIOS
--------------------

      config/             configuración de la aplicación
      controllers/        controladores (contiene sólo el controlador por defecto)
      documentacion/      ejemplos de uso de la api y archivos sql para crear la bbdd
      models/             clases de modelos propias de negocio
      modules/v1/         clases de modelos y controladores propios de cada versión
      tests/              test unitarios y funcionales



DOCUMENTACIÓN
-------------
En el directorio documentación se pueden encontrar:
- API_urls.txt --> fichero con ejemplos de las urls con sus entradas y salidas.
- restaurante_tablas_condatos.sql --> fichero sql para crear la bbdd (incluye la carga de unos datos de ejemplo en las tablas).
- restaurante_solodatos.sql --> fichero sql con los datos de ejemplo.



CONFIGURACIÓN
-------------

### Database

Editar el archivo `config/db.php` para incluir los datos de conexión a base de datos:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=yii2basic',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

La base de datos para testing se indica en `config/test_db.php`



ESTRUCTURA BBDD
---------------

- Se han creado 3 tablas de catálogo (contienen sólo [id, nombre, descripcion]):
    alergeno, ingrediente, plato.
- Dos tablas para las relaciones entre alergenos-ingredientes e ingredientes-platos, con sus respectivas foreign keys.
- Por último, se ha creado una tabla para guardar los posibles cambios de ingredientes de cada plato (se guarda la receta inicial de cada plato con orden_cambio = 0, y luego los sucesivos cambios con orden_cambio sucesivos).



FUNCIONAMIENTO DE LA API
------------------------
No se permite borrar ni alérgenos, ni ingredientes, ni platos de sus catálogos respectivos.

- Alérgenos:
  + Consultar la lista completa de alérgenos.
      http://localhost:8888/alergenos - GET
  + Consultar los datos de un alérgeno concreto, incluidos los ingredientes y platos en que se encuentra.
      http://localhost:8888/alergenos/1
      http://localhost:8888/alergenos/1?expand=platos - GET
      http://localhost:8888/alergenos/1?expand=ingredientes - GET
  + Crear un alérgeno nuevo.
      http://localhost:8888/alergenos - POST
  + Modificar un alérgeno.
      http://localhost:8888/alergenos/1 - PUT

- Ingredientes:
  + Consultar la lista completa de ingredientes.
      http://localhost:8888/ingredientes - GET
  + Consultar los datos de un ingrediente concreto, incluidos los alérgenos que tiene y los platos en que se encuentra.
      http://localhost:8888/ingredientes/1
      http://localhost:8888/ingredientes/1?expand=alergenos - GET
      http://localhost:8888/ingredientes/1?expand=platos - GET
  + Crear un ingrediente nuevo.
      http://localhost:8888/ingredientes - POST
  + Modificar un ingrediente.
      http://localhost:8888/ingredientes/1 - PUT
  + Generar y modificar la lista de alérgenos de un ingrediente.
      http://localhost:8888/ingredientes/1/alergenos - PUT

- Platos:
  + Consultar la lista completa de platos.
      http://localhost:8888/platos - GET
  + Consultar los datos de un plato concreto, incluidos los alérgenos que tiene y los ingredientes que tiene.
      http://localhost:8888/platos/1
      http://localhost:8888/platos/1?expand=ingredientes - GET
      http://localhost:8888/platos/1?expand=alergenos - GET
  + Consultar los cambios de ingredientes que ha habido en un plato.
      http://localhost:8888/platos/1?expand=platoingredientecambios - GET
  + Crear un plato nuevo.
      http://localhost:8888/platos - POST
  + Modificar un plato.
      http://localhost:8888/platos/1 - PUT
  + Generar y modificar la lista de ingredientes de un plato.
      http://localhost:8888/platos/1/ingredientes - PUT




TESTING
-------

Los tests automáticos están en el directorio `tests`. Han sido desarrollados con [Codeception PHP Testing Framework](http://codeception.com/).
Hay 2 conjuntos de pruebas:

- `unit`
- `functional`

Los tests se pueden ejecutar con el comando:

```
vendor/bin/codecept run
```

Sólo se han incluido test unitarios y funcionales.



DATOS EJEMPLO
-------------
Como ya se ha comentado, se adjuntan unos ficheros para cargar la bbdd; ambos ficheros tienen los mismos datos de ejemplo. Son los siguientes:

 - alergenos: 1, 2, 3, 4, 5
 - ingredientes: 1, 2, 3, 4, 5
 - platos: 1, 2, 3

 - ingredientes:
    + 1 => alergenos: 3, 4
    + 2 => alergenos: 1, 2
    + 3 => alergenos: 1, 3, 4
    + 4 => alergenos:  
    + 5 => alergenos: 4

 - platos:
    + 1 => ingredientes: 1, 2, 3
    + 2 => ingredientes: 1, 3
    + 3 => ingredientes: 2, 5

 - cambios en platos:
      + plato:
        * 1 => ingredientes: [2, 3, 4] => [1, 2, 3]
        * 2 => ingredientes: sin cambios
        * 3 => ingredientes: [1, 5] => [2, 5]

