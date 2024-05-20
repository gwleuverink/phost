<?php

namespace Database\Factories;

use Illuminate\Support\Facades\Blade;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'content' => $this->rawMessage([
                'title' => 'Hello World!',
            ]),
            'bookmarked' => false,
            'read_at' => null,
        ];
    }

    public function bookmarked(): Factory
    {
        return $this->state(fn () => [
            'bookmarked' => true,
        ]);
    }

    public function content(array $variables): Factory
    {
        return $this->state(fn () => [
            'content' => $this->rawMessage($variables),
        ]);
    }

    private function rawMessage(array $variables)
    {
        return Blade::render(
            file_get_contents(database_path('factories/stubs/raw-message.blade.php')),
            $variables,
            deleteCachedView: true
        );
    }
}
