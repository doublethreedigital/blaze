<?php

namespace DoubleThreeDigital\Zippy\Tests\Http\Controllers;

use DoubleThreeDigital\Zippy\Tests\TestCase;
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

        Config::set('zippy', $configData);

        $this
            ->actingAs($this->user())
            ->get(cp_route('zippy.config'))
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
