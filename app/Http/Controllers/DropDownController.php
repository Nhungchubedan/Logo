<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DropDownController extends Controller
{
    public function fetchDistricts(Request $request) {

        $district = json_decode(file_get_contents('../resources/json/district.json'))->data->data;
        $data = [];
        foreach ($district as $item) {
            if ($item->parent_code === $request->province_code) {
                $data[] = $item;
            }
        }
       
        return response()->json($data);
    }
    
    public function fetchCommunes(Request $request) {

        $commune = json_decode(file_get_contents('../resources/json/commune.json'))->data->data;
        $data = [];
        foreach ($commune as $item) {
            if ($item->parent_code === $request->district_code) {
                $data[] = $item;
            }
        }
  
        return response()->json($data);
    }
}
