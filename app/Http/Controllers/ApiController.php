<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Site;
use App\Action;
use Telegram;
use App\Client;
use Illuminate\Support\Str;

class ApiController extends Controller
{
    public function getData(Request $request)
    {
        $data = json_decode($request->getContent());
        $my_ref = parse_url($data->referer, PHP_URL_HOST);
        $fingerprint = $data->fingerprint;
        $client = Client::where('fingerprint', $fingerprint)->first();
        if(!$client){
            $client = Client::create(['fingerprint'=> $fingerprint]);
        }

        $code = $data->code;
        $action = $data->action;
        $code_data = explode('_', $code);
        $site = Site::find($code_data[0]);
        $dat = [];
        if(!empty($data->data)){
            parse_str($data->data, $dat);
        }

        //var_dump($site);die();
        if($site && $site->code == $code_data[1]){
            $user = $site->user;
            if($action == 'Visit'){
                $message = 'Клиент '.$client->id.' на сайте '.$site->url;
            }

            if($action == 'Submit'){
                $message = "Отправка формы на сайте ".$site->url." \n";
                foreach($dat as $key=>$d){
                    $message .= $key.' - '.$d." \n";
                    if(Str::contains($key, 'name')){
                        $client->name = $d;
                        $client->save();
                    }
                    if(Str::contains($key, 'phone')){
                        $client->phone = $d;
                        $client->save();
                    }
                    if(Str::contains($key, 'email')){
                        $client->email = $d;
                        $client->save();
                    }
                }
            }
            if($client->name){
                $message .= "\n ".$client->name;
            }
            if($client->phone){
                $message .= "\n ".$client->phone;
            }
            if($client->email){
                $message .= "\n ".$client->email;
            }
            $message .= "\n IP: ".$request->ip();
            if($data->referer){
                $message .= "\n HTTP_REFERER: ".$my_ref;
            }
            if($data->source){
                $message .= "\n utm_source: ".$data->source;
            }
            if($data->source){
                $message .= "\n utm_term: ".$data->term;
            }
            if($data->source){
                $message .= "\n utm_campaign: ".$data->campaign;
            }
            $sm=[ 'chat_id' => $site->user->name, 'text' => $message, 'caption'=>$message];
            Telegram::sendMessage($sm);
            $newaction = Action::create([
                'site_id' => $site->id,
                'fingerprint' => $fingerprint,
                'action'=> $action,
                'ip' => $request->ip(),
                'referer' => $my_ref,
                'data' => json_encode($dat),
            ]);
        }

        //var_dump($data);
    }
}
