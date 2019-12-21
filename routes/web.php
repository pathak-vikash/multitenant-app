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


// create website
Route::get("/create-website", function(){
    
    //use Hyn\Tenancy\Models\Website;
    //use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;

    $website = new Website;
    app(WebsiteRepository::class)->create($website);
    dd($website->uuid);

    // 4570613b0df94c8299129834c8013877

});

// Connect Hostname
Route::get("/connect-site/{site?}", function($site){
    
    //use Hyn\Tenancy\Models\Hostname;
    //use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;

    if(!isset($site)) $site = 'tenant1';

    $fqdn = $site.'.demo.app';
    $hostname = Hostname::where('fqdn', $fqdn)->first();

    if(!$hostname) {

        # create website
        $website = new Website;
        app(WebsiteRepository::class)->create($website);

        # attach host
        $hostname = new Hostname;
        $hostname->fqdn = $fqdn;
        $hostname = app(HostnameRepository::class)->create($hostname);
        app(HostnameRepository::class)->attach($hostname, $website);
    } else {
        $website = Website::find($hostname->website_id);
    }
    
    
    dd($website->hostnames); // Collection with $hostname

});

// switch tenant
Route::get('/switch-site/{site?}', function($site){

    //use Hyn\Tenancy\Environment;
    if(!isset($site)) $site = 'tenant1';
    
    $fqdn = $site.'.demo.app';
    $hostname = Hostname::where('fqdn', $fqdn)->first();

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

    // create posts
    /* $post = new \App\Post();
    $post->title = "Demo title - " . $site;
    $post->content = "demo content";
    $post->save(); */

    $posts = \App\Post::all()->toArray();
    dd($posts);

});


Route::get('{fqdn}/posts/create', function($fqdn){
    $hostname = Hostname::where('fqdn', $fqdn)->first();

    if(!$hostname) abort(403);

    $website = Website::find($hostname->website_id);
    $tenancy = app(Environment::class);
    $tenancy->hostname($hostname);
    $tenancy->tenant($website); // switches the tenant and reconfigures the app

    $post = new \App\Post();
    $faker = Faker\Factory::create();
    $post->title = $faker->sentence(7);
    $post->content = $faker->text(100);
    $post->save();

    dd($post->toArray());
});

Route::get('{fqdn}/posts', function($fqdn){
    $hostname = Hostname::where('fqdn', $fqdn)->first();

    if(!$hostname) abort(403);

    $website = Website::find($hostname->website_id);
    $tenancy = app(Environment::class);
    $tenancy->hostname($hostname);
    $tenancy->tenant($website); // switches the tenant and reconfigures the app

    $posts = \App\Post::all();
    dd($posts->toArray());

});

