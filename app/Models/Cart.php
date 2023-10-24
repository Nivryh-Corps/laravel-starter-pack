<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [ 
        "wait_flag",
        "paid_flag",
        "user_id",
        "sum_total"
    ];

    public function init(Request $req){ 
        $this->wait_flag = $req->input('wait_flag');
        $this->paid_flag = $req->input('paid_flag');
        $this->user_id = $req->input('user_id');
        $this->sum_total = $req->input('sum_total');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function products(){
        return $this->hasMany(ProductItem::class);
    }

}