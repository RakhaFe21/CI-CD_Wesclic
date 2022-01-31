<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Model\Instructor;
use App\User;
use Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\NotificationUser;
use App\Model\Package;
use App\Model\PackagePurchaseHistory;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Model\AdminEarning;
use App\Notifications\InstructorRegister;
use App\Model\VerifyUser;
use App\Notifications\VerifyNotifications;

use phpseclib\Crypt\Hash;

class InstructorController extends Controller
{

    function userNotify($user_id,$details)
    {
        $notify = new NotificationUser();
        $notify->user_id = $user_id;
        $notify->data = $details;
        $notify->save();
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    /*all instructor list*/
    public function index(Request $request)
    {
        //there are the check the admin or
        if (Auth::user()->user_type == "Admin") {
            if ($request->has('search')) {
                $instructors = Instructor::where("name", 'LIKE', '%'. $request->search.'%')
                    ->paginate(10);
            } else {
                $instructors = Instructor::latest()->paginate(10);
            }
        } else {
            $instructors = Instructor::where('user_id', Auth::id())->paginate(10);
        }
        return view('instructor.index', compact('instructors'));
    }


    /*This function show all instructor related history
    like Package, Course , Enrolment Student list Get Payment History*/
    public function show($id)
    {
        if(Auth::user()->user_type == "Instructor"){
            $instructor = Instructor::where('user_id', Auth::id())
                ->with('purchaseHistory')
                ->with('courses')
                ->first();
        }else{
            $instructor = Instructor::where('user_id', $id)
                ->with('purchaseHistory')
                ->with('courses')
                ->first();
        }


        return view('instructor.show', compact('instructor'));
    }

    public function delete($id)
    {
        $instructor = Instructor::where('user_id', $id)->delete();
        $user = User::findOrFail($id);
        $details = [
            'body' => $user->name . translate(' profile delete '),
        ];

        /* sending instructor notification */
        $notify = $this->userNotify(Auth::user()->id,$details);

        notify()->success(translate('Profile Delete successfully'));
        return back();
    }

    /*Update profile */
    public function edit($id)
    {
        $each_user = Instructor::where('user_id',$id)->firstOrFail();
        return view('instructor.profile', compact('each_user'));
    }

    /*Update the Profile*/
    public function update(Request $request)
    {
        if (env('DEMO') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }

        $instructor = Instructor::where('user_id', $request->user_id)->firstOrFail();
        $instructor->phone = $request->phone;
        if ($request->hasFile('newImage')) {
            fileDelete($request->image);
            $instructor->image = fileUpload($request->newImage, 'instructor');
        } else {
            $instructor->image = $request->image;
        }
        $instructor->address = $request->address;
        $instructor->linked = $request->linked;
        $instructor->tw = $request->tw;
        $instructor->fb = $request->fb;
        $instructor->skype = $request->skype;
        $instructor->about = $request->about;

        if ($request->hasFile('signature')){
            $instructor->signature = fileUpload($request->signature,'instructor') ;
        }
        $instructor->save();

        /*User*/
        $user = User::findOrFail($request->user_id);
        $user->image = $instructor->image;
        if ($request->password != null){
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }
        $user->save();

        $details = [
            'body' => $instructor->name . translate(' profile updated '),
        ];

        /* sending instructor notification */
        $notify = $this->userNotify(Auth::user()->id,$details);

        notify()->success(translate('Profile updated successfully'));
        return back();
    }

    /*banned the instructor*/
    public function banned(Request $request)
    {

        if (env('DEMO') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }

        $user = User::findOrFail($request->id);
        if ($user->user_type == "Instructor" && $user->banned == true) {
            $user->banned = false;
            notify()->success(translate('This user is Active'));

        } elseif ($user->user_type == "Instructor" && $user->banned == false) {
            $user->banned = true;
            notify()->success(translate('This user is Banned'));
        } else {
            notify()->warning(translate('Please there are problem try again'));
        }
        $user->save();
        return back();
    }



    public function create()
    {
        return view('instructor.modal');
    }


    public function instructor_store(Request $request)
    {
        if (env('DEMO') === "YES") {
        Alert::warning('warning', 'This is demo purpose only');
        return back();
      }

      $request->validate([
            //'package_id' => 'required',
            'name' => 'required',
            'email' => ['required', 'unique:users'],
            'password' => ['required', 'min:8'],
            'confirm_password' => 'required|required_with:password|same:password',
        ], [
            //'package_id.required' => translate('Please select a package'),
            'name.required' => translate('Name is required'),
            'email.required' => translate('Email is required'),
            'email.unique' => translate('Email is already exist.'),
            'password.required' => translate('Password is required'),
            'password.min' => translate('Password must be minimum 8 characters'),
            'confirm_password.required' => translate('Please confirm your password'),
            'confirm_password.same' => translate('Password did not match'),
        ]);
        /*get package value*/
        $package = Package::where('id', 1)->firstOrFail();
        // $package = Package::where('id', $request->package_id)->firstOrFail();
        //create user for login

        $slug_name = Str::slug($request->name);
        /*check the sulg */
        $users = User::where('slug', $slug_name)->get();
        if ($users->count() > 0) {
            $slug_name = $slug_name.($users->count() + 1);
        }
        $user = new User();
        $user->slug = $slug_name;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        $user->user_type = 'Instructor';
        $user->save();

        //save data in instructor
        $instructor = new Instructor();
        $instructor->name = $request->name;
        $instructor->email = $request->email;
        $instructor->package_id = 1;
        $instructor->user_id = $user->id;
        $instructor->save();


            //add purchase history
            $purchase = new PackagePurchaseHistory();
            $purchase->amount = $package->price;
            $purchase->payment_method = $request->payment_method;
            $purchase->package_id = 1;
            $purchase->user_id = $user->id;
            $purchase->save();


            //todo::admin Earning calculation
            $admin = new AdminEarning();
            $admin->amount = $package->price;
            $admin->purposes = "Sale Package";
            $admin->save();

            try {

                $user->notify(new InstructorRegister());

                VerifyUser::create([
                    'user_id' => $user->id,
                    'token' => sha1(time())
                ]);
                //send verify mail
                $user->notify(new VerifyNotifications($user));
            } catch (\Exception $exception) {

            }
        

        Session::flash('message', translate("Registration done successfully."));
        return back();
    }
    //END
}
