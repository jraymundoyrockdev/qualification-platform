<?php
namespace App\Http\Controllers\Api\Transformers;

use App\Modules\Package\Package;
use League\Fractal\TransformerAbstract;

class PackageTransformer extends TransformerAbstract
{
    /**
     * @param Package $package
     *
     * @return array
     */
    public function transform(Package $package)
    {
        return [
            'id' => $package->getId(),
            'code' => $package->getCode(),
            'title' => $package->getTitle(),
            'status' => $package->getStatus(),
            'links' => ['uri' => '/package/' . $package->getId()]
        ];
    }
}
