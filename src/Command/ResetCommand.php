<?php
/**
 * @see https://github.com/japseyz/dot-migrations/ for the canonical source repository
 * @copyright Copyright (c) 2017 Apidemia (https://www.apidemia.com)
 * @license https://github.com/japseyz/dot-migrations/blob/master/LICENSE.md MIT License
 */

declare(strict_types=1);

namespace Dot\Migrations\Command;

use Zend\Console\Adapter\AdapterInterface;
use ZF\Console\Route;

/**
 * Class ResetCommand
 * @package Dot\Migrations\Command
 */
class ResetCommand extends BaseCommand
{
    /**
     * @param Route $route
     * @param AdapterInterface $console
     * @return int
     */
    public function __invoke(Route $route, AdapterInterface $console)
    {
        // Check for production
        if ($this->shouldAbortInProduction($console)) {
            return 0;
        }

        // Let the user know that the command has started
        $console->writeLine('Resetting tables');

        // Run the Phinx command
        \exec(
            $this->shellPath.' rollback -t 0 -f '.
            '-e '.$this->env.' '.
            '-c '.$this->configPath.' ',
            $this->output,
            $this->failure
        );

        if (! $this->failure) {
            // Let the user know that the command has finished
            $console->writeLine('Finished resetting tables');
        }

        return 0;
    }
}
