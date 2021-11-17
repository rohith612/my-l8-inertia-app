<?php

namespace App\Interfaces;

interface CategoryServiceInterface{
    /**
     * fetch the product model from the matching condition
     * 
     * @return collection
     */
    public function categoryList($searchKey = NULL);
    /**
     * insert the product model to db
     * 
     * @return objects
     */
    public function categoryAdd($request);
    /**
     * update the product model to db
     * 
     * @return objects
     */
    public function categoryUpdate($request, $model);
    /**
     * remove the product model to db
     * 
     * @return objects
     */
    public function categoryRemove($model);
}