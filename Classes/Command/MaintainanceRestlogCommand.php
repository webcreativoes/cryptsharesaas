<?php
declare(strict_types=1);

namespace BefineSolutionsAG\Cryptsharesaas\Command;

use DateTime;
use DateInterval;
use TYPO3\CMS\Core\Core\Environment;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MaintainanceRestlogCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('cryptsharesaas:maintainance-restlog')
            ->setDescription('Deletes old rest log files and logs the process.')
            ->setHelp('This command removes restLog files older than 2 weeks from the logging directory.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $envPath = match (true) {
            Environment::getContext()->isProduction() => "/is/htdocs/wp13251579_RIVEMTPQCA/www/logging/",
            Environment::getContext()->isDevelopment() => "/is/htdocs/wp13303627_IADXHPXADX/www/logging/",
            Environment::getContext()->isTesting() => "",
            default => "/is/htdocs/wp13303627_IADXHPXADX/www/logging/"
        };

        $this->deleteLogs($envPath . 'restLog' . DIRECTORY_SEPARATOR, 'restLog', $envPath);
        $this->deleteLogs($envPath . 'restLog-Error' . DIRECTORY_SEPARATOR, 'restLogError', $envPath);
        $this->deleteLogs($envPath . 'webHooks' . DIRECTORY_SEPARATOR, 'webHooks', $envPath);

        return Command::SUCCESS;
    }

    private function deleteLogs(string $folder, string $type, string $envPath): void
    {
        $files = $this->getAllFilesFromFolder($folder);

        if (!empty($files)) {
            $dt = new DateTime('now');
            $date = $dt->format('Y-m-d');
            $logEntry = $date;

            // 2 Wochen subtrahieren
            $dt->sub(new DateInterval('P14D'));
            $oldTimestamp = $dt->getTimestamp();

            $fileNamePost = $envPath . "Maintainance" . DIRECTORY_SEPARATOR . $type . "-" . $date . ".txt";
            $maintenanceLog = fopen($fileNamePost, 'w');

            if ($maintenanceLog === false) {
                return;
            }

            foreach ($files as $value) {
                $filepath = $folder . $value;
                $fileTime = date("F d Y H:i:s.", @filectime($filepath));

                if (@filectime($filepath) <= $oldTimestamp) {
                    $logEntry .= @filectime($filepath) . "--" . $fileTime . ":" . "-" . $filepath . PHP_EOL;
                    if (file_exists($filepath)) {
                        unlink($filepath);
                    }
                }
            }

            fwrite($maintenanceLog, $logEntry);
            fclose($maintenanceLog);
        }
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
