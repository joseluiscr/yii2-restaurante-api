<?php

namespace tests\models;

use app\models\PlatoIngredienteCambio;
use app\models\PlatoIngrediente;
use app\models\IngrAlergeno;
use app\models\Plato;
use app\models\Ingrediente;
use app\models\Alergeno;

class PlatoTest extends \Codeception\Test\Unit
{
    
    public function _before()
    {
        // Limpiar la BBDD antes de empezar el test
            // Lo hago con los ActiveRecord porque no sé hacerlo con fixtures
        PlatoIngredienteCambio::deleteAll();
        PlatoIngrediente::deleteAll();
        IngrAlergeno::deleteAll();
        Plato::deleteAll();
        Ingrediente::deleteAll();
        Alergeno::deleteAll();

        //Cargar los datos para el test
        $clase = 'app\models\Alergeno';
        $this->tester->haveRecord($clase, array('id' => 1, 'nombre' => 'alergeno1',
                                                'descripcion' => 'Este es el alergeno 1'
                                ));
        $this->tester->haveRecord($clase, array('id' => 2, 'nombre' => 'alergeno2',
                                                'descripcion' => 'Este es el alergeno 2'
                                ));
        $this->tester->haveRecord($clase, array('id' => 3, 'nombre' => 'alergeno3',
                                                'descripcion' => 'Este es el alergeno 3'
                                ));
        $this->tester->haveRecord($clase, array('id' => 4, 'nombre' => 'alergeno4',
                                                'descripcion' => 'Este es el alergeno 4'
                                ));
        $this->tester->haveRecord($clase, array('id' => 5, 'nombre' => 'alergeno5',
                                                'descripcion' => 'Este es el alergeno 5'
                                ));
        $clase = 'app\models\Ingrediente';
        $this->tester->haveRecord($clase, array('id' => 1, 'nombre' => 'ingrediente1',
                                                'descripcion' => 'Este es el ingrediente 1'
                                ));
        $this->tester->haveRecord($clase, array('id' => 2, 'nombre' => 'ingrediente2',
                                                'descripcion' => 'Este es el ingrediente 2'
                                ));
        $this->tester->haveRecord($clase, array('id' => 3, 'nombre' => 'ingrediente3',
                                                'descripcion' => 'Este es el ingrediente 3'
                                ));
        $this->tester->haveRecord($clase, array('id' => 4, 'nombre' => 'ingrediente4',
                                                'descripcion' => 'Este es el ingrediente 4'
                                ));
        $this->tester->haveRecord($clase, array('id' => 5, 'nombre' => 'ingrediente5',
                                                'descripcion' => 'Este es el ingrediente 5'
                                ));
        $clase = 'app\models\Plato';
        $this->tester->haveRecord($clase, array('id' => 1, 'nombre' => 'plato1',
                                                'descripcion' => 'Este es el plato 1'
                                ));
        $this->tester->haveRecord($clase, array('id' => 2, 'nombre' => 'plato2',
                                                'descripcion' => 'Este es el plato 2'
                                ));
        $this->tester->haveRecord($clase, array('id' => 3, 'nombre' => 'plato3',
                                                'descripcion' => 'Este es el plato 3'
                                ));
        $clase = 'app\models\IngrAlergeno';
        $this->tester->haveRecord($clase, array('id_ingrediente' => 1, 'id_alergeno' => 3));
        $this->tester->haveRecord($clase, array('id_ingrediente' => 1, 'id_alergeno' => 4));
        $this->tester->haveRecord($clase, array('id_ingrediente' => 2, 'id_alergeno' => 1));
        $this->tester->haveRecord($clase, array('id_ingrediente' => 2, 'id_alergeno' => 2));
        $this->tester->haveRecord($clase, array('id_ingrediente' => 3, 'id_alergeno' => 1));
        $this->tester->haveRecord($clase, array('id_ingrediente' => 3, 'id_alergeno' => 3));
        $this->tester->haveRecord($clase, array('id_ingrediente' => 3, 'id_alergeno' => 4));
        $this->tester->haveRecord($clase, array('id_ingrediente' => 5, 'id_alergeno' => 4));
        $clase = 'app\models\PlatoIngrediente';
        $this->tester->haveRecord($clase, array('id_plato' => 1, 'id_ingrediente' => 1));
        $this->tester->haveRecord($clase, array('id_plato' => 1, 'id_ingrediente' => 2));
        $this->tester->haveRecord($clase, array('id_plato' => 1, 'id_ingrediente' => 3));
        $this->tester->haveRecord($clase, array('id_plato' => 2, 'id_ingrediente' => 3));
        $this->tester->haveRecord($clase, array('id_plato' => 2, 'id_ingrediente' => 1));
        $this->tester->haveRecord($clase, array('id_plato' => 3, 'id_ingrediente' => 2));
        $this->tester->haveRecord($clase, array('id_plato' => 3, 'id_ingrediente' => 5));

        $clase = 'app\models\PlatoIngredienteCambio';
        $this->tester->haveRecord($clase, array('id_plato' => 1, 'id_ingrediente' => 2, 'orden_cambio' => 0, 'accion' => 1));
        $this->tester->haveRecord($clase, array('id_plato' => 1, 'id_ingrediente' => 3, 'orden_cambio' => 0, 'accion' => 1));
        $this->tester->haveRecord($clase, array('id_plato' => 1, 'id_ingrediente' => 4, 'orden_cambio' => 0, 'accion' => 1));
        $this->tester->haveRecord($clase, array('id_plato' => 1, 'id_ingrediente' => 4, 'orden_cambio' => 1, 'accion' => 2));// Quitar el 4
        $this->tester->haveRecord($clase, array('id_plato' => 1, 'id_ingrediente' => 1, 'orden_cambio' => 1, 'accion' => 1));// Añadir el 1

        $this->tester->haveRecord($clase, array('id_plato' => 2, 'id_ingrediente' => 3, 'orden_cambio' => 0, 'accion' => 1));
        $this->tester->haveRecord($clase, array('id_plato' => 2, 'id_ingrediente' => 1, 'orden_cambio' => 0, 'accion' => 1));

        $this->tester->haveRecord($clase, array('id_plato' => 3, 'id_ingrediente' => 1, 'orden_cambio' => 0, 'accion' => 1));
        $this->tester->haveRecord($clase, array('id_plato' => 3, 'id_ingrediente' => 5, 'orden_cambio' => 0, 'accion' => 1));
        $this->tester->haveRecord($clase, array('id_plato' => 3, 'id_ingrediente' => 1, 'orden_cambio' => 1, 'accion' => 2));// Quitar el 1
        $this->tester->haveRecord($clase, array('id_plato' => 3, 'id_ingrediente' => 2, 'orden_cambio' => 1, 'accion' => 1));// Añadir el 2

    }

