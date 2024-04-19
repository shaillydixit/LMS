<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function check_category($data,$category_id)
	{
		 $category = DB::table('categories') 
					->where('status', '=', '1')
					->where('category_name', '=', $data['category_name'])
					->where('id', '!=', $category_id)
				 	->first();
		return $category;		
	}
}
