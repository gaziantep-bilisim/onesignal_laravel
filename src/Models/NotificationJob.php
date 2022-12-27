<?php


namespace HumblDump\GBSignal\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * HumblDump\GBSignal\Models\NotificationJob
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \HumblDump\GBSignal\Models\Notification|null $Notification
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationJob newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationJob newQuery()
 * @method static \Illuminate\Database\Query\Builder|NotificationJob onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationJob query()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationJob whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationJob whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationJob whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|NotificationJob withTrashed()
 * @method static \Illuminate\Database\Query\Builder|NotificationJob withoutTrashed()
 * @mixin \Eloquent
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationJob whereDeletedAt($value)
 * @property string|null $body
 * @property int|null $status
 * @property string|null $job_status
 * @property string|null $onesignal_id
 * @property int $notification_id
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationJob whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationJob whereJobStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationJob whereNotificationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationJob whereOnesignalId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationJob whereStatus($value)
 * @property int|null $recipients
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationJob whereRecipients($value)
 */
class NotificationJob extends Model
{
    use SoftDeletes;
    protected $table = 'gbsignal_notification_jobs';
    protected $fillable = [
        'body',
        'status',
        'job_status',
        'onesignal_id',
        'recipients',
        'notification_id',
    ];


    public function Notification(): BelongsTo
    {
        return $this->belongsTo(Notification::class);
    }
}
