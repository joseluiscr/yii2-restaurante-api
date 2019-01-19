<?php

namespace app\tests\fixtures;

use yii\test\ActiveFixture;

class IngrAlergenoFixture extends ActiveFixture
{
    public $modelClass = 'app\models\IngrAlergeno';
    public $depends = [
    	'app\tests\fixtures\AlergenoFixture',
		'app\tests\fixtures\IngredienteFixture',
	];
}
