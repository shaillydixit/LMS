<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Pagging;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubcategoryController extends Controller
{
    public function Index()
    {
        return view('subcategory.index');
    }

    public function AddSubcategory()
    {
        $category = Category::where('status','1')->get();
        return view('subcategory.add_subcategory', compact('category'));
    }

    public function FetchSubcategory(Request $request)
    {
        $aColumns = array('subcategory.id', 'subcategory.subcategory_name','category.category_name','subcategory.status',  'subcategory.created_at');
        $isWhere = array("subcategory.status != '2'");
        $table = "subcategories as subcategory";
        $isJOIN = array(
            'inner join categories as category on category.id = subcategory.category_id'
        );
        $hOrder = "subcategory.id desc";
        $sqlReturn = Pagging::get_datatables($aColumns, $table, $hOrder, $isJOIN, $isWhere, $request);
        $appData = array();
        $no = $request->iDisplayStart + 1;
        foreach ($sqlReturn['data'] as $row) {
            $row_data = array();
            $row_data[] = $no;
            $row_data[] = $row->category_name;
            $row_data[] = $row->subcategory_name;
            $row_data[] = '<a class="btn btn-primary btn-sm px-5" href="' . url('edit-subcategory/' . $row->id) . '" >
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

    public function ManageSubcategory(Request $request)
    {
        $data = array(
            'category_id' => $request->category_id,
            'subcategory_name' => $request->subcategory_name,
        );

        $subcategory_id = $request->id;
        $checksubcategory = Subcategory::check_subcategory($data, $subcategory_id);
        $row = array();
        if(!empty($checksubcategory)){
            $row['res'] = '2';
        }else if(!empty($subcategory_id))
        {
            $data['status'] = '1';
            $data['updated_by'] = Auth::user()->id;
            $data['updated_at'] = date('Y-m-d H:i:s');

            $updated_id = Subcategory::where('id', $subcategory_id)->update($data);
            if($updated_id)
            {
                $row['res'] = '3';
            }else{
                $row['res'] = '0';
            }
        }else{
            $data['status'] = '1';
            $data['updated_by'] = Auth::user()->id;
            $data['created_by'] = Auth::user()->id;
            $data['updated_at'] = date('Y-m-d H:i:s');
            $data['created_at'] = date('Y-m-d H:i:s');
            $insertid = Subcategory::insertGetId($data);

            if($insertid)
            {
                $row['res'] = '1';
            }else{
                $row['res'] = '0';
            }

        }
        return $row;
    }

    public function DeleteSubcategory(Request $request)
    {
        $data = array(
            'status' => '2'
        );
        $deleted = Subcategory::where('id', $request->id)->update($data);

        $row = array();
        if($deleted)
        {
            $row['res'] = '1';
        }else{
            $row['res'] = '0';
        }
    }

    public function EditSubcategory($id)
    {
        $category = Category::where('status','1')->get();
        $subcategoryData = Subcategory::where('id', $id)->first();
        return view('subcategory.add_subcategory',compact('subcategoryData','category'));
    }

}
