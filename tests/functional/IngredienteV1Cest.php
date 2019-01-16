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
class IngredienteV1Cest
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
        
        $I->wantTo("Update an ingrediente");
        
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
    /*
    public function cleanIngredienteAlergenos(\FunctionalTester $I)
    {
        
        $I->wantTo("Clean an ingrediente's alergenos");
        
        $I->sendPUT(Url::to(['/v1/ingrediente/mod-alergenos', 'id' => 1], true), [
                'alergenos' => [[]
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
    */

    /* Delete action
    --------------------------------------------------------------- */
    /**
     * @param FunctionalTester $I
     */
    public function deleteIngredienteNotAllowed(\FunctionalTester $I)
    {
        
        $I->wantTo("Check deleting an ingrediente is not allowed");
        
        $url = 'v1/ingrediente/delete';
        $I->sendDELETE(Url::to(['/v1/ingrediente/view', 'id' => 36], true));

        $I->seeResponseCodeIs(404);
        
    }

}