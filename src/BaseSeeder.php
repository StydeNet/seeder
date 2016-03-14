<?php
namespace Styde\Seeder;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

abstract class BaseSeeder extends Seeder
{
    /**
     * Database tables to truncate.
     *
     * @var array
     */
    protected $truncate = array();

    /**
     * Seeder names to run.
     *
     * @var array
     */
    protected $seeders = array();

    /**
     * Run the database seeds.
     *
     * @return  void
     */
    public function run()
    {
        $this->truncateTables($this->truncate);
        $this->seed($this->seeders);
    }

    /**
     * Seed every seeder listed in $seeders array.
     *
     * @param  array $seeders
     *
     * @return void
     */
    protected function seed($seeders)
    {
        foreach ($this->seeders as $seeder) {
            Model::unguard();
            $this->call(Helper::buildSeederName($seeder));
        }
    }

    /**
     * Truncate database tables.
     *
     * @param  array  $tables
     *
     * @return void
     */
    protected function truncateTables(array $tables)
    {
        $this->checkForeignKeys(false);

        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }

        $this->checkForeignKeys(true);
    }

    /**
     * Enable or disable the check of the foreign keys constraints.
     *
     * @param  bool $check
     *
     * @return void
     */
    protected function checkForeignKeys($check)
    {
        $check = $check ? '1' : '0';
        DB::statement('SET FOREIGN_KEY_CHECKS = '.$check.';');
    }
}
