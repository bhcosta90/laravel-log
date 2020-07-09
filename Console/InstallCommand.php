<?php

namespace BRCas\Log\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'brcas:log-install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all of the BRCas Log resources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->comment('Publishing BRCas Log Configuration...');
        $this->call('vendor:publish', ['--tag' => 'brcas-log-config']);
    }
}
