<?php

function isAdmin()
{
    return Auth::user()->user_type === "ADMIN";
}

