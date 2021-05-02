<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\AuthRedirectRequest;

use App\Events\UserAuthorized;

/**
 * Handles the WebApp user authentication
 */
class VCCAuthController extends Controller
{
    /**
     * Redirects the WebApp user to the VCC to get the oauth token
     */
    public static function redirect(AuthRedirectRequest $request){
        $validatedRequest = $request->validated();
        setcookie('authWebsocketID', $validatedRequest["socketID"], 20, '/');
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
        dd(Cookie::get('authWebsocketID'));
        if($_COOKIE["authWebsocketID"])
            $websocketID = $_COOKIE["authWebsocketID"];
        setcookie('authWebsocketID', null); // delete cookie
        if($websocketID == null)
            return response("An error occurred: WS_ID_MISSING_IN_COOKIE", 400);

        UserAuthorized::dispatch($Horizon_User, $websocketID);

        return response("", 204);

        //redirect back to the VTCManager WebApp
        return redirect(
            config("services.vtcm-web-app.redirect").
            "?token=".
            urlencode($Horizon_User->createToken("VTCManager WebApp")->plainTextToken));
    }
}
