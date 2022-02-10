<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return UserCollection
     *
     * @OA\Get(
     *     path="/api/users",
     *     tags={"users"},
     *     summary="Returns paginated user",
     *     description="This can only be done by the logged in user.",
     *     operationId="createUser",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     *
     * )
     */

    public function index()
    {
        return  new UserCollection(
            User::with(['posts' =>
            fn($q) => $q->paginate(10) ]
        )->paginate(10)

    );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
*/
    /**
     * @OA\Post(path="/api/users",
     *     tags={"users"},
     *     summary="Creates a user",
     *     description="",
     *     operationId="store",
     *     @OA\RequestBody(
     *         description="user object",
     *         required=true,
     *      @OA\JsonContent(ref="#/components/schemas/User"),
     *
     *
     *     ),
     *
     *     @OA\Response(response="default", description="successful operation")
     * )
     */
    public function store(Request $request)
    {

         $user = new User();
         $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password ?? 'password');
        $user->save();
        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  User  $user
     * @return UserCollection
     */
    public function show(User $user)
    {
      //  return $user;
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Patch(path="/api/users/{id}",
     *     tags={"users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of User that needs to be updated",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     summary="Patches a user",
     *     description="",
     *     operationId="update",
     *     @OA\RequestBody(
     *         description="User object",
     *         required=true,
     *      @OA\JsonContent(ref="#/components/schemas/User"),
     *
     *
     *     ),
     *
     *     @OA\Response(response="default", description="successful operation")
     * )
     */
    public function update(Request $request, User $user)
    {
        $user->fill($request->only('name','email','password'));
        $user->save();
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Delete(path="/api/users/{id}",
     *     tags={"users"},
     *     summary="Deletes a user",
     *     description="",
     *     operationId="delete",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of User that needs to be deleted",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *
     *     @OA\Response(response="default", description="successful operation")
     * )
     */
    public function destroy(User $user)
    {
        return $user->delete();
    }
}
