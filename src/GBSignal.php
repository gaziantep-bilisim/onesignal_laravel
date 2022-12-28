<?php


namespace HumblDump\GBSignal;

use Carbon\Carbon;
use Generator;
use GuzzleHttp\Pool;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;

use Illuminate\Support\Collection;
use HumblDump\GBSignal\OneSignal\Notification;
use HumblDump\GBSignal\Models\Notification as NotificationModel;
use HumblDump\GBSignal\Models\NotificationJob as NotificationJobModel;


/**
 * Send push notification with using OneSignal V1 API
 * @see https://documentation.onesignal.com/reference
 * @see https://documentation.onesignal.com/reference#create-notification
 * @author Humbldump
 * @version 1.0.0
 * @link https://github.com/humbldump
 *
 */
class GBSignal
{

    const API_BASE = 'https://onesignal.com/api/v1/';

    private ?Client $client;

    private ?string $uri;

    private ?array $headers;

    private ?array $query;

    public ?Notification $body;

    public ?Notification $notification;

    private ?collection $request_chunk;

    private ?Collection $response_chunk;

    private ?Collection $error_chunk;

    private ?Collection $notification_jobs_chunk;

    private ?NotificationModel $notification_model;

    public function __construct()
    {
        // * Client
        $this->client = new Client([
            'base_uri' => self::API_BASE,
            'timeout' => config('GBSignal.timeout', 10),
        ]);

        // * Client Headers
        $this->headers = [
            "User-Agent" => "GBSignal",
            "accept" => "application/json",
        ];

        $this->chunk = new Collection();
        $this->response_chunk = new Collection();
        $this->error_chunk = new Collection();
        $this->request_chunk = new Collection();
        $this->notification_jobs_chunk = new Collection();
    }


    public function createNotification(): GBSignal
    {
        $this->uri = 'notifications';
        $this->notification = new Notification();

        // init the model
        $this->notification_model = NotificationModel::create();

        // ? Setle the app id for notification
        $this->notification->setAppId(config('GBSignal.app_id'));

        return $this;
    }

    public function deleteNotification(NotificationModel|String $finder){

            $this->setAuthorize('DELETE')->setContentType();
            $this->uri = 'notifications';

            $notification_ids = $finder instanceof NotificationModel ? $finder->jobs->pluck('onesignal_id')->toArray() : [$finder];

            foreach ($notification_ids as $id) {
                $this->request_chunk->push(
                    $this->client->requestAsync('DELETE', $this->uri."/{$id}", [
                        'headers' => $this->headers,
                        'query' => $this->query,
                    ])
                );
            }

            return $this->send();
    }

    /**
     * This method fill get the notification list from onesignal
     * This method will not work if there is 80.000 users
     * @param int $limit The limit of the device
     * @param int $offset The offset of the device
     * @return collection|array
     */
    public function getDeviceList($limit = 300, $offset = 0){

            $this->setAuthorize('GET')->setContentType();
            $this->uri = 'players';

            $this->addQuery('limit', $limit)
                ->addQuery('offset', $offset);

            $this->request_chunk->push(
                $this->client->requestAsync('GET', $this->uri, [
                    'headers' => $this->headers,
                    'query' => $this->query,
                ])
            );

            return $this->send();
    }

    /**
     *
     * This method will get the slected id device from onesignal
     * @param string $id The player id
     */
    public function getDevice($id){

            $this->setAuthorize('GET')->setContentType();
            $this->uri = 'players';

            $this->request_chunk->push(
                $this->client->requestAsync('GET', $this->uri."/{$id}", [
                    'headers' => $this->headers,
                    'query' => $this->query,
                ])
            );

            return $this->send();
    }

    /**
     * This method will get status of the notification from onesignal
     * @param NotificationModel|String $finder The notification model or the notification id array
     */
    public function getNotification( NotificationModel|String $finder){

        $this->setAuthorize('GET')->setContentType();
        $this->uri = 'notifications';

        $notification_ids = $finder instanceof NotificationModel ? $finder->jobs->whereNotNull('onesignal_id')->pluck('onesignal_id')->toArray() : [$finder];

        foreach ($notification_ids as $id) {
            $this->request_chunk->push(
                $this->client->requestAsync('GET', $this->uri."/{$id}", [
                    'headers' => $this->headers,
                    'query' => $this->query,
                ])
            );
        }

        return $this->send();

    }

