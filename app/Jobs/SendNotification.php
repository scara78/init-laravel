<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Movie;
use App\Serie;
use App\Livetv;
use App\Setting;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Exception;

class SendNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $settings = Setting::find(1);
        $client = new Client(['headers' => ['Authorization' => "key=$settings->authorization", 'Content-Type' => 'application/json']]);


        try {
            if ($this->data instanceof Movie) {
                $client->post('https://fcm.googleapis.com/fcm/send', [
                    'json' => [
                        'to' => "/topics/all",
                        'notification' => ['title' => $this->data->title . ' has been added', 'body' => $this->data->overview, 'image' => $this->data->backdrop_path],
                        'data' =>  ['instanceof' => 'movie', 'id' => $this->data->id, 'click_action' => "FLUTTER_NOTIFICATION_CLICK"]
                    ]
                ]);
            }
            if ($this->data instanceof Serie) {
                $client->post('https://fcm.googleapis.com/fcm/send', [
                    'json' => [
                        'to' => "/topics/all",
                        'notification' => ['title' => $this->data->name . ' has been added', 'body' => $this->data->overview, 'image' => $this->data->backdrop_path],
                        'data' =>  ['instanceof' => 'serie', 'id' => $this->data->id, 'click_action' => "FLUTTER_NOTIFICATION_CLICK"]
                    ]
                ]);
            }

            if ($this->data instanceof Livetv) {
                $client->post('https://fcm.googleapis.com/fcm/send', [
                    'json' => [
                        'to' => "/topics/all",
                        'notification' => ['title' => $this->data->name . ' has been added', 'body' => $this->data->overview, 'image' => $this->data->backdrop_path],
                        'data' =>  ['instanceof' => 'livetv', 'id' => $this->data->id, 'click_action' => "FLUTTER_NOTIFICATION_CLICK"]
                    ]
                ]);
            }
            $status = 'success';
        } catch (ClientException $ce) {
            $status = 'error';
        } catch (RequestException $re) {
            $status = 'error';
        } catch (Exception $e) {
            $status = 'error';
        }

        return ['status' => $status];
    }
}
