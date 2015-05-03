<?php namespace Drapor\Networking\Commands;
use Illuminate\Console\Command;
use Illuminate\Container\Container;
use CreateServiceRequestsTable;
class NetworkingMigrateCommand extends Command
{
    /**
     * Name of the command.
     *
     * @param string
     */
    protected $name        = 'networking:migrate';

    protected $description = 'Migrate networking';

    public function __construct()
    {
        parent::__construct();
        $this->migrater =  new CreateServiceRequestsTable();
    }

    /**
     * Run the package migrations.
     */
    public function fire()
    {
       $this->migrater->up();
    }
}