    public function _after()
    {
        // Limpiar la BBDD después de terminar el test
          // Lo hago con los ActiveRecord porque no sé hacerlo con fixtures
        PlatoIngredienteCambio::deleteAll();
        PlatoIngrediente::deleteAll();
        IngrAlergeno::deleteAll();
        Plato::deleteAll();
        Ingrediente::deleteAll();
        Alergeno::deleteAll();

    }

    /*
    * Comprobar que la búsqueda por Id es correcta
    */
    public function testFindPlatoById()
    {
        $aux = Plato::findOne(1);
        $this->assertEquals($aux->id, 1);
        $this->assertEquals($aux->nombre, 'plato1');
        $this->assertEquals($aux->descripcion, 'Este es el plato 1');

    }

    /*
    * Comprobar que las validaciones son correctas
    */
    public function testValidatePlato()
    {
        $aux = new Plato();

        $aux->nombre = '';
        $this->assertFalse($aux->validate('nombre'));

        $aux->nombre = 'Este es un valor demasiado grande para este campo porque es solo de 30 caracteres';
        $aux->descripcion = 'Este es un valor demasiado grande para este campo porque es solo de 100 caracteres.'.
                            'Este es un valor demasiado grande para este campo porque es solo de 100 caracteres.'.
                            'Este es un valor demasiado grande para este campo porque es solo de 100 caracteres.'
                            ;
        $this->assertFalse($aux->validate('nombre'));
        $this->assertFalse($aux->validate('descripcion'));

    }

    /*
    * Comprobar que la obtención de ingredientes es correcta
    */
    public function testPlatoGetIngredientes()
    {
        $aux = Plato::findOne(1);

        $this->assertEquals($aux->getIngredientes()->count(), 3);

        foreach($aux->ingredientes as $obj){
            $this->assertContains($obj->id, [1, 2, 3]);
        }

    }

