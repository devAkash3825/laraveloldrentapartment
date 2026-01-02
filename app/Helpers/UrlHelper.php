<?php

namespace App\Helpers;

class UrlHelper
{
    public static function getPropertyImageUrl($prop)
    {
        return "https://rentapartment.s3.ap-southeast-2.amazonaws.com/Gallery/Property_" . $prop->recentviewed . "/Original/" . $prop->propertyinfo->gallerytype->gallerydetail[0]->ImageName;
    }


    
}
    