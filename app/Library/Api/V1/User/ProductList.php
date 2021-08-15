<?php


namespace App\Library\Api\V1\User;


use App\Models\Product;
use App\Traits\ProductTrait;
use App\Traits\ReviewTrait;

class ProductList
{
    use ReviewTrait, ProductTrait;

    public $products;
    public $pincode;
    public $area;

    public function __construct($products, $pincode = null, $area = null)
    {
        $this->products = $products;
        $this->pincode = $pincode;
        $this->area = $area;
    }

    public function execute()
    {
        $data = [];
        if (!empty($this->products)) {
            $i = 0;
            foreach ($this->products as $product) {
                $data[$i]['id'] = $product['id'];
                $data[$i]['name'] = $product['name'];
                $data[$i]['description'] = $product['description'];
                $data[$i]['product_prices'] = [];
                $data[$i]['stock'] = $this->checkProductStock($product['id'], $this->pincode, $this->area);
                $data[$i]['liked'] = $this->checkIfProductLiked($product['id']);

                $lowestPrice = $this->getLowestPrice($product['id']);
                $data[$i]['display_price'] = isset($lowestPrice) ? [
                    'id' => $lowestPrice->id,
                    'price' => $lowestPrice->price,
                    'discount' => $lowestPrice->discount,
                    'unit' => $lowestPrice->unit,
                    'quantity' => $lowestPrice->quantity,
                    'stock' => $this->checkProductPriceStock($lowestPrice->id, $this->pincode, false, $this->area),
                    'liked' => $this->checkIfProductProductLiked($lowestPrice->id),
                ] : null;

                if (isset($product['product_prices'])) {
                    foreach ($product['product_prices'] as $productPrice){

                        $data[$i]['product_prices'][] = [
                            'id' => $productPrice['id'],
                            'price' => $productPrice['price'],
                            'discount' => $productPrice['discount'],
                            'unit' => $productPrice['unit'],
                            'quantity' => $productPrice['quantity'],
                            'stock' => $this->checkProductPriceStock($productPrice['id'], $this->pincode, false, $this->area),
                            'liked' => $this->checkIfProductProductLiked($productPrice['id']),
                        ];
                    }
                }

                $data[$i]['categories'] = "";
                if (isset($product['categories'])) {
                    foreach ($product['categories'] as $category) {
                        $data[$i]['categories'] .= $category['name'] . ', ';
                    }
                    $data[$i]['categories'] = rtrim($data[$i]['categories'], ', ');
                }
                if (isset($product['reviews'])) {
                    $data[$i]['rating'] = $this->calculateRatingAverage($product['id']);
                } else {
                    $data[$i]['rating'] = 0;
                }


                if (isset($product['images'][0]['thumbnail'])) {
                    $data[$i]['thumb_link'] = $product['images'][0]['thumbnail'] ? $product['images'][0]['thumbnail'] : null;
                } else {
                    $data[$i]['thumb_link'] = null;
                }
                $i++;
            }
        }
        return $data;
    }
}

