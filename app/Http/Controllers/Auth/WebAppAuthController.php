<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

/**
 * Handles the WebApp user authentication
 */
class WebAppAuthController extends Controller
{
    /**
     * Redirects the WebApp user to the VCC to get the oauth token
     */
    public static function redirect(){
        return Socialite::driver('vcc')->redirect();
    }

    /**
     * Authenticates the user and redirects the user back to the WebApp with the API token
     */
    public static function callback(Request $request){
        //create user if necessary
        $VCC_User = Socialite::driver('vcc')->stateless()->user();
        $Horizon_User = User::where(['id' => $VCC_User->id])->first();
        if(!$Horizon_User){
            $Horizon_User = User::create([
                'id' => $VCC_User->id,
            ]);
        }

        //refresh the vcc API token
        //$Horizon_User->latest_vcc_api_token = $VCC_User->accessTokenResponseBody["access_token"];
        $Horizon_User->save();

        Auth::login($Horizon_User);

        if(str_contains($request->server('HTTP_USER_AGENT'), "Horizon Desktop Client")){
            $response = [];
            $response["message"] = "OK";
            $response["token"] = $Horizon_User->createToken("Horizon Desktop Client")->plainTextToken;
            return $response;
        }

        //redirect back to the VTCManager WebApp
        return redirect(
            config("services.vtcm-web-app.redirect").
            "?token=".
            urlencode($Horizon_User->createToken("VTCManager WebApp")->plainTextToken));
    }
}
