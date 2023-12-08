<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Auth\EloquentUserProvider as UserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use Illuminate\Support\Facades\Hash;


class CustomUserProvider extends UserProvider
{
    /**
     * Overrides the framework defaults validate credentials method
     *
     * @param UserContract $user
     * @param array $credentials
     * @return bool
     */
    public function validateCredentials(UserContract $user, array $credentials): bool
    {
        $plainPassword = $credentials['password'];
        $hashedPassword = $user->getAuthPassword();

        if (!$this->hasMd5Encryption($hashedPassword) && Hash::check($plainPassword, $hashedPassword)) {
            return true;
        } elseif ($this->hasMd5Encryption($hashedPassword) && md5($plainPassword) == $hashedPassword) {
            /** @var User $user **/
            $this->updatePasswordToBcrypt($user, $plainPassword);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Checks if the password has encryption
     *
     * @param string $password
     *
     * @return bool
     */
    private function hasMd5Encryption(string $password): bool
    {
        return (strlen($password) === 32 && preg_match('/^[a-f0-9]+$/', $password));
    }

    /**
     * Updates the user's password to bcrypt encryption
     *
     * @param User   $user
     * @param string $plainPassword
     *
     * @return void
     */
    private function updatePasswordToBcrypt(User $user, string $plainPassword): void
    {
        $user->password = Hash::make($plainPassword);
        $user->save();
    }
}
