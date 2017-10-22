<?php

namespace Bundle\UrlParamTest;
use Silex\Application;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class Test extends \Bolt\Extension\SimpleExtension {

    /**
     * @inheritdoc
     */
    protected function registerServices(Application $app)
    {
        $app['url_generator'] = $app->extend(
            'url_generator',
            function (UrlGeneratorInterface $urlGenerator) use ($app) {
                return new Routing\UrlOverrider($urlGenerator, $app);
            }
        );
    }
}
