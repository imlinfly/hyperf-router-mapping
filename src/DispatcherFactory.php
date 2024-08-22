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
use Hyperf\Stringable\Str;

class DispatcherFactory extends HyperfDispatcherFactory
{
    protected function getPrefix(string $className, string $prefix): string
    {
        $prefix = parent::getPrefix($className, $prefix);

        $mappings = \Hyperf\Config\config('router_mapping', []);

        // 如果className是以mapping的key开头的，就替换成mapping的value
        foreach ($mappings as $key => $value) {
            // 匹配className 将
            // \$key\Controller\ 替换成 /$value/...
            // \$key\Test1\Controller\ 替换成 /$value/test1/...
            // \$key\Test1\Test2\Controller\ 替换成 /$value/test1/test2/...
            // ...

            // 将key转为正则匹配字符串
            $matchKey = str_replace('\\', '\\\\', $key);

            if (preg_match('/\\\\' . $matchKey . '((\\\[a-zA-Z0-9_]+)*)\\\Controller\\\/', $className, $matches)) {
                $path = $matches[1];
                // 将 \ 替换成 /
                $path = str_replace('\\', '/', $path);

                // 转为下划线
                if ('' !== $path) {
                    $path = strtolower(substr($path, 0, 2)) . substr($path, 2);
                    // 转为小驼峰
                    $path = Str::snake($path);
                }

                $prefix = '/' . $value . $path . $prefix;

                break;
            }
        }

        return $prefix;
    }
}
