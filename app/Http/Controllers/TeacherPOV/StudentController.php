<?php

namespace App\Http\Controllers\TeacherPOV;

use App\Models\User;
use App\Models\Classe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;


class StudentController extends Controller
{
    /**
     * Show the form for creating a new student.
     *
     * @return \Illuminate\Http\Response
     */
public function index(Request $request)
{
    $classes = Classe::pluck('NameClass', 'id')->unique();
    $selectedClass = $request->input('class');

    $users = User::when($selectedClass, function ($query) use ($selectedClass) {
        $query->whereHas('classes', function ($query) use ($selectedClass) {
            $query->where('id', $selectedClass);
        });
    })
    ->where('isTeacher', false)
    ->get();

    return view('teacher.List.Students', compact('users','classes'));
}


    /**
     * Store a newly created student in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function Student(Request $request)
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'isTeacher' => false,
        ]);
 
    $classId = $request->input('classe_id');
    $class = Classe::findOrFail($classId);
    $class->students()->attach($user);
    return redirect('Students');
    }

        protected function Show()
    {
        return view('teacher.Add.AddStudents');
        
    }
        protected function Manage()
    {
        return view('teacher.Manage.ManageStudents');
        
    }
        protected function edit($id)
    {
        $student = User::find($id);
        $classes = Classe::all();
        return view('teacher.Edit.EditStudent', compact('student',"classes"));
   
    }
        protected function update(Request $request,$id)
    {
        $user = User::find($id);
        $user->name=$request->input('name');
        $user->email=$request->input('email');
        $user->password=Hash::make($request->input('password'));
        $user->save();
        $selected_class_id = $request->input('class');
        $user->classes()->sync([$selected_class_id]);
       return redirect('Students');
    }
       protected function destroy($id)
    {
        $student = User::find($id);
        if ($student) {
            $student->classes()->detach();
            $student->delete();
            return redirect('/Students')->with('success', 'Student deleted successfully');
        }
        else {
            return redirect('/Students')->with('error', 'Student not found');
        }
   
    }
    //     protected function showClass(Request $request){
    //     $Selected=intval($request->input("selectedclass"));
    //     $classid = DB::table('classes')
    //     ->select('id')
    //     ->where('NameClass', $Selected)
    //     ->first();
    //     $allclasses=DB::table('classes')
    //     ->select('classes.NameClass');
    //     $classes = Classe::find($classid->id);
    //     $users = DB::table('users')
    //     ->join('classe_user', 'classe_user.user_id', '=', 'users.id')
    //     ->join("classes",'classe_user.classe_id','=','classes.id')
    //     ->select('users.name','users.email','classes.NameClass','users.id')
    //     ->where('users.isTeacher', 0)
    //     ->where('classe_user.classe_id', '=', $classid->id)
    //     ->get();
    //     return view('teacher.List.Students', with('users'));  
    // }
        public function filter(){
        $classes = Classe::all();
        $users = User::all();
        return view('teacher.Add.AddStudents', compact('users','classes'));
        }

}
