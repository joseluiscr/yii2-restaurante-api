<?php

use app\models\PlatoIngredienteCambio;
use app\models\PlatoIngrediente;
use app\models\IngrAlergeno;
use app\models\Plato;
use app\models\Ingrediente;
use app\models\Alergeno;
use yii\helpers\Url;

/**
 * AlergenoController API functional test.
 *
 */
class AlergenoV1Cest
{
    /**
     * @param FunctionalTester $I
     */
    public function _before(\FunctionalTester $I)
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
        $I->haveRecord($clase, array('id' => 1, 'nombre' => 'alergeno1',
                                                'descripcion' => 'Este es el alergeno 1'
                                ));
        $I->haveRecord($clase, array('id' => 2, 'nombre' => 'alergeno2',
                                                'descripcion' => 'Este es el alergeno 2'
                                ));
        $I->haveRecord($clase, array('id' => 3, 'nombre' => 'alergeno3',
                                                'descripcion' => 'Este es el alergeno 3'
                                ));
        $I->haveRecord($clase, array('id' => 4, 'nombre' => 'alergeno4',
                                                'descripcion' => 'Este es el alergeno 4'
                                ));
        $I->haveRecord($clase, array('id' => 5, 'nombre' => 'alergeno5',
                                                'descripcion' => 'Este es el alergeno 5'
                                ));
        $clase = 'app\models\Ingrediente';
        $I->haveRecord($clase, array('id' => 1, 'nombre' => 'ingrediente1',
                                                'descripcion' => 'Este es el ingrediente 1'
                                ));
        $I->haveRecord($clase, array('id' => 2, 'nombre' => 'ingrediente2',
                                                'descripcion' => 'Este es el ingrediente 2'
                                ));
        $I->haveRecord($clase, array('id' => 3, 'nombre' => 'ingrediente3',
                                                'descripcion' => 'Este es el ingrediente 3'
                                ));
        $I->haveRecord($clase, array('id' => 4, 'nombre' => 'ingrediente4',
                                                'descripcion' => 'Este es el ingrediente 4'
                                ));
        $I->haveRecord($clase, array('id' => 5, 'nombre' => 'ingrediente5',
                                                'descripcion' => 'Este es el ingrediente 5'
                                ));
        $clase = 'app\models\Plato';
        $I->haveRecord($clase, array('id' => 1, 'nombre' => 'plato1',
                                                'descripcion' => 'Este es el plato 1'
                                ));
        $I->haveRecord($clase, array('id' => 2, 'nombre' => 'plato2',
                                                'descripcion' => 'Este es el plato 2'
                                ));
        $I->haveRecord($clase, array('id' => 3, 'nombre' => 'plato3',
                                                'descripcion' => 'Este es el plato 3'
                                ));
        $clase = 'app\models\IngrAlergeno';
        $I->haveRecord($clase, array('id_ingrediente' => 1, 'id_alergeno' => 3));
        $I->haveRecord($clase, array('id_ingrediente' => 1, 'id_alergeno' => 4));
        $I->haveRecord($clase, array('id_ingrediente' => 2, 'id_alergeno' => 1));
        $I->haveRecord($clase, array('id_ingrediente' => 2, 'id_alergeno' => 2));
        $I->haveRecord($clase, array('id_ingrediente' => 3, 'id_alergeno' => 1));
        $I->haveRecord($clase, array('id_ingrediente' => 3, 'id_alergeno' => 3));
        $I->haveRecord($clase, array('id_ingrediente' => 3, 'id_alergeno' => 4));
        $I->haveRecord($clase, array('id_ingrediente' => 5, 'id_alergeno' => 4));
        $clase = 'app\models\PlatoIngrediente';
        $I->haveRecord($clase, array('id_plato' => 1, 'id_ingrediente' => 1));
        $I->haveRecord($clase, array('id_plato' => 1, 'id_ingrediente' => 2));
        $I->haveRecord($clase, array('id_plato' => 1, 'id_ingrediente' => 3));
        $I->haveRecord($clase, array('id_plato' => 2, 'id_ingrediente' => 3));
        $I->haveRecord($clase, array('id_plato' => 2, 'id_ingrediente' => 1));
        $I->haveRecord($clase, array('id_plato' => 3, 'id_ingrediente' => 2));
        $I->haveRecord($clase, array('id_plato' => 3, 'id_ingrediente' => 5));

        $clase = 'app\models\PlatoIngredienteCambio';
        $I->haveRecord($clase, array('id_plato' => 1, 'id_ingrediente' => 2, 'orden_cambio' => 0, 'accion' => 1));
        $I->haveRecord($clase, array('id_plato' => 1, 'id_ingrediente' => 3, 'orden_cambio' => 0, 'accion' => 1));
        $I->haveRecord($clase, array('id_plato' => 1, 'id_ingrediente' => 4, 'orden_cambio' => 0, 'accion' => 1));
        $I->haveRecord($clase, array('id_plato' => 1, 'id_ingrediente' => 4, 'orden_cambio' => 1, 'accion' => 2));// Quitar el 4
        $I->haveRecord($clase, array('id_plato' => 1, 'id_ingrediente' => 1, 'orden_cambio' => 1, 'accion' => 1));// Añadir el 1

        $I->haveRecord($clase, array('id_plato' => 2, 'id_ingrediente' => 3, 'orden_cambio' => 0, 'accion' => 1));
        $I->haveRecord($clase, array('id_plato' => 2, 'id_ingrediente' => 1, 'orden_cambio' => 0, 'accion' => 1));

        $I->haveRecord($clase, array('id_plato' => 3, 'id_ingrediente' => 1, 'orden_cambio' => 0, 'accion' => 1));
        $I->haveRecord($clase, array('id_plato' => 3, 'id_ingrediente' => 5, 'orden_cambio' => 0, 'accion' => 1));
        $I->haveRecord($clase, array('id_plato' => 3, 'id_ingrediente' => 1, 'orden_cambio' => 1, 'accion' => 2));// Quitar el 1
        $I->haveRecord($clase, array('id_plato' => 3, 'id_ingrediente' => 2, 'orden_cambio' => 1, 'accion' => 1));// Añadir el 2

    }

    /**
     * @param FunctionalTester $I
     */
    public function _after(\FunctionalTester $I)
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