    /**
     * This method fill get the notification list from onesignal
     *
     * @param int $limit The limit of the notification
     * @param int $offset The offset of the notification
     * @param string $kind The kind of the notification [0 => panel, 1 => api, 2 => automated, null => all]
     */
    public function getNotificationList($limit = 50, $offset = 0, $kind = null){

        $this->setAuthorize('GET')->setContentType();
        $this->uri = 'notifications';

        $this->addQuery('limit', $limit)->addQuery('offset', $offset);

        if($kind != null)
            $this->addQuery('kind', $kind);


        $this->request_chunk->push(
            $this->client->requestAsync('GET', $this->uri, [
                'headers' => $this->headers,
                'query' => $this->query,
            ])
        );

        return $this->send();
    }

    /**
     *
     * This method will send notification to tags
     * @param array<string> $values The array of the ids
     * !@important The array must always contains string values!!!
     */
    public function sendToExternal(array $values = [])
    {
        // ? Setle the headers and authorization
        $this->setAuthorize()->setContentType();

        if ($this->notification_model == null) {
            $this->notification_model = NotificationModel::create();
        }

        foreach ($this->externalGenerator($values) as $notification) {
            /**
             * @var Notification $notification
             */

            // ? if there is no notification model, create one
            if ($this->notification_model == null) {
                $this->notification_model = NotificationModel::create();
            }

            /**
             * @var NotificationJobModel $job
             */
            $job = NotificationJobModel::create([
                'notification_id' => $this->notification_model->id,
                'body' => collect($this->notification)->filter()->toJson(),
                'job_status' => 'pending',
            ]);

            // ? Add the job to the notification jobs chunk
            $this->notification_jobs_chunk->push($job);

            // ? Add the notification to the request chunk
            $this->request_chunk->push(
                $this->client->requestAsync('POST', $this->uri, [
                    'body' => $job->body,
                    'headers' => $this->headers,
                ])
            );
        }

        $this->updateModel(count($values));

        return collect(['model' => $this->notification_model, 'response' => $this->send()]);
    }

    /**
     *
     * This method will send notification to tags
     * @param String $key The key of the tah eg. 'company_id'
     * @param String $relation The relation of the tag in ['>','<','=','!=','exists','not_exists']
     *
     */
    public function sendToTag(String $key, String $relation, array $value)
    {
        // ? Setle the headers and authorization
        $this->setAuthorize()->setContentType();

        foreach ($this->filterGenerator($key, $relation, $value) as $notification) {
            /**
             * @var Notification $notification
             */

            // ? if there is no notification model, create one
            if ($this->notification_model == null) {
                $this->notification_model = NotificationModel::create();
            }

            /**
             * @var NotificationJobModel $job
             */
            $job = NotificationJobModel::create([
                'notification_id' => $this->notification_model->id,
                'body' => collect($this->notification)->filter()->toJson(),
                'job_status' => 'pending',
            ]);

            // ? Add the job to the notification jobs chunk
            $this->notification_jobs_chunk->push($job);

            // ? Add the notification to the request chunk
            $this->request_chunk->push(
                $this->client->requestAsync('POST', $this->uri, [
                    'body' => $job->body,
                    'headers' => $this->headers,
                ])
            );
        }

        $this->updateModel(count($value));

        return collect(['model' => $this->notification_model, 'response' => $this->send()]);
    }

    /**
     *
     * This method will send notification to all users in the app
     *
     */
    public function sendToAll()
    {
        // ? Setle the headers and authorization
        $this->setAuthorize()->setContentType();

        $this->notification->addSegments("All");

        // ? if there is no notification model, create one
        if ($this->notification_model == null) {
            $this->notification_model = NotificationModel::create();
        }


        /**
         * @var NotificationJobModel $job
         */
        $job = NotificationJobModel::create([
            'notification_id' => $this->notification_model->id,
            'body' => collect($this->notification)->filter()->toJson(),
            'job_status' => 'pending',
        ]);

        // ? Add the job to the notification jobs chunk
        $this->notification_jobs_chunk->push($job);

        $this->request_chunk->push(
            $this->client->requestAsync('POST', $this->uri, [
                'body' => $job->body,
                'headers' => $this->headers,
            ])
        );

        $this->updateModel();

        return collect(['model' => $this->notification_model, 'response' => $this->send()]);
    }

