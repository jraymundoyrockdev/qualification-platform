<?php

namespace App\Http\Controllers\Api\Transformers;

use App\Modules\Assessor\Assessor;
use League\Fractal\TransformerAbstract;

class AssessorTransformer extends TransformerAbstract
{
    /**
     * @param Assessor $assessor
     *
     * @return array
     */
    public function transform(Assessor $assessor)
    {
        return [
            'id' => $assessor->getId(),
            'name' => $assessor->getName(),
            'email' => $assessor->getEmail(),
            'mobile' => $assessor->getMobile(),
            'notes' => $assessor->getNotes(),
            'type' => $assessor->getType(),
            'links' => ['uri' => '/assessor/' . $assessor->getId()]
        ];
    }
}
