<?php

namespace App\Models\SRO\Account;

use App\Models\SRO\Portal\MuUser;
use App\Models\SRO\Shard\Char;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class TbUser extends Model
{
    use HasFactory;

    /**
     * The Database connection name for the model.
     *
     * @var string
     */
    protected $connection = 'account';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'dbo.TB_User';

    /**
     * The table primary Key
     *
     * @var string
     */
    protected $primaryKey = 'JID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

    protected $hidden = [
        'password'
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        if (config('global.server.version') === 'vSRO') {
            $this->fillable = [
                'StrUserID',
                'Name',
                'password',
                'Status',
                'GMrank',
                'Email',
                'regtime',
                'reg_ip',
                'sec_primary',
                'sec_content',
                'AccPlayTime',
                'LatestUpdateTime_ToPlayTime'
            ];
        } else {
            $this->fillable = [
                'PortalJID',
                'StrUserID',
                'ServiceCompany',
                'password',
                'Active',
                'UserIP',
                'CountryCode',
                'VisitDate',
                'RegDate',
                'sec_primary',
                'sec_content',
                'sec_grade',
            ];
        }
    }

    public static function setGameAccount($jid, $username, $password, $email, $ip)
    {
        if (config('global.server.version') === 'vSRO') {
            return self::create([
                'StrUserID' => strtolower($username),
                'Name' => $username,
                'password' => md5($password),
                'Status' => 1,
                'GMrank' => 0,
                'Email' => $email,
                'regtime' => now(),
                'reg_ip' => $ip,
                'sec_primary' => 3,
                'sec_content' => 3
            ]);
        } else {
            return self::create([
                'PortalJID' => $jid,
                'StrUserID' => $username,
                'ServiceCompany' => 11,
                'password' => md5($password),
                'Active' => 1,
                'UserIP' => $ip,
                'CountryCode' => 'EG',
                'VisitDate' => now(),
                'RegDate' => now(),
                'sec_primary' => 3,
                'sec_content' => 3,
                'sec_grade' => 0,
            ]);
        }
    }

    public static function getTbUserCount()
    {
        $minutes = config('global.cache.account_info', 5);

        return Cache::remember('account_info_ingame_count', now()->addMinutes($minutes), function () {
            return self::count();
        });
    }

    public function getSkSilk()
    {
        return $this->belongsTo(SkSilk::class, 'JID', 'JID');
    }

    public function certifyKey()
    {
        return $this->hasMany(WebItemCertifyKey::class, 'UserJID', 'JID');
    }

    public function getSkSilkHistory()
    {
        return $this->hasMany(SkSilkBuyList::class, 'UserJID', 'JID');
    }

    public function shardUser()
    {
        return $this->belongsToMany(Char::class, '_User', 'UserJID', 'CharID');
    }

    public function muUser()
    {
        return $this->hasOne(MuUser::class, 'JID', 'PortalJID');
    }

    public function user()
    {
        if (config('global.server.version') === 'vSRO') {
            return $this->belongsTo(User::class, 'jid', 'JID');
        } else{
            return $this->belongsTo(User::class, 'jid', 'PortalJID');
        }
    }
    public function blockedUser()
    {
        return $this->hasOne(BlockedUser::class, 'UserJID', 'JID');
    }
}
