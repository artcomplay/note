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
        $elements = DB::table('elements')->where([
            ['user_id', '=', $user_id],
            ['parent_id', '=', 0],
        ])->get();
        return view('admin.dashboard', ['elements' => $elements]);
    }

    public function create_note(Request $request){
        if($request->ajax()){
            if (Auth::user()){
                $element_name = $request->element_name;
                $parent_id = $request->parent_id;
                $parent_complex_id = $request->parent_complex_id;
                $user_id = Auth::user()->id;
                $date = Carbon::now();
                if($parent_id == null && $parent_complex_id == null){
                    $parent_id = 0;
                    $id_note = DB::table('elements')->insertGetId(
                        array('element_name' => $element_name, 'parent_id' => $parent_id, 'complex_id' => $parent_id, 'user_id' => $user_id, 'created_at' => $date, 'updated_at' => $date)
                    );
                    $result = DB::update('update elements set complex_id = ? where id = ?', [ $id_note, $id_note ]);
                } else if($parent_id != null){
                    $id_note = DB::table('elements')->insertGetId(
                        array('element_name' => $element_name, 'parent_id' => $parent_id, 'complex_id' => $parent_complex_id, 'user_id' => $user_id, 'created_at' => $date, 'updated_at' => $date)
                    );
                    $complex_id = $parent_complex_id . '-' . $id_note;
                    $result = DB::update('update elements set complex_id = ? where id = ?', [ $complex_id, $id_note ]);
                }

                return $result;
            }
        } 
    }

    public function element_data(Request $request){
        if($request->ajax()){
            if (Auth::user()){
                $user_id = Auth::user()->id;
                $elements = DB::table('elements')->where([
                    ['parent_id', '=', $request->parent_id],
                    ['user_id', '=', $user_id],
                ])->get();

                return $elements;
            }
        }
    }

    public function remove_element(Request $request){
        if($request->ajax()){
            if (Auth::user()){
                $element_id = $request->element_id;
                $user_id = Auth::user()->id;
                $result = DB::table('elements')->where('id', $element_id)->where('user_id',  $user_id)->delete();
                return $result;
            }
        }
    }

    public function get_remove_elements(Request $request){
        if($request->ajax()){
            if (Auth::user()){
                $element_id = $request->element_id;
                $user_id = Auth::user()->id;
                $elements = DB::table('elements')->where([
                    ['parent_id', '=', $request->element_id],
                    ['user_id', '=', $user_id],
                ])->get();
                return $elements;
            }
        }
    }


    public function show_elements(Request $request){
        if($request->ajax()){
            if (Auth::user()){
                $element_id = $request->element_id;
                return $element_id;
            }
        }
    }




    public function edit_element(Request $request){
        if($request->ajax()){
            if (Auth::user()){
                $user_id = Auth::user()->id;
                $date = Carbon::now();
                $element_id = $request->element_id;
                $name = $request->element_name;
                $result = DB::update('update elements set element_name = ? where id = ?', [ $name, $element_id ]);
            }
        } 

        return $result;
    }



    public function create_attr(Request $request){
        if($request->ajax()){
            if (Auth::user()){
                $user_id = Auth::user()->id;
                $date = Carbon::now();
                $element_id = $request->attrubute_id;
                $attribute_bool = $request->attribute_bool;
                $attribute_file  = $request->attribute_file;
                $attribute_ip = $request->attribute_ip;
                $attribute_name = $request->attribute_name;
                $attribute_text = $request->attribute_text;
                $attribute_varchar = $request->attribute_varchar;
                $description = $request->description;
                $double_2 = $request->double_2;
                $double_15 = $request->double_15;
                $number_attribute = $request->number_attribute;
                $time_first = $request->time_first;
                $time_second = $request->time_second;
                $attribute_json = null;
                if($attribute_bool == true){
                    $attribute_bool = 1;
                } else if($attribute_bool == false){
                    $attribute_bool = 0;
                } else if($attribute_bool == null){
                    $attribute_bool = null;
                }
                $id_note = DB::table('attributes')->insertGetId(
                    array('user_id' => $user_id, 'element_id' => $element_id, 'attribute_name' => $attribute_name, 'attribute_description' => $description, 'created_at' => $date, 'updated_at' => $date)
                );
                $result = DB::table('attributes_value')->insert(
                    array('user_id' => $user_id, 'attribute_id' => $id_note, 'attribute_time_first' => $time_first, 'attribute_time_second' => $time_second,  'attribute_int' => $number_attribute, 'attribute_float' => $double_2, 'attribute_double' => $double_15, 'attribute_text' => $attribute_text, 'attribute_varchar' => $attribute_varchar, 'attribute_img' => $attribute_file, 'attribute_bool' => $attribute_bool, 'attribute_IP' => $attribute_ip, 'attribute_json' => $attribute_json, 'created_at' => $date, 'updated_at' => $date)
                );
            }
        } 

        return $result;
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

    public function subject_attributes_data(Request $request){
        $user_id = Auth::user()->id;
        $attributes = DB::table('attributes')->where([
            ['subject_id', '=', $request->subjectID],
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

    public function get_section_name(Request $request){
        if($request->ajax()){
            if (Auth::user()){
                $user_id = Auth::user()->id;
                $section = DB::table('sections')->where([
                    ['id', '=', $request->sectionID],
                    ['user_id', '=', $user_id],
                ])->get();

                return $section;
            }
        }
    }

    public function get_section_id_for_cat(Request $request){
        if($request->ajax()){
            if (Auth::user()){
                $user_id = Auth::user()->id;
                $category = DB::table('categories')->where([
                    ['id', '=', $request->categoryID],
                    ['user_id', '=', $user_id],
                ])->get();
        
                return $category;
            }
        } 
    }

    public function get_section_id_for_edit(Request $request){
        if($request->ajax()){
            if (Auth::user()){
                $user_id = Auth::user()->id;
                $category = DB::table('categories')->where([
                    ['id', '=', $request->categoryID],
                    ['user_id', '=', $user_id],
                ])->get();
        
                return $category;
            }
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
                $category_id = $request->categoryID;
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



    public function subject_data(Request $request){
        if($request->ajax()){
            if (Auth::user()){
                $user_id = Auth::user()->id;
                $elements = DB::table('elements')->where([
                    ['subject_id', '=', $request->subjectID],
                    ['user_id', '=', $user_id],
                ])->get();
            }
        } 
        return $elements;
    }

    public function remove_subject(Request $request){
        if($request->ajax()){
            if (Auth::user()){
                $subject_id = $request->subjectID;
                $user_id = Auth::user()->id;
                DB::table('subjects')->where('id', $subject_id)->where('user_id',  $user_id)->delete();
                return $request;
            }
        } 
    }

    public function create_element(Request $request){
        if($request->ajax()){
            if (Auth::user()){
                $user_id = Auth::user()->id;
                $date = Carbon::now();
                DB::table('elements')->insert(
                    array('subject_id' => $request->subjectID, 'element_name' => $request->elementName, 'user_id' => $user_id, 'created_at' => $date, 'updated_at' => $date)
                );
            }
        } 
        return $request;
    }


}


