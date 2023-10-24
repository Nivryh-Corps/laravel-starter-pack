<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ProductItem extends Model
{
    use HasFactory;

    protected $fillable = [ 
        "quantity",
        "cart_id",
        "product_id"
    ];

    public function init(Request $req){ 
        $this->quantity = $req->input('quantity');
    }

    public function product(){
        return $this->belongsTo(Product::class)->get('product_name', 'product_price');
    }
}