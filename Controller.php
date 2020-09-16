<?php

class Controller
{
    function view($view)
    {
        require_once($view);
    }
}
