<?php

namespace App\Http\Controllers\Api\Transformers;

use App\Users\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * @param Unit $user
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id' => $user->getId(),
            'username' => $user->getUsername(),
            'firstname' => $user->getFirstname(),
            'middlename' => $user->getMiddlename(),
            'lastname' => $user->getLastname(),
            'role' => $user->getRole(),
            'links' => ['uri' => '/user/' . $user->getId()]
        ];
    }
}
