<?php
function isAdmin()
{
    return Auth::user() && Auth::user()->user_type === "ADMIN";
}

function sanitizeValue($class=null,$object=null,$errors=null) {
    if($errors->has($object) || old($object))
        return old($object);

    return $class ? $class->$object : '';
}

function setSelectedUserType($user, $name,$value) {
    return old($name) === $value || ( isset($user) && $user->$name === $value ) ? "selected" : "";
}