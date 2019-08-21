<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', function(){
    $query = http_build_query([
        'client_id' => '4',
        'redirect_uri' => 'http://192.168.56.1:8080/callback',
        'response_type' => 'code',
        'scope' => ''
    ]);
    return redirect("http://192.168.56.1:8000/oauth/authorize?$query");
});


Route::get('callback', function(\Illuminate\Http\Request $request){
    $code = $request->get('code');
    $http = new \GuzzleHttp\Client();
    $response = $http->post('http://192.168.56.1:8000/oauth/token',[
        'form_params' => [
            'client_id' => '4',
            'client_secret' => 'gWGPdB04b51CqPqnWF1bhdgo97ulZO0gTtrWpXoV',
            'redirect_uri' => 'http://192.168.56.1:8080/callback',
            'code' => $code,
            'grant_type' => 'authorization_code'
        ]
    ]);
    dd(json_decode($response->getBody(), true));
});