    /*
    * Comprobar que la obtención de alérgenos es correcta
    */
    public function testPlatoGetAlergenos()
    {
        $aux = Plato::findOne(1);

        $this->assertEquals($aux->getAlergenos()->count(), 4);

        foreach($aux->getAlergenos()->all() as $obj){
            $this->assertContains($obj->id, [1, 2, 3, 4]);
        }

    }

    /*
    * Comprobar que la obtención de cambios de ingredientes es correcta
    */
    public function testPlatoGetIngrCambios()
    {
        $aux = Plato::findOne(1);

        $this->assertEquals($aux->getPlatoIngredienteCambios()->count(), 5);

        foreach($aux->getPlatoIngredienteCambios()->all() as $cambio){
            $this->assertContains([$cambio->id_plato, $cambio->id_ingrediente, $cambio->orden_cambio, $cambio->accion],
                                  [
                                    [1,2,0,1],
                                    [1,3,0,1],
                                    [1,4,0,1],

                                    [1,4,1,2],
                                    [1,1,1,1],
                                  ]
                              );
        }

    }

    /*
    * Comprobar que la eliminación de ingredientes es correcta
    */
    public function testPlatoEliminarIngrediente()
    {
        $aux = Plato::findOne(1);

        // Eliminar el ingrediente 3 de este plato
        $ingr3 = Ingrediente::findOne(3);
            $version = 2; //segundo grupo de cambios
        $aux->eliminarIngrPlato($ingr3, $version);

        // Verificar que se ha eliminado del plato y que se ha registrado el cambio
        $this->tester->dontSeeRecord(PlatoIngrediente::className(), 
                                    ['id_plato' => 1, 'id_ingrediente' => 3]
                                );
        $this->tester->seeRecord(PlatoIngredienteCambio::className(), 
                                    ['id_plato' => 1, 'id_ingrediente' => 3,
                                     'orden_cambio' => $version, 'accion' => 2]
                                );

    }

    /*
    * Comprobar que la adición de ingredientes es correcta
    */
    public function testPlatoAnadirIngrediente()
    {
        $aux = Plato::findOne(1);

        // Añadir el ingrediente 5 a este plato
        $ingr5 = Ingrediente::findOne(5);
            $version = 2; //segundo grupo de cambios
        $aux->anadirIngrPlato($ingr5, $version);

        // Verificar que se ha añaido al plato y que se ha registrado el cambio
        $this->tester->seeRecord(PlatoIngrediente::className(), 
                                    ['id_plato' => 1, 'id_ingrediente' => 5]
                                );
        $this->tester->seeRecord(PlatoIngredienteCambio::className(), 
                                    ['id_plato' => 1, 'id_ingrediente' => 5,
                                     'orden_cambio' => $version, 'accion' => 1
                                    ]
                                );

    }

    /*
    * Comprobar que la modificación de ingredientes es correcta
    */
    public function testPlatoModIngredientes()
    {
        $aux = Plato::findOne(1);

        // Lista actual de ingredientes de este plato -> [1,2,3]

        // Creamos la nueva lista de ingredientes del plato -> [2,3,5]
        $ingredientesNuevos = Ingrediente::findAll([2,3,5]);

        // Modificamos la lista de ingredientes del plato
        $aux->modificarIngredientes($ingredientesNuevos);

        // Comprobamos que se ha modificado la lista y que se han registrado los cambios
        $this->tester->seeRecord(PlatoIngrediente::className(), 
                                ['id_plato' => 1, 'id_ingrediente' => 2]
                                );
        $this->tester->seeRecord(PlatoIngrediente::className(), 
                                ['id_plato' => 1, 'id_ingrediente' => 3]
                                );
        $this->tester->seeRecord(PlatoIngrediente::className(), 
                                ['id_plato' => 1, 'id_ingrediente' => 5]
                                );
        $this->tester->dontSeeRecord(PlatoIngrediente::className(), 
                                ['id_plato' => 1, 'id_ingrediente' => 1]
                                );

        $this->tester->seeRecord(PlatoIngredienteCambio::className(), 
                                    ['id_plato' => 1, 'id_ingrediente' => 5,
                                     'orden_cambio' => 2, 'accion' => 1
                                    ]
                                );
        $this->tester->seeRecord(PlatoIngredienteCambio::className(), 
                                    ['id_plato' => 1, 'id_ingrediente' => 1,
                                     'orden_cambio' => 2, 'accion' => 2
                                    ]
                                );

    }

}