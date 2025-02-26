<?php
declare(strict_types=1);

namespace BefineSolutionsAG\Cryptsharesaas\Task;

use DateTime;
use DateInterval;
use TYPO3\CMS\Scheduler\Task\AbstractTask;

class MaintainanceContractData extends AbstractTask
{
    public function execute(): bool
    {
        $path = "/is/htdocs/wp13251579_RIVEMTPQCA/www/logging/contractData/";
        $files = $this->getAllFilesFromFolder($path);

        if (!empty($files)) {
            $dt = new DateTime('now');
            $date = $dt->format('Y-m-d');
            $logEntry = $date;

            // 2 Tage subtrahieren
            $dt->sub(new DateInterval('P2D'));
            $oldTimeStamp = $dt->getTimestamp();

            $fileNamePost = "/is/htdocs/wp13251579_RIVEMTPQCA/www/logging/Maintainance/contractData-" . $date . ".txt";
            $maintenanceLog = fopen($fileNamePost, 'w');

            if ($maintenanceLog === false) {
                return false;
            }

            foreach ($files as $value) {
                $filepath = $path . $value;
                $fileTime = date("F d Y H:i:s.", @filectime($filepath));

                if (@filectime($filepath) <= $oldTimeStamp) {
                    $logEntry .= @filectime($filepath) . "--" . $fileTime . ":" . "-" . $filepath . PHP_EOL;
                    if (file_exists($filepath)) {
                        unlink($filepath);
                    }
                }
            }

            fwrite($maintenanceLog, $logEntry);
            fclose($maintenanceLog);
        }

        return true;
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

class MaintainanceRestlog extends AbstractTask
{
    public function execute(): bool
    {
        $this->deleteLogs('/is/htdocs/wp13251579_RIVEMTPQCA/www/logging/restLog/', 'restLog');
        $this->deleteLogs('/is/htdocs/wp13251579_RIVEMTPQCA/www/logging/restLog-Error/', 'restLogError');
        $this->deleteLogs('/is/htdocs/wp13251579_RIVEMTPQCA/www/logging/webHooks/', 'webHooks');
        return true;
    }

    private function deleteLogs(string $folder, string $type): void
    {
        $files = $this->getAllFilesFromFolder($folder);

        if (!empty($files)) {
            $dt = new DateTime('now');
            $date = $dt->format('Y-m-d');
            $logEntry = $date;

            // 2 Wochen subtrahieren
            $dt->sub(new DateInterval('P14D'));
            $oldTimestamp = $dt->getTimestamp();

            $fileNamePost = "/is/htdocs/wp13251579_RIVEMTPQCA/www/logging/Maintainance/" . $type . "-" . $date . ".txt";
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
