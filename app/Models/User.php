<?php

namespace App\Models;

use App\Models\SRO\Account\TbUser;
use App\Models\SRO\Portal\AphChangedSilk;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\SRO\Portal\MuUser;
use App\Models\SRO\Portal\MuVIPInfo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'jid',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function getUserCount()
    {
        $minutes = config('global.cache.account_info', 5);

        return Cache::remember('account_count', now()->addMinutes($minutes), function () {
            return self::count();
        });
    }

    public function muUser()
    {
        return $this->hasOne(MuUser::class, 'JID', 'jid');
    }

    public function tbUser()
    {
        if (config('global.server.version') === 'vSRO') {
            return $this->hasOne(TbUser::class, 'JID', 'jid');
        } else{
            return $this->hasOne(TbUser::class, 'PortalJID', 'jid');
        }
    }

    public function news()
    {
        return $this->hasMany(News::class);
    }

    public function role()
    {
        return $this->hasOne(UserRole::class);
    }

    public function invitesCreated()
    {
        return $this->hasMany(Invite::class, 'jid', 'jid');
    }

    public function invitesUsed()
    {
        return $this->hasMany(Invite::class, 'invited_jid', 'jid');
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            if (!$user->invitesCreated()->exists()) {
                do {
                    $code = strtoupper(Str::random(8));
                } while (Invite::where('code', $code)->exists());

                Invite::create([
                    'code' => $code,
                    'jid' => $user->jid,
                    'name' => $user->username,
                ]);
            }
        });
    }
}
