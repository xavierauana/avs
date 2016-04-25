<?php
/**
 * Author: Xavier Au
 * Date: 16/1/16
 * Time: 10:11 PM
 */

namespace App\Contracts;


use App\Media;
use Illuminate\Support\Collection;

interface HasMediaResource
{
    public function media();
    public function addMedia(array $mediaParam):Media;
}