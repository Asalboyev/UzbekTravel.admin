<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;

use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use App\Models\Lang;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public $title = 'Услуги';
    public $route_name = 'services';
    public $route_parameter = 'service';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services = Service::latest()
            ->paginate(12);
        $languages = Lang::all();

        return view('app.services.index', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'services' => $services,
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
        $all_categories = Service::all();

        return view('app.services.create', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'langs' => $langs,
            'all_categories' => $all_categories
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

        $validator = Validator::make($data, [
            'title.'.$this->main_lang->code => 'required'
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }
        $data['slug'] = Str::slug($data['title'][$this->main_lang->code], '-');
        if(Service::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $data['slug'].'-'.time();
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

        Service::create($data);

        return redirect()->route('services.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        $langs = Lang::all();
        $all_categories = Service::all()->except($service->id);

        return view('app.services.edit', [
            'title' => $this->title,
            'route_name' => $this->route_name,
            'route_parameter' => $this->route_parameter,
            'langs' => $langs,
            'service' => $service,
            'all_categories' => $all_categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'title.'.$this->main_lang->code => 'required'
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with([
                'success' => false,
                'message' => 'Ошибка валидации'
            ]);
        }
        $data['slug'] = Str::slug($data['title'][$this->main_lang->code], '-');
        if(Service::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $data['slug'].'-'.time();
        }

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

        $service->update($data);

        return redirect()->route('services.index')->with([
            'success' => true,
            'message' => 'Успешно сохранен'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        if(isset($service->children[0])) {
            return back()->with([
                'success' => false,
                'message' => 'Есть дочерние категории. Сначала нужно удалить их.'
            ]);
        }
        $service->delete();

        return back()->with([
            'success' => true,
            'message' => 'Успешно удален'
        ]);
    }
}
