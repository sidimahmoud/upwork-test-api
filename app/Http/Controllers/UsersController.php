<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Users\Contracts\Repositories\UserRepository;
use App\Modules\Users\User;
class UsersController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * UsersController constructor.
     *
     * @param UserRepository $userRepository
     * @param Request $request
     */
    public function __construct(UserRepository $userRepository,Request $request) {
        $this->userRepository = $userRepository->withQueryBuilder();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->has('all')) {
            $users = $this->userRepository->get();
        } else {
            $users = $this->userRepository->paginate();
        }
        $data = $this->userRepository->transformCollection($users);
        return response()->json($data);
    }
}
