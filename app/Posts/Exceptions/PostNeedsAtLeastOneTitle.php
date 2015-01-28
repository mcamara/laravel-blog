<?php namespace Posts\Exceptions;

use Exception;

class PostNeedsAtLeastOneTitle extends Exception {

    function __construct()
    {
        parent::__construct("Posts need at least a title, it doesn't matter which language.");
    }
}