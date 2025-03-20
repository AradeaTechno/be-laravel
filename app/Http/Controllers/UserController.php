<?php

namespace App\Http\Controllers;

use App\Helpers\RequestHelper;
use App\Helpers\ResponseHelper;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function getAll(Request $request){
        $perPage = $request->query('per_page', 10);
        $users = User::paginate($perPage);
        return ResponseHelper::create(200, $users);
    }

    public function getById($id){
        $user = User::find($id);
        if(!$user) return ResponseHelper::create(404);
        return ResponseHelper::create(200, $user);
    }

}
