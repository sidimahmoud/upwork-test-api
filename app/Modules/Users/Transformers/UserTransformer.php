<?php

namespace App\Modules\Users\Transformers;

use App\Modules\Users\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * Transform model
     *
     * @param User $user
     * @return array
     */
    public function transform(User $user)
    {
        return $user->toArray();
    }
}
