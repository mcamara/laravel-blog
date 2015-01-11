<?php namespace Blog\Users\Exceptions;

use Exception;

class CannotDeleteLastUser extends Exception {

    function __construct()
    {
        parent::__construct("You cannot delete the last user on the system.");
    }
}