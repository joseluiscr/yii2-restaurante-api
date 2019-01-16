<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "plato_ingrediente".
 *
 * @property int $id_plato id del plato
 * @property int $id_ingrediente id del ingrediente
 *
 * @property Ingrediente $ingrediente
 * @property Plato $plato
 */
class PlatoIngrediente extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'plato_ingrediente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_plato', 'id_ingrediente'], 'required'],
            [['id_plato', 'id_ingrediente'], 'integer'],
            [['id_plato', 'id_ingrediente'], 'unique', 'targetAttribute' => ['id_plato', 'id_ingrediente']],
            [['id_ingrediente'], 'exist', 'skipOnError' => true, 'targetClass' => Ingrediente::className(), 'targetAttribute' => ['id_ingrediente' => 'id']],
            [['id_plato'], 'exist', 'skipOnError' => true, 'targetClass' => Plato::className(), 'targetAttribute' => ['id_plato' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_plato' => 'Id Plato',
            'id_ingrediente' => 'Id Ingrediente',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIngrediente()
    {
        return $this->hasOne(Ingrediente::className(), ['id' => 'id_ingrediente']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlato()
    {
        return $this->hasOne(Plato::className(), ['id' => 'id_plato']);
    }
}
