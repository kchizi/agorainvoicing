<?php

namespace App\Model\Product;

use Illuminate\Database\Eloquent\Model;

class ProductBundle extends Model
{
    protected $table = 'product_bundles';
    protected $fillable = ['name', 'valid_from', 'valid_till', 'uses', 'maximum_uses', 'allow-promotion', 'show'];

    public function relation()
    {
        return $this->hasMany('App\Model\Product\ProductBundleRelation', 'bundle_id');
    }

    public function delete()
    {
        $this->relation()->delete();

        return parent::delete();
    }
}
