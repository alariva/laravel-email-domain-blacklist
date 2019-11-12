<?php

namespace Tests;

use Alariva\EmailDomainBlacklist\BlacklistUpdateEmailDomainsCommand;
use Alariva\EmailDomainBlacklist\Updater;
use Illuminate\Support\Facades\Config;
use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Tester\CommandTester;

class ConsoleTest extends BaseTestCase
{
    protected $command;

    protected $commandTester;

    protected $stubPath = __DIR__.'/stubs/source.json';

    public function setUp(): void
    {
        parent::setUp();

        $application = new ConsoleApplication();

        $testedCommand = $this->app->make(BlacklistUpdateEmailDomainsCommand::class, [Updater::class]);
        $testedCommand->setLaravel(app());
        $application->add($testedCommand);

        $this->command = $application->find('blacklist:update-email-domains');

        $this->commandTester = new CommandTester($this->command);
    }

    /** @test */
    public function it_syncs_blacklist_from_external_source_via_console()
    {
        Config::set('validation.email.blacklist.source', $this->stubPath);

        $this->commandTester->execute([
            'command' => $this->command->getName(),
        ]);

        $records = $this->getStubRecordsCount();

        $this->assertRegExp("/{$records} domains retrieved/", $this->commandTester->getDisplay());
    }

    protected function getStubRecordsCount()
    {
        return count(json_decode(file_get_contents($this->stubPath)));
    }
}
