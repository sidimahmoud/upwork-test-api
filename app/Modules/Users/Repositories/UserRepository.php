<?php

namespace App\Modules\Users\Repositories;

use App\Modules\Users\Contracts\Repositories\UserRepository as UserRepositoryContract;
use League\Fractal\TransformerAbstract;
use App\Modules\Users\User;
use App\Modules\Users\Transformers\UserTransformer;
use App\Modules\BaseModule\Repositories\BaseRepository;

class UserRepository extends BaseRepository implements UserRepositoryContract
{
    /**
     * UserRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * @return TransformerAbstract
     */
    public function getTransformer(): TransformerAbstract
    {
        return new UserTransformer;
    }

    /**
     * @return string
     */
    public function getResourceKey(): string
    {
        return 'users';
    }
}
