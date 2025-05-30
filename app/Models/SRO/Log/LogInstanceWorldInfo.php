<?php

namespace App\Models\SRO\Log;

use App\Models\SRO\Shard\Char;
use App\Models\SRO\Shard\Guild;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class LogInstanceWorldInfo extends Model
{
    use HasFactory;

    /**
     * The Database connection name for the model.
     *
     * @var string
     */
    protected $connection = 'log';

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
    protected $table = 'dbo._LogInstanceWorldInfo';

    public static function getUniqueRanking($limit = 25, $month = 0)
    {
        $uniqueList = config('ranking.uniques');
        $minutes = config('global.cache.ranking_unique', 60);

        $case = 'SUM(CASE ';
        foreach ($uniqueList as $uniqueCode => $points) {
            $points = $points['points'];
            $case .= "WHEN _LogInstanceWorldInfo.Value = '$uniqueCode' THEN $points ";
        }
        $case .= 'ELSE 0 END) AS Points';
        $startOfMonth = Carbon::now()->startOfMonth();

        return Cache::remember("ranking_unique_{$limit}_{$month}", now()->addMinutes($minutes), function () use ($month, $startOfMonth, $uniqueList, $case, $limit) {
            return self::select(
                    '_Char.CharName16',
                    '_Char.RefObjID',
                    '_Char.CurLevel',
                    '_Guild.ID',
                    '_Guild.Name',
                    DB::raw($case)
                )
                ->join(DB::connection('shard')->getDatabaseName().'.dbo._Char', '_Char.CharID', '=', '_LogInstanceWorldInfo.CharID')
                ->join(DB::connection('shard')->getDatabaseName().'.dbo._Guild', '_Char.GuildID', '=', '_Guild.ID')
                ->whereIn('_LogInstanceWorldInfo.Value', array_keys($uniqueList))
                ->where('_LogInstanceWorldInfo.ValueCodeName128', 'KILL_UNIQUE_MONSTER')
                ->when($month == 1, function ($query) use ($startOfMonth) {
                    $query->where('_LogInstanceWorldInfo.EventTime', '>=', $startOfMonth);
                })
                ->groupBy(
                    '_Char.CharName16',
                    '_Char.RefObjID',
                    '_Char.CurLevel',
                    '_Guild.ID',
                    '_Guild.Name'
                )
                ->orderByDesc('Points')
                ->limit($limit)
                ->get();
        });
    }

	public static function getUniquesKill($limit = 25, $CharID = 0, $includeSpawns = true)
	{
		$uniqueList = array_keys(config('ranking.uniques'));
		$minutes = config('global.cache.unique_history', 10);

		return Cache::remember("unique_history_{$limit}_{$CharID}_{$includeSpawns}", now()->addMinutes($minutes), function () use ($CharID, $limit, $uniqueList, $includeSpawns) {
			return self::select([
					'_LogInstanceWorldInfo.CharID',
					'_Char.CharName16',
					'_Char.RefObjID',
					'_Char.CurLevel',
					'_LogInstanceWorldInfo.ValueCodeName128',
					'_LogInstanceWorldInfo.Value',
					'_LogInstanceWorldInfo.WorldID',
					'_RefRegion.wRegionID',
					'_RefRegion.AreaName',
					'_LogInstanceWorldInfo.EventTime'
				])
				->leftJoin(DB::connection('shard')->getDatabaseName().'.dbo._Char', '_Char.CharID', '=', '_LogInstanceWorldInfo.CharID')
				->leftJoin(DB::connection('shard')->getDatabaseName().'.dbo._RefRegion', '_RefRegion.wRegionID', '=', '_LogInstanceWorldInfo.WorldID')
				->whereIn('_LogInstanceWorldInfo.Value', $uniqueList)
				->when($includeSpawns, function ($query) {
					$query->whereIn('_LogInstanceWorldInfo.ValueCodeName128', ['KILL_UNIQUE_MONSTER', 'SPAWN_UNIQUE_MONSTER']);
				}, function ($query) {
					$query->where('_LogInstanceWorldInfo.ValueCodeName128', 'KILL_UNIQUE_MONSTER');
				})
				->when($CharID > 0, function ($query) use ($CharID) {
					$query->where('_LogInstanceWorldInfo.CharID', $CharID);
				})
				->orderByDesc('_LogInstanceWorldInfo.EventTime')
				->limit($limit)
				->get();
		});
	}
}
