<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Patrol;
use DB;
class TableClearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:table-clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Wyczyszczono zawartość tabeli w bazie danych';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Patrol::query()->delete();

        $this->info('Tabela została wyczyszczona!');
    }
}
