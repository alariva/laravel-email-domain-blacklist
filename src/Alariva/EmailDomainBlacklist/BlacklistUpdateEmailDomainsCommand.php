<?php

namespace Alariva\EmailDomainBlacklist;

use Alariva\EmailDomainBlacklist\Updater;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class BlacklistUpdateEmailDomainsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blacklist:update-email-domains';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update cache for email domains blacklist';

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
     * @return mixed
     */
    public function handle()
    {
        $count = Updater::update();

        if ($count === false) {
            $this->warn('No domains retrieved. Check the email.blacklist.source key for validation config.');

            return;
        }

        if ($count === 0) {
            $this->info('Advice: Blacklist was retrieved from source but 0 domains were listed.');

            return;
        }

        $this->info("{$count} domains retrieved. Cache updated. You are good to go.");
    }
}
