<?php namespace Users\Middleware;


use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Routing\Middleware;
use \Illuminate\Routing\Route;

class UserAccess implements Middleware {

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;
    /**
     * @var Router
     */
    private $router;

    /**
     * Create a new filter instance.
     *
     * @param  Guard $auth
     */
    public function __construct( Guard $auth, Route $router )
    {
        $this->auth = $auth;
        $this->router = $router;
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
        // Same id as the route or admin
        if ( $this->auth->guest() ||
            (
                !$this->auth->user()->isAdmin() && $this->router->parameter('users') != $this->auth->user()->id
            )
        )
        {
            if ( $request->ajax() )
            {
                return response('Unauthorized.', 401);
            }

            return redirect("/");
        }

        return $next($request);
    }
}