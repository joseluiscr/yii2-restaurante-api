<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ingr_alergeno".
 *
 * @property int $id_ingrediente id del ingrediente
 * @property int $id_alergeno id del alergeno
 *
 * @property Alergeno $alergeno
 * @property Ingrediente $ingrediente
 */
class IngrAlergeno extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ingr_alergeno';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_ingrediente', 'id_alergeno'], 'required'],
            [['id_ingrediente', 'id_alergeno'], 'integer'],
            [['id_ingrediente', 'id_alergeno'], 'unique', 'targetAttribute' => ['id_ingrediente', 'id_alergeno']],
            [['id_alergeno'], 'exist', 'skipOnError' => true, 'targetClass' => Alergeno::className(), 'targetAttribute' => ['id_alergeno' => 'id']],
            [['id_ingrediente'], 'exist', 'skipOnError' => true, 'targetClass' => Ingrediente::className(), 'targetAttribute' => ['id_ingrediente' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_ingrediente' => 'Id Ingrediente',
            'id_alergeno' => 'Id Alergeno',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlergeno()
    {
        return $this->hasOne(Alergeno::className(), ['id' => 'id_alergeno']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIngrediente()
    {
        return $this->hasOne(Ingrediente::className(), ['id' => 'id_ingrediente']);
    }
}
