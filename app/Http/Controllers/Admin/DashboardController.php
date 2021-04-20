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
                if($attribute_name != null){
                    $id_note = DB::table('attributes')->insertGetId(
                        array('user_id' => $user_id, 'element_id' => $element_id, 'attribute_name' => $attribute_name, 'attribute_description' => $description, 'created_at' => $date, 'updated_at' => $date)
                    );
                    if($time_first != null || $time_second != null || $number_attribute != null || $double_2 != null || $double_15 != null || $attribute_text != null || $attribute_varchar != null || $attribute_file != null || $attribute_ip != null || $attribute_bool != null){
                        $result = DB::table('attributes_value')->insertGetId(
                            array('user_id' => $user_id, 'attribute_id' => $id_note, 'attribute_time_first' => $time_first, 'attribute_time_second' => $time_second,  'attribute_int' => $number_attribute, 'attribute_float' => $double_2, 'attribute_double' => $double_15, 'attribute_text' => $attribute_text, 'attribute_varchar' => $attribute_varchar, 'attribute_img' => $attribute_file, 'attribute_bool' => $attribute_bool, 'attribute_IP' => $attribute_ip, 'attribute_json' => $attribute_json, 'created_at' => $date, 'updated_at' => $date)
                        );
                    } else {
                        $result = null;
                    }
                } else {
                    $result = null;
                }
                return $result;
            }
        } 
    }

    public function get_attr(Request $request){
        if($request->ajax()){
            if (Auth::user()){
                $element_id = $request->element_id;
                $user_id = Auth::user()->id;
                $attributes = DB::table('attributes')->where([
                    ['element_id', '=', $element_id],
                    ['user_id', '=', $user_id],
                ])->get();

                $attributes_values = null;
                for($i = 0; $i < count($attributes); $i++){
                    $attributes_values[$i] = DB::table('attributes_value')->where([
                        ['attribute_id', '=', $attributes[$i]->id],
                        ['user_id', '=', $user_id],
                    ])->get();
                    $count_attr = DB::table('attributes_value')->where([
                        ['attribute_id', '=', $attributes[$i]->id],
                        ['user_id', '=', $user_id],
                    ])->count();
                    $attributes_values[$i]['element_id'] = $element_id;
                    $attributes_values[$i]['count_attr'] = $count_attr;
                    $attributes_values[$i]['attribute_id'] = $attributes[$i]->id;
                    $attributes_values[$i]['attribute_name'] = $attributes[$i]->attribute_name;
                    $attributes_values[$i]['attribute_description'] = $attributes[$i]->attribute_description;
                }
                return $attributes_values;
            }
        }
    }

    public function edit_attr(Request $request){
        if($request->ajax()){
            if (Auth::user()){
                $attrubute_id = $request->attrubute_id;
                $attrubute_name = $request->attrubute_name;
                $attribute_description = $request->attribute_description;
                $result = DB::table('attributes')->where('id', $attrubute_id )->update(['attribute_name' => $attrubute_name, 'attribute_description' => $attribute_description]);
                return $result;
            }
        }
    }

    public function get_complex_id(Request $request){
        if($request->ajax()){
            if (Auth::user()){
                $user_id = Auth::user()->id;
                $element = DB::table('elements')->where([
                    ['id', '=', $request->element_id],
                    ['user_id', '=', $user_id],
                ])->get();

                $elements = explode('-', $element[0]->complex_id);

                return $elements;
            }
        }
    }

    public function edit_value_attr(Request $request){
        if($request->ajax()){
            if (Auth::user()){
                $user_id = Auth::user()->id;
                $date = Carbon::now();
                $id = $request->id;
                $attrubute_id = $request->attrubute_id;
                $attribute_bool = $request->attribute_bool;
                $attribute_file  = $request->attribute_file;
                $attribute_ip = $request->attribute_ip;
                $attribute_text = $request->attribute_text;
                $attribute_varchar = $request->attribute_varchar;
                $double_2 = $request->double_2;
                $double_15 = $request->double_15;
                $number_attribute = $request->number_attribute;
                $time_first = $request->time_first;
                $time_second = $request->time_second;
                $attribute_json = null;
                //$result = DB::table('attributes_value')->where(['attribute_id' => $attrubute_id, 'user_id' => $user_id, 'id' => $id])->update(['attribute_bool' => $attribute_bool, 'attribute_img' => $attribute_file, 'attribute_ip' => $attribute_ip, 'attribute_text' => $attribute_text, 'attribute_varchar' => $attribute_varchar, 'attribute_float' => $double_2, 'attribute_double' => $double_15, 'attribute_int' => $number_attribute, 'attribute_time_first' => $time_first, 'attribute_time_second' => $time_second, 'attribute_json' => $attribute_json, 'updated_at' => $date]);
                $result = DB::table('attributes_value')->where(['id' => $id , 'user_id' => $user_id, 'attribute_id' => $attrubute_id])->update(['attribute_bool' => $attribute_bool, 'attribute_img' => $attribute_file, 'attribute_ip' => $attribute_ip, 'attribute_text' => $attribute_text, 'attribute_varchar' => $attribute_varchar, 'attribute_float' => $double_2, 'attribute_double' => $double_15, 'attribute_int' => $number_attribute, 'attribute_time_first' => $time_first, 'attribute_time_second' => $time_second, 'attribute_json' => $attribute_json, 'updated_at' => $date]);
                return $result;
            }
        }
    }

    public function remove_attr(Request $request){
        if($request->ajax()){
            if (Auth::user()){
                $user_id = Auth::user()->id;
                $attr_id = $request->attr_id;
                if($request->attr_type == 'main'){
                    $result = DB::table('attributes_value')->where('attribute_id', $attr_id)->where('user_id',  $user_id)->delete();
                    $result = DB::table('attributes')->where('id', $attr_id)->where('user_id',  $user_id)->delete();
                } else if($request->attr_type == 'value'){
                    $result = DB::table('attributes_value')->where('id', $attr_id)->where('user_id',  $user_id)->delete();
                }
            }
            return $result;
        }
    }


    public function create_attr_value(Request $request){
        if($request->ajax()){
            if (Auth::user()){
                $user_id = Auth::user()->id;
                $date = Carbon::now();
                $attribute_id = $request->attrubute_id;
                $attribute_bool = $request->attribute_bool;
                $attribute_file  = $request->attribute_file;
                $attribute_ip = $request->attribute_ip;
                $attribute_text = $request->attribute_text;
                $attribute_varchar = $request->attribute_varchar;
                $double_2 = $request->double_2;
                $double_15 = $request->double_15;
                $number_attribute = $request->number_attribute;
                $time_first = $request->time_first;
                $time_second = $request->time_second;
                $attribute_json = null;
                if($time_first != null || $time_second != null || $number_attribute != null || $double_2 != null || $double_15 != null || $attribute_text != null || $attribute_varchar != null || $attribute_file != null || $attribute_ip != null || $attribute_bool != null){
                    $result = DB::table('attributes_value')->insertGetId(
                        array('user_id' => $user_id, 'attribute_id' => $attribute_id, 'attribute_time_first' => $time_first, 'attribute_time_second' => $time_second,  'attribute_int' => $number_attribute, 'attribute_float' => $double_2, 'attribute_double' => $double_15, 'attribute_text' => $attribute_text, 'attribute_varchar' => $attribute_varchar, 'attribute_img' => $attribute_file, 'attribute_bool' => $attribute_bool, 'attribute_IP' => $attribute_ip, 'attribute_json' => $attribute_json, 'created_at' => $date, 'updated_at' => $date)
                    );
                } else {
                    $result = null;
                }
                return $result;
            }
        }
    }


    public function search_element(Request $request){
        if($request->ajax()){
            if (Auth::user()){
                $user_id = Auth::user()->id;
                $elements = DB::table('elements')->where([
                    ['element_name', 'LIKE', '%' . $request->value_text .'%' ],
                    ['user_id', '=', $user_id],
                ])->get();

                return $elements;
            }
        }
    }


    public function search_attributes_int(Request $request){
        if($request->ajax()){
            if (Auth::user()){
                $user_id = Auth::user()->id;
                $attributes_int = DB::table('attributes_value')->where([
                    ['attribute_int', '!=', null ],
                    ['user_id', '=', $user_id],
                ])->get();

                return $attributes_int;
            }
        }
    }

    public function search_attributes_float(Request $request){
        if($request->ajax()){
            if (Auth::user()){
                $user_id = Auth::user()->id;
                $attributes_float = DB::table('attributes_value')->where([
                    ['attribute_float', '!=', null ],
                    ['user_id', '=', $user_id],
                ])->get();

                return $attributes_float;
            }
        }
    }

    public function search_attributes_double(Request $request){
        if($request->ajax()){
            if (Auth::user()){
                $user_id = Auth::user()->id;
                $attributes_double = DB::table('attributes_value')->where([
                    ['attribute_double', '!=', null ],
                    ['user_id', '=', $user_id],
                ])->get();

                $count = 0;
                foreach($attributes_double as $attr){
                    $array[$count] = $attr->attribute_id;
                    $count += 1;
                }

                $array = array_unique($array, SORT_REGULAR);

                $count = 0;
                foreach($array as $arr){
                    $attributes[$count] = DB::table('attributes_value')->where([
                        ['attribute_id', '=', $arr ],
                        ['user_id', '=', $user_id],
                    ])->get();
                    $count += 1;
                }

                return $attributes;
            }
        }
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


