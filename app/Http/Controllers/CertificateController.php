<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\Lang;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    public $title = 'Сертификаты';
    public $route_name = 'certificates';
    public $route_parameter = 'certificate';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $certificates = Certificate::latest()
            ->paginate(12);
        $languages = Lang::all();

        return view('app.certificates.index', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'certificates' => $certificates,
            'languages' => $languages
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $langs = Lang::all();

        return view('app.certificates.create', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'langs' => $langs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        // 🔐 Validatsiya
        $validator = Validator::make($data, [
            'title.' . $this->main_lang->code => 'required',
            // boshqa validatsiyalar
        ]);

        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }

        // 📂 Fayllarni til bo‘yicha arrayga saqlash
        if ($request->hasFile('file')) {
            $files = $request->file('file');
            $data['img'] = [];

            foreach ($files as $lang => $file) {
                if ($file instanceof \Illuminate\Http\UploadedFile) {
                    $path = $file->store("certificates/$lang", 'public');
                    $data['img'][$lang] = $path;
                }
            }
        }

        // ❌ json_encode QILMAYMIZ!
        // Laravel model casts orqali avtomatik array qilib o'qiydi va yozadi

        Certificate::create($data);

        return redirect()->route('certificates.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function show(Certificate $certificate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function edit(Certificate $certificate)
    {
        $langs = Lang::all();

        return view('app.certificates.edit', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'langs' => $langs,
            'certificate' => $certificate
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Certificate $certificate)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'title.' . $this->main_lang->code => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }

        // Eski img arrayni olib qo'yamiz
        $existingImgs = $certificate->img ?? [];

        // Fayllar mavjud bo‘lsa
        if ($request->hasFile('file')) {
            $files = $request->file('file');

            foreach ($files as $lang => $file) {
                if ($file instanceof \Illuminate\Http\UploadedFile) {
                    // Eski faylni o‘chirish
                    if (!empty($existingImgs[$lang]) && Storage::disk('public')->exists($existingImgs[$lang])) {
                        Storage::disk('public')->delete($existingImgs[$lang]);
                    }

                    // Yangi faylni saqlash
                    $path = $file->store("certificates/$lang", 'public');
                    $existingImgs[$lang] = $path;
                }
            }
        }

        // img ni array shaklida yangilaymiz
        $data['img'] = $existingImgs;

        // title va desc ham array bo‘lishi kerak
        // E'tibor bering: json_encode QILMAYMIZ, chunki modelda `cast` bilan array deb ko‘rsatilgan

        $certificate->update($data);

        return redirect()->route('certificates.index')->with([
            'success' => true,
            'message' => 'Успешно обновлено'
        ]);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Certificate  $certificate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Certificate $certificate)
    {
        $certificate->delete();

        return back()->with([
            'success' => true,
            'message' => 'Успешно удален'
        ]);
    }
}
