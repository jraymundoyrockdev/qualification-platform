<?php

namespace App\Http\Controllers\Api\Transformers;

use App\Modules\Occupation\Occupation;
use League\Fractal\TransformerAbstract;

class OccupationTransformer extends TransformerAbstract
{
    /**
     * @param Occupation $occupation
     *
     * @return array
     */
    public function transform(Occupation $occupation)
    {
        return [
            'id' => $occupation->getId(),
            'code' => $occupation->getCode(),
            'title' => $occupation->getTitle(),
            'description' => $occupation->getDescription(),
            'active' => $occupation->getActive(),
            'links' => ['uri' => '/occupation/' . $occupation->getId()]
        ];
    }
}
