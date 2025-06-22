<?php

namespace App\Models\SRO\Shard;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Chest extends Model
{
    /**
     * The Database connection name for the model.
     *
     * @var string
     */
    protected $connection = 'shard';

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
    protected $table = 'dbo._Chest';

    /**
     * The table primary Key
     *
     * @var string
     */
    protected $primaryKey = 'UserJID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'UserJID',
        'slot',
        'ItemID'
    ];

    public static function getChest($UserJID, $max, $min)
    {
        $minutes = config('global.cache.character_info', 1440);

        return Cache::remember("character_info_chest_{$UserJID}", now()->addMinutes($minutes), static function () use ($UserJID, $max, $min) {
            return self::join('_Items', '_Items.ID64', '_Chest.ItemID')
            ->join('_RefObjCommon', '_Items.RefItemId', '_RefObjCommon.ID')
            ->join('_RefObjItem', '_RefObjCommon.Link', '_RefObjItem.ID')
            ->join('_User', '_Chest.UserJID', '=', '_User.UserJID')
            ->join('_Char', '_User.CharID', '=', '_Char.CharID')
            ->where('_Chest.UserJID', '=', $UserJID)
            ->where('Slot', '<=', $max)
            ->where('Slot', '>=', $min)
            ->where('ItemID', '!=', 0)
            ->get()
            ->toArray();
        });
    }
}
