<?php
/**
 * Created by PhpStorm.
 * User: Sergey Trizna
 * Date: 18.02.17
 * Time: 5:18
 */
namespace BS\Common {
    class Autoload
    {
        public function __construct()
        {
        }

        public static function autoload($file)
        {
            $file = str_replace('\\', '/', $file);
            $path = $_SERVER['DOCUMENT_ROOT'] . '/classes';
            $filepath = $_SERVER['DOCUMENT_ROOT'] . '/classes/' . $file . '.php';

            if (file_exists($filepath)) {
                require_once($filepath);

            } else {
                $flag = true;
                Autoload::recursive_autoload($file, $path, $flag);
            }
        }

        public static function recursive_autoload($file, $path, $flag)
        {
            if (false !== ($handle = opendir($path)) && $flag) {
                while (false !== ($dir = readdir($handle)) && $flag) {

                    if (strpos($dir, '.') === false) {
                        $path2 = $path . '/' . $dir;
                        $filepath = $path2 . '/' . $file . '.php';
                        if (file_exists($filepath)) {
                            require_once($filepath);
                            break;
                        }
                        Autoload::recursive_autoload($file, $path2, $flag);
                    }
                }
                closedir($handle);
            }
        }
    }

    \spl_autoload_register('BS\Common\Autoload::autoload');
}