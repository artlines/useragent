<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use App\Site;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use GuzzleHttp\Exception\RequestException;
use App\Action;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sites = Auth::user()->sites;
        foreach($sites as $site){
            $client = new \GuzzleHttp\Client();
            try {
                $response = $client->get($site->url);
                $code = $response->getStatusCode();
                if ($code != 200) {
                    $status[$site->id] = 'Ошибка';
                } else {
                    $body = $response->getBody();
                    $remainingBytes = $body->getContents();
                    if (strpos($remainingBytes, $site->code) !== false) {
                        $status[$site->id] = 'OK';
                    } else {
                        $status[$site->id] = 'Код не найден';
                    }
                }
            } catch (RequestException $e){
                $status[$site->id] = 'Ошибка';
            }

        }
        return view('site.sites',['status'=>$status]);
    }

    public function addSite()
    {
        return view('addsite');
    }

    public function saveSite(Request $request)
    {
        $site = Site::create([
            'user_id' => Auth::user()->id,
            'url' => $request->url,
            'code' => Str::random(12),
        ]);
        return redirect('/home');
    }

    public function deleteSite($id)
    {
        $site = Site::findOrFail($id);
        $site->delete();
        return back();
    }

    public function showActions($id)
    {
        $site = Site::findOrFail($id);
        if($site->user_id != Auth::user()->id){
            return redirect('/home');
        }
        $actions = Action::where('site_id', $id)->orderBy('created_at', 'desc')->get();
        return view('site.actions',['actions' => $actions, 'site'=>$site]);
    }

    public function client($id)
    {
        $client = Client::findOrFail($id);
        $sites = Auth::user()->sites;
        $ids = [];
        foreach($sites as $site){
            $ids[] =$site->id;
            $count[$site->id] =0;
        }
        $actions = $client->actions()->whereIn('site_id', $ids)->get();
        foreach($actions as $action){
            $count[$action->site_id]++;
        }

        return view('site.client', ['client'=> $client, 'actions' => $actions, 'counts'=>$count,'sites'=>$sites]);
    }
}
