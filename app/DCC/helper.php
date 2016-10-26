<?php

function isAdmin()
{
    return Auth::user() && Auth::user()->user_type === "ADMIN";
}

