<?php

 //
App::error(function(\Illuminate\Session\TokenMismatchException $exception)
{
    return Redirect::route('login')->with('message','Your session has expired. Please try logging in again.');
});