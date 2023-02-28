<?php /** @noinspection PhpUnused */
namespace castle;
class Upload extends Castle
{
    const VALS_KEY_FILES = 'files';

    static public function process() : void
    {
        try
        {
            $config_settings = static::_upload();
            foreach (static::_files() as $file)
            {
                list($saved_to, $saved_as) = static::_process_file($file);
                move_uploaded_file($saved_to . $saved_as, $config_settings['path'] . $saved_as);
                store_upload_file($file['name'], $config_settings['path'], $saved_as);
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
        $saved_as = array_pop($path_array);
        $saved_to = implode('/', $path_array) . '/';
        return [$saved_to, $saved_as];
    }

    static public function get_files(int $index) : array
    {
        return upload_files()[$index];
    }

}