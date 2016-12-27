<?php
function isAdmin()
{
    return Auth::user() && Auth::user()->user_type === "ADMIN";
}

function sanitizeValue($class=null,$object=null,$errors=null) {
    if($errors->has($object) || old($object))
        return is_array(old($object)) ? collect(old($object))->toJson() : old($object);

    return $class ? $class->$object : null;
}

function setSelectedUserType($user, $name, $value) {
    return old($name) === $value || ( isset($user) && $user->$name === $value ) ? "selected" : "";
}