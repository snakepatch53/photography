<?php

class RAdapter
{
    // constructor
    private $router;
    private String $path;
    private string $http_domain;
    /**
     * The function __construct() is a constructor method that is called when an object is instantiated. It is used to initialize the
     * object's properties
     * 
     * @param router The router object
     * @param string path The path to the folder where the images are stored.
     * @param string http_domain The domain name of the website.
     */
    function __construct($router, string $path, string $http_domain)
    {
        $this->router = $router;
        $this->path = $path;
        $this->http_domain = $http_domain;
    }

    /**
     * It creates a route that renders a view
     * 
     * @param String selector The route selector
     * @param String name The name of the view
     * @param callback This is a function that will be executed before the view is rendered.
     * @param middleware This is a function that will be executed before the view is rendered.
     * @param bool auto_include If true, it will include a file with the same name as the view name.
     */
    public function getHTML(String $selector, String $name, $callback = null, $middleware = null, bool $auto_include = true)
    {
        $this->router->get($selector, function (...$args) use ($name, $callback, $middleware, $auto_include) {
            $path = $this->path;
            $http_domain = $this->http_domain;
            $DATA = [
                "title" => ucfirst($name),
                "name" => strtolower($name),
                "path" => $path,
                "http_domain" => $http_domain,
                "mysqlAdapter" => new MysqlAdapter(
                    $_ENV['DB_HOST'],
                    $_ENV['DB_USER'],
                    $_ENV['DB_PASS'],
                    $_ENV['DB_NAME'],
                    $_ENV['DB_PORT']
                ),
            ];

            // Comprobar si se envio un callback
            if ($callback) {
                $callback_respponse = $callback($DATA, ...$args);
                // Comprobar si el callback devuelve un array para unirlo al array DATA
                if (is_array($callback_respponse)) $DATA = array_merge($DATA, $callback_respponse);
            }

            // Comprobar si se envio un middleware
            if ($middleware) {
                $middleware_respponse = $middleware($DATA, ...$args);
                // Comprobar si el middleware devuelve un array para unirlo al array DATA
                if (is_array($middleware_respponse)) $DATA = array_merge($DATA, $middleware_respponse);
            }
            // Comprobar si se envio quiere que se incluya un archivo con el mismo nombre que el nombre de la vista
            if ($auto_include == true) {
                // Comprobar si existe el archivo
                if (file_exists($path . $name . '.php')) {
                    (fn ($DATA, ...$args) => include($path . $name . '.php'))($DATA, ...$args);
                } else {
                    throw new Exception("View name not found: " . $path . $name . '.php');
                }
            }
        });
    }

    /**
     * It sets a 404 page.
     * 
     * @param String name The name of the view
     * @param callback This is a function that will be executed before the view is rendered.
     * @param middleware This is a function that will be executed before the view is loaded.
     * @param bool auto_include If true, it will automatically include a file with the same name as the view name.
     */
    public function set404(String $name, $callback = null, $middleware = null, bool $auto_include = true)
    {
        $this->router->set404(function (...$args) use ($name, $callback, $middleware, $auto_include) {
            $path = $this->path;
            $http_domain = $this->http_domain;
            $DATA = [
                "title" => ucfirst($name),
                "name" => $name,
                "path" => $path,
                "http_domain" => $http_domain,
                "mysqlAdapter" => new MysqlAdapter(
                    $_ENV['DB_HOST'],
                    $_ENV['DB_USER'],
                    $_ENV['DB_PASS'],
                    $_ENV['DB_NAME'],
                    $_ENV['DB_PORT']
                ),
            ];

            // Comprobar si se envio un callback
            if ($callback) {
                $callback_respponse = $callback($DATA, ...$args);
                // Comprobar si el callback devuelve un array para unirlo al array DATA
                if (is_array($callback_respponse)) $DATA = array_merge($DATA, $callback_respponse);
            }

            // Comprobar si se envio un middleware
            if ($middleware) {
                $middleware_respponse = $middleware($DATA, ...$args);
                // Comprobar si el middleware devuelve un array para unirlo al array DATA
                if (is_array($middleware_respponse)) $DATA = array_merge($DATA, $middleware_respponse);
            }
            // Comprobar si se envio quiere que se incluya un archivo con el mismo nombre que el nombre de la vista
            if ($auto_include == true) {
                // Comprobar si existe el archivo
                if (file_exists($path . $name . '.php')) {
                    (fn ($DATA, ...$args) => include($path . $name . '.php'))($DATA, ...$args);
                } else {
                    throw new Exception("View name not found: " . $path . $name . '.php');
                }
            }
        });
    }

    /**
     * It's a function that receives a selector, a callback and a middleware. The callback and middleware are optional
     * 
     * @param String selector The route selector, e.g. /user/{id}
     * @param callback This is the function that will be executed when the route is called.
     * @param middleware This is a function that will be executed before the callback.
     */
    public function post(String $selector, $callback = null, $middleware = null)
    {
        $this->router->post($selector, function (...$args) use ($callback, $middleware) {
            $path = $this->path;
            $http_domain = $this->http_domain;
            $DATA = [
                "path" => $path,
                "http_domain" => $http_domain,
                "mysqlAdapter" => new MysqlAdapter(
                    $_ENV['DB_HOST'],
                    $_ENV['DB_USER'],
                    $_ENV['DB_PASS'],
                    $_ENV['DB_NAME'],
                    $_ENV['DB_PORT']
                ),
                "autorized" => true
            ];
            // Comprobar si se envio un callback
            if ($callback) {
                $callback_respponse = $callback($DATA, ...$args);
                // Comprobar si el callback devuelve un array para unirlo al array DATA
                if (is_array($callback_respponse)) $DATA = array_merge($DATA, $callback_respponse);
            }

            if ($DATA['autorized'] == false) {
                echo json_encode([
                    "status" => "error",
                    "message" => "Don't have permission to access this resource",
                    "response" => false,
                    "data" => []
                ]);
                return;
            }
            // Comprobar si se envio un middleware
            if ($middleware) {
                $middleware_respponse = $middleware($DATA, ...$args);
                // Comprobar si el middleware devuelve un array para unirlo al array DATA
                if (is_array($middleware_respponse)) $DATA = array_merge($DATA, $middleware_respponse);
            }
        });
    }

    /**
     * This function returns the router object.
     * 
     * @return Router The router object.
     */
    public function getRouter()
    {
        return $this->router;
    }
}
