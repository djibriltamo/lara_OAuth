<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Jetstream\Events\AddingTeam;
use Laravel\Socialite\Facades\Socialite;

class GithubController extends Controller
{
    CONST DRIVER_TYPE = 'github';

    public function handleGithubRedirect()
    {
        return Socialite::driver(static::DRIVER_TYPE)->redirect();
    }

    public function handleGithubCallback()
    {
        try {
            $user = Socialite::driver(static::DRIVER_TYPE)->stateless()->user();
            
            $userExisted = User::where('oauth_id', $user->getId())->where('oauth_type', static::DRIVER_TYPE)->first();

            if ($userExisted) {

                Auth::login($userExisted);

                return redirect()->route('dashboard');
            }else{
                
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'oauth_id' => $user->id,
                    'oauth_type' => static::DRIVER_TYPE,
                    'password' => Hash::make($user->id),
                ]);

                AddingTeam::dispatch($newUser);

                $newUser->switchTeam($team = $newUser->ownedTeams()->create([
                    'name' => $newUser->name . "'s Team",
                    'personal_team' => false
                ]));

                $newUser->update([
                    'current_team_id' => $team->id,
                ]);

                Auth::login($newUser);
                return redirect()->route('dashboard');
            }
            
        } catch (Exception $e) {
           dd($e);
        }
    }

}
