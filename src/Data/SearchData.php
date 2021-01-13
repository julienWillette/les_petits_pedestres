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
    public $categories = [];

    /**
     * @var Size[]
     */
    public $sizes = [];

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