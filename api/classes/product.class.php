<?php
/**
 * @author: Jonathan Hollingsworth
 * @description: Product class
 */

class Product
{
    public $productId;

    public $categoryId;

    public $price;

    public $name;

    public $sequence;

    public $created;

    public $lastUpdated;

    public $status;

    /** @var  ProductDetailItem[] $productDetailItems */
    public $productDetailItems;

    //TODO: change to image class
    /** $var array $images */
    public $images;

    /** @var Price $prices */
    public $prices;

}