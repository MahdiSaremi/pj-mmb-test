<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use Mmb\Support\Db\HasFinder;
use Mmb\Support\Step\HasStep;
use Mmb\Support\Step\Stepping;
use Rapid\Laplus\Guide\Attributes\IsRelation;
use Rapid\Laplus\Present\HasPresent;
use Rapid\Laplus\Present\Present;
use Spatie\Permission\Traits\HasRoles;

/**
 * @Guide
 * @mixin \Rapid\_Stub\_844975b172352e06c0dc31bdb4a7cab1
 * @EndGuide
 */
class BotUser extends Authenticatable implements Stepping
{
    use HasFactory, HasPresent, HasStep, HasFinder, HasRoles;

    protected $guard_name = 'bot';

    public function present(Present $present)
    {
        $present->id();
        $present->text('name');
        $present->text('step');
        $present->unsignedInteger('coin')->default(0);
        $present->string('invite_code')->nullable();
        $present->belongsTo(BotUser::class, 'invited_by')->nullOnDelete();
        $present->timestamps();
    }

    public function getForeignKey()
    {
        return 'user_id';
    }

    public function makeInviteCode() : string
    {
        if (!$this->invite_code)
        {
            $this->invite_code = retry(10, function () {
                $code = Str::random(8);

                throw_if(static::where('invite_code', $code)->exists());

                return $code;
            });
        }

        return $this->invite_code;
    }

    #[IsRelation]
    public function invites()
    {
        return $this->hasMany(BotUser::class, 'invited_by_id');
    }

}
