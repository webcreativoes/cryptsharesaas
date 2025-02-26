<?php
declare(strict_types=1);

namespace BefineSolutionsAG\Cryptsharesaas\Command;

use DateTime;
use DateInterval;
use TYPO3\CMS\Core\Core\Environment;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MaintainanceContractDataCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('cryptsharesaas:maintainance-contract-data')
            ->setDescription('Deletes old contract data files and logs the process.')
            ->setHelp('This command removes contract data files older than 2 days from the logging directory.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $envPath = match (true) {
            Environment::getContext()->isProduction() => "/is/htdocs/wp13251579_RIVEMTPQCA/www/logging/",
            Environment::getContext()->isDevelopment() => "/is/htdocs/wp13303627_IADXHPXADX/www/logging/",
            Environment::getContext()->isTesting() => "",
            default => "/is/htdocs/wp13303627_IADXHPXADX/www/logging/"
        };

        $path = $envPath . "contractData" . DIRECTORY_SEPARATOR;
        $files = $this->getAllFilesFromFolder($path);

        if (!empty($files)) {
            $dt = new DateTime('now');
            $date = $dt->format('Y-m-d');
            $logEntry = $date;

            // 2 Tage subtrahieren
            $dt->sub(new DateInterval('P2D'));
            $oldTimeStamp = $dt->getTimestamp();

            $fileNamePost = $envPath . "Maintainance" . DIRECTORY_SEPARATOR . "contractData-" . $date . ".txt";
            $maintenanceLog = fopen($fileNamePost, 'w');

            if ($maintenanceLog === false) {
                $output->writeln('<error>Failed to open log file: ' . $fileNamePost . '</error>');
                return Command::FAILURE;
            }

            foreach ($files as $value) {
                $filepath = $path . $value;
                $fileTime = date("F d Y H:i:s.", @filectime($filepath));

                if (@filectime($filepath) <= $oldTimeStamp) {
                    $logEntry .= @filectime($filepath) . "--" . $fileTime . ":" . "-" . $filepath . PHP_EOL;
                    unlink($filepath);
                }
            }

            fwrite($maintenanceLog, $logEntry);
            fclose($maintenanceLog);
        }

        return Command::SUCCESS;
    }

    private function getAllFilesFromFolder(string $folder): array
    {
        $files = [];
        if (is_dir($folder) && ($handle = opendir($folder))) {
            while (($file = readdir($handle)) !== false) {
                if ($file !== '.' && $file !== '..') {
                    $files[] = $file;
                }
            }
            closedir($handle);
            natsort($files);
        }
        return $files;
    }
}
