<?php

namespace App\Http\Controllers\Api\Transformers;

use App\Modules\Unit\Unit;
use League\Fractal\TransformerAbstract;

class UnitTransformer extends TransformerAbstract
{
    /**
     * @param Unit $unit
     *
     * @return array
     */
    public function transform(Unit $unit)
    {
        return [
            'id' => $unit->getId(),
            'code' => $unit->getCode(),
            'title' => $unit->getTitle(),
            'group_name' => $unit->getGroupName(),
            'subgroup' => $unit->getSubGroup(),
            'links' => ['uri' => '/unit/' . $unit->getId()]
        ];
    }
}
