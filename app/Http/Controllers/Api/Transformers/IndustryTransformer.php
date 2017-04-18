<?php

namespace App\Http\Controllers\Api\Transformers;

use App\Modules\Industry\Industry;
use League\Fractal\TransformerAbstract;

class IndustryTransformer extends TransformerAbstract
{
    /**
     * @param Industry $industry
     *
     * @return array
     */
    public function transform(Industry $industry)
    {
        return [
            'id' => $industry->getId(),
            'code' => $industry->getCode(),
            'title' => $industry->getTitle(),
            'description' => $industry->getDescription(),
            'parent_code' => $industry->getParentCode(),
            'active' => $industry->getActive(),
            'links' => ['uri' => '/industry/' . $industry->getId()]
        ];
    }
}
