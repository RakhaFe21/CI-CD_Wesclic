<?php

namespace App\Http\Controllers\Module;

use App\Http\Controllers\Controller;
use App\Model\Course;
use App\Model\Enrollment;
use App\User;
use App\Model\Student;
use App\Notifications\StudentRegister;
use Alert;
use App\Model\Logbook;
use App\Model\LogbookStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Hash;
use Session;
use App\Model\VerifyUser;
use App\Notifications\VerifyNotifications;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    /*All students with search option */
    public function index(Request $request)
    {
        if (Auth::user()->user_type == "Admin") {
            /*if Authenticated  user is admin , admin can show all students */
            if ($request->get('search')) {
                $students = Student::where('name', 'like', '%' . $request->get('search') . '%')
                    ->orWhere('email', 'like', '%' . $request->get('search') . '%')
                    ->orderBydesc('id')->paginate(10);
            } else {
                $students = Student::orderBydesc('id')->paginate(10);
            }


        } else {
            /*There are the Instructor show only his/her register Students list*/
            $courses = Course::where('user_id', Auth::id())->get();
            $course_id_array = array();
            foreach ($courses as $i) {
                array_push($course_id_array, $i->id);
            }
            $enroll_student_id = array();
            $enroll = Enrollment::whereIn('course_id', $course_id_array)->get();
            foreach ($enroll as $i) {
                array_push($enroll_student_id, $i->user_id);
            }

            if ($request->get('search')) {
                $students = Student::where('name', 'like', '%' . $request->get('search') . '%')
                    ->orWhere('email', 'like', '%' . $request->get('search') . '%')
                    ->whereIn('user_id', $enroll_student_id)->orderBydesc('id')->paginate(10);
            } else {
                $students = Student::whereIn('user_id', $enroll_student_id)->orderBydesc('id')->paginate(10);
            }
        }
        return view('module.students.index', compact('students'));
    }

    /*This function show all instructor related history
    like Package, Course , Enrolment Student list Get Payment History*/

    public function peserta_baru(Request $request)
    {
        if (Auth::user()->user_type == "Admin") {
            /*if Authenticated  user is admin , admin can show all students */
            if ($request->get('search')) {
                $students = Student::where('name', 'like', '%' . $request->get('search') . '%')
                    ->orWhere('email', 'like', '%' . $request->get('search') . '%')
                    ->orderBydesc('id')->paginate(10);
            } else {
                $students = Student::leftjoin('users AS b', 'students.user_id', 'b.id')->orderBydesc('students.id')->paginate(10);
            }
        } 
        return view('course.peserta.index', compact('students'));
    }

    public function show($id)
    {
        $each_student = Student::where('user_id', $id)->first();

        return view('module.students.show', compact('each_student'));
    }


    public function create()
    {
        return view('module.students.create');
    }


    public function student_store(Request $request)
    {
        if (env('DEMO') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }

        // registration validation
        $request->validate(
            [
                'name' => 'required',
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8'],
                'confirmed' => 'required|required_with:password|same:password',
            ],
            [
                'name.required' => translate('Name is required'),
                'email.required' => translate('Email is required'),
                'email.unique' => translate('Email is already register'),
                'password.required' => translate('Password is required'),
                'password.min' => translate('Password  must be 8 character '),
                'password.string' => translate('Password is required'),
                'confirmed.required' => translate('Please confirm your password'),
                'confirmed.same' => translate('Password did not match'),
            ]

        );

        //create user for login
        $user = new User();
        $user->name = $request->name;
        $user->slug = Str::slug($request->name);
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->user_type = 'Student';
        $user->save();

        //create student
        $student = new Student();
        $student->name = $request->name;
        $student->email = $request->email;
        $student->user_id = $user->id;
        $student->save();

        /*here is the student */
        try {
            $user->notify(new StudentRegister());

            VerifyUser::create([
                'user_id' => $user->id,
                'token' => sha1(time())
            ]);
            
            

            // send verify mail
            $user->notify(new VerifyNotifications($user));

        } catch (\Exception $exception) {
        }

        Session::flash('message', translate("Registration done successfully."));
        return back();
    }


    public function student_enroll_courses($id)
    {
        $enrollments = Enrollment::where('user_id', $id)->select('course_id')->get();
        return view('module.students.enroll_course', compact('enrollments', 'id'));
    }

    public function student_enroll_courses_store(Request $request, $id)
    {
        $items = $request->course_id;

        foreach($items as $item){
            $enroll = new Enrollment;
            $enroll->course_id = $item;
            $enroll->user_id = $id;
            $enroll->save();
        }

        Session::flash('message', translate("Course enrolled for student."));
        return back();

    }

    // Logbook Student

    public function student_logbook_courses($course_id, $user_id)
    {
        $logbooks = Logbook::where('course_id', $course_id)->get();
        $logbook_students = LogbookStudent::leftJoin('logbook as l', 'l.id', '=', 'logbook_students.logbook_id')
        ->where('l.course_id', $course_id)
        ->where('user_id', $user_id)->pluck('logbook_id')->toArray();
        $student = Student::where('user_id', $user_id)->first();
        return view('module.students.logbook_course', compact('logbooks', 'logbook_students', 'student', 'user_id'));
    }

    public function student_logbook_courses_store(Request $request, $user_id)
    {
        $logbooks = $request->logbook_id;

        LogbookStudent::where('user_id', $user_id)->delete();
        foreach($logbooks as $id){
            $logStudent = new LogbookStudent();
            $logStudent->logbook_id = $id;
            $logStudent->user_id = $user_id;
            $logStudent->save();

        }

        notify()->success('Student logbook updated successfully!');
        return redirect()->back()->with('success', 'Student logbook updated successfully!');
    }

    //END
}
