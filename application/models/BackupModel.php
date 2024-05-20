<?php
defined('BASEPATH') or exit('');

class BackupModel extends CI_Model
{
    public function toDb($filename)
    {
        $lines = file($filename);
        $temp_line = "";
        foreach ($lines as $line)
        {
            if (substr($line, 0, 2) == '--' || $line == '' || substr($line, 0, 1) == '#')
                continue;
            $temp_line .= $line;
            if (substr(trim($line), -1, 1) == ';')
            {
                $this->db->query($temp_line);
                $temp_line = '';
            }
        }
    }
}