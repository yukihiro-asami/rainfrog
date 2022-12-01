<?php /** @noinspection PhpUnused */
namespace castle;
class View extends Castle
{
    protected string $_filename;
    protected array $_data;
    function __construct(string $filename = null, array $data = [])
    {
        $this->_filename = $filename;
        $this->_data = $data;
    }
    static function forge(string $filename = null, array $data = []) : View
    {
        return new static($filename, $data);
    }
    function data($data = NULL) : View|array
    {
        if ($data === NULL)
        {
            return $this->_data;
        } else {
            $this->_data = $data;
            return $this;
        }
    }
    function file_path($filename) : View|string
    {
        if ($filename === NULL)
        {
            return $this->_filename;
        } else {
            $this->_filename = $filename;
            return $this;
        }
    }
    function render() : string
    {
        return view($this->_data, $this::_views_dir() . $this->_filename);
    }
}