<?php

namespace App\Http\Controllers\Api\Transformers;

use App\Modules\RTO\RTO;
use League\Fractal\TransformerAbstract;

class RTOTransformer extends TransformerAbstract
{
    public function transform(RTO $rto)
    {
        return [
            'id' => $rto->getId(),
            'code' => $rto->getCode(),
            'name' => $rto->getName(),
            'email' => $rto->getEmail(),
            'signed' => $rto->getSigned(),
            'rating_price' => $rto->getRatingPrice(),
            'rating_speed' => $rto->getRatingSpeed(),
            'rating_efficiency' => $rto->getRatingEfficiency(),
            'rating_professionalism' => $rto->getRatingProfessionalism(),
            'user_comments' => $rto->getUserComments(),
            'hidden' => $rto->getHidden(),
            'phone' => $rto->getPhone(),
            'website' => $rto->getWebsite(),
            'contact' => $rto->getContact(),
            'form' => $rto->getForm(),
            'links' => ['uri' => '/rto/' . $rto->getId()]
        ];
    }
}
