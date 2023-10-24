<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [ 
        "product_name",
        "product_price",
        "product_description",
        "discount"
    ];

    public function init(Request $req){ 
        $this->product_name = $req->input('product_name');
        $this->product_price = $req->input('product_price');
        $this->product_description = $req->input('product_description');
        $this->discount = $req->input('discount');
    }

}