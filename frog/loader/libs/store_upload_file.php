<?php
namespace castle;
function store_upload_file(
    string $name,
    string $saved_to,
    string $saved_as
) : bool
{
    global $__upload_files;
    $__upload_files[] = [
        'name'  =>  $name,
        'saved_to'  =>  $saved_to,
        'saved_as'  =>  $saved_as
    ];
    return true;
}