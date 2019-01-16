<?php

namespace app\modules\v1\controllers;

use yii\rest\ActiveController;

class AlergenoController extends ActiveController
{
    public $modelClass = 'app\modules\v1\models\AlergenoModel';

    /* Declare actions supported by APIs */
    public function actions(){

        $actions = parent::actions();

        unset($actions['delete']);//No permitir la acción borrar Alergenos

        return $actions;
    }

}