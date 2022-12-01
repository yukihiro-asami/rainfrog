<?php
namespace castle;
const EXCLUDE_FILES_IN_LIBS = ['.', '..', 'load.php'];
foreach (scandir(__DIR__) as $file_name)
{
    if (in_array($file_name, EXCLUDE_FILES_IN_LIBS) === false)
        include($file_name);
}