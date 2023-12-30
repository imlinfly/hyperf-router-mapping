<?php

/**
 * Created by PhpStorm.
 * User: LinFei
 * Created time 2023/12/14 14:11:28
 * E-mail: fly@eyabc.cn
 */
declare(strict_types=1);

namespace Lynnfly\HyperfRouterMapping;


use Hyperf\HttpServer\Router\DispatcherFactory as HyperfDispatcherFactory;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
                HyperfDispatcherFactory::class => DispatcherFactory::class,
            ],
            'publish' => [
                [
                    'id' => 'config',
                    'description' => 'The config of ',
                    'source' => __DIR__ . '/../publish/router_mapping.php',
                    'destination' => BASE_PATH . '/config/autoload/router_mapping.php',
                ],
            ],
        ];
    }
}
