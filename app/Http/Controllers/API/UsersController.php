<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CreateUserRequest;
use App\Http\Requests\API\UpdateUserRequest;
use App\Http\Resources\API\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->registerMiddlewares();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return UserResource::collection(User::query()->simplePaginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request): UserResource
    {
        return new UserResource(User::query()->create(array_merge(
            $request->all(),
            ['password' => \bcrypt($request->get('password'))]
        )));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): UserResource
    {
        return new UserResource(\tap($user)->update(array_merge(
            $request->all(),
            ['password' => \bcrypt($request->get('password'))]
        )));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();

        return response()->json(['message' => 'ok']);
    }

    private function registerMiddlewares(): void
    {
        $this->middleware(['auth:api', 'scope:create_user'])
            ->only('store');
        $this->middleware(['client:list_users'])
            ->only('index');
        $this->middleware(['client:show_user'])
            ->only('show');
        $this->middleware(['auth:api', 'scope:update_user'])
            ->only('update');
        $this->middleware(['auth:api', 'scope:delete_user'])
            ->only('destroy');
    }
}
