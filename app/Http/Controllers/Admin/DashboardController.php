<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Section;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class DashboardController extends Controller
{
    public function dashboard() {
        $user_id = Auth::user()->id;
        $sections = DB::table('sections')->where([
            ['user_id', '=', $user_id],
        ])->get();
        return view('admin.dashboard', ['sections' => $sections]);
    }

    public function category_data(Request $request){
        $user_id = Auth::user()->id;
        $subject = DB::table('subjects')->where([
            ['category_id', '=', $request->categoryID],
            ['user_id', '=', $user_id],
        ])->get();
        return $subject;
    }

    public function attributes_data(Request $request){
        $user_id = Auth::user()->id;
        $attributes = DB::table('attributes')->where([
            ['category_id', '=', $request->categoryID],
            ['user_id', '=', $user_id],
        ])->get();
        return $attributes;
    }

    public function index(Request $request) {
        $user_id = Auth::user()->id;
        if($request->ajax()){
            $sections = DB::table('sections')->where([
                ['name', '=', $request->sectionName],
                ['user_id', '=', $user_id],
            ])->get();
            $categories = DB::table('categories')->where([
                ['section_id', '=', $request->sectionId],
                ['user_id', '=', $user_id],
            ])->get();
            return $categories;
        }
    }



    public function create_section(Request $request) {
        if($request->ajax()){
            if (Auth::user()){
                $section = $request->section;
                $user_id = Auth::user()->id;
                Section::create(array('name' => $section, 'user_id' => $user_id));
                return $section;
            }
        } 
    }

    public function remove_section(Request $request) {
        if($request->ajax()){
            if (Auth::user()){
                $section_id = $request->sectionId;
                $user_id = Auth::user()->id;
                DB::table('sections')->where('id', $section_id)->where('user_id',  $user_id)->delete();
                DB::table('categories')->where('section_id', $section_id)->where('user_id',  $user_id)->delete();
                return $request;
            }
        } 
    }

    public function create_category(Request $request){
        if($request->ajax()){
            if (Auth::user()){
                $category = $request->category;
                $section_id = $request->idSection;
                $user_id = Auth::user()->id;
                $date = Carbon::now();
                DB::table('categories')->insert(
                    array('category_name' => $category, 'section_id' => $section_id, 'user_id' => $user_id, 'created_at' => $date, 'updated_at' => $date)
                );
                return $category;
            }
        } 
    }

    public function remove_category(Request $request) {
        if($request->ajax()){
            if (Auth::user()){
                $category_id = $request->category_id;
                $user_id = Auth::user()->id;
                DB::table('categories')->where('id', $category_id)->where('user_id',  $user_id)->delete();
                return $category_id;
            }
        } 
    }

    public function create_subject(Request $request){
        if($request->ajax()){
            if (Auth::user()){
                $subject = $request->subject;
                $category_id = $request->categoryID;
                $user_id = Auth::user()->id;
                $date = Carbon::now();
                DB::table('subjects')->insert(
                    array('subject_name' => $subject, 'category_id' => $category_id, 'user_id' => $user_id, 'created_at' => $date, 'updated_at' => $date)
                );
                return $subject;
            }
        } 
    }

    public function create_attribute(Request $request){
        if($request->ajax()){
            if (Auth::user()){

                $attributeName = $request->attributeName;
                $description = $request->description;
                $numberAttribute = $request->numberAttribute;
                $double2 = $request->double2;
                $double15 = $request->double15;
                $timeFirst = $request->timeFirst;
                $timeSecond = $request->timeSecond;
                $attributeText = $request->attributeText;
                $attributeVarchar = $request->attributeVarchar;
                $attributeFile = $request->attributeFile;
                $attributeTrue = $request->attributeTrue;
                $attributeFalse = $request->attributeFalse;
                $attributeIP = $request->attributeIP;
                $createAttribute = $request->createAttribute;
                $categoryID = $request->categoryID;
                $subjectID = $request->subjectID;
                $elementID = $request->elementID;
                $attributeJSON = null;
                
                if($attributeTrue == 'false' && $attributeFalse == 'false'){
                    $attribute_bool = null;
                } else if($attributeTrue == 'true'){
                    $attribute_bool = 1;
                } else if($attributeFalse == 'true'){
                    $attribute_bool = 0;
                } else {
                    $attribute_bool = null;
                }
                

                $user_id = Auth::user()->id;
                $date = Carbon::now();
                DB::table('attributes')->insert(
                    array('user_id' => $user_id, 'category_id' => $categoryID, 'subject_id' => $subjectID, 'element_id' => $elementID, 'attribute_name' => $attributeName, 'attribute_description' => $description, 'attribute_int' => $numberAttribute, 'attribute_float' => $double2, 'attribute_double' => $double15, 'attribute_text' => $attributeText, 'attribute_varchar' => $attributeVarchar, 'attribute_img' => $attributeFile, 'attribute_bool' => $attribute_bool, 'attribute_IP' => $attributeIP, 'attribute_json' => $attributeJSON, 'created_at' => $date, 'updated_at' => $date, 'attribute_time_first' => $timeFirst, 'attribute_time_second' => $timeSecond)
                );
                return $request;
            }
        }
    }

    public function edit_section(Request $request){
        return $request;
    }

    public function edit_category(Request $request){
        return $request;
    }

    public function edit_subject(Request $request){
        return $request;
    }

}


