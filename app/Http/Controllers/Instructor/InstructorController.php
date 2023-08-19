<?php

namespace App\Http\Controllers\Instructor;

use App\User;
use Carbon\Carbon;
use App\Model\Package;
use App\Model\Instructor;
use App\Model\VerifyUser;
use App\NotificationUser;
use App\Model\AdminEarning;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Model\PackagePurchaseHistory;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use App\Notifications\InstructorRegister;
use Illuminate\Database\Schema\Blueprint;

use App\Notifications\VerifyNotifications;

class InstructorController extends Controller
{

    function userNotify($user_id, $details)
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
        if (in_array(Auth::user()->user_type, ["Admin", 'Executive'])) {
            if ($request->has('search')) {
                $instructors = Instructor::where("name", 'LIKE', '%' . $request->search . '%')
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
        if (Auth::user()->user_type == "Instructor") {
            $instructor = Instructor::where('user_id', Auth::id())
                ->with('purchaseHistory')
                ->with('courses')
                ->first();
        } else {
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
        $users = User::where('id', $id)->delete();
        $user = User::findOrFail($id);
        $details = [
            'body' => $user->name . translate(' profile delete '),
        ];

        /* sending instructor notification */
        $notify = $this->userNotify(Auth::user()->id, $details);

        notify()->success(translate('Profile Delete successfully'));
        return back();
    }

    /*Update profile */
    public function edit($id)
    {
        $each_user = Instructor::where('user_id', $id)->firstOrFail();
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

        if ($request->hasFile('signature')) {
            $instructor->signature = fileUpload($request->signature, 'instructor');
        }
        $instructor->save();

        /*User*/
        $user = User::findOrFail($request->user_id);
        $user->image = $instructor->image;
        if ($request->password != null) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }
        $user->save();

        $details = [
            'body' => $instructor->name . translate(' profile updated '),
        ];

        /* sending instructor notification */
        $notify = $this->userNotify(Auth::user()->id, $details);

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
        // Periksa apakah mode demo aktif
        if (env('DEMO') === "YES") {
            Alert::warning('warning', 'This is for demo purposes only');
            return back();
        }
    
        // Validasi input
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
            'nik' => 'required|unique:instructors', // Pastikan NIK unik di tabel instructors
        ], [
            'name.required' => translate('Name is required'),
            'email.required' => translate('Email is required'),
            'email.email' => translate('Invalid email format'),
            'email.unique' => translate('Email already exists.'),
            'password.required' => translate('Password is required'),
            'password.min' => translate('Password must be at least 8 characters'),
            'confirm_password.required' => translate('Please confirm your password'),
            'confirm_password.same' => translate('Passwords do not match'),
            'nik.required' => translate('NIK is required'),
            'nik.unique' => translate('NIK already exists.'),
        ]);
    
        try {
            // Create a new user
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->nik = $request->nik;
            $user->password = Hash::make($request->password);
            $user->user_type = 'Instructor';
            $user->save();

            // Create a new instructor
            $instructor = new Instructor();
            $instructor->name = $request->name;
            $instructor->email = $request->email;
            $instructor->nik = $request->nik;
            $instructor->user_id = $user->id;
            $instructor->save();

            // Create a purchase history (you might need to adjust this part)
            $package = Package::find(1); // You need to replace 1 with the correct package ID
            $purchase = new PackagePurchaseHistory();
            $purchase->amount = $package->price; // Adjust this based on your logic
            $purchase->payment_method = $request->payment_method; // Adjust this based on your logic
            $purchase->package_id = $package->id; // Adjust this based on your logic
            $purchase->user_id = $user->id;
            $purchase->save();
    
            // Hitung pendapatan admin (Anda perlu mengimplementasikan ini)
    
            // Kirim email verifikasi
            $user->notify(new VerifyNotifications($user));
    
            Session::flash('message', translate("Registration done successfully."));
            return back();
        } catch (\Exception $exception) {
            // Tangani pengecualian jika diperlukan
            // Misalnya, tampilkan pesan kesalahan atau log pesan kesalahan
            return back()->withErrors(['error' => 'Registration failed. Please try again.']);
        }
    }
}    