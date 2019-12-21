<?php

namespace App\Http\Middleware;
use Hyn\Tenancy\Models\Website;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Environment;


use Closure;

class Tenancy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $params = $request->route()->parameters();

        if(!isset($params['site'])) $params['site'] = "tenant1.demo.app";

        $hostname = Hostname::where('fqdn', $params['site'])->first();
        if(!$hostname) abort(403);

        $website = Website::find($hostname->website_id);
        $tenancy = app(Environment::class);
        $tenancy->hostname($hostname);
        $tenancy->tenant($website); // switches the tenant and reconfigures the app

        return $next($request);
    }
}
