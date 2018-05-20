<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        // Create a client with a base URI
        $client = new Client(['base_uri' => 'https://api.github.com/']);
        // Send a request to https://foo.com/api/test
        $response = $client->request('GET', 'users/'.$user->nickname.'/starred');

        //dd(json_decode($response->getBody()->getContents()));

        $repos = json_decode($response->getBody()->getContents());

        return view('home', compact('repos'));
    }
}
