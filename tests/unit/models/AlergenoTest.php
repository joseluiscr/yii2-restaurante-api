<?php

namespace tests\models;

use app\models\PlatoIngredienteCambio;
use app\models\PlatoIngrediente;
use app\models\IngrAlergeno;
use app\models\Plato;
use app\models\Ingrediente;
use app\models\Alergeno;

class AlergenoTest extends \Codeception\Test\Unit
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
    public function testFindAlergenoById()
    {
        $aux = Alergeno::findOne(1);
        $this->assertEquals($aux->id, 1);
        $this->assertEquals($aux->nombre, 'alergeno1');
        $this->assertEquals($aux->descripcion, 'Este es el alergeno 1');

    }

    /*
    * Comprobar que las validaciones son correctas
    */
    public function testValidateAlergeno()
    {
        $aux = new Alergeno();

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
    public function testAlergenoGetIngredientes()
    {
        $aux = Alergeno::findOne(1);

        $this->assertEquals($aux->getIngredientes()->count(), 2);

        foreach($aux->ingredientes as $obj){
            $this->assertContains($obj->id, [2, 3]);
        }

    }

    /*
    * Comprobar que la obtención de platos es correcta
    */
    public function testAlergenoGetPlatos()
    {
        $aux = Alergeno::findOne(1);

        $this->assertEquals($aux->getPlatos()->count(),3);

        foreach($aux->getPlatos()->all() as $obj){
            $this->assertContains($obj->id, [1, 2, 3]);
        }

    }

}