    /**
     *
     * This method will send notification to all users in the app
     *  @return \StdClass<success;error>
     */
    private function send(): \StdClass
    {
        $pool = new Pool($this->client, $this->preparePool(), [
            'concurrency' => config('onesignal.pool_size', 10),
            'fulfilled' => function (Response $response, $index) {
                // ? get response body
                /**
                 * @var Collection $_response
                 */
                $_response = collect(json_decode($response->getBody()->getContents(), true));

                if ($this->uri == 'notifications' && $this->notification_jobs_chunk->isNotEmpty()) {
                    $this->notification_jobs_chunk[$index]->update([
                        'status' => true,
                        'job_status' => $_response->has('recipients') && $_response->get('recipients') > 0 ? 'completed' : 'skipped',
                        'recipients' => $_response->has('recipients') ? $_response->get('recipients') : 0,
                        'onesignal_id' => $_response->has('id') && $_response->get("id") != "" ? $_response->get('id') : null,
                    ]);

                    $_response->put('job_id', $this->notification_jobs_chunk[$index]->id);
                }

                $this->response_chunk->push(json_decode($_response->toJson()));

            },
            'rejected' => function (\GuzzleHttp\Exception\ClientException $reason, $index) {


                if ($this->uri == 'notifications' && $this->notification_jobs_chunk->isNotEmpty()) {
                    $this->notification_jobs_chunk[$index]->update([
                        'status' => true,
                        'job_status' => 'failed',
                    ]);
                }

                $this->error_chunk->push(json_decode($reason->getResponse()->getBody()->getContents()));
            },
        ]);

        $promise = $pool->promise();

        $promise->wait();

        $res = new \stdClass();

        $res->success = $this->response_chunk;
        $res->error = $this->error_chunk;
        return $res;
    }

    private function preparePool()
    {
        foreach ($this->request_chunk as $r) {
            yield fn () => $r;
        }
    }

    private function externalGenerator(array $values = [])
    {
        $_values = collect($values);

        foreach ($_values->chunk(1999) as $chunk) {
            /**
             *
             * @var Collection $chunk
             */

            $this->notification->addExternalIds($chunk->toArray());

            yield $this->notification;
        }
    }

    private function filterGenerator(String $key, String $relation, array|String|int $value): Generator
    {
        foreach ($value as $kValue) {
            $this->notification->addFilter($key, $relation, strval($kValue));

            if ($this->notification->filterFull) {
                // ? if the notification filter is full push this notification to the notification chunk
                yield $this->notification;

                // ? clone the notification and clear the filters
                $this->notification = clone $this->notification;
                $this->notification->filters = new Collection();
                $this->notification->filterFull = false;
            }
        }

        yield $this->notification;
    }

    private function addQuery($key, $value): GBSignal{

        $this->query[$key] = $value;

        return $this;
    }

    private function setAuthorize($method = "POST"): GBSignal
    {

        if (!config('GBSignal.auth_key'))
            throw new \Exception("GBSignal api key is not setted. Please set GBSignal.api_key in your .env file.");

        if(in_array($method, ["GET", "PUT", "PATCH", "DELETE"]))
            $this->query['app_id'] = config('GBSignal.app_id');

        $this->headers["Authorization"] = "Basic " . config('GBSignal.auth_key');

        return $this;
    }

    private function setContentType(): GBSignal
    {
        $this->headers["Content-Type"] = "application/json";


        return $this;
    }

    private function updateModel($receiverCount = 0){
        $this->notification_model->update([
            'title' => property_exists($this->notification->headings, 'en') ? $this->notification->headings->en : null,
            'content' => property_exists($this->notification->contents, 'en') ? $this->notification->contents->en : null,
            'send_after' => Carbon::parse($this->notification->send_after),
            'receiver_count' => $receiverCount,
        ]);

        return;
    }
}
