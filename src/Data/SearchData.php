<?php

namespace App\Data;

use App\Entity\Category;
use App\Entity\Size;

 class SearchData
 {
    /**
     * @var string
     */
    public $q = '';

    /**
     * @var Category[]
     */
    public $category = [];

    /**
     * @var Size[]
     */
    public $size = [];

    /**
     * @var null|integer
     */
    public $max;

    /**
     * @var null|integer
     */
    public $min;

    /**
     * @var boolean
     */
    public $promo = false;

} 