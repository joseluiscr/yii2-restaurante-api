<?php

namespace app\modules\v1\models;

use Yii;
use app\models\Alergeno;

use yii\web\Link; // represents a link object as defined in JSON Hypermedia API Language.
use yii\web\Linkable;
use yii\helpers\Url;

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
class AlergenoModel extends Alergeno
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

        // Añadir la lista de platos
        $fieldsAux['platos'] = function($model){
                                    return $model->getPlatos()->all();
                                };         

        return $fieldsAux;

    }

    /**
     * Devuelve los links relacionados con el objeto
     *
     * {@inheritdoc}
     */
    public function getLinks()
    {
        return [
            Link::REL_SELF => Url::to(['alergeno/view', 'id' => $this->id], true),
            'platos' => Url::to(['alergeno/view', 'id' => $this->id, 'expand' => 'platos'], true),
            'edit' => Url::to(['alergeno/view', 'id' => $this->id], true),
            'index' => Url::to(['alergeno/index'], true),
        ];
    }

}
