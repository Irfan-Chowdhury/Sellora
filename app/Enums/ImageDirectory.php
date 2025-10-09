<?php

namespace App\Enums;

enum ImageDirectory: string
{
    case CATEGORY = 'uploads/images/categories/';
    case PRODUCT  = 'uploads/images/products/';
    case BRAND    = 'uploads/images/brands/';
    case SLIDER    = 'uploads/images/sliders/';
}
