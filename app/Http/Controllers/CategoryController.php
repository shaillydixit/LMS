<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Pagging;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class CategoryController extends Controller
{
    public function Index()
    {
        return view('category.index');
    }

    public function FetchCategory(Request $request)
    {
        $aColumns = array('category.id', 'category.category_name','category.category_image','category.status',  'category.created_at');
        $isWhere = array("category.status != '2'");
        $table = "categories as category";
        $isJOIN = array();
        $hOrder = "category.id desc";
        $sqlReturn = Pagging::get_datatables($aColumns, $table, $hOrder, $isJOIN, $isWhere, $request);
        $appData = array();
        $no = $request->iDisplayStart + 1;
        foreach ($sqlReturn['data'] as $row) {
           
            $row_data = array();
            $row_data[] = $no;
            $row_data[] =(!empty($row->category_image)) ? '<img src="' . URL::to('/') . '/storage/files/category' . '/' . $row->category_image . '" width="50" height="50" class="img-thumbnail rounded-circle">' : '';
            $row_data[] = $row->category_name;

            $row_data[] = '<a class="btn btn-primary btn-sm px-5" href="' . url('edit-category/' . $row->id) . '" >
                    Edit
                </a> 
                <a class="btn btn-danger px-5 btn-sm" href="javascript:;"  onclick="delete_record(' . $row->id . ')">
                   Delete
                </a>';

            $appData[] = $row_data;
            $no++;
        }
        $totalrecord = Pagging::count_all($aColumns, $table, $hOrder, $isJOIN, $isWhere, '');
        $numrecord = $sqlReturn['data'];
        $output = array(
            "sEcho" => intval($request->sEcho),
            "iTotalRecords" =>  $numrecord,
            "iTotalDisplayRecords" => $totalrecord,
            "aaData" => $appData
        );
        echo json_encode($output);
    }

    public function AddCategory()
    {
        return view('category.add_category');
    }

    public function ManageCategory(Request $request)
	{
		$data = array(
			'category_name'	 	    => $request->category_name,
			'category_slug'	         => $request->category_slug,
			'updated_by' 		    => Auth::user()->id,
		);
		$category_id = $request->id;
		$row = array();
		$check_category	= Category::check_category($data, $category_id);
		if (!empty($check_category)) {
			$row['res'] = '2';
		} else if (!empty($category_id)) {
            if ($request->hasFile('category_image')) {
                $existingPhoto = Auth::user()->category_image;
                if ($existingPhoto && Storage::disk('public')->exists('files/category/' . $existingPhoto)) {
                    Storage::disk('public')->delete('files/category/' . $existingPhoto);
                }
                $filename = 'photo_' . time() . '.' . $request->category_image->extension();
                $request->category_image->storeAs('files/category', $filename, 'public');
                $data['category_image'] = $filename;
            }

			$data['status'] 	 = '1';
			$data['updated_at'] = date('Y-m-d H:i:s');
			$updateid =  Category::where('id', $category_id)
				->update($data);
			$row = array();
			if ($updateid) {
				$row['res'] = '3';
			} else {
				$row['res'] = '0';
			}
		} else {
            if ($request->hasFile('category_image')) {
                $filename = 'photo_' . time() . '.' . $request->category_image->extension();
                $request->category_image->storeAs('files/category', $filename, 'public');
                $data['category_image'] = $filename;
			}
			$data['status'] 	 	 = '1';
            $data['created_by'] 	 =  Auth::user()->id;
			$data['created_at'] 	 = date('Y-m-d H:i:s');
			$data['updated_at']  	 = date('Y-m-d H:i:s');
			$insertid =   Category::insertGetId($data);
			$row['res'] = '1';

			if ($insertid) {
				$row['res'] = '1';
			} else {
				$row['res'] = '0';
			}
		}
		return $row;
	}


    public function DeleteCategory(Request $request)
    {
        $data = array(
            "status" => '2'
        );
        $deleted = Category::where('id', $request->id)
            ->update($data);
        $row = array();
        if ($deleted) {
            $row['res'] = 1;
        } else {
            $row['res'] = 0;
        }
        return json_encode($row);
    }

    public function EditCategory($id)
    {
        $categoryData = Category::where('id', $id)->first();
        return view('category.add_category',compact('categoryData'));
    }
}
