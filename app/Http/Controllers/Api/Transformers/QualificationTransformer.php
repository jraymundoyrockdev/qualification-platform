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
            'packaging_rules' => $qualification->getPackagingRules(),
            'currency_status' => $qualification->getCurrencyStatus(),
            'status' => 'active',
            'aqf_level' => $qualification->getAqfLevel(),
            'online_learning_status' => 'active',
            'rpl_status' => 'active',
            'expiration_date' => $qualification->getExpirationDate(),
            'created_by' => $qualification->getCreatedBy(),
            'links' => ['uri' => '/qualification/' . $qualification->getId()]
        ];
    }
}
