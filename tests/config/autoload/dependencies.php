<?php

/**
 * Created by PhpStorm.
 * User: anonymous
 * Created time 2024/8/22 20:18
 * Email: anonymous@qq.com
 */
declare (strict_types=1);

use Hyperf\Config\ConfigFactory;
use Hyperf\Contract\ConfigInterface;

return [
    ConfigInterface::class => ConfigFactory::class,
];
