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

}


