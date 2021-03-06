<?php

namespace DoubleThreeDigital\Blaze\Tests\Http\Controllers;

use DoubleThreeDigital\Blaze\Tests\TestCase;
use Statamic\Facades\Collection;
use Statamic\Facades\Entry;
use Statamic\Facades\GlobalSet;
use Statamic\Facades\Nav;
use Statamic\Facades\Role;
use Statamic\Facades\Taxonomy;
use Statamic\Facades\Term;
use Statamic\Facades\User;
use Statamic\Facades\UserGroup;

class BlazeControllerTest extends TestCase
{
    /** @test */
    public function can_search_for_entry()
    {
        Collection::make('pages')->save();

        Entry::make()
            ->id('id-one')
            ->collection('pages')
            ->slug('foo-die-bar')
            ->data([
                'title' => 'Foo Die Bar',
            ])
            ->save();

        $this
            ->actingAs($this->user())
            ->post(cp_route('blaze.search'), [
                'query' => 'Foo',
            ])
            ->assertOk()
            ->assertSee('Foo Die Bar')
            ->assertSee('id-one');
    }

    /** @test */
    public function can_search_for_term()
    {
        $this->markTestIncomplete();

        Taxonomy::make('categories')->save();

        Term::make()
            ->taxonomy('categories')
            ->slug('bax-die-foo')
            ->data([
                'title' => 'Bar Die Foo',
            ])
            ->save();

        $this
            ->actingAs($this->user())
            ->post(cp_route('blaze.search', [
                'query' => 'Bar',
            ]))
            ->assertOk()
            ->assertSee('Bar Die Foo')
            ->assertSee('id-two');
    }

    /** @test */
    public function can_search_for_users()
    {
        $this->markTestIncomplete();

        User::make()
            ->email('jan.smith@example.com')
            ->data(['name' => 'Jan Smith'])
            ->save();

        $this
            ->actingAs($this->user())
            ->post(cp_route('blaze.search', [
                'query' => 'Jan',
            ]))
            ->assertOk()
            ->assertSee('Jan Smith')
            ->assertSee('jan.smith@example.com');
    }

    /** @test */
    public function can_search_for_collection()
    {
        Collection::make('animals')
            ->title('Animals')
            ->save();

        $this
            ->actingAs($this->user())
            ->post(cp_route('blaze.search', [
                'query' => 'animals',
            ]))
            ->assertOk()
            ->assertSee('Animals')
            ->assertSee('animals');
    }

    /** @test */
    public function can_search_for_navigation()
    {
        Nav::make('header-nav')
            ->title('Header Nav')
            ->save();

        $this
            ->actingAs($this->user())
            ->post(cp_route('blaze.search', [
                'query' => 'header',
            ]))
            ->assertOk()
            ->assertSee('Header Nav')
            ->assertSee('header-nav');
    }

    /** @test */
    public function can_search_for_taxonomy()
    {
        Taxonomy::make('tags')
            ->title('Tags')
            ->save();

        $this
            ->actingAs($this->user())
            ->post(cp_route('blaze.search', [
                'query' => 'tags',
            ]))
            ->assertOk()
            ->assertSee('Tags')
            ->assertSee('tags');
    }

    /** @test */
    public function can_search_for_global_set()
    {
        $globalSet = GlobalSet::make('seo');
        $globalSet->addLocalization($globalSet->makeLocalization('default'))->title('SEO');
        $globalSet->save();

        $this
            ->actingAs($this->user())
            ->post(cp_route('blaze.search', [
                'query' => 'SEO',
            ]))
            ->assertOk()
            ->assertSee('SEO')
            ->assertSee('seo');
    }

    /** @test */
    public function can_search_for_nav_item()
    {
        $this
            ->actingAs($this->user())
            ->post(cp_route('blaze.search', [
                'query' => 'Updates',
            ]))
            ->assertOk()
            ->assertSee('Updates')
            ->assertSee('updater');
    }

    /** @test */
    public function can_search_for_blueprint()
    {
        $this
            ->actingAs($this->user())
            ->post(cp_route('blaze.search', [
                'query' => 'Crazio',
            ]))
            ->assertOk()
            ->assertSee('Crazio')
            ->assertSee('blueprints');
    }

    /** @test */
    public function can_search_for_fieldset()
    {
        $this
            ->actingAs($this->user())
            ->post(cp_route('blaze.search', [
                'query' => 'Coolz',
            ]))
            ->assertOk()
            ->assertSee('Coolzies')
            ->assertSee('fieldsets');
    }

    /** @test */
    public function can_search_for_utility()
    {
        $this
            ->actingAs($this->user())
            ->post(cp_route('blaze.search', [
                'query' => 'Cache Ma',
            ]))
            ->assertOk()
            ->assertSee('Cache Manager')
            ->assertSee('utilities');
    }

    /** @test */
    public function can_search_for_user_group()
    {
        UserGroup::make()
            ->handle('authors')
            ->title('Authors')
            ->save();

        $this
            ->actingAs($this->user())
            ->post(cp_route('blaze.search', [
                'query' => 'Autho',
            ]))
            ->assertOk()
            ->assertSee('Authors')
            ->assertSee('groups');
    }

    /** @test */
    public function can_search_for_user_role()
    {
        Role::make('content-editors')
            ->title('Content Editors')
            ->save();

        $this
            ->actingAs($this->user())
            ->post(cp_route('blaze.search', [
                'query' => 'Content Ed',
            ]))
            ->assertOk()
            ->assertSee('Content Editors')
            ->assertSee('roles');
    }

    /** @test */
    public function can_search_for_documentation_page()
    {
        $this
            ->actingAs($this->user())
            ->post(cp_route('blaze.search', [
                'query' => 'Independent',
            ]))
            ->assertOk()
            ->assertSee('Using an Independent Authentication Guard')
            ->assertSee('using-an-independent-authentication-guard');
    }

    /**
     * @test
     * https://github.com/doublethreedigital/blaze/issues/35
     */
    public function cant_search_for_documentation_page_that_contains_german_umlaut()
    {
        $this
            ->actingAs($this->user())
            ->post(cp_route('blaze.search', [
                'query' => '??',
            ]))
            ->assertOk()
            ->assertDontSee('order_type')
            ->assertDontSee('offset');
    }

    protected function user()
    {
        return User::make()
            ->makeSuper()
            ->email('joe.bloggs@example.com')
            ->save();
    }
}
