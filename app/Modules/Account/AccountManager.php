<?php

namespace App\Modules\Account;

use Modules\Account\Models\Account;
use Modules\Account\Models\Avatar;
use Modules\File\Models\File;

class AccountManager
{

    public static function get() : Account
    {
        return Account::current();
    }

    public static function addAvatar(File $file) : void
    {
        static::get()->avatars()->create([
            'file_id' => $file->id,
        ]);
        static::get()->unsetRelation('avatars');
    }

    public static function removeAvatar(Avatar $avatar) : void
    {
        $avatar->delete();
        static::get()->unsetRelation('avatars');
    }

}
