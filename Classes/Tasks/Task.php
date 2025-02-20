<?php

namespace BefineSolutionsAG\Cryptsharesaas\Task;

use \Datetime;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class MaintainanceContractData extends \TYPO3\CMS\Scheduler\Task\AbstractTask {
    public function execute()
    {
        $path = "/is/htdocs/wp13251579_RIVEMTPQCA/www/logging/contractData/";
        $files = $this->getAllFilesFromFolder($path);
        if ($files) {
            $dt = new DateTime('now');
            $date = $dt->format('Y-m-d');
            $LogEntry = $date;
            $dt->getTimestamp();
            date_sub($dt, date_interval_create_from_date_string('2 days'));
            $oldTimeStamp = $dt->getTimestamp();
            $fileNamePost = "/is/htdocs/wp13251579_RIVEMTPQCA/www/logging/Maintainance/contractData-".$date.".txt";
            $maintenanceLog = fopen($fileNamePost, 'w');
            foreach ($files as $value) {
                $filepath = $path.$value;
                $fileTime = date("F d Y H:i:s.", filectime($filepath));
                if (filectime($filepath) <= $oldTimeStamp){
                    $LogEntry .= filectime($filepath)."--".$fileTime.":"."-".$filepath."\r\n";
                    unlink($filepath);
                }
            }
            fwrite($maintenanceLog, $LogEntry);
            fclose($maintenanceLog);
            return true;
        }
    }

    public function getAllFilesFromFolder($folder) {
        $files = [];
        if ( is_dir ( $folder ) && $handle = opendir($folder) ){
            while (($file = readdir($handle)) !== false) {
                if($file != '.' && $file != '..'){
                    $files[] = $file;
                }
            }
            closedir($handle);
            natsort($files);
        }
        return $files;
    }
}

class MaintainanceRestlog extends \TYPO3\CMS\Scheduler\Task\AbstractTask {
    public function execute(){
        $this->deleteLogs('/is/htdocs/wp13251579_RIVEMTPQCA/www/logging/restLog/','restLog');
        $this->deleteLogs('/is/htdocs/wp13251579_RIVEMTPQCA/www/logging/restLog-Error/','restLogError');
        $this->deleteLogs('/is/htdocs/wp13251579_RIVEMTPQCA/www/logging/webHooks/','webHooks');
        return true;
    }

    public function deleteLogs($folder,$type) {
        $path = $folder;
        $files = $this->getAllFilesFromFolder($path);
        if ($files) {
            $dt = new DateTime('now');
            $date = $dt->format('Y-m-d');
            $LogEntry = $date;
            $dt->getTimestamp();
            date_sub($dt, date_interval_create_from_date_string('2 weeks'));
            $oldTimestamp =$dt->getTimestamp();
            $fileNamePost = "/is/htdocs/wp13251579_RIVEMTPQCA/www/logging/Maintainance/'$type'-".$date.".txt";
            $maintenanceLog = fopen($fileNamePost, 'w');
            foreach ($files as $value) {
                $filepath = $path.$value;
                $fileTime = date("F d Y H:i:s.", filectime($filepath));
                if (filectime($filepath) <= $oldTimestamp){
                    $LogEntry .= filectime($filepath)."--".$fileTime.":"."-".$filepath."\r\n";

                    unlink($filepath);
                }

            }
            fwrite($maintenanceLog, $LogEntry);
            fclose($maintenanceLog);
            return true;
        }
    }

    public function getAllFilesFromFolder($folder) {
        $files = [];
        if ( is_dir ( $folder ) && $handle = opendir($folder) ) {
            while (($file = readdir($handle)) !== false) {
                if($file != '.' && $file != '..'){
                    $files[] = $file;
                }
            }
            closedir($handle);
            natsort($files);
        }
        return $files;
    }
}
