<?php

namespace tests\models;

use app\models\PlatoIngredienteCambio;
use app\models\PlatoIngrediente;
use app\models\IngrAlergeno;
use app\models\Plato;
use app\models\Ingrediente;
use app\models\Alergeno;
use app\modules\v1\models\IngredienteModel;

use app\tests\fixtures\AlergenoFixture;
use app\tests\fixtures\IngredienteFixture;
use app\tests\fixtures\PlatoFixture;
use app\tests\fixtures\IngrAlergenoFixture;
use app\tests\fixtures\PlatoIngredienteFixture;
use app\tests\fixtures\PlatoIngredienteCambioFixture;

class IngredienteModelV1Test extends \Codeception\Test\Unit
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
    * Comprobar que la lista de campos ofrecidos es correcta
    */
    public function testIngredienteV1Fields()
    {
        $aux = IngredienteModel::findOne(1);

        $field = $aux->fields();

        // Comprobar que es ['id', 'nombre', 'descripcion']
        $this->assertEquals(count($field) ,3);
        $this->assertTrue(in_array ( 'id' , $field ));
        $this->assertTrue(in_array ( 'nombre' , $field ));
        $this->assertTrue(in_array ( 'descripcion' , $field ));

    }

    /*
    * Comprobar que la lista de campos adicionales ofrecidos es correcta
    */
    public function testIngredienteV1ExtraFields()
    {
        $aux = IngredienteModel::findOne(1);

        $extra = $aux->extraFields();

        // Comprobar que es ['alergenos', 'platos' ]
        $this->assertEquals(count($extra) ,2);
        $this->assertTrue(in_array ( 'alergenos' , $extra ));
        $this->assertTrue(in_array ( 'platos' , $extra ));

    }

    /*
    * Comprobar que la conversión de un ingrediente en array es correcta (incluyendo los campos adicionales)
    */
    public function testIngredienteV1ConvertModelToArray() {

        $aux = IngredienteModel::findOne(1);
        
        $relaciones = ['alergenos','platos'];
        $arrayAttributes = $aux->convertModelToArray($relaciones);

        $this->assertEquals(count($arrayAttributes), 5);
        $this->assertEquals($arrayAttributes['id'], $aux->id);
        $this->assertEquals($arrayAttributes['nombre'], $aux->nombre);
        $this->assertEquals($arrayAttributes['descripcion'], $aux->descripcion);
        $this->assertEquals($arrayAttributes['alergenos'], $aux->alergenos);
        $this->assertEquals($arrayAttributes['platos'], $aux->platos);

    }

}