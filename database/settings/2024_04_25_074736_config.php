<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('config.port', 2525);
        $this->migrator->add('config.theme', 'system');
    }
};
