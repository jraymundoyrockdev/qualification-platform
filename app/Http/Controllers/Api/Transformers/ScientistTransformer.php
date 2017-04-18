<?php

namespace App\Http\Controllers\Api\Transformers;

use App\Modules\Scientist\Scientist;
use App\Modules\Theory\Theory;
use League\Fractal\TransformerAbstract;
use Illuminate\Support\Facades\Request;

class ScientistTransformer extends TransformerAbstract
{
    public function transform(Scientist $scientist)
    {
        return [
            'id' => $scientist->getId(),
            'firstName' => $scientist->getFirstname(),
            'lastName' => $scientist->getLastname(),
            'links' => ['uri' => '/scientist/' . $scientist->getId()],
            'relationships' => [
                'theory' => [
                    'data' => $this->collectTheories($scientist->getTheory())
                ]
            ]
        ];
    }

    /**
     * @param Theory $theories
     *
     * @return array
     */
    private function collectTheories($theories)
    {
        $collectedTheories = [];

        foreach ($theories as $theory) {
            $collectedTheories[] = [
                'id' => $theory->getId(),
                'title' => $theory->getTitle()
            ];
        }

        return $collectedTheories;
    }
}
