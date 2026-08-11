<?php
/**
 * =============================================================================
 * ConstantMVC — Router
 * =============================================================================
 *
 * The router is the traffic controller of the MVC flow. Every request has
 * already been rewritten by .htaccess into index.php?url=<path>. The router
 * takes that <path>, looks it up in the routes table (defined in index.php),
 * and calls the matching "Controller@method".
 *
 * REQUEST FLOW:  browser → .htaccess → index.php → Router → Controller → Model → View
 */

final class Router
{
    /** The routes table: 'url' => 'ControllerName@methodName'. */
    private array $routes = [];

    public function __construct(array $routes)
    {
        // Normalise every route key once, so lookups are predictable.
        foreach ($routes as $url => $action) {
            $this->routes[$this->clean($url)] = $action;
        }
    }

    /**
     * Match the requested URL to a route and run its controller action.
     */
    public function run(string $url): mixed
    {
        $url = $this->clean($url);

        if (!array_key_exists($url, $this->routes)) {
            http_response_code(404);
            exit('404 — no route defined for this URL.');
        }

        // Split "PersonController@index" into the class and the method.
        [$controller, $method] = explode('@', $this->routes[$url]);

        // Load the controller file from app/Controllers/.
        $path = __DIR__ . "/../app/Controllers/{$controller}.php";
        if (!file_exists($path)) {
            http_response_code(500);
            exit("Controller '{$controller}' does not exist.");
        }
        require_once $path;

        if (!class_exists($controller) || !method_exists($controller, $method)) {
            http_response_code(500);
            exit("Route action '{$controller}@{$method}' is not callable.");
        }

        // Hand control to the controller — the "C" in MVC takes over from here.
        return (new $controller())->$method();
    }

    /** Trim slashes and lower-case a URL so "/Create/" and "create" match. */
    private function clean(string $url): string
    {
        return strtolower(trim($url, '/'));
    }
}
