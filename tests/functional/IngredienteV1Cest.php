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
 * IngredienteController API functional test.
 *
 */
class IngredienteV1Cest
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
    public function indexIngredientes(\FunctionalTester $I)
    {
        
        $I->wantTo("View complete list of all ingredientes");
        
        $I->sendGET(Url::to(['/v1/ingrediente/index'], true));

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        
        $I->seeResponseContainsJson([
                [
                    'id'=> 1,
                    'nombre' => 'ingrediente1',
                    'descripcion' => 'Este es el ingrediente 1'
                ],
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
                [
                    'id'=> 4,
                    'nombre' => 'ingrediente4',
                    'descripcion' => 'Este es el ingrediente 4'
                ],
                [
                    'id'=> 5,
                    'nombre' => 'ingrediente5',
                    'descripcion' => 'Este es el ingrediente 5'
                ],
        ]);
        
    }

    /* View action
    --------------------------------------------------------------- */
    /**
     * @param FunctionalTester $I
     */
    public function viewIngredienteNotExist(\FunctionalTester $I)
    {
        
        $I->wantTo("View a not existing ingrediente");
        
        $I->sendGET(Url::to(['/v1/ingrediente/view', 'id' => 36], true));

        $I->seeResponseCodeIs(404);
        $I->seeResponseIsJson();
        
        $I->seeResponseContainsJson([
            'message' => 'Object not found: 36',
        ]);
        
    }

    /**
     * @param FunctionalTester $I
     */
    public function viewIngredienteWithoutDetails(\FunctionalTester $I)
    {
        
        $I->wantTo("View an ingrediente's data without details");
        
        $I->sendGET(Url::to(['/v1/ingrediente/view', 'id' => 1], true));

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        
        $I->seeResponseContainsJson([
            'id'     => 1,
            'nombre' => 'ingrediente1',
            'descripcion' => 'Este es el ingrediente 1',
        ]);
        
    }

    /**
     * @param FunctionalTester $I
     */
    public function viewIngredienteAlergenos(\FunctionalTester $I)
    {
        
        $I->wantTo("View an ingrediente's data with its alergenos");
        
        $I->sendGET(Url::to(['/v1/ingrediente/view', 'id' => 1, 'expand' => 'alergenos'], true));

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        
        $I->seeResponseContainsJson([
            'id'     => 1,
            'nombre' => 'ingrediente1',
            'descripcion' => 'Este es el ingrediente 1',
            'alergenos' => [
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
            ]
        ]);

    }

    /**
     * @param FunctionalTester $I
     */
    public function viewIngredientePlatos(\FunctionalTester $I)
    {
        
        $I->wantTo("View an ingrediente's data with its platos");
        
        $I->sendGET(Url::to(['/v1/ingrediente/view', 'id' => 1, 'expand' => 'platos'], true));

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        
        $I->seeResponseContainsJson([
            'id'     => 1,
            'nombre' => 'ingrediente1',
            'descripcion' => 'Este es el ingrediente 1',
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
            ]
        ]);

    }

    /* Create action
    --------------------------------------------------------------- */
    /**
     * @param FunctionalTester $I
     */
    public function createIngredienteValidation(\FunctionalTester $I)
    {
        
        $I->wantTo("Check validations on creating ingrediente");
        
        // nombre obligatorio
        $I->sendPOST(Url::to('/v1/ingredientes', true), [
            'nombre' => '',
        ]);
        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'field' => 'nombre',
            'message' => 'Nombre cannot be blank.',
        ]);

        // nombre string(30)
        $I->sendPOST(Url::to('/v1/ingredientes', true), [
            'nombre' => '111111111111111111111111111111111111111111111111111111111111111111111111111',
        ]);
        $I->seeResponseCodeIs(422);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'field' => 'nombre',
            'message' => 'Nombre should contain at most 30 characters.',
        ]);

        // nombre string(100)
        $I->sendPOST(Url::to('/v1/ingredientes', true), [
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
    public function createIngrediente(\FunctionalTester $I)
    {
        
        $I->wantTo("Create an ingrediente");
        
        $I->sendPOST(Url::to('/v1/ingredientes', true), [
            'nombre' => 'nuevo ingrediente',
            'descripcion' => 'Este es un nuevo ingrediente'
        ]);

        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();
        
        $I->seeResponseContainsJson([
            'nombre' => 'nuevo ingrediente',
            'descripcion' => 'Este es un nuevo ingrediente',
        ]);
        
    }

    /* Update action
    --------------------------------------------------------------- */
    /**
     * @param FunctionalTester $I
     */
    public function updateIngrediente(\FunctionalTester $I)
    {
        
        $I->wantTo("Update an ingrediente without details");
        
        $I->sendPUT(Url::to(['/v1/ingrediente/view','id'=>1], true), [
            'nombre' => 'ingrediente1mod',
            'descripcion' => 'Este es el ingrediente 1 modificado'
        ]);

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        
        $I->seeResponseContainsJson([
            'nombre' => 'ingrediente1mod',
            'descripcion' => 'Este es el ingrediente 1 modificado',
        ]);
        
    }

    /**
     * @param FunctionalTester $I
     */
    public function modIngrAlergenosValidation(\FunctionalTester $I)
    {
        
        $I->wantTo("Check validations on modifying ingrediente's alergenos: alergenos param is mandatory");
        
        $I->sendPUT(Url::to(['/v1/ingrediente/mod-alergenos', 'id' => 1], true)
        );

        $I->seeResponseCodeIs(400);
        $I->seeResponseIsJson();
        
        $I->seeResponseContainsJson([
            'message' => 'The alergenos body param is mandatory'
        ]);

    }

    /**
     * @param FunctionalTester $I
     */
    public function modIngredienteAlergenos(\FunctionalTester $I)
    {
        
        $I->wantTo("Change an ingrediente's alergenos");
        
        $I->sendPUT(Url::to(['/v1/ingrediente/mod-alergenos', 'id' => 1], true), [
                'alergenos' => [
                    ['id'=> 2],
                    ['id'=> 3],
                    ['id'=> 5],
                ]
            ]
        );

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        
        $I->seeResponseContainsJson([
            'id'     => 1,
            'nombre' => 'ingrediente1',
            'descripcion' => 'Este es el ingrediente 1',
            'alergenos' => [
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
                    'id'=> 5,
                    'nombre' => 'alergeno5',
                    'descripcion' => 'Este es el alergeno 5'
                ],
            ]
        ]);

    }

    /**
     * @param FunctionalTester $I
     */
    public function cleanIngredienteAlergenos(\FunctionalTester $I)
    {
        
        $I->wantTo("Remove all alergenos from an ingrediente");
        
        $I->sendPUT(Url::to(['/v1/ingrediente/mod-alergenos', 'id' => 1], true), [
                'alergenos' => [''
                ]
            ]
        );

        $I->seeResponseCodeIs(200);
        $I->seeResponseIsJson();
        
        $I->seeResponseContainsJson([
            'id'     => 1,
            'nombre' => 'ingrediente1',
            'descripcion' => 'Este es el ingrediente 1',
            'alergenos' => [
            ]
        ]);

    }
    
    /* Delete action
    --------------------------------------------------------------- */
    /**
     * @param FunctionalTester $I
     */
    public function deleteIngredienteNotAllowed(\FunctionalTester $I)
    {
        
        $I->wantTo("Check deleting an ingrediente is not allowed");
        
        $url = 'v1/ingrediente/delete';
        $I->sendDELETE(Url::to(['/v1/ingrediente/view', 'id' => 1], true));

        $I->seeResponseCodeIs(404);
        
    }

}