<?php /** @noinspection PhpUnused */
namespace castle;
class Upload extends Castle
{
    const VALS_KEY_FILES = 'files';

    static public function process() : void
    {
        try
        {
            foreach (static::_files() as $file)
            {
                list($save_to, $save_as) = static::_process_file($file);
                store_upload_file($file['name'], $save_to, $save_as);
            }
        } catch (\Throwable $t) {
            self::_log_info($t->getTraceAsString());
        }
    }

    static public function is_valid() : bool
    {
        return count(upload_files()) > 0;
    }

    static public function _process_file(array $file) : array
    {
        $path_array = explode('/', $file['tmp_name']);
        $save_as = array_pop($path_array);
        $save_to = implode('/', $path_array) . '/';
        return [$save_to, $save_as];
    }

    static public function get_files(int $index) : array
    {
        return upload_files()[$index];
    }

}