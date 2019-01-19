<?php

namespace app\tests\fixtures;

use yii\test\ActiveFixture;

class PlatoIngredienteFixture extends ActiveFixture
{
    public $modelClass = 'app\models\PlatoIngrediente';
    public $depends = [
    	'app\tests\fixtures\IngredienteFixture',
		'app\tests\fixtures\PlatoFixture',
	];
}