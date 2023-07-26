<?php

namespace App\Actions\Fortify;

use App\Models\Notificacion;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'min:4', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        // $user = new User;
        // $user->name = $input['name'];
        // $user->username = $input['username'];
        // $user->fecha_nacimiento = $input['fecha_nacimiento'];
        // $user->residencia_id = $input['residencia_id'];
        // $user->email = $input['email'];
        // $user->password = Hash::make($input['password']);
        // $user->save();

        // $notificacion = new Notificacion;
        // $notificacion->user_id = $user->id;
        // $notificacion->mensaje = '¡Su cuenta fue creada con exito! Ahora podrá subir sus videos en la pestaña Mis Videos.';
        // return redirect()->route('video.inicio');
        // $ultimoUser = User::find(DB::table('users')->max('id'));
        // $ultimo = $ultimoUser->id + 1;
        // $noti = new Notificacion;
        // $noti->user_id = $ultimo;
        // $noti->mensaje = '¡Registro exitoso! Ahora podrá subir videos en la secciión Mis videos.';
        // $noti->save();
        return User::create([
            'name' => $input['name'],
            'username' => $input['username'],
            'fecha_nacimiento' => $input['fecha_nacimiento'],
            'residencia_id' => $input['residencia_id'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
