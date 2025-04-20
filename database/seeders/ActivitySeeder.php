<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        $activities = ['Программист', 'Дизайнер', 'Колхозник'];

        foreach ($activities as $activityName) {
            Activity::create([
                'name' => $activityName,
            ]);
        }
    }
}
