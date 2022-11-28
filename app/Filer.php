<?php
declare(strict_types=1);

namespace App;

class Filer {

    // Подробнее на https://en.wikipedia.org/wiki/Data_URI_scheme
    // https://translated.turbopages.org/proxy_u/en-ru.ru.d9ea93b4-6383682a-1bc4a85a-74722d776562/https/stackoverflow.com/questions/10530001/how-to-securely-store-files-on-a-server
    public static function dataUri($file, $mime) : string {
        $contents = file_get_contents($file);
        $base64   = base64_encode($contents);
        return ('data:' . $mime . ';base64,' . $base64);
    }
}
