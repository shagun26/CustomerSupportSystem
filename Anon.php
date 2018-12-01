<?php

// Class for anonymous users. Holds their username and their helper.
// Used in anonSetup file.
class Anon
{
    protected $name;
    protected $helper;
    
    function __construct($new_name, $new_helper)
    {
        $this -> name = $new_name;
        $this -> helper = $new_helper;
    }

    function set_name($new_name)
    {
        $name = $this -> new_name;
    }

    function get_name()
    {
        return $this -> name;
    }

    function set_helper($new_helper)
    {
        $helper = $this -> new_helper;
    }

    function get_helper()
    {
        return $this -> helper;
    }
}

?>