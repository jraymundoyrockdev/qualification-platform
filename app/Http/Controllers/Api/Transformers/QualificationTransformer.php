<?php

namespace App\Http\Controllers\Api\Transformers;

use App\Modules\Qualification\Qualification;
use League\Fractal\TransformerAbstract;

class QualificationTransformer extends TransformerAbstract
{
    /**
     * @param Qualification $qualification
     *
     * @return array
     */
    public function transform(Qualification $qualification)
    {
        return [
            'id' => $qualification->getId(),
            'code' => $qualification->getCode(),
            'title' => $qualification->getTitle(),
            'description' => $qualification->getDescription(),
            'subject_information' => $qualification->getSubjectInformation(),
            'currency_status' => $qualification->getCurrencyStatus(),
            'links' => ['uri' => '/qualification/' . $qualification->getId()]
        ];
    }
}
