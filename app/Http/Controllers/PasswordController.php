<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PasswordController extends Controller
{
    public function resetPassword($email) {
        $emailExist = User::where('email', $email)->get();

        if(count($emailExist) > 0) {
            return [
                "status" => Response::HTTP_ACCEPTED,
                "message" => "Si está mi pana" 
            ];
        } else {
            return [
                "status" => Response::HTTP_BAD_REQUEST,
                "message" => "El correo ingresado no se encuentra en nuestros registros." 
            ];
        }
    }
}
