<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Site;
use App\Action;
use Telegram;
use App\Client;

class ApiController extends Controller
{
    public function getData(Request $request)
    {
        $data = json_decode($request->getContent());

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
                }
            }
            $sm=[ 'chat_id' => $site->user->name, 'text' => $message, 'caption'=>$message];
            Telegram::sendMessage($sm);
            $newaction = Action::create([
                'site_id' => $site->id,
                'fingerprint' => $fingerprint,
                'action'=> $action,
                'ip' => $request->ip(),
                'referer' => $request->referer,
                'data' => json_encode($dat),
            ]);
        }

        //var_dump($data);
    }
}
