<?php

namespace app\tests\fixtures;

use yii\test\ActiveFixture;

class PlatoIngredienteCambioFixture extends ActiveFixture
{
    public $modelClass = 'app\models\PlatoIngredienteCambio';
    public $depends = [
    	'app\tests\fixtures\IngredienteFixture',
		'app\tests\fixtures\PlatoFixture',
	];
}