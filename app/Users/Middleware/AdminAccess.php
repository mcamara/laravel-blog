<?php namespace Users\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Routing\Middleware;

class AdminAccess implements Middleware {

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard $auth
     */
    public function __construct( Guard $auth )
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Closure $next
     * @return mixed
     */
    public function handle( $request, Closure $next )
    {
        if ( $this->auth->guest() || !$this->auth->user()->isAdmin() )
        {
            if ( $request->ajax() )
            {
                return response('Unauthorized.', 401);
            } else
            {
                return redirect("/");
            }
        }

        return $next($request);
    }
}




