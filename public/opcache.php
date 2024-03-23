<?php

declare(strict_types=1);

if ('POST' === $_SERVER['REQUEST_METHOD']) {
    opcache_reset();
    echo '0';
}
