<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ingrediente".
 *
 * @property int $id id unico del ingrediente
 * @property string $nombre nombre del ingrediente
 * @property string $descripcion texto libre aclaratorio
 *
 * @property IngrAlergeno[] $ingrAlergenos
 * @property Alergeno[] $alergenos
 * @property PlatoIngrediente[] $platoIngredientes
 * @property Plato[] $platos
 * @property PlatoIngredienteCambio[] $platoIngredienteCambios
 */
class Ingrediente extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ingrediente';
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
        return $this->hasMany(IngrAlergeno::className(), ['id_ingrediente' => 'id']);
    }
    */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlergenos()
    {
        return $this->hasMany(Alergeno::className(), ['id' => 'id_alergeno'])->viaTable('ingr_alergeno', ['id_ingrediente' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlatoIngredientes()
    {
        return $this->hasMany(PlatoIngrediente::className(), ['id_ingrediente' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlatos()
    {
        return $this->hasMany(Plato::className(), ['id' => 'id_plato'])->viaTable('plato_ingrediente', ['id_ingrediente' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlatoIngredienteCambios()
    {
        return $this->hasMany(PlatoIngredienteCambio::className(), ['id_ingrediente' => 'id']);
    }

    /**
     * Recibe una lista de alérgenos y la convierte en la lista de alérgenos del ingrediente
     * @param Alergeno[] $alergenosNuevos 
     */
    public function modificarAlergenos($alergenosNuevos)
    {
        //Eliminar la lista actual de alérgenos
        $this->unlinkAll('alergenos', true);

        //Añadir la lista nueva
        foreach ($alergenosNuevos as $alergeno){
            $this->link('alergenos', $alergeno);
        }

    }

}
