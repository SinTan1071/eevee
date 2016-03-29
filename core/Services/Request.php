<?php

namespace Core\Services;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;

// create(
// $uri,
// $method = 'GET',
// $parameters = array(),
// $cookies = array(),
// $files = array(),
// $server = array(),
// $content = null);

class Request
{
    protected $app;

    protected $uri;

    protected $method;

    protected $params;

    protected $data;

    protected $content;

    protected $file;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function api(string $uri)
    {
        $this->uri = $uri;

        return $this;
    }

    public function params(array $params)
    {
        $this->params = $params;

        return $this;
    }

    public function post()
    {
        return $this->request('POST');
    }

    public function request($method)
    {
        $request = SymfonyRequest::create('/api/register', 'POST', [
          'username' => 'gue1437',
          'password' => 'Helloshic',
          'mail' => 'gue1437@lehu.io',
          ]);

        return $this->app->run($request);
    }
}
