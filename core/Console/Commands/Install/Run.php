<?php

namespace Core\Console\Commands\Install;

use Illuminate\Console\Command;

class Run extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install EEVEE.';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->comment('Eevee version(1.0)');

        if (!$this->confirm('begin ? [y|N]')) {
          return false;
        }
        $name = $this->ask('database host ?');
        $name = $this->ask('database ?');
        $name = $this->ask('database  ?');
        $name = $this->secret('database password ?');
        $name = $this->ask('database table prefix ?');

        $name = $this->ask('root username ?');
        $name = $this->ask('root mail ?');
        $name = $this->secret('root password ?');

    }
}
