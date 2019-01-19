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

class AlergenoTest extends \Codeception\Test\Unit
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
