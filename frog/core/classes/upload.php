<?php /** @noinspection PhpUnused */
namespace castle;
class Upload extends Castle
{
    const VALS_KEY_FILES = 'files';

    static public function process() : void
    {
        foreach (static::_file() as $name => $file)
        {
            list($name, $save_to, $save_as) = static::_process_file($file);
            store_upload_file($name, $save_to, $save_as);
        }
    }

    static public function is_valid() : bool
    {
        return count(upload_files()) > 0;
    }

    static public function _process_file(array $file) : array
    {
        $name = $file['file'];
        $path_array = explode('/', $file['tmp_name']);
        $save_as = array_pop($path_array);
        $save_to = implode('/', $path_array);
        return [$name, $save_to, $save_as];
    }

    static public function get_files() : array
    {
        return upload_files();
    }

    static public function _file() : array
    {
        return static::_value(static::VALS_KEY_FILES);
    }

}