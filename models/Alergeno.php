<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "alergeno".
 *
 * @property int $id id unico del alergeno
 * @property string $nombre nombre del alergeno
 * @property string $descripcion texto libre aclaratorio
 *
 * @property IngrAlergeno[] $ingrAlergenos
 * @property Ingrediente[] $ingredientes
 */
class Alergeno extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'alergeno';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 30],
            [['descripcion'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    /*
    public function getIngrAlergenos()
    {
        return $this->hasMany(IngrAlergeno::className(), ['id_alergeno' => 'id']);
    }
    */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIngredientes()
    {
        return $this->hasMany(Ingrediente::className(), ['id' => 'id_ingrediente'])->viaTable('ingr_alergeno', ['id_alergeno' => 'id']);
    }

    /**
     * Devuelve los platos que contienen un alérgeno
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPlatos()
    {
        return Plato::find()
            ->joinWith(['ingredientes', 'ingredientes.alergenos C'])
            ->where(['C.id' => $this->id])
            ->distinct();

    }

}
