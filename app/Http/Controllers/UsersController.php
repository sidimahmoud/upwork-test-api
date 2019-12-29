<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Modules\Users\Contracts\Repositories\UserRepository;
use App\Modules\Users\User;
use App\Modules\Users\Requests\UserRequest;
use App\Http\Controllers\Traits\FileUploadTrait;
class UsersController extends Controller
{
    use FileUploadTrait;
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
    public function index(){

        if (request()->has('all')) {
            $users = $this->userRepository->get();
        } else {
            $users = $this->userRepository->paginate();
        }
        $data = $this->userRepository->transformCollection($users);
        return response()->json($data);
    }
    /**
     * Store a newly created user.
     *
     * @param UserRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request){
      $data = $request->all();
      dd($data);
      $imageName = time().'.'.$request->file('user_image')->getClientOriginalExtension();
      $data['user_image']=$imageName;
      $request->file('user_image')->move(public_path('uploads'), $imageName);
      $user = $this->userRepository->create($data);
      $this->userRepository->setModel($user);
      $data = $this->userRepository->transformItem();
      return response()->json($data, 201);
    }
}
