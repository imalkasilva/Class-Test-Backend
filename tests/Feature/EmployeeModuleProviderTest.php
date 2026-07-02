<?php

test('employee module service provider is discoverable', function () {
    expect(class_exists(\Modules\Employee\Providers\EmployeeServiceProvider::class))->toBeTrue();
});
