<?php

namespace tests\models;

use app\models\PlatoIngredienteCambio;
use app\models\PlatoIngrediente;
use app\models\IngrAlergeno;
use app\models\Plato;
use app\models\Ingrediente;
use app\models\Alergeno;

use app\tests\fixtures\AlergenoFixture;
use app\tests\fixtures\IngredienteFixture;
use app\tests\fixtures\PlatoFixture;
use app\tests\fixtures\IngrAlergenoFixture;
use app\tests\fixtures\PlatoIngredienteFixture;
use app\tests\fixtures\PlatoIngredienteCambioFixture;

class PlatoTest extends \Codeception\Test\Unit
{
    /*
    public function _fixtures(){ // Se ejecuta antes de cada método de la clase, por lo que queda fuera del cleanup
    }
    */

    public function _before() // Se ejecuta dentro de cada método (lo primero que se ejecuta), por lo que queda dentro del cleanup
    {
        //Cargar los datos para el test
        $this->tester->haveFixtures([
            'alergenos' => [
                'class' => AlergenoFixture::className(),
                'dataFile' => '@app/tests/fixtures/data/alergeno.php'
            ],
            'ingredientes' => [
                'class' => IngredienteFixture::className(),
                'dataFile' => '@app/tests/fixtures/data/ingrediente.php'
            ],
            'platos' => [
                'class' => PlatoFixture::className(),
                'dataFile' => '@app/tests/fixtures/data/plato.php'
            ],
            'ingredientes_alergenos' => [
                'class' => IngrAlergenoFixture::className(),
                'dataFile' => '@app/tests/fixtures/data/ingr_alergeno.php'
            ],
            'platos_ingredientes' => [
                'class' => PlatoIngredienteFixture::className(),
                'dataFile' => '@app/tests/fixtures/data/plato_ingrediente.php'
            ],
            'plato_ingrediente_cambios' => [
                'class' => PlatoIngredienteCambioFixture::className(),
                'dataFile' => '@app/tests/fixtures/data/plato_ingrediente_cambio.php'
            ],
        ]);
        
    }

    /*
    public function _after() // Se ejecuta dentro de cada método (lo último), por lo que queda dentro del cleanup
    {
    }
    */
    
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