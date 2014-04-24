<?php

/**
 * We need an API credentials file for functional tests.
 */
// if (!file_exists(__DIR__.'/tests/stubs/credentials.json')) {
//     die(
//         'Expected API credentials not found at: '.__DIR__.'/tests/stubs/credentials.json. '.
//         'Please see example at '.__DIR__.'/tests/stubs/credentials.sample.json'."\n"
//     );
// }

/**
 * Include the composer autoloader.
 */
require_once __DIR__.'/vendor/autoload.php';