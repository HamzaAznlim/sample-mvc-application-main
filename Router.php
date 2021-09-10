<?php
namespace app;

class Router
{
    public array $getRoutes=[];
    public array $postRoutes=[];
    public array $params=array();
    private static array $tmp = array();
   


    public function match($strUrlTemplate, $strUrl)
    {
        $strUrlRegex = preg_replace_callback(
            '~\{([^{}]+)\}~',
            function ($matches) {
                $repl = '([^)]+)';
                self::$tmp[] = $matches[1];
                return $repl;
            },
            $strUrlTemplate
        );

        $UrlArray = array();
        $matches = array();
        $strUrlRegex = str_replace('/', '\/', $strUrlRegex);

        if (preg_match("/^" . $strUrlRegex . "$/", $strUrl, $matches)) {
            for ($i = 0; $i < count(self::$tmp); $i++) {
                @$UrlArray[self::$tmp[$i]] = $matches[$i + 1];
            }

      

            self::$tmp = array();
            $UrlArray['route']=$strUrl;
            
            return $UrlArray;
        }

        return false;
    }



    public function get($url="/", $fn)
    {
        $this->getRoutes[$url]=$fn;
    }



    public function post($url, $fn)
    {
        $this->postRoutes[$url]=$fn;
    }


    protected function getRouteParams($currentUrl, $Method = 'GET')
    {
        $m__ = ($Method == 'GET') ? "getRoutes" :"postRoutes";

        foreach (array_keys($this->$m__) as $routeParam) {
            if ($this->match($routeParam, $currentUrl)) {
                $realRoute= $this->match($routeParam, $currentUrl);
          
                if (is_array($realRoute) && isset($realRoute)) {
                    $this->$m__[$currentUrl] = $this->$m__[$routeParam];
                } else {
                    unset($this->$m__[$routeParam]);
                }
            }
        }
        if (isset($realRoute)) {
            if (is_array($realRoute)) {
                foreach ($realRoute as $key => $value) {
                    if ($key !== 'route') {
                        $this->params[$key] =$value;
                    }
                }
            }
        }
    }


    public function resolve()
    {
        $currentUrl = $_SERVER['PATH_INFO'] ?? '/';
        $Method     = $_SERVER['REQUEST_METHOD'];
        $fn = $this->getRoutes[$currentUrl] ?? null;
        $params=array();


        if ($Method === "GET") {
            $this->getRouteParams($currentUrl);
            $fn = $this->getRoutes[$currentUrl] ?? null;
        } else {
            $fn = $this->postRoutes[$currentUrl] ?? null;
        }
        if ($fn) {
            call_user_func($fn, $this, new Request());
        } else {
            call_user_func(['app\controllers\NotfoundController','index'], $this);
        }
    }

    public function view($view, $param=[])
    {
        foreach ($param as $key => $value) {
            $$key=$value;
        }
        
        if (\file_exists(VIEW_PATH."$view.php")) {
            include_once VIEW_PATH."$view.php";
        } else {
            include_once VIEW_PATH."notFound/viewNotFound.php";
        }
    }
    public function renderRoute()
    {
        include_once ROUTE_PATH."web.php";
    }
}
