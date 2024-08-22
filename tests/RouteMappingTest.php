<?php

/**
 * Created by PhpStorm.
 * User: anonymous
 * Created time 2024/01/17 17:05:13
 * E-mail: anonymous@qq.com
 */
declare (strict_types=1);

use Hyperf\Context\ApplicationContext;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Di\Container;
use Hyperf\Di\Definition\DefinitionSourceFactory;
use Lynnfly\HyperfRouterMapping\DispatcherFactory;
use PHPUnit\Framework\TestCase;

class RouteMappingTest extends TestCase
{
    // ./vendor/bin/phpunit  --colors=always ./tests/RouteMappingTest.php --filter testGetPrefix
    public function testGetPrefix()
    {
        define('BASE_PATH', __DIR__);

        $container = new Container((new DefinitionSourceFactory())());
        ApplicationContext::setContainer($container);

        $config = $container->get(ConfigInterface::class);
        $config->set('router_mapping', [
            'Api\AaaBbb' => 'api_aaa_bbb',
            'Api' => 'api',
            'ApiV1' => 'api/v1',
        ]);

        $items = [
            ['class' => 'TestApp\Controller\TestController', 'prefix' => '', 'result' => '/test'],
            ['class' => 'TestApp\Controller\AaaBbb\TestController', 'prefix' => '', 'result' => '/aaa_bbb/test'],
            ['class' => 'TestApp\Api\Controller\TestController', 'prefix' => '', 'result' => '/api/test'],
            ['class' => 'TestApp\Api\Controller\TestController', 'prefix' => 'test_api', 'result' => '/api/test_api'],
            ['class' => 'TestApp\Api\AaaBbb\Controller\TestController', 'prefix' => 'test_api', 'result' => '/api_aaa_bbb/test_api'],
            ['class' => 'TestApp\Api\AaaBbb\Controller\TestController', 'prefix' => '', 'result' => '/api_aaa_bbb/test'],
            ['class' => 'TestApp\Api\BbbAaa\Controller\TestController', 'prefix' => 'test_api', 'result' => '/api/bbb_aaa/test_api'],
            ['class' => 'TestApp\Api\BbbAaa\Controller\TestController', 'prefix' => '', 'result' => '/api/bbb_aaa/test'],
            ['class' => 'TestApp\Api\Demo\Controller\DemoController', 'prefix' => '', 'result' => '/api/demo/demo'],
            ['class' => 'TestApp\Api\Demo\Controller\DemoController', 'prefix' => '(null)', 'result' => '/api/demo'],
            ['class' => 'TestApp\Api\Demo\Controller\DemoController', 'prefix' => '/demo', 'result' => '/api/demo'],
            ['class' => 'TestApp\Api\User\Demo\Controller\DemoController', 'prefix' => '/user/demo', 'result' => '/api/user/demo'],
            ['class' => 'TestApp\Api\User\Demo\Controller\DemoController', 'prefix' => '(null)', 'result' => '/api/user/demo'],
            ['class' => 'TestApp\ApiV1\User\Controller\AuthController', 'prefix' => '', 'result' => '/api/v1/user/auth'],
        ];

        $instance = $container->get(DispatcherFactory::class);
        $ref = new ReflectionObject($instance);
        $method = $ref->getMethod('getPrefix');
        $method->setAccessible(true);

        foreach ($items as $item) {
            $result = $method->invokeArgs($instance, [$item['class'], $item['prefix']]);
            var_dump('class ' . $item['class'] . ' prefix ' . $item['prefix'] . ' result: ' . $result);
            $this->assertEquals($item['result'], $result);
        }
    }
}
