<?php
namespace App\Traits;

use App\Models\Product;

trait ReviewTrait {

    public function calculateRatingAverage($productId){
        $product = Product::find($productId);
        $one = $two = $three = $four = $five = 0;

        foreach ($product->reviews as $review){
            if($review->star == 1) $one++;
            if($review->star == 2) $two++;
            if($review->star == 3) $three++;
            if($review->star == 4) $four++;
            if($review->star == 5) $five++;
        }
        $starTotal = ($one + $two + $three + $four + $five);
        if($starTotal == 0){
            return 0;
        }
        $average = (($one * 1) + ($two * 2) + ($three * 3) + ($four * 4) + ($five * 5)) / ($one + $two + $three + $four + $five);
        return number_format($average, 2);
    }

}
