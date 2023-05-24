<?php

namespace App\Http\Controllers\TeacherPOV;

use App\Models\Classe;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module;

class NoteController extends Controller
{
    public function Manage(){
        return view("teacher.Manage.ManageNotes");
    }
    public function create(){
        $modules=Module::all();
        return view("teacher.Add.AddNote",compact('modules'));
    }
public function store()
{
    $classes = Classe::with('students')->get();
    $modules=Module::all();
    return view('teacher.Add.AddNote', compact('classes','modules'));
}

}
