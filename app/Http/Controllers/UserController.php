<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'title' => 'User',
            'users' => User::paginate(25),
        ];

        return view('pages.users.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'title' => 'User',
            'roles' => ['admin', 'pegawai']
        ];

        return view('pages.users.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {
        $data = $request->validated();
        if(!empty($request->user_foto)){
            $filename = $request->user_foto->store('photos', 'public');
            $data['user_foto'] = url('storage/' . $filename);
        }

        $user = new User($data);

        DB::beginTransaction();
        try{
            if(!$user->saveUser()){
                throw new Exception('Gagal menambahkan User!');
            }
            DB::commit();
            return to_route('user.index')->with('success', 'Berhasil menambahkan user!');
        }catch(Exception $e){
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $data = [
            'title' => 'User',
            'user'  => $user,
            'roles' => ['admin', 'pegawai'],
        ];

        return view('pages.users.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        if(!empty($request->user_foto)){
            $filename = $request->user_foto->store('photos', 'public');
            $data['user_foto'] = url('storage/' . $filename);
        }

        DB::beginTransaction();
        try{
            if(!$user->updateUser($data)){
                throw new Exception('Gagal menyimpan data!');
            }
            DB::commit();
            return to_route('user.index')->with('success', 'Berhasil menyimpan data user');
        }catch(Exception $e){
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        DB::beginTransaction();
        try{
            if($user->deleteUser()){
                throw new Exception('Gagal menghapus user!');
            }
            DB::commit();
            return to_route('user.index')->with('success', 'Berhasil menghapus data user');
        }catch(Exception $e){
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function search(Request $request){
        $search = "%$request->search%";
        $users = User::where('name', 'like', $search)->get();
        if (empty($users->toArray())) {
            $response = [
                'status'    => 404,
                'message'   => 'Data tidak ditemukan',
            ];
        } else {
            $response = [
                'status'    => 200,
                'data'      => $users,
            ];
        }

        return response($response);
    }

}
