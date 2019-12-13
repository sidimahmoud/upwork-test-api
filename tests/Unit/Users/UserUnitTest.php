<?php

namespace Tests\Unit\Users;

use App\Modules\Users\Contracts\Repositories\UserRepository;
use App\Modules\Users\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Tests\TestCase;

class UserUnitTest extends TestCase
{
    const USERS_TABLE = 'users';

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * Setup the test
     */
    public function setUp()
    {
        parent::setUp();
        $this->userRepository = resolve(UserRepository::class);
    }

    /** @test */
    public function it_can_create_user()
    {
        $data = factory(User::class)->make()->toArray();
        $user = $this->userRepository->create($data);
        $this->assertInstanceOf(User::class, $user);
        $this->assertDatabaseHas(self::USERS_TABLE, $data);
    }

    /** @test */
    public function it_can_find_user_by_id()
    {
        $user = factory(User::class)->create();
        factory(User::class)->create();
        $_user = $this->userRepository->findById($user->id);
        $this->assertInstanceOf(User::class, $_user);
        $this->assertEquals($user->id, $_user->id);
    }

    /** @test */
    public function it_can_find_users()
    {
        $user = factory(User::class)->create();
        $users = $this->userRepository->get();
        $this->assertInstanceOf(Collection::class, $users);
        $this->assertCount(1, $users);
        $users->each(function ($_user) use ($user) {
            $this->assertInstanceOf(User::class, $_user);
            $this->assertEquals($user->id, $_user->id);
        });
    }

    /** @test */
    public function it_can_paginate_users()
    {
        $user = factory(User::class)->create();
        $users = $this->userRepository->paginate();
        $this->assertInstanceOf(LengthAwarePaginator::class, $users);
        $this->assertCount(1, $users->items());
        collect($users->items())->each(function ($_user) use ($user) {
            $this->assertInstanceOf(User::class, $_user);
            $this->assertEquals($user->id, $_user->id);
        });
    }

    /** @test */
    public function it_can_update_the_user()
    {
        $user = factory(User::class)->create();
        $data = factory(User::class)->make()->toArray();
        $this->userRepository->setModel($user);
        $this->userRepository->update($data);
        $this->assertDatabaseHas(self::USERS_TABLE, array_merge($data, [
            'id' => $user->id
        ]));
    }

    /** @test */
    public function it_can_delete_the_user()
    {
        $user = factory(User::class)->create();
        $_user = factory(User::class)->create();
        $this->userRepository->setModel($user);
        $this->userRepository->delete();
        $this->assertDatabaseMissing(self::USERS_TABLE, [
            'id' => $user->id
        ]);
        $this->assertDatabaseHas(self::USERS_TABLE, [
            'id' => $_user->id
        ]);
    }
}
