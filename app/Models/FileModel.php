<?php

namespace App\Models;

class FileModel
{
    public function getFileNameExtension($file)
    {
        switch ($file) {
            case 'data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64':
                return 'xlsx';

            case 'data:application/pdf;base64':
                return 'pdf';
        }
    }
}
