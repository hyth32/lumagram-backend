<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        $activities = ['Программист', 'Дизайнер', 'Колхозник'];

        foreach ($activities as $name) {
            try {
                Activity::create(['name' => $name]);
                $this->command->info("Created: $name");
            } catch (\Exception $e) {
                $this->command->error($e->getMessage());
            }
        }
    }
}
