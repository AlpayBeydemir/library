<?php

use App\Models\Product_isbn;

if (! function_exists("create_isbn")){

    function create_isbn($stock, $id){

        if (isset($stock) && !empty($stock)) {

            for ($i = 0; $i < $stock; $i++){

                $prefix_isbn = "ISBN:" . rand(0,10000000000);
                $product_isbn_create = new Product_isbn();

                $product_isbn_create->product_id   = $id;
                $product_isbn_create->product_isbn = $prefix_isbn;

                $product_isbn_create->save();
            }
        }
    }

}
