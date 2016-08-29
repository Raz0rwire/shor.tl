<?php

class SmokeTest extends PHPUnit_Framework_TestCase
{
    private function setupApp(string $url)
    {
        $config = array_merge(include('config/database.php'), include('config/defaults.php'));

        return app(
            $config,
            [
                'REQUEST_URI' => $url
            ],
            instantiate_class('\Shortl\Shortl\Infrastructure\RequestParser'),
            instantiate_class('\Shortl\Shortl\Infrastructure\ActionMapper'),
            instantiate_class('\Shortl\Shortl\Infrastructure\ResponseFactory')
        );
    }

    public function testIfMalformattedUrlsResultsInMissingAction()
    {
        $app = $this->setupApp('/malformatted/url');

        $headers = xdebug_get_headers();
        $this->assertContains('Type-Of-Missing: action', $headers);
    }


    public function testIfWellFormattedUrlsResultInMissingEntity()
    {
        $config = array_merge(include('config/database.php'), include('config/defaults.php'));

        $app = $this->setupApp('/test');

        $headers = xdebug_get_headers();
        $this->assertContains('Type-Of-Missing: entity', $headers);
    }

    public function testIfShortenedUrlIsCreatedCorrectly()
    {
        $config = array_merge(include('config/database.php'), include('config/defaults.php'));

        $app = $this->setupApp('/new?url=https://google.com/time/' . time());

        $headers = xdebug_get_headers();
        $this->assertContains('Content-Type: application/json', $headers);

        $content = json_decode($app);
        $this->assertNotNull($content);
        $this->assertObjectHasAttribute('data',$content);
    }


    public function testIfMalformattedUrlIsNotShortened()
    {
        $config = array_merge(include('config/database.php'), include('config/defaults.php'));
        $app = $this->setupApp('/new?url=https://google.com/space here this should not validate');

        $headers = xdebug_get_headers();
        $this->assertContains('Content-Type: application/json', $headers);

        $content = json_decode($app);
        $this->assertNotNull($content);
    }

    public function testIfShortenedUrlIsCreatedCorrectlyAndFoundCorrectly()
    {
        $config = array_merge(include('config/database.php'), include('config/defaults.php'));

        $url = '/new?url=https://google.com/time/' . time();
        $app = $this->setupApp($url);

        $headers = xdebug_get_headers();
        $this->assertContains('Content-Type: application/json', $headers);

        $content = json_decode($app);
        $this->assertNotNull($content);
        $this->assertObjectHasAttribute('data',$content);

        $url_parts = explode('/',$content->data->short_url);
        $short_url = '/'.(array_pop($url_parts));
        $app = $this->setupApp($short_url);

        $headers = xdebug_get_headers();
        $this->assertContains('Location: '.$content->data->url, $headers);
    }

}