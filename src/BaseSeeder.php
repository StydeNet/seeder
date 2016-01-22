<?php

namespace Styde\Seeder;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

abstract class BaseSeeder extends Seeder
{
    protected $truncate = array();
    protected $seeders = array();

    /**
     * Run the database seeds.
     */
    public function run()
    {
        $this->truncateTables($this->truncate);
        $this->seed($this->seeders);
    }

    protected function seed($seeders)
    {
        foreach ($this->seeders as $seeder) {
            Model::unguard();
            $this->call(Helper::buildSeederName($seeder));
        }
    }

    protected function truncateTables(array $tables)
    {
        $this->checkForeignKeys(false);

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }

        $this->checkForeignKeys(true);
    }

    protected function checkForeignKeys($check)
    {
        $check = $check ? '1' : '0';
        DB::statement("SET FOREIGN_KEY_CHECKS = $check;");
    }

}
