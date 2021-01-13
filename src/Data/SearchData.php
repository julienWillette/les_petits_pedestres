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
    public $maxPrice;

    /**
     * @var null|integer
     */
    public $minPrice;

    /**
     * @var boolean
     */
    public $promo = false;

} 