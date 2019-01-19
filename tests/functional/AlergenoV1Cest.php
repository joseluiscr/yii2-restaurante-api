<?php

use app\models\PlatoIngredienteCambio;
use app\models\PlatoIngrediente;
use app\models\IngrAlergeno;
use app\models\Plato;
use app\models\Ingrediente;
use app\models\Alergeno;
use yii\helpers\Url;

use app\tests\fixtures\AlergenoFixture;
use app\tests\fixtures\IngredienteFixture;
use app\tests\fixtures\PlatoFixture;
use app\tests\fixtures\IngrAlergenoFixture;
use app\tests\fixtures\PlatoIngredienteFixture;
use app\tests\fixtures\PlatoIngredienteCambioFixture;

/**
 * AlergenoController API functional test.
 *
 */
class AlergenoV1Cest
{
    /*
    public function _fixtures(){ // Se ejecuta antes de cada método de la clase, por lo que queda fuera del cleanup
    }
    */

    public function _before(\FunctionalTester $I) // Se ejecuta dentro de cada método (lo primero que se ejecuta), por lo que queda dentro del cleanup
    {
        //Cargar los datos para el test
        $I->haveFixtures([
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
    public function _after(\FunctionalTester $I) // Se ejecuta dentro de cada método (lo último), por lo que queda dentro del cleanup
    {
    }
    */

    /* Index action
    --------------------------------------------------------------- */
    /**
     * @param FunctionalTester $I
     */
    public function indexAlergenos(\FunctionalTester $I)
    {
        
        $I->wantTo("View complete list of all alergenos");
        
        $I->sendGET(Url::to(['/v1/alergeno/index'], true));

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        
        $I->seeResponseContainsJson([
                [
                    'id'=> 1,
                    'nombre' => 'alergeno1',
                    'descripcion' => 'Este es el alergeno 1'
                ],
                [
                    'id'=> 2,
                    'nombre' => 'alergeno2',
                    'descripcion' => 'Este es el alergeno 2'
                ],
                [
                    'id'=> 3,
                    'nombre' => 'alergeno3',
                    'descripcion' => 'Este es el alergeno 3'
                ],
                [
                    'id'=> 4,
                    'nombre' => 'alergeno4',
                    'descripcion' => 'Este es el alergeno 4'
                ],
                [
                    'id'=> 5,
                    'nombre' => 'alergeno5',
                    'descripcion' => 'Este es el alergeno 5'
                ],
        ]);
        
    }


    /* View action
    --------------------------------------------------------------- */
    /**
     * @param FunctionalTester $I
     */
    public function viewAlergenoNotExist(\FunctionalTester $I)
    {
        
        $I->wantTo("View a not existing alergeno");
        
        $I->sendGET(Url::to(['/v1/alergeno/view', 'id' => 36], true));

        $I->seeResponseCodeIs(404);
        $I->seeResponseIsJson();
        
        $I->seeResponseContainsJson([
            'message' => 'Object not found: 36',
        ]);
        
    }

    /**
     * @param FunctionalTester $I
     */
    public function viewAlergenoWithoutDetails(\FunctionalTester $I)
    {
        
        $I->wantTo("View an alergeno's data without details");
        
        $I->sendGET(Url::to(['/v1/alergeno/view', 'id' => 1], true));

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        
        $I->seeResponseContainsJson([
            'id'     => 1,
            'nombre' => 'alergeno1',
            'descripcion' => 'Este es el alergeno 1',
        ]);
        
    }

    /**
     * @param FunctionalTester $I
     */
    public function viewAlergenoIngredientes(\FunctionalTester $I)
    {
        
        $I->wantTo("View an alergeno's data with its ingredientes");
        
        $I->sendGET(Url::to(['/v1/alergeno/view', 'id' => 1, 'expand' => 'ingredientes'], true));

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        
        $I->seeResponseContainsJson([
            'id'     => 1,
            'nombre' => 'alergeno1',
            'descripcion' => 'Este es el alergeno 1',
            'ingredientes' => [
                [
                    'id'=> 2,
                    'nombre' => 'ingrediente2',
                    'descripcion' => 'Este es el ingrediente 2'
                ],
                [
                    'id'=> 3,
                    'nombre' => 'ingrediente3',
                    'descripcion' => 'Este es el ingrediente 3'
                ],
            ]
        ]);

    }

    /**
     * @param FunctionalTester $I
     */
    public function viewAlergenoPlatos(\FunctionalTester $I)
    {
        
        $I->wantTo("View an alergeno's data with its platos");
        
        $I->sendGET(Url::to(['/v1/alergeno/view', 'id' => 1, 'expand' => 'platos'], true));

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        
        $I->seeResponseContainsJson([
            'id'     => 1,
            'nombre' => 'alergeno1',
            'descripcion' => 'Este es el alergeno 1',
            'platos' => [
                [
                    'id'=> 1,
                    'nombre' => 'plato1',
                    'descripcion' => 'Este es el plato 1'
                ],
                [
                    'id'=> 2,
                    'nombre' => 'plato2',
                    'descripcion' => 'Este es el plato 2'
                ],
                [
                    'id'=> 3,
                    'nombre' => 'plato3',
                    'descripcion' => 'Este es el plato 3'
                ],
            ]
        ]);

    }

    /* Create action
    --------------------------------------------------------------- */
    /**
     * @param FunctionalTester $I
     */
    public function createAlergenoValidation(\FunctionalTester $I)
    {
        
        $I->wantTo("Check validations on creating alergeno");
        
        // nombre obligatorio
        $I->sendPOST(Url::to('/v1/alergenos', true), [
            'nombre' => '',
        ]);
        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'field' => 'nombre',
            'message' => 'Nombre cannot be blank.',
        ]);

        // nombre string(30)
        $I->sendPOST(Url::to('/v1/alergenos', true), [
            'nombre' => '111111111111111111111111111111111111111111111111111111111111111111111111111',
        ]);
        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'field' => 'nombre',
            'message' => 'Nombre should contain at most 30 characters.',
        ]);

        // nombre string(100)
        $I->sendPOST(Url::to('/v1/alergenos', true), [
            'descripcion' => '111111111111111111111111111111111111111111111111111111111111111111111111111'.
                        '111111111111111111111111111111111111111111111111111111111111111111111111111'.
                        '111111111111111111111111111111111111111111111111111111111111111111111111111',
        ]);
        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'field' => 'descripcion',
            'message' => 'Descripcion should contain at most 100 characters.',
        ]);

    }

    /**
     * @param FunctionalTester $I
     */
    public function createAlergeno(\FunctionalTester $I)
    {
        
        $I->wantTo("Create an alergeno");
        
        $I->sendPOST(Url::to('/v1/alergenos', true), [
            'nombre' => 'nuevo alergeno',
            'descripcion' => 'Este es un nuevo alergeno'
        ]);

        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
        
        $I->seeResponseContainsJson([
            'nombre' => 'nuevo alergeno',
            'descripcion' => 'Este es un nuevo alergeno',
        ]);
        
    }

    /* Update action
    --------------------------------------------------------------- */
    /**
     * @param FunctionalTester $I
     */
    public function updateAlergeno(\FunctionalTester $I)
    {
        
        $I->wantTo("Update an alergeno");
        
        $I->sendPUT(Url::to(['/v1/alergeno/view','id'=>1], true), [
            'nombre' => 'alergeno1mod',
            'descripcion' => 'Este es el alergeno 1 modificado'
        ]);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        
        $I->seeResponseContainsJson([
            'nombre' => 'alergeno1mod',
            'descripcion' => 'Este es el alergeno 1 modificado',
        ]);
        
    }

    /* Delete action
    --------------------------------------------------------------- */
    /**
     * @param FunctionalTester $I
     */
    public function deleteAlergenoNotAllowed(\FunctionalTester $I)
    {
        
        $I->wantTo("Check deleting an alergeno is not allowed");
        
        $url = 'v1/alergeno/delete';
        $I->sendDELETE(Url::to(['/v1/alergeno/view', 'id' => 1], true));

        $I->seeResponseCodeIs(404);
        
    }

}
