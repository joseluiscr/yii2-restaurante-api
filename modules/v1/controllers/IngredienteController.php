<?php

namespace app\modules\v1\controllers;

use yii\rest\ActiveController;
use app\modules\v1\models\IngredienteModel;
use app\modules\v1\models\AlergenoModel;

class IngredienteController extends ActiveController
{
    public $modelClass = 'app\modules\v1\models\IngredienteModel';

    /* Declare actions supported by APIs */
    public function actions(){

        $actions = parent::actions();

        unset($actions['delete']);//No permitir la acción borrar Ingredientes

        return $actions;
    }

    /*
		Acción para añadir o quitar alérgenos a un ingrediente
    */
    public function actionModAlergenos($id){
        
    	$request = \Yii::$app->request;

        // Sólo se permite el método PUT para esta acción
        if (!$request->isPut) {
            throw new \yii\web\HttpException(405);
        }       

    	$listaAlergenos = $request->getBodyParam('alergenos');

    	if(!isset($listaAlergenos)){
    		throw new \yii\web\HttpException(400, 'The alergenos body param is mandatory');
    	}

    	// En la lista tenemos la lista completa de alergenos del ingrediente tras la modificación
    	$ingrediente = IngredienteModel::findOne($id);
    	$alergenosNuevos = AlergenoModel::findAll($listaAlergenos); // Array de objetos AlergenosModel

    	$ingrediente->modificarAlergenos($alergenosNuevos);

    	// Refrescar los datos para devolverlos
    	unset($ingrediente);
    	$ingrediente = IngredienteModel::findOne($id);

    	return $ingrediente->convertModelToArray(['alergenos']);
    	
    }

}