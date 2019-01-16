<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "plato_ingrediente_cambio".
 *
 * @property int $id_plato id del plato afectado por el cambio
 * @property int $id_ingrediente id del ingrediente anadido o eliminado
 * @property int $orden_cambio num de orden del cambio para un plato concreto
 * @property string $fecha_cambio fecha y hora del cambio
 * @property int $accion Indica la accion realizada sobre el ingrediente del plato: 1-anadir al plato, 2-eliminar del plato
 *
 * @property Ingrediente $ingrediente
 * @property Plato $plato
 */
class PlatoIngredienteCambio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'plato_ingrediente_cambio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_plato', 'id_ingrediente', 'orden_cambio', 'accion'], 'required'],
            [['id_plato', 'id_ingrediente', 'orden_cambio', 'accion'], 'integer'],
            [['fecha_cambio'], 'safe'],
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
            'orden_cambio' => 'Orden Cambio',
            'fecha_cambio' => 'Fecha Cambio',
            'accion' => 'Accion',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function fields()
    {
        $fieldsAux = parent::fields();

        // Redefinir el campo 'accion'
        unset($fieldsAux['accion']);
        $fieldsAux['accion'] = function($model){
                                    if($model->accion == 1){
                                        return 'anadido';
                                    }else{
                                        return 'eliminado';
                                    }
                                };

        return $fieldsAux;

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
