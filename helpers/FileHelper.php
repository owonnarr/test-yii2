<?php
/**
 * Created by PhpStorm.
 * User: owonnarr
 * Date: 07.05.19
 * Time: 11:31
 */

namespace app\helpers;

class FileHelper
{
    private $data = [];
    /**
     * get file data
     * @param string $filename
     * @return array
     */
    public function getFileData(string $filename)
    {
        $file = fopen($filename, "r");

        if (!$file) {
           throw new \DomainException('Error. Ошибка открытия файла');
        }

        while (!feof($file)) {
            $result = trim(fgets($file));
            $data = explode(':', $result);

            if ($data[0] && $data[1]) {
                $this->data[] = [
                    $data[0] => $data[1]
                ];

            }
        }

        fclose($file);

        return $this->data;
    }
}