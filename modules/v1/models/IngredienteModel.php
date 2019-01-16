<?php

namespace app\modules\v1\models;

use Yii;
use app\models\Ingrediente;

use yii\web\Link; // represents a link object as defined in JSON Hypermedia API Language.
use yii\web\Linkable;
use yii\helpers\Url;

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
class IngredienteModel extends Ingrediente
                       implements Linkable // Para que muestre los links [getLinks()]
{

    /**
     * Devuelve un array con los campos que la API devolverá sólo si se piden explícitamente
     *
     * {@inheritdoc}
     */
    public function extraFields()
    {
        return ['alergenos',
                'platos',
            ];
    } 

    /**
     * Convierte un objeto en un array, incluidas sus relaciones
     * @param string[] $relaciones
     * @return array[]
     */
    public function convertModelToArray($relaciones) {

        $result = $this->attributes;

        foreach($relaciones as $relacion){
            if ($relacion == 'alergenos') {
                $result = array_merge($result, ['alergenos' => $this->alergenos]);
            }
            if ($relacion == 'platos') {
                $result = array_merge($result, ['platos' => $this->platos]);
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
            Link::REL_SELF => Url::to(['ingrediente/view', 'id' => $this->id], true),
            'alergenos' => Url::to(['ingrediente/view', 'id' => $this->id, 'expand' => 'alergenos'], true),
            'platos' => Url::to(['ingrediente/view', 'id' => $this->id, 'expand' => 'platos'], true),
            'edit' => Url::to(['ingrediente/view', 'id' => $this->id], true),
            'edit-alergenos' => Url::to(['ingrediente/mod-alergenos', 'id' => $this->id], true),
            'index' => Url::to(['ingrediente/index'], true),
        ];
    }

}
