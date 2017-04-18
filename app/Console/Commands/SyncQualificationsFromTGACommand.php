<?php namespace App\Console\Commands;

use App\Services\Sync\SyncQualificationService;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;

class SyncQualificationsFromTGACommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'inbound:sync-qualifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Qualifications from TGA.';

    /**
     * @var SyncQualificationService
     */
    private $qualification;

    /**
     * SyncSQSMessagesCommand constructor.
     * @param SyncQualificationService $inbound
     */
    public function __construct(SyncQualificationService $qualification)
    {
        parent::__construct();

        $this->qualification = $qualification;
    }

    public function fire()
    {
        $this->qualification->sync();
    }

}
