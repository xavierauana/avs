<?php
/**
 * Author: Xavier Au
 * Date: 29/1/16
 * Time: 2:35 PM
 */

function getAuthUserForJson(){
    $user = Auth::user();
    $data['id'] = $user->id;
    $data['name'] = $user->name;
    $data['email'] = $user->email;
    $data['canMultiple'] = $user->can('multiple');
    $data['wishListItems'] = $user->wishListItems()->lists('property_id');
    return $data;
}