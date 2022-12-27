<?php


namespace HumblDump\GBSignal\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * HumblDump\GBSignal\Models\Notification
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\HumblDump\GBSignal\Models\NotificationJob[] $jobs
 * @property-read int|null $jobs_count
 * @method static \Illuminate\Database\Eloquent\Builder|Notification failed()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification newQuery()
 * @method static \Illuminate\Database\Query\Builder|Notification onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification success()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Notification withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Notification withoutTrashed()
 * @mixin \Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereDeletedAt($value)
 */
class Notification extends Model
{
    use SoftDeletes;
    protected $table = 'gbsignal_notifications';
    protected $guarded = [];




    public function jobs(): HasMany
    {
        return $this->hasMany(NotificationJob::class);
    }

    public function failedJobs()
    {
        return $this->jobs()->where('status', false);
    }

    public function successJobs()
    {
        return $this->jobs()->where('status', true);
    }

    public function scopeFailed($query)
    {
        return $query->whereHas('failedJobs');
    }

    public function scopeSuccess($query)
    {
        return $query->whereHas('successJobs');
    }
}
