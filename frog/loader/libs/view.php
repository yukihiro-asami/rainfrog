<?php
namespace castle;
use Throwable;
function view(array $data, string $file_name) : string
{
    return (function () use ($data, $file_name)
    {
        extract($data, EXTR_REFS);
        ob_start();
        try
        {
            include $file_name;
        }
        catch (\Exception $e)
        {
            ob_end_clean();
            throw $e;
        }
        return ob_get_clean();
    })();
}