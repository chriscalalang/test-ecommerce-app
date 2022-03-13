<?php

namespace App\Domains\User\Actions;

use App\Domains\User\Models\User;
use Illuminate\Support\Str;

/**
 * Class CreateUserAction
 * @package App\Domains\User\Actions
 */
class CreateUserAction
{
    /**
     * @param array $data
     * @return User
     */
    public function handle(array $data): User
    {
        $user = User::where('email', $data['email'])->first();

        if(!empty($user)) {
            return $user;
        }

        /** TODO: send welcome email with temp password using Str::random(8)
         *  but for this test we just use "password"
         **/
        $randomPassword = bcrypt('password');

        $user = new User;
        $user->name = $data['first_name'] . ' ' . $data['last_name'];
        $user->first_name = $data['first_name'];
        $user->last_name = $data['last_name'];
        $user->email = $data['email'];
        $user->password = (empty($data['password']) ? $randomPassword : $data['password']);
        $user->phone_number = $data['phone_number'];
        $user->address_line_1 = $data['address_line_1'];
        $user->address_line_2 = $data['address_line_2'];
        $user->address_line_3 = $data['address_line_3'];
        $user->city = $data['city'];
        $user->state = $data['state'];
        $user->zip_code = $data['zip_code'];
        $user->country = $data['country'];

        $user->save();

        return $user;
    }
}
