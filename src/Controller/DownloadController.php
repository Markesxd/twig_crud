<?php

namespace Rafael\TwigCrud\Controller;

class DownloadController implements Controller
{
    public function handle(array $params, array $query): void
    {
        $filename = __DIR__ . "/../Database/Uploads/{$params[2]}";
        if($params[2] === '' || !file_exists($filename)){
            echo "Arquivo não existe";
            return;
        }
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: 0");
        header('Content-Disposition: attachment; filename="'.basename($filename).'"');
        header('Content-Length: ' . filesize($filename));
        header('Pragma: public');
        flush();
        readfile($filename);
    }
}
