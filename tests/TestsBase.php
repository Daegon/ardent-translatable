<?php

use Orchestra\Testbench\TestCase;

abstract class TestsBase extends TestCase {

  public function setUp()
    {

        parent::setUp();

        App::register('Dimsav\Translatable\TranslatableServiceProvider');

        $this->resetDatabase();
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['path.base'] = __DIR__ . '/../src';
        $app['config']->set('database.default', 'mysql');
        $app['config']->set('database.connections.mysql', array(
            'driver'   => 'mysql',
            'host' => 'localhost',
            'database' => 'ardent_translatable_test',
            'username' => 'homestead',
            'password' => 'secret',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ));
        $app['config']->set('translatable::locales', array('nl', 'el', 'en', 'fr', 'de', 'id'));
    }

    private function resetDatabase()
    {
        $artisan = $this->app->make('artisan');

        // This creates the "migrations" table if not existing
        $artisan->call('migrate', [
            '--database' => 'mysql',
            '--path'     => '../tests/migrations',
        ]);

        // We empty the tables
        $artisan->call('migrate:reset', [
            '--database' => 'mysql',
        ]);
        // We fill the tables
        $artisan->call('migrate', [
            '--database' => 'mysql',
            '--path'     => '../tests/migrations',
        ]);

    }
}