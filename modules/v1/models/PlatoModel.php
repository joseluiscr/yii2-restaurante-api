<?php

namespace app\modules\v1\models;

use Yii;
use app\models\Plato;

use yii\web\Link; // represents a link object as defined in JSON Hypermedia API Language.
use yii\web\Linkable;
use yii\helpers\Url;

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
class PlatoModel extends Plato
                 implements Linkable // Para que muestre los links [getLinks()]
{

	/**
     * Devuelve un array con los campos que la API devolverá sólo si se piden explícitamente
     *
     * {@inheritdoc}
     */
    public function extraFields()
    {
        $fieldsAux = parent::extraFields();

        // Añadir la lista de ingredientes
        $fieldsAux[] = 'ingredientes';

        // Añadir la lista de alérgenos
        $fieldsAux['alergenos'] = function($model){
                                    return $model->getAlergenos()->all();
                                };

        // Añadir la lista de cambios de ingredientes
        $fieldsAux['platoingredientecambios'] = function($model){
                                    return $model->getPlatoIngredienteCambios()->all();
                                };

        return $fieldsAux;

    } 

    /**
     * Convierte un objeto en un array, incluidas sus relaciones
     * @param string[] $relaciones 
     */
    public function convertModelToArray($relaciones) {

        $result = $this->attributes;

        foreach($relaciones as $relacion){
            if ($relacion == 'alergenos') {
                $result = array_merge($result, ['alergenos' => $this->alergenos]);
            }
            if ($relacion == 'ingredientes') {
                $result = array_merge($result, ['ingredientes' => $this->ingredientes]);
            }

        }

        return $result;

    }

     /**
     * Devuelve los links relacionados con el objeto
     *
     * {@inheritdoc}
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['plato/view', 'id' => $this->id], true),
            'alergenos' => Url::to(['plato/view', 'id' => $this->id, 'expand' => 'alergenos'], true),
            'ingredientes' => Url::to(['plato/view', 'id' => $this->id, 'expand' => 'ingredientes'], true),
            'cambios-ingredientes' => Url::to(['plato/view', 'id' => $this->id, 'expand' => 'platoingredientecambios'], true),
            'edit' => Url::to(['plato/view', 'id' => $this->id], true),
            'edit-ingredientes' => Url::to(['plato/mod-ingredientes', 'id' => $this->id], true),
            'index' => Url::to(['plato/index'], true),
        ];
    }

}