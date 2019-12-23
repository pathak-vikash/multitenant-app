<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hyn\Tenancy\Models\Website;
use Hyn\Tenancy\Contracts\Repositories\WebsiteRepository;

use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;
use Hyn\Tenancy\Environment;

class SitesController extends Controller
{
    
    public function connect($site){
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

        return $website->hostnames;
    }

    public function switch($site){
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
        return $tenancy->hostname();
    }
}
