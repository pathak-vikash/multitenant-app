<?php
use Hyn\Tenancy\Models\Website;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;

use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;

use Hyn\Tenancy\Environment;
//use Illuminate\Http\Request;

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


# connect domain
Route::get("{site}/connect", function($site){
    
    //use Hyn\Tenancy\Models\Hostname;
    //use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;

    $hostname = Hostname::where('fqdn', $site)->first();

    if(!$hostname) {

        # create website
        $website = new Website;
        app(WebsiteRepository::class)->create($website);

        # attach host
        $hostname = new Hostname;
        $hostname->fqdn = $site;
        $hostname = app(HostnameRepository::class)->create($hostname);
        app(HostnameRepository::class)->attach($hostname, $website);
    } else {
        $website = Website::find($hostname->website_id);
    }
    
    
    dd($website->hostnames); // Collection with $hostname

});


# Tenant Route
Route::middleware('tenancy')->prefix("{site}")->group(function(){

    # crate post
    Route::get('posts/create', function($site){

        $post = new \App\Post();
        $faker = Faker\Factory::create();
        $post->title = $faker->sentence(7);
        $post->content = $faker->text(100);
        $post->save();
    
        dd($post->toArray());
    });

    # get posts
    Route::get('posts', function(){

        $posts = \App\Post::all();
        dd($posts->toArray());
    
    });
});

// switch tenant
/* Route::get('{site}/switch', function($site){

    //use Hyn\Tenancy\Environment;
    $hostname = Hostname::where('fqdn', $site)->first();

    if(!$hostname) abort(403);

    $website = Website::find($hostname->website_id);
    $tenancy = app(Environment::class);
    $tenancy->hostname($hostname);
    $tenancy->tenant($website); // switches the tenant and reconfigures the app

    /*  
        $tenancy->website(); // resolves $website
        $tenancy->hostname(); // resolves $hostname as currently active hostname
        $tenancy->tenant(); // resolves $website
        $tenancy->identifyHostname(); // resets resolving $hostname by using the Request 
    */
    /*dd($tenancy);

}); */

