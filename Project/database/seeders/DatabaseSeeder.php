<?php

namespace Database\Seeders;

use Eloquent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /*
     * Run the database seeds (MediaLibrary example).
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();

        DB::unprepared(file_get_contents('resources/sql/create_schema.sql'));
        $this->command->info('DB: Schema created');

        DB::unprepared(file_get_contents('resources/sql/create_db.sql'));
        $this->command->info('DB: Database created');

        DB::unprepared(file_get_contents('resources/sql/indexes.sql'));
        $this->command->info('DB: Performance indexes created');

        DB::unprepared(file_get_contents('resources/sql/triggers.sql'));
        $this->command->info('DB: Triggers created');

        DB::unprepared(file_get_contents('resources/sql/udfs.sql'));
        $this->command->info('DB: Udfs created');
        $this->command->info('DB: Database seeded!');
    }
    }

