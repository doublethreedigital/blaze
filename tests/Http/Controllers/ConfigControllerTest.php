<?php

namespace DoubleThreeDigital\Blaze\Tests\Http\Controllers;

use DoubleThreeDigital\Blaze\Tests\TestCase;
use Illuminate\Support\Facades\Config;
use Statamic\Facades\User;

class ConfigControllerTest extends TestCase
{
    /** @test */
    public function can_get_config()
    {
        $configData = [
            'foo' => 'bar',
            'bar' => 'foo',
            'bax' => 'baz',
            'baz' => 'bax',
        ];

        Config::set('blaze', $configData);

        $this
            ->actingAs($this->user())
            ->get(cp_route('blaze.config'))
            ->assertOk()
            ->assertJson([
                'config' => $configData,
            ]);
    }

    protected function user()
    {
        return User::make()
            ->makeSuper()
            ->email('joe.bloggs@example.com')
            ->save();
    }
}
