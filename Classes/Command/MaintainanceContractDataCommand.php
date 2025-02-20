<?php
namespace BefineSolutionsAG\Cryptsharesaas\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MaintainanceContractDataCommand extends Command
{
    /**
     * Configure the command by defining the name, options and arguments
     */
    protected function configure()
    {
        $this->setHelp('Prints a list of recent sys_log entries.' . LF . 'If you want to get more detailed information, use the --verbose option.');
    }

    /**
     * Executes the command for showing sys_log entries
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int error code
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        switch (\TYPO3\CMS\Core\Core\Environment::getContext()) {

            case 'Production':
                $envPath = "/is/htdocs/wp13251579_RIVEMTPQCA/www/logging/";
                break;
            case 'Development/Local':
                $envPath = "";
                break;
            case 'Development':
            default:
                $envPath = "/is/htdocs/wp13303627_IADXHPXADX/www/logging/";
        }
        $path = $envPath."contractData/";
        $files = $this->getAllFilesFromFolder($path);
        if ($files) {
            $dt = new \DateTime('now');
            $date = $dt->format('Y-m-d');
            $LogEntry = $date;
            $dt->getTimestamp();
            date_sub($dt, date_interval_create_from_date_string('2 days'));
            $oldTimeStamp = $dt->getTimestamp();
            $fileNamePost = $envPath."Maintainance/contractData-".$date.".txt";
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
        }
        return Command::SUCCESS;
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