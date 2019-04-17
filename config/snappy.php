<?php

return [
    'pdf' => [
        'enabled' => true,
        'binary'  => ENV('WKHTMLTOPDFPATH', '/usr/bin/wkhtmltopdf'),
        'timeout' => false,
        'options' => [],
        'env'     => [],
    ],
    'image' => [
        'enabled' => true,
        'binary'  => ENV('WKHTMLTOIMGPATH', '/usr/bin/wkhtmltoimage'),
        'timeout' => false,
        'options' => [],
        'env'     => [],
    ],
];
