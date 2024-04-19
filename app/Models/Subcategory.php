<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Subcategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public static function check_subcategory($data,$subcategory_id)
	{
		 $subcategory = DB::table('subcategories') 
					->where('status', '=', '1')
					->where('subcategory_name', '=', $data['subcategory_name'])
					->where('id', '!=', $subcategory_id)
				 	->first();
		return $subcategory;		
	}
}
