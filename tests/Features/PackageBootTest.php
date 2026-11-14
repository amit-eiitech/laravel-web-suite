<?php

namespace Eii\WebSuite\Tests\Features;

use Eii\WebSuite\WebSuiteServiceProvider;

it('loads the web suite service provider', function () {
    expect(class_exists(WebSuiteServiceProvider::class))->toBeTrue();
});
