<?php


namespace HumblDump\GBSignal\OneSignal;

use stdClass;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use HumblDump\GBSignal\Models\Notification as NotificationModel;

class Notification
{
    /**
     *
     * @var Object $contents The message to be sent
     */
    public $contents;

    /**
     *
     * @var Object $headings The title of the message
     */
    public $headings;

    /**
     *
     * @var Object $data The hidden data of the notification
     */
    public $data;

    /**
     *
     * @var string $url The url of the notification
     */
    public $url;

    /**
     *
     * @var array $buttons The buttons of the notification
     */
    public $buttons;

    /**
     * @var int $ttl The time to live of the notification
     */
    public $ttl;


    /**
     * @var String $send_after The time to send the notification
     */
    public $send_after;

    /**
     * @var array
     */
    public $included_segments;

    /**
     * @var array
     */
    public $include_external_user_ids;

    /**
     *
     * @var Collection $filters The list of filters will be applied to the
     */
    public $filters;

    public bool $filterFull = false;

    public $app_id;

    public function __construct()
    {
        // $this->included_segments = array();
    }

    public function addFilter(String $key, String $relation, String $value){

        if($this-> filters == null)
            $this->filters = new Collection();

        if($this->filters->count() > 198){
            $this->filterFull = true;
            return $this;
        }

        if($this->filters->count() > 0){
            $or = new stdClass();
            $or->operator = "OR";
            $this->filters->push($or);
        }

        $filter = new stdClass();

        $filter->field = "tag";
        $filter->key = $key;
        $filter->relation = $relation;
        $filter->value = $value;

        $this->filters->push($filter);

        return $this;

    }

    public function addExternalIds(array $external_ids): ?Notification
    {
        if($this->include_external_user_ids == null)
            $this->include_external_user_ids = array();

        $this->include_external_user_ids = $external_ids;
        return $this;
    }

    public function setAppId(String $app_id): ?Notification
    {
        $this->app_id = $app_id;
        return $this;
    }

    public function setHead(string $head, $lang = "en"): ?Notification
    {

        if($this->headings == null)
            $this->headings = new stdClass();

        $this->headings->$lang = $head;

        return $this;
    }

    public function setContent(string $content, $lang = "en"): ?Notification
    {

        if($this->contents == null)
            $this->contents = new stdClass();

        $this->contents->$lang = $content;
        return $this;
    }

    public function setData(String $key, String|int|null $value): ?Notification
    {

        if($this->data == null)
            $this->data = new stdClass();

        $this->data->$key = $value;
        return $this;
    }

    public function setUrl(String $url): ?Notification
    {
        $this->url = $url;
        return $this;
    }

    public function setSendAfter(Carbon $send_after): ?Notification
    {

        if($send_after->isPast())
            throw new \Exception("Send after date can not be past");

        $this->send_after = $send_after->toIso8601String();

        return $this;
    }

    public function addButton(String $id, String $text, String $icon = null, String $url = null): ?Notification
    {

        if($this->buttons == null)
            $this->buttons = array();

        $this->buttons[] = [
            "id" => $id,
            "text" => $text,
            "icon" => $icon,
        ];
        return $this;
    }

    public function addSegments(String $segment){

        if($this->included_segments == null)
            $this->included_segments = array();

        if($this->filters != null && $this->filters->count() > 0){
            throw new \Exception("You can not add segments when you have filters");
        }

        $this->included_segments[] = $segment;
        return $this;
    }
}
