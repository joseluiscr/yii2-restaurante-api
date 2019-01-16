<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "plato".
 *
 * @property int $id id unico del plato
 * @property string $nombre nombre del plato
 * @property string $descripcion texto libre aclaratorio
 *
 * @property PlatoIngrediente[] $platoIngredientes
 * @property Ingrediente[] $ingredientes
 * @property PlatoIngredienteCambio[] $platoIngredienteCambios
 */
class Plato extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'plato';
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
    public function getPlatoIngredientes()
    {
        return $this->hasMany(PlatoIngrediente::className(), ['id_plato' => 'id']);
    }
    */

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIngredientes()
    {
        return $this->hasMany(Ingrediente::className(), ['id' => 'id_ingrediente'])->viaTable('plato_ingrediente', ['id_plato' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlatoIngredienteCambios()
    {
        return $this->hasMany(PlatoIngredienteCambio::className(), ['id_plato' => 'id']);
    }

    /**
     * Devuelve los alérgenos de un plato
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlergenos()
    {
        return Alergeno::find()
            ->joinWith(['ingredientes', 'ingredientes.platos C'])
            ->where(['C.id' => $this->id])
            ->distinct();

    }

    /**
     * Recibe un ingredientes y lo elimina de la lista de ingredientes del plato
     * @param Ingrediente[] $ingr
     * @param int $version -> Identificador de la versión del plato a que pertenece este cambio:
     *                        todos los cambios hechos a la vez sobre este plato tienen el mismo
     *                        valor de este param
     */
    public function eliminarIngrPlato($ingr, $version)
    {

        $this->unlink('ingredientes', $ingr, true);

        //También registramos el cambio en el histórico
        $cambio = new PlatoIngredienteCambio();
        $cambio->id_plato = $this->id;
        $cambio->id_ingrediente = $ingr->id;
        $cambio->orden_cambio = $version;
        $cambio->accion = 2; // Ingrediente eliminado
        $cambio->save();

    }

    /**
     * Recibe un ingredientes y lo añade a la lista de ingredientes del plato
     * @param Ingrediente[] $ingr
     * @param int $version -> Identificador de la versión del plato a que pertenece este cambio:
     *                        todos los cambios hechos a la vez sobre este plato tienen el mismo
     *                        valor de este param
     */
    public function anadirIngrPlato($ingr, $version)
    {

        $this->link('ingredientes', $ingr);

        //También registramos el cambio en el histórico
        $cambio = new PlatoIngredienteCambio();
        $cambio->id_plato = $this->id;
        $cambio->id_ingrediente = $ingr->id;
        $cambio->orden_cambio = $version;
        $cambio->accion = 1; // Ingrediente añadido
        $cambio->save();

    }

    /**
     * Recibe una lista de ingredientes y la convierte en la lista de ingredientes del plato
     * @param Ingrediente[] $ingredientesNuevos 
     */
    public function modificarIngredientes($ingredientesNuevos)
    {
        // Hay que dejar un registro de cambios, por ello hay que saber lo que se elimina y lo que se añade

        // Determinar los ingredientes a eliminar y los ingredientes a añadir
        $ingredientesNuevos = ArrayHelper::toArray($ingredientesNuevos);
        $ingredientesAntiguos = ArrayHelper::toArray($this->ingredientes);

        $ingredientesNuevos = ArrayHelper::getColumn($ingredientesNuevos, 'id');
        $ingredientesAntiguos = ArrayHelper::getColumn($ingredientesAntiguos, 'id');

        // "Restar" a los antiguos, los nuevos => lo que quede es lo que se debe eliminar
        $aEliminar = array_diff($ingredientesAntiguos, $ingredientesNuevos);

        // "Restar" a los nuevos, los antiguos => lo que quede es lo que se debe añadir
        $aAnadir = array_diff($ingredientesNuevos, $ingredientesAntiguos);

        // Obtener la versión de los cambios a realizar (la última + 1)
        $version = PlatoIngredienteCambio::find()->where(['id_plato'=>$this->id])->max('orden_cambio');
        if(!isset($version)){
            $version = 0;
        }else{
            $version = $version + 1;
        }

        // Eliminar
        foreach ($aEliminar as $i){
            $ingr = Ingrediente::findOne($i);
            $this->eliminarIngrPlato($ingr, $version); 
        }

        // Añadir
        foreach ($aAnadir as $j){
            $ingr = Ingrediente::findOne($j);  
            $this->anadirIngrPlato($ingr, $version); 
        }

    }

}
