<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    public function registration()
    {
        return view('auth.register');
    }

    public function register(UserRequest $request)
    {
        $formData = $request->validated();
        try{
            DB::beginTransaction();

            $user   =   User::create($formData);

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()]);
        }

        auth()->login($user);

        return response([
            'success' => true,'message'=>'User created successfully',
            'intended' => route('home'),
        ], 201);
    }
}
