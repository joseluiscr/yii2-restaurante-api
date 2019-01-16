<?php

namespace app\modules\v1\controllers;

use yii\rest\ActiveController;
use app\modules\v1\models\IngredienteModel;
use app\modules\v1\models\PlatoModel;

class PlatoController extends ActiveController
{
    public $modelClass = 'app\modules\v1\models\PlatoModel';

    /* Declare actions supported by APIs */
    public function actions(){

        $actions = parent::actions();

        unset($actions['delete']);//No permitir la acción borrar Platos

        return $actions;
    }

    /*
		Acción para añadir o quitar ingredientes a un plato
    */
    public function actionModIngredientes($id){
        
    	$request = \Yii::$app->request;

        // Sólo se permite el método PUT para esta acción
        if (!$request->isPut) {
            throw new \yii\web\HttpException(405);
        }  

    	$listaIngredientes = $request->getBodyParam('ingredientes');

    	if(!isset($listaIngredientes)){
    		throw new \yii\web\HttpException(400, 'The ingredientes body param is mandatory');
    	}

    	// En la lista tenemos la lista completa de ingredientes del plato tras la modificación
    	$plato = PlatoModel::findOne($id);
    	$ingredientesNuevos = IngredienteModel::findAll($listaIngredientes); // Array de objetos IngredienteModel

    	// Modificar la lista de ingredientes
    	$plato->modificarIngredientes($ingredientesNuevos);

    	// Refrescar los datos para devolverlos
    	unset($plato);
    	$plato = PlatoModel::findOne($id);

    	return $plato->convertModelToArray(['ingredientes']);

    }

}