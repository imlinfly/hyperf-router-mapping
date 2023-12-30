<?php

/**
 * Created by PhpStorm.
 * User: LinFei
 * Created time 2023/12/23 23:38:25
 * E-mail: fly@eyabc.cn
 */
declare (strict_types=1);

namespace Lynnfly\HyperfRouterMapping;

use Hyperf\HttpServer\Router\DispatcherFactory as HyperfDispatcherFactory;

class DispatcherFactory extends HyperfDispatcherFactory
{
    protected function getPrefix(string $className, string $prefix): string
    {
        $prefix = parent::getPrefix($className, $prefix);

        $mappings = \Hyperf\Config\config('router_mapping', []);

        // 如果className是以mapping的key开头的，就替换成mapping的value
        foreach ($mappings as $key => $value) {
            if (str_contains($className, '\\' . $key . '\Controller') || str_contains($className, '\Controller\\' . $key . '\\')) {
                // // 如果prefix是以mapping的key开头的，就替换成mapping的value
                // if (str_contains($prefix, '/' . $key . '/')) {
                //     $prefix = str_replace('/' . $key . '/', '/' . $value . '/', $prefix);
                // }
                $prefix = '/' . $value . $prefix;
            }
        }

        return $prefix;
    }
}
