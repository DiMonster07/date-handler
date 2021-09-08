<?php declare(strict_types=1);

namespace App\Command;

use App\Handler\DateHandler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class DateCommand.
 */
class DateCommand extends Command
{
    /**
     * {@inheritdoc}
     */
    protected static $defaultName = 'app:date';

    /**
     * @var DateHandler
     */
    protected DateHandler $dateHandler;

    /**
     * {@inheritdoc}
     */
    public function __construct(DateHandler $dateHandler, string $name = null)
    {
        parent::__construct($name);

        $this->dateHandler = $dateHandler;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setDescription('Get allowed dates')
            ->addOption('get-allowed-for-edit')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if ($input->getOption('get-allowed-for-edit')) {
            $datesAllowedForEdit = $this->dateHandler->getDatesAllowedForEdit();
            $datesAllowedForEditCount = count($datesAllowedForEdit);

            $output->writeln('<info>Count: </info>' . count($datesAllowedForEdit));
            if ($datesAllowedForEditCount === 0) {
                return 0;
            }

            $output->writeln('Dates:');
            foreach ($datesAllowedForEdit as $dateAllowedForEdit) {
                $output->writeln(sprintf('    %s', $dateAllowedForEdit->format('d.m.Y')));
            }
        }

        return 0;
    }
}