<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Exception;
use App\Model\Course;
use App\Model\Logbook;
use Auth;
use Alert;
use App\Model\Category;
use App\Model\Classes;
use App\Model\ClassContent;
use App\Model\Language;
use App\Model\Enrollment;
use App\Model\KursusJadwal;
use App\Model\KursusSesi;
use App\Model\Student;
use Carbon\Carbon;
use App\NotificationUser;
use DB;

class CourseController extends Controller
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

    /*only instructor show only his/her course
     Admin can show all Course
    */
    public function index(Request $request)
    {
        if ($request->has('search')) {
            if (Auth::user()->user_type == "Admin") {
                $courses = Course::where('title', 'like', '%' . $request->search . '%')->latest()->paginate(10);
            } else {
                $courses = Course::where("user_id", Auth::id())->where('title', 'like', '%' . $request->search . '%')->latest()->paginate(10);
            }
        } else {
            if (Auth::user()->user_type == "Admin") {
                $courses = Course::latest()->paginate(10);
            } else {
                $courses = Course::where("user_id", Auth::id())->latest()->paginate(10);
            }
        }

        return view('course.index', compact('courses'));
    }

    public function peserta_pel($course_id)
    {
        $course = Course::findOrFail($course_id);

        $students['pending'] = Student::leftjoin('enrollments AS e', 'students.user_id', 'e.user_id')->where('e.course_id', $course_id)->orderBydesc('students.id')
        ->where('e.status', 'Pending')
        ->selectRaw("*, e.id as enrollment_id")->paginate(10);

        $students['tes_tulis'] = Student::leftjoin('enrollments AS e', 'students.user_id', 'e.user_id')->where('e.course_id', $course_id)->orderBydesc('students.id')
        ->where('e.status', 'Tes Tulis')
        ->selectRaw("*, e.id as enrollment_id")->paginate(10);

        $students['tes_wawancara'] = Student::leftjoin('enrollments AS e', 'students.user_id', 'e.user_id')->where('e.course_id', $course_id)->orderBydesc('students.id')
        ->where('e.status', 'Tes Wawancara')
        ->selectRaw("*, e.id as enrollment_id")->paginate(10);

        $students['pendaftaran_ulang'] = [];
        $students['terdaftar'] = [];

        return view('course.peserta.list', compact('students', 'course_id', 'course'));
    }

    public function enrollmentStatusUpdate(Request $request, $course_id)
    {
        $reqData = $request->only(['enrollment_id', 'status']);
        // dd($reqData);
        
        if(empty($reqData['enrollment_id']) || empty($reqData['status'])) {
            return redirect()->back()->with('error', 'Request invalid!');
        }

        $where = [];

        if($reqData['status'] == 'Tes Tulis') {
            $where['kursus_jadwal.nama_jadwal'] = 'Tes Tulis';
        }

        $kursus_sesi_tersedia = DB::table('kursus_sesi')
        ->join('kursus_jadwal', 'kursus_jadwal.id', '=', 'kursus_sesi.id_kursus_jadwal')
        ->leftJoin('kursus_sesi_siswa', 'kursus_sesi_siswa.id_kursus_sesi', '=', 'kursus_sesi.id')
        ->where($where)
        ->where('id_kursus', $course_id)
        ->whereNull('kursus_jadwal.deleted_at')->whereNull('kursus_sesi.deleted_at')->whereNull('kursus_sesi_siswa.id_user')
        ->selectRaw('kursus_sesi.*, kursus_jadwal.*, kursus_sesi.id as id, kursus_sesi_siswa.id_user as id_sesi_siswa')->get();
        
        // foreach ($kursus_sesi_tersedia as $key => $sesi_tersedia) {
            
        // }

        dd($kursus_sesi_tersedia);
        
    }

    // course.create
    public function create()
    {
        $categories = Category::all();
        // $languages = Language::all();
        return view('course.create', compact('categories'));
    }

    // course.store
    public function store(Request $request)
    {
        if (env('DEMO') === "YES") {
            Alert::warning('warning', 'This is demo purpose only');
            return back();
        }
        $request->validate([
            'title' => 'required|unique:courses',
            // 'image' => 'required',
            'category_id' => 'required',
            'level' => 'required',
        ], [
            'title.required' => translate('Title is required'),
            'level.required' => translate('Course Level is required'),
            'title.unique' => translate('Course title must be unique'),
            'category_id.required' => translate('You must choose a category'),
            // 'image.required' => translate('Course thumbnail is required'),
        ]);

        // dd($request->all());

        DB::beginTransaction();
        try {

            $courses = new Course();
            $courses->title = $request->title;
            $courses->slug = Str::slug($request->title);
            $courses->short_description = $request->short_description;
            $courses->big_description = $request->big_description;
            $courses->image = !empty($request->image) ? $request->image : 'uploads/course/default.jpeg';
            $courses->level = $request->level;
            $courses->provider = null;
            $courses->overview_url = null;
            $courses->rating = 5;
            $courses->requirement = json_encode([]);
            $courses->outcome = json_encode([]);
            $courses->tag = json_encode([]);
            $courses->is_free = 0;
            $courses->price = null;
            $courses->is_discount = 0;
            $courses->discount_price = null;
            $courses->language = 'Bahasa Indonesia';
            $courses->meta_title = $request->title;
            $courses->meta_description = $request->short_description;
            $courses->category_id = $request->category_id;
            $courses->is_published = $request->is_published == "on" ? true : false;
            $courses->user_id = Auth::user()->id;

            // Custom
            $courses->tahapan_pelatihan = $request->tahapan_pelatihan;
            $courses->jumlah_peserta = $request->jumlah_peserta;
            $courses->mulai_pendaftaran = $request->mulai_pendaftaran;
            $courses->berakhir_pendaftaran = $request->berakhir_pendaftaran;
            $courses->need_dtks = $request->need_dtks == "on" ? true : false;
            $courses->allow_disability = $request->allow_disability == "on" ? true : false;

            if ($request->has('has_tes_tulis') && $request->has_tes_tulis == 'on') {
                $courses->has_tes_tulis = true;
            }

            if ($request->has('has_tes_wawancara') && $request->has_tes_wawancara == 'on') {
                $courses->has_tes_wawancara = true;
            }

            $courses->save();

            // get last insert id
            $id_courses     = $courses->id;

            if ($request->has('has_tes_tulis') && $request->has_tes_tulis == 'on') {
                $jadwal = KursusJadwal::create([
                    'id_kursus' => $id_courses,
                    'nama_jadwal' => 'Tes Tulis',
                    'jumlah_sesi_perhari' => $request->testu_jumlah_sesi_perhari,
                    'durasi_persesi' => $request->testu_durasi_per_sesi,
                    'jumlah_peserta_persesi' => $request->testu_jumlah_peserta_persesi,
                    'tanggal_mulai' => $request->testu_tanggal_mulai,
                    'jam_mulai' => $request->testu_jam_mulai,
                ]);
                $sesi_insert = [];
                for ($i = 0; $i < count($request->testu_sesi_tanggal); $i++) {
                    $sesi_insert[$i]['id_kursus_jadwal'] = $jadwal->id;
                    $sesi_insert[$i]['nama_sesi'] = $request->testu_sesi_nama[$i];
                    $sesi_insert[$i]['tanggal_sesi'] = $request->testu_sesi_tanggal[$i];
                    $sesi_insert[$i]['jam_sesi'] = $request->testu_sesi_jam[$i];
                    $sesi_insert[$i]['lokasi_sesi'] = $request->testu_sesi_lokasi[$i];
                    $sesi_insert[$i]['created_at'] = date('Y-m-d H:i:s');
                }
                KursusSesi::insert($sesi_insert);
            }

            if ($request->has('has_tes_wawancara') && $request->has_tes_wawancara == 'on') {
                $jadwal = KursusJadwal::create([
                    'id_kursus' => $id_courses,
                    'nama_jadwal' => 'Tes Wawancara',
                    'jumlah_sesi_perhari' => $request->teswa_jumlah_sesi_perhari,
                    'durasi_persesi' => $request->teswa_durasi_per_sesi,
                    'jumlah_peserta_persesi' => $request->teswa_jumlah_peserta_persesi,
                    'tanggal_mulai' => $request->teswa_tanggal_mulai,
                    'jam_mulai' => $request->teswa_jam_mulai,
                ]);
                $sesi_insert = [];
                for ($i = 0; $i < count($request->teswa_sesi_tanggal); $i++) {
                    $sesi_insert[$i]['id_kursus_jadwal'] = $jadwal->id;
                    $sesi_insert[$i]['nama_sesi'] = $request->teswa_sesi_nama[$i];
                    $sesi_insert[$i]['tanggal_sesi'] = $request->teswa_sesi_tanggal[$i];
                    $sesi_insert[$i]['jam_sesi'] = $request->teswa_sesi_jam[$i];
                    $sesi_insert[$i]['lokasi_sesi'] = $request->teswa_sesi_lokasi[$i];
                    $sesi_insert[$i]['created_at'] = date('Y-m-d H:i:s');
                }
                KursusSesi::insert($sesi_insert);
            }

            foreach ($request->logbook as $data) {
                $logbook = new logbook();
                $logbook->name       = $data;
                $logbook->course_id  = $id_courses;
                $logbook->created_at = date('Y-m-d H:i:s');
                $logbook->save();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        // $details = [
        //     'body' => translate($request->title . ' new course uploaded by ' . Auth::user()->name),
        // ];

        /* sending instructor notification */

        notify()->success($request->title . ' created successfully!');
        return redirect('dashboard/course/index');
    }

    /*Check all slug*/
    public function check(Request $request)
    {
        $slug = $request->title;
        if ($slug) {
            $data = Course::where('title', $slug)->count();

            if ($data > 0) {
                return 'not_unique';
            } else {
                return 'unique';
            }
        }
    }

    // course.show
    public function show($course_id)
    {
        $course = Course::with('classesAll')->findOrFail($course_id);
        return view('course.show', compact('course', 'course_id'));
    }

    // course.destroy
    public function destroy($course_id)
    {

        if (env('DEMO') === "YES") {
            Alert::warning('warning', 'This is demo purpose only');
            return back();
        }

        $s = Enrollment::where('course_id', $course_id)->count();

        if ($s <= 0) {
            Course::findOrFail($course_id)->delete();
            notify()->success(translate('Course deleted successfully'));
            return back();
        } else {
            notify()->success(translate('This course has enrolled student'));
            return back();
        }
    }

    // course.edit
    public function edit($course_id)
    {
        $each_course = Course::findOrFail($course_id);
        $logbook = Logbook::where('course_id', $course_id)->get();
        $categories = Category::all();
        $jadwal_tes_tulis = KursusJadwal::with(['sesi'])->where('id_kursus', $course_id)->where('nama_jadwal', 'Tes Tulis')->first();
        $jadwal_tes_tulis = $jadwal_tes_tulis ?? json_encode([]);
        $jadwal_tes_wawancara = KursusJadwal::with(['sesi'])->where('id_kursus', $course_id)->where('nama_jadwal', 'Tes Wawancara')->first();
        $jadwal_tes_wawancara = $jadwal_tes_wawancara ?? json_encode([]);

        return view('course.edit', compact('each_course', 'categories', 'logbook', 'jadwal_tes_tulis', 'jadwal_tes_wawancara'));
    }

    // course.update
    public function update(Request $request)
    {

        if (env('DEMO') === "YES") {
            Alert::warning('warning', 'This is demo purpose only');
            return back();
        }

        $request->validate([
            'title' => 'required',
            'image' => 'required',
            'category_id' => 'required',
            'level' => 'required',
        ], [
            'title.required' => translate('Title is required'),
            'level.required' => translate('Level is required'),
            'category_id.required' => translate('You must choose a category'),

        ]);


        $courses = Course::where('id', $request->id)->firstOrFail();
        $course_id = $courses->id;

        // print_r($request->id);
        // dd($request->all());

        DB::beginTransaction();
        try {

            $courses->title = $request->title;
            $courses->slug = Str::slug($request->title);
            $courses->short_description = $request->short_description;
            $courses->big_description = $request->big_description;
            if ($request->has('image') && !empty($request->image)) {
                $courses->image = $request->image;
            }
            $courses->level = $request->level;
            $courses->provider = null;
            $courses->overview_url = null;
            $courses->rating = 5;
            $courses->requirement = json_encode([]);
            $courses->outcome = json_encode([]);
            $courses->tag = json_encode([]);
            $courses->is_free = 0;
            $courses->price = null;
            $courses->is_discount = 0;
            $courses->discount_price = null;
            $courses->language = 'Bahasa Indonesia';
            $courses->meta_title = $request->title;
            $courses->meta_description = $request->short_description;
            $courses->category_id = $request->category_id;
            $courses->is_published = $request->is_published == "on" ? true : false;
            $courses->user_id = Auth::user()->id;

            // Custom
            $courses->tahapan_pelatihan = $request->tahapan_pelatihan;
            $courses->jumlah_peserta = $request->jumlah_peserta;
            $courses->mulai_pendaftaran = $request->mulai_pendaftaran;
            $courses->berakhir_pendaftaran = $request->berakhir_pendaftaran;
            $courses->need_dtks = $request->need_dtks == "on" ? true : false;
            $courses->allow_disability = $request->allow_disability == "on" ? true : false;

            if ($request->has('has_tes_tulis') && $request->has_tes_tulis == 'on') {
                $courses->has_tes_tulis = true;
            }

            if ($request->has('has_tes_wawancara') && $request->has_tes_wawancara == 'on') {
                $courses->has_tes_wawancara = true;
            }

            $courses->save();

            if ($request->has('has_tes_tulis') && $request->has_tes_tulis == 'on') {
                $cek_tes_tulis = KursusJadwal::where('id_kursus', $course_id)->where('nama_jadwal', 'Tes Tulis');

                if ($cek_tes_tulis->count() < 1) {
                    $jadwal = KursusJadwal::create([
                        'id_kursus' => $course_id,
                        'nama_jadwal' => 'Tes Tulis',
                        'jumlah_sesi_perhari' => $request->testu_jumlah_sesi_perhari,
                        'durasi_persesi' => $request->testu_durasi_per_sesi,
                        'jumlah_peserta_persesi' => $request->testu_jumlah_peserta_persesi,
                        'tanggal_mulai' => $request->testu_tanggal_mulai,
                        'jam_mulai' => $request->testu_jam_mulai,
                    ]);
                    $id_jadwal = $jadwal->id;
                } else {
                    $id_jadwal = $cek_tes_tulis->first()->id;
                }
                $sesi_insert = [];
                $sesi_update = [];
                for ($i = 0; $i < count($request->testu_sesi_tanggal); $i++) {
                    if (isset($request->testu_sesi_id[$i]) && !empty($request->testu_sesi_id[$i])) {
                        $id_sesi = $request->testu_sesi_id[$i];
                        $sesi_update['id_kursus_jadwal'] = $id_jadwal;
                        $sesi_update['nama_sesi'] = $request->testu_sesi_nama[$i];
                        $sesi_update['tanggal_sesi'] = $request->testu_sesi_tanggal[$i];
                        $sesi_update['jam_sesi'] = $request->testu_sesi_jam[$i];
                        $sesi_update['lokasi_sesi'] = $request->testu_sesi_lokasi[$i];
                        KursusSesi::where('id', $id_sesi)->update($sesi_update);
                    } else {
                        if (!empty($request->testu_sesi_nama[$i]) && !empty($request->testu_sesi_tanggal[$i]) && !empty($request->testu_sesi_jam[$i]) && !empty($request->testu_sesi_lokasi[$i])) {
                            $sesi_insert['id_kursus_jadwal'] = $id_jadwal;
                            $sesi_insert['nama_sesi'] = $request->testu_sesi_nama[$i];
                            $sesi_insert['tanggal_sesi'] = $request->testu_sesi_tanggal[$i];
                            $sesi_insert['jam_sesi'] = $request->testu_sesi_jam[$i];
                            $sesi_insert['lokasi_sesi'] = $request->testu_sesi_lokasi[$i];
                            KursusSesi::create($sesi_insert);
                        }
                    }
                }
            }

            if ($request->has('has_tes_wawancara') && $request->has_tes_wawancara == 'on') {
                $cek_tes_wawancara = KursusJadwal::where('id_kursus', $course_id)->where('nama_jadwal', 'Tes Wawancara');

                if ($cek_tes_wawancara->count() < 1) {
                    $jadwal = KursusJadwal::create([
                        'id_kursus' => $course_id,
                        'nama_jadwal' => 'Tes Wawancara',
                        'jumlah_sesi_perhari' => $request->teswa_jumlah_sesi_perhari,
                        'durasi_persesi' => $request->teswa_durasi_per_sesi,
                        'jumlah_peserta_persesi' => $request->teswa_jumlah_peserta_persesi,
                        'tanggal_mulai' => $request->teswa_tanggal_mulai,
                        'jam_mulai' => $request->teswa_jam_mulai,
                    ]);
                    $id_jadwal = $jadwal->id;
                } else {
                    $id_jadwal = $cek_tes_wawancara->first()->id;
                }
                $sesi_insert = [];
                for ($i = 0; $i < count($request->teswa_sesi_tanggal); $i++) {
                    if (isset($request->teswa_sesi_id[$i]) && !empty($request->teswa_sesi_id[$i])) {
                        $id_sesi = $request->teswa_sesi_id[$i];
                        $sesi_update['id_kursus_jadwal'] = $id_jadwal;
                        $sesi_update['nama_sesi'] = $request->teswa_sesi_nama[$i];
                        $sesi_update['tanggal_sesi'] = $request->teswa_sesi_tanggal[$i];
                        $sesi_update['jam_sesi'] = $request->teswa_sesi_jam[$i];
                        $sesi_update['lokasi_sesi'] = $request->teswa_sesi_lokasi[$i];
                        KursusSesi::where('id', $id_sesi)->update($sesi_update);
                    } else {
                        if (!empty($request->teswa_sesi_nama[$i]) && !empty($request->teswa_sesi_tanggal[$i]) && !empty($request->teswa_sesi_jam[$i]) && !empty($request->teswa_sesi_lokasi[$i])) {
                            $sesi_insert['id_kursus_jadwal'] = $id_jadwal;
                            $sesi_insert['nama_sesi'] = $request->teswa_sesi_nama[$i];
                            $sesi_insert['tanggal_sesi'] = $request->teswa_sesi_tanggal[$i];
                            $sesi_insert['jam_sesi'] = $request->teswa_sesi_jam[$i];
                            $sesi_insert['lokasi_sesi'] = $request->teswa_sesi_lokasi[$i];
                            KursusSesi::create($sesi_insert);
                        }
                    }
                }
            }

            foreach ($request->logbook as $key => $name) {
                if (isset($request->logbook_id[$key]) && !empty($request->logbook_id[$key])) {
                    $logbook = new logbook();
                    $find = $logbook->where('id', $request->logbook_id[$key]);
                    $find->update(['name' => $name]);
                } else {
                    $logbook = new logbook();
                    $logbook->name = $name;
                    $logbook->course_id = $course_id;
                    $logbook->save();
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }

        notify()->success($request->title . ' updated successfully!');

        return redirect()->route('course.index');
    }

    //published
    public function published(Request $request)
    {

        if (env('DEMO') === "YES") {
            Alert::warning('warning', 'This is demo purpose only');
            return back();
        }

        $course = Course::where('id', $request->id)->first();
        if ($course->is_published == 1) {
            $course->is_published = 0;
            $course->save();
        } else {
            $course->is_published = 1;
            $course->save();
        }
        return response(['message' => translate('Course Published  Status is Change ')], 200);
    }



    //course rating
    public function rating(Request $request)
    {

        if (env('DEMO') === "YES") {
            Alert::warning('warning', 'This is demo purpose only');
            return back();
        }

        $course = Course::where('id', $request->id)->first();
        $course->rating = $request->rating;
        $course->save();
        return response(['message' => translate('Course Rating is Changed ')], 200);
    }
    //END
}
