<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AdditionalFunction;
use App\Models\Brand;
use App\Models\Certificate;
use App\Models\Document;
use App\Models\DocumentCategory;
use App\Models\Feedback;
use App\Models\Lang;
use App\Models\Member;
use App\Models\Partner;
use App\Models\PostsCategory;
use App\Models\ProductsCategory;
use App\Models\Question;
use App\Models\Service;
use App\Models\Translation;
use App\Models\Vacancy;
use App\Models\Work;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\SiteInfo;
use App\Models\Product;
use App\Models\Application;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;


class ApiController extends Controller
{
    public function get_banner()
    {
        // Foydalanuvchi tilini olish
        $locale = App::getLocale();

        // Postlarni oxirgi qo'shilganidan boshlab olish va 10 tadan paginate qilish
        $banners = Brand::latest()->paginate(500);

        // Agar postlar topilmasa, 404 xatolikni qaytaradi
        if ($banners->isEmpty()) {
            return response()->json([
                'message' => 'No records found'
            ], 404);
        }

        // Postlarni foydalanuvchi tiliga moslashtirish
        $translatedPosts = collect($banners->items())->map(function ($banner) use ($locale) {
            return [
                'id' => $banner->id,
                'title' => $banner->title[$locale] ?? null,
                'desc' => $banner->desc[$locale] ?? null,
                'url' => $banner->url ?? null,
                'video' => $banner->img,
                'images' => [
                    'lg' => $banner->lg_img, // Katta rasm uchun URL
                    'md' => $banner->md_img, // O‘rta rasm uchun URL
                    'sm' => $banner->sm_img, // Kichik rasm uchun URL
                ],
            ];
        });

        // Postlar va paginate ma'lumotlarini JSON formatida qaytarish
        return response()->json([
            'data' => $translatedPosts,             // Tilga mos postlar
            'total' => $banners->total(),             // Umumiy postlar soni
            'per_page' => $banners->perPage(),        // Har bir sahifadagi postlar soni
            'current_page' => $banners->currentPage(), // Hozirgi sahifa raqami
            'last_page' => $banners->lastPage(),      // Oxirgi sahifa raqami
            'next_page_url' => $banners->nextPageUrl(), // Keyingi sahifa URLi
            'prev_page_url' => $banners->previousPageUrl(), // Oldingi sahifa URLi
        ]);
    }
    public function get_faq()
    {
        // Foydalanuvchi tilini olish
        $locale = App::getLocale();

        // Postlarni oxirgi qo'shilganidan boshlab olish va 10 tadan paginate qilish
        $banners = Question::latest()->paginate(500);

        // Agar postlar topilmasa, 404 xatolikni qaytaradi
        if ($banners->isEmpty()) {
            return response()->json([
                'message' => 'No records found'
            ], 404);
        }

        // Postlarni foydalanuvchi tiliga moslashtirish
        $translatedPosts = collect($banners->items())->map(function ($banner) use ($locale) {
            return [
                'id' => $banner->id,
                'question' => $banner->question[$locale] ?? null,
                'answer' => $banner->answer[$locale] ?? null,
            ];
        });

        // Postlar va paginate ma'lumotlarini JSON formatida qaytarish
        return response()->json([
            'data' => $translatedPosts,             // Tilga mos postlar
            'total' => $banners->total(),             // Umumiy postlar soni
            'per_page' => $banners->perPage(),        // Har bir sahifadagi postlar soni
            'current_page' => $banners->currentPage(), // Hozirgi sahifa raqami
            'last_page' => $banners->lastPage(),      // Oxirgi sahifa raqami
            'next_page_url' => $banners->nextPageUrl(), // Keyingi sahifa URLi
            'prev_page_url' => $banners->previousPageUrl(), // Oldingi sahifa URLi
        ]);
    }
    public function feedbacks()
    {
        // Foydalanuvchi tilini olish
        $locale = App::getLocale();

        // Postlarni oxirgi qo'shilganidan boshlab olish va 10 tadan paginate qilish
        $banners = Feedback::where('position', 1)
            ->latest()
            ->paginate(500);

        // Agar postlar topilmasa, 404 xatolikni qaytaradi
        if ($banners->isEmpty()) {
            return response()->json([
                'message' => 'No records found'
            ], 404);
        }

        // Postlarni foydalanuvchi tiliga moslashtirish
        $translatedPosts = collect($banners->items())->map(function ($banner) use ($locale) {
            return [
                'id' => $banner->id,
                'name' => $banner->name[$locale] ?? null,
                'feedback' => $banner->feedback[$locale] ?? null,
                'images' => [
                    'lg' => $banner->lg_img,
                    'md' => $banner->md_img,
                    'sm' => $banner->sm_img,
                ],
            ];
        });

        // Postlar va paginate ma'lumotlarini JSON formatida qaytarish
        return response()->json([
            'data' => $translatedPosts,             // Tilga mos postlar
            'total' => $banners->total(),             // Umumiy postlar soni
            'per_page' => $banners->perPage(),        // Har bir sahifadagi postlar soni
            'current_page' => $banners->currentPage(), // Hozirgi sahifa raqami
            'last_page' => $banners->lastPage(),      // Oxirgi sahifa raqami
            'next_page_url' => $banners->nextPageUrl(), // Keyingi sahifa URLi
            'prev_page_url' => $banners->previousPageUrl(), // Oldingi sahifa URLi
        ]);
    }
    public function langs()
    {
        // Foydalanuvchi tilini olish
        $locale = App::getLocale();

        // Postlarni oxirgi qo'shilganidan boshlab olish va 10 tadan paginate qilish
        $banners = Lang::latest()->paginate(500);

        // Agar postlar topilmasa, 404 xatolikni qaytaradi
        if ($banners->isEmpty()) {
            return response()->json([
                'message' => 'No records found'
            ], 404);
        }

        // Postlarni foydalanuvchi tiliga moslashtirish
        $translatedPosts = collect($banners->items())->map(function ($banner) use ($locale) {
            return [
                'id' => $banner->id,
                'title' => $banner->title ?? null,
                'code' => $banner->code ?? null,
                'is_main' => $banner->is_main ?? null,
                'icon' => $banner->icon ? url('/upload/images/' . $banner->icon) : null, // Katta o'lchamdagi rasm
            ];
        });
        // Postlar va paginate ma'lumotlarini JSON formatida qaytarish
        return response()->json([
            'data' => $translatedPosts,             // Tilga mos postlar
            'total' => $banners->total(),             // Umumiy postlar soni
            'per_page' => $banners->perPage(),        // Har bir sahifadagi postlar soni
            'current_page' => $banners->currentPage(), // Hozirgi sahifa raqami
            'last_page' => $banners->lastPage(),      // Oxirgi sahifa raqami
            'next_page_url' => $banners->nextPageUrl(), // Keyingi sahifa URLi
            'prev_page_url' => $banners->previousPageUrl(), // Oldingi sahifa URLi
        ]);
    }

    public function translations()
    {
        // Foydalanuvchi tilini olish
        $locale = App::getLocale();

        // Tarjimalarni olish, har bir tarjimani uning guruhidan olish
        $banners = Translation::with('translationGroup')->latest()->get();

        // Agar tarjimalar topilmasa, 404 xatolikni qaytaradi
        if ($banners->isEmpty()) {
            return response()->json([
                'message' => 'No records found'
            ], 404);
        }

        // Tarjimalarni formatlash: key: value shaklida, group.sub_text.key formatida
        $translations = $banners->mapWithKeys(function ($banner) use ($locale) {
            return [
                $banner->translationGroup->sub_text . '.' . $banner->key => $banner->val[$locale] ?? null
            ];
        });

        // JSON formatida qaytarish
        return response()->json($translations);
    }

    public function get_partners()
    {
        // Foydalanuvchi tilini olish
        $locale = App::getLocale();

        // Postlarni oxirgi qo'shilganidan boshlab olish va 10 tadan paginate qilish
        $member = Partner::latest()->paginate(500);

        // Agar postlar topilmasa, 404 xatolikni qaytaradi
        if ($member->isEmpty()) {
            return response()->json([
                'message' => 'No records found'
            ], 404);
        }

        // Postlarni foydalanuvchi tiliga moslashtirish
        $translatedPosts = collect($member->items())->map(function ($banner) use ($locale) {
            return [
                'id' => $banner->id,
                'title' => $banner->title[$locale] ?? null,
                'desc' => $banner->desc[$locale] ?? null,

                'images' => [
                    'lg' => $banner->lg_img, // Katta rasm uchun URL
                    'md' => $banner->md_img, // O‘rta rasm uchun URL
                    'sm' => $banner->sm_img, // Kichik rasm uchun URL
                ],
                'link' => $banner->link ?? null,
            ];
        });

        // Postlar va paginate ma'lumotlarini JSON formatida qaytarish
        return response()->json([
            'data' => $translatedPosts,             // Tilga mos postlar
            'total' => $member->total(),             // Umumiy postlar soni
            'per_page' => $member->perPage(),        // Har bir sahifadagi postlar soni
            'current_page' => $member->currentPage(), // Hozirgi sahifa raqami
            'last_page' => $member->lastPage(),      // Oxirgi sahifa raqami
            'next_page_url' => $member->nextPageUrl(), // Keyingi sahifa URLi
            'prev_page_url' => $member->previousPageUrl(), // Oldingi sahifa URLi
        ]);
    }

    public function show_partners($id)
    {
        // Foydalanuvchi tilini olish
        $locale = App::getLocale();

        // Berilgan ID bo‘yicha a'zoni olish
        $member = Member::find($id);

        // Agar a'zo topilmasa, 404 xatolikni qaytaradi
        if (!$member) {
            return response()->json([
                'message' => 'Member not found'
            ], 404);
        }

        // A'zo ma'lumotlarini foydalanuvchi tiliga moslashtirish
        $translatedMember = [
            'id' => $member->id,
            'title' => $member->title[$locale] ?? null,
            'desc' => $member->desc[$locale] ?? null,

            'images' => [
                'lg' => $member->lg_img, // Katta rasm uchun URL
                'md' => $member->md_img, // O‘rta rasm uchun URL
                'sm' => $member->sm_img, // Kichik rasm uchun URL
            ],
            'link' => $member->link ?? null,
        ];

        // A'zo ma'lumotlarini JSON formatida qaytarish
        return response()->json($translatedMember);
    }
    public function get_file()
    {
        // Foydalanuvchi tilini olish
        $locale = App::getLocale();

        // Postlarni oxirgi qo'shilganidan boshlab olish va 10 tadan paginate qilish
        $member = Certificate::latest()->paginate(500);

        // Agar postlar topilmasa, 404 xatolikni qaytaradi
        if ($member->isEmpty()) {
            return response()->json([
                'message' => 'No records found'
            ], 404);
        }

        // Postlarni foydalanuvchi tiliga moslashtirish
        $translatedPosts = collect($member->items())->map(function ($banner) use ($locale) {
            return [
                'id' => $banner->id,
                'title' => $banner->title[$locale] ?? null,
                'url' => $banner->subtitle ?? null,
                'file' => $banner->img[$locale] ? url($banner->img[$locale]) : null,
            ];
        });

        // Postlar va paginate ma'lumotlarini JSON formatida qaytarish
        return response()->json([
            'data' => $translatedPosts,             // Tilga mos postlar
            'total' => $member->total(),             // Umumiy postlar soni
            'per_page' => $member->perPage(),        // Har bir sahifadagi postlar soni
            'current_page' => $member->currentPage(), // Hozirgi sahifa raqami
            'last_page' => $member->lastPage(),      // Oxirgi sahifa raqami
            'next_page_url' => $member->nextPageUrl(), // Keyingi sahifa URLi
            'prev_page_url' => $member->previousPageUrl(), // Oldingi sahifa URLi
        ]);
    }

    public function show_file($id)
    {
        // Foydalanuvchi tilini olish
        $locale = App::getLocale();

        // Berilgan ID bo‘yicha a'zoni olish
        $member = Certificate::find($id);

        // Agar a'zo topilmasa, 404 xatolikni qaytaradi
        if (!$member) {
            return response()->json([
                'message' => 'Member not found'
            ], 404);
        }

        // A'zo ma'lumotlarini foydalanuvchi tiliga moslashtirish
        $translatedMember = [
            'id' => $member->id,
            'title' => $member->title[$locale] ?? null,
            'url' => $banner->subtitle ?? null,
            'file' => $member->img ? url($member->img) : null,
        ];

        // A'zo ma'lumotlarini JSON formatida qaytarish
        return response()->json($translatedMember);
    }
    public function get_file2()
    {
        // Foydalanuvchi tilini olish
        $locale = App::getLocale();

        // Postlarni oxirgi qo'shilganidan boshlab olish va 10 tadan paginate qilish
        $member = Service::where('desc', 1)->latest()->paginate(500);

        // Agar postlar topilmasa, 404 xatolikni qaytaradi
        if ($member->isEmpty()) {
            return response()->json([
                'message' => 'No records found'
            ], 404);
        }

        // Postlarni foydalanuvchi tiliga moslashtirish
        $translatedPosts = collect($member->items())->map(function ($banner) use ($locale) {
            return [
                'id' => $banner->id,
                'title' => $banner->title[$locale] ?? null,
                'url' => $banner->subtitle ?? null,
                'file' => $banner->img[$locale] ?? null  ? url($banner->img[$locale]) : null ,
            ];
        });

        // Postlar va paginate ma'lumotlarini JSON formatida qaytarish
        return response()->json([
            'data' => $translatedPosts,             // Tilga mos postlar
            'total' => $member->total(),             // Umumiy postlar soni
            'per_page' => $member->perPage(),        // Har bir sahifadagi postlar soni
            'current_page' => $member->currentPage(), // Hozirgi sahifa raqami
            'last_page' => $member->lastPage(),      // Oxirgi sahifa raqami
            'next_page_url' => $member->nextPageUrl(), // Keyingi sahifa URLi
            'prev_page_url' => $member->previousPageUrl(), // Oldingi sahifa URLi
        ]);
    }
    public function get_file3()
    {
        // Foydalanuvchi tilini olish
        $locale = App::getLocale();

        // Postlarni oxirgi qo'shilganidan boshlab olish va 10 tadan paginate qilish
        $member = Service::where('desc', 2)->latest()->paginate(500);

        // Agar postlar topilmasa, 404 xatolikni qaytaradi
        if ($member->isEmpty()) {
            return response()->json([
                'message' => 'No records found'
            ], 404);
        }

        // Postlarni foydalanuvchi tiliga moslashtirish
        $translatedPosts = collect($member->items())->map(function ($banner) use ($locale) {
            return [
                'id' => $banner->id,
                'title' => $banner->title[$locale] ?? null,
                'url' => $banner->subtitle ?? null,
                'file' => $banner->img[$locale] ?? null  ? url($banner->img[$locale]) : null ,
            ];
        });

        // Postlar va paginate ma'lumotlarini JSON formatida qaytarish
        return response()->json([
            'data' => $translatedPosts,             // Tilga mos postlar
            'total' => $member->total(),             // Umumiy postlar soni
            'per_page' => $member->perPage(),        // Har bir sahifadagi postlar soni
            'current_page' => $member->currentPage(), // Hozirgi sahifa raqami
            'last_page' => $member->lastPage(),      // Oxirgi sahifa raqami
            'next_page_url' => $member->nextPageUrl(), // Keyingi sahifa URLi
            'prev_page_url' => $member->previousPageUrl(), // Oldingi sahifa URLi
        ]);
    }
    public function get_url()
    {
        // Foydalanuvchi tilini olish
        $locale = App::getLocale();

        // Postlarni oxirgi qo'shilganidan boshlab olish va 10 tadan paginate qilish
        $member = Question::latest()->paginate(500);

        // Agar postlar topilmasa, 404 xatolikni qaytaradi
        if ($member->isEmpty()) {
            return response()->json([
                'message' => 'No records found'
            ], 404);
        }

        // Postlarni foydalanuvchi tiliga moslashtirish
        $translatedPosts = collect($member->items())->map(function ($banner) use ($locale) {
            return [
                'id' => $banner->id,
                'title' => $banner->question[$locale] ?? null,
                'url' => $banner->answer ?? null ,
            ];
        });

        // Postlar va paginate ma'lumotlarini JSON formatida qaytarish
        return response()->json([
            'data' => $translatedPosts,             // Tilga mos postlar
            'total' => $member->total(),             // Umumiy postlar soni
            'per_page' => $member->perPage(),        // Har bir sahifadagi postlar soni
            'current_page' => $member->currentPage(), // Hozirgi sahifa raqami
            'last_page' => $member->lastPage(),      // Oxirgi sahifa raqami
            'next_page_url' => $member->nextPageUrl(), // Keyingi sahifa URLi
            'prev_page_url' => $member->previousPageUrl(), // Oldingi sahifa URLi
        ]);
    }

    public function show_file2($id)
    {
        // Foydalanuvchi tilini olish
        $locale = App::getLocale();

        // Berilgan ID bo‘yicha a'zoni olish
        $member = Service::find($id);

        // Agar a'zo topilmasa, 404 xatolikni qaytaradi
        if (!$member) {
            return response()->json([
                'message' => 'Member not found'
            ], 404);
        }

        // A'zo ma'lumotlarini foydalanuvchi tiliga moslashtirish
        $translatedMember = [
            'id' => $member->id,
            'title' => $member->title[$locale] ?? null,
            'url' => $banner->subtitle ?? null,
            'file' => $member->img ? url($member->img) : null,
        ];

        // A'zo ma'lumotlarini JSON formatida qaytarish
        return response()->json($translatedMember);
    }
    public function get_feedbacks()
    {
        // Foydalanuvchi tilini olish
        $locale = App::getLocale();

        // Postlarni oxirgi qo'shilganidan boshlab olish va 10 tadan paginate qilish
        $member = Feedback::latest()->paginate(500);

        // Agar postlar topilmasa, 404 xatolikni qaytaradi
        if ($member->isEmpty()) {
            return response()->json([
                'message' => 'No records found'
            ], 404);
        }

        // Postlarni foydalanuvchi tiliga moslashtirish
        $translatedPosts = collect($member->items())->map(function ($banner) use ($locale) {
            return [
                'id' => $banner->id,
                'name' => $banner->name[$locale] ?? null,
                'position' => $banner->position[$locale] ?? null,
                'feedback' => $banner->feedback[$locale] ?? null,

                'tender_fayli' => asset('storage/feedbacks/' . $banner->file),
                'pdf_file' => asset('storage/feedbacks/' . $banner->video),
                'doc_fayli' => asset('storage/feedbacks/' . $banner->logo),

                'images' => [
                    'lg' => $banner->lg_img, // Katta rasm uchun URL
                    'md' => $banner->md_img, // O‘rta rasm uchun URL
                    'sm' => $banner->sm_img, // Kichik rasm uchun URL
                ],

                'start_date' => $banner->youtube_link ?? null,
                'deadline' => $banner->link ?? null,

            ];
        });

        // Postlar va paginate ma'lumotlarini JSON formatida qaytarish
        return response()->json([
            'data' => $translatedPosts,             // Tilga mos postlar
            'total' => $member->total(),             // Umumiy postlar soni
            'per_page' => $member->perPage(),        // Har bir sahifadagi postlar soni
            'current_page' => $member->currentPage(), // Hozirgi sahifa raqami
            'last_page' => $member->lastPage(),      // Oxirgi sahifa raqami
            'next_page_url' => $member->nextPageUrl(), // Keyingi sahifa URLi
            'prev_page_url' => $member->previousPageUrl(), // Oldingi sahifa URLi
        ]);
    }

    public function show_feedbacks($id)
    {
        // Foydalanuvchi tilini olish
        $locale = App::getLocale();

        // Berilgan ID bo‘yicha a'zoni olish
        $member = Feedback::find($id);

        // Agar a'zo topilmasa, 404 xatolikni qaytaradi
        if (!$member) {
            return response()->json([
                'message' => 'Feedback not found'
            ], 404);
        }

        // A'zo ma'lumotlarini foydalanuvchi tiliga moslashtirish
        $translatedMember = [
            'id' => $member->id,
            'name' => $member->name[$locale] ?? null,
            'position' => $member->position[$locale] ?? null,
            'work_time' => $member->work_time[$locale] ?? null,
            'images' => [
                'lg' => $member->lg_img, // Katta rasm uchun URL
                'md' => $member->md_img, // O‘rta rasm uchun URL
                'sm' => $member->sm_img, // Kichik rasm uchun URL
            ],
            'phone_number' => $member->phone_number ?? null,
            'instagram_link' => $member->instagram_link ?? null,
            'telegram_link' => $member->telegram_link ?? null,
            'linkedin_link' => $member->linkedin_link ?? null,
            'facebook_link' => $member->facebook_link ?? null,
        ];

        // A'zo ma'lumotlarini JSON formatida qaytarish
        return response()->json($translatedMember);
    }
    public function get_vacancies()
    {
        // Foydalanuvchi tilini olish
        $locale = App::getLocale();

        // Postlarni oxirgi qo'shilganidan boshlab olish va 10 tadan paginate qilish
        $posts = Vacancy::latest()->paginate(500);

        // Agar postlar topilmasa, 404 xatolikni qaytaradi
        if ($posts->isEmpty()) {
            return response()->json([
                'message' => 'No records found'
            ], 404);
        }

        // Postlarni foydalanuvchi tiliga moslashtirish
        $translatedPosts = collect($posts->items())->map(function ($post) use ($locale) {
            return [
                'id' => $post->id,
//                'subtitle' => $post->subtitle[$locale] ?? null,
                'title' => $post->title[$locale] ?? null,
                'desc' => $post->desc[$locale] ?? null,
//                'time' => \Carbon\Carbon::parse($post->created_at)->format('H:i'),

                'images' => [
                    'lg' => $post->lg_img, // Katta rasm uchun URL
                    'md' => $post->md_img, // O‘rta rasm uchun URL
                    'sm' => $post->sm_img, // Kichik rasm uchun URL
                ],
                'date' => $post->date,
                'slug' => $post->slug,
                'views_count' => $post->views_count,
            ];
        });

        // Postlar va paginate ma'lumotlarini JSON formatida qaytarish
        return response()->json([
            'data' => $translatedPosts,             // Tilga mos postlar
            'total' => $posts->total(),             // Umumiy postlar soni
            'per_page' => $posts->perPage(),        // Har bir sahifadagi postlar soni
            'current_page' => $posts->currentPage(), // Hozirgi sahifa raqami
            'last_page' => $posts->lastPage(),      // Oxirgi sahifa raqami
            'next_page_url' => $posts->nextPageUrl(), // Keyingi sahifa URLi
            'prev_page_url' => $posts->previousPageUrl(), // Oldingi sahifa URLi
        ]);
    }


    public function show_vacancies($slug)
    {
        $locale = App::getLocale();

        // Slug orqali vacancy olish
        $vacancy = Vacancy::where('slug', $slug)->first();

        if (is_null($vacancy)) {
            return response()->json(['message' => 'Vacancy not found'], 404);
        }

        // Ko'rishlar sonini oshirish
        $vacancy->increment('views_count');

        // Oldingi vacancy (slug asosida emas, id bo‘yicha ketma-ketlikda)
        $previousVacancy = Vacancy::where('id', '<', $vacancy->id)->orderBy('id', 'desc')->first();

        // Keyingi vacancy
        $nextVacancy = Vacancy::where('id', '>', $vacancy->id)->orderBy('id', 'asc')->first();

        // Foydalanuvchi tiliga tarjima qilingan vacancy
        $translatedVacancy = [
            'id' => $vacancy->id,
            'title' => $vacancy->title[$locale] ?? null,
            'desc' => $vacancy->desc[$locale] ?? null,
            'images' => [
                'lg' => $vacancy->lg_img,
                'md' => $vacancy->md_img,
                'sm' => $vacancy->sm_img,
            ],
            'time' => \Carbon\Carbon::parse($vacancy->created_at)->format('H:i'),
            'date' => $vacancy->data,
            'views_count' => $vacancy->views_count,
            'meta_keywords' => $vacancy->meta_keywords,
            'previous' => $previousVacancy ? [
                'name' => $previousVacancy->title[$locale] ?? null,
                'slug' => $previousVacancy->slug,
            ] : null,
            'next' => $nextVacancy ? [
                'name' => $nextVacancy->title[$locale] ?? null,
                'slug' => $nextVacancy->slug,
            ] : null,
        ];

        return response()->json($translatedVacancy);
    }



    public function get_posts()
    {
        // Foydalanuvchi tilini olish
        $locale = App::getLocale();

        // Postlarni oxirgi qo'shilganidan boshlab olish va 10 tadan paginate qilish
        $posts = Post::latest()->with('postImages')->paginate(500);

        // Agar postlar topilmasa, 404 xatolikni qaytaradi
        if ($posts->isEmpty()) {
            return response()->json([
                'message' => 'No records found'
            ], 404);
        }

        // Postlarni foydalanuvchi tiliga moslashtirish
        $translatedPosts = collect($posts->items())->map(function ($post) use ($locale) {
            return [
                'id' => $post->id,
                'title' => $post->title[$locale] ?? null,
                'desc' => $post->desc[$locale] ?? null,

                'images' => $post->postImages->map(function ($image) {
                    return [
                        'lg' => $image->lg_img, // Katta o'lchamdagi rasm URL
                        'md' => $image->md_img, // O'rta o'lchamdagi rasm URL
                        'sm' => $image->sm_img, // Kichik o'lchamdagi rasm URL
                    ];
                })->toArray(),
                'date' => $post->date,
                'views_count' => $post->views_count,
                'slug' => $post->slug,
                'meta_keywords' => $post->meta_keywords,
            ];
        });

        // Postlar va paginate ma'lumotlarini JSON formatida qaytarish
        return response()->json([
            'data' => $translatedPosts,             // Tilga mos postlar
            'total' => $posts->total(),             // Umumiy postlar soni
            'per_page' => $posts->perPage(),        // Har bir sahifadagi postlar soni
            'current_page' => $posts->currentPage(), // Hozirgi sahifa raqami
            'last_page' => $posts->lastPage(),      // Oxirgi sahifa raqami
            'next_page_url' => $posts->nextPageUrl(), // Keyingi sahifa URLi
            'prev_page_url' => $posts->previousPageUrl(), // Oldingi sahifa URLi
        ]);
    }

    public function show_post($slug)
    {
        // Foydalanuvchi tilini olish
        $locale = App::getLocale();

        // Slug orqali postni olish
        $post = Post::where('slug', $slug)->first();

        if (is_null($post)) {
            return response()->json(['message' => 'Post not found or URL is not null'], 404);
        }

        // Oldingi postni olish (ID qiymati hozirgi postdan kichik bo'lgan eng oxirgi post)
        $previousPost = Post::where('id', '<', $post->id)->orderBy('id', 'desc')->first();

        // Keyingi postni olish (ID qiymati hozirgi postdan katta bo'lgan eng birinchi post)
        $nextPost = Post::where('id', '>', $post->id)->orderBy('id', 'asc')->first();

        // Postni foydalanuvchi tiliga moslashtirish
        $translatedPost = [
            'id' => $post->id,
            'title' => $post->title[$locale] ?? null,
            'desc' => $post->desc[$locale] ?? null,
            'images' => $post->postImages->map(function ($image) {
                return [
                    'lg' => $image->lg_img, // Katta o'lchamdagi rasm URL
                    'md' => $image->md_img, // O'rta o'lchamdagi rasm URL
                    'sm' => $image->sm_img, // Kichik o'lchamdagi rasm URL
                ];
            })->toArray(),
            'slug' => $post->slug,
            'date' => $post->date,
            'views_count' => $post->views_count,
            'meta_keywords' => $post->meta_keywords,
            // Oldingi post
            'previous' => $previousPost ? [
                'name' => $previousPost->title[$locale] ?? null,
                'slug' => $previousPost->slug,
            ] : null,
            // Keyingi post
            'next' => $nextPost ? [
                'name' => $nextPost->title[$locale] ?? null,
                'slug' => $nextPost->slug,
            ] : null,
        ];

        return response()->json($translatedPost);
    }


    public function get_catalogs()
    {
        // Foydalanuvchi tilini olish
        $locale = App::getLocale();

        // Postlarni oxirgi qo'shilganidan boshlab olish va 10 tadan paginate qilish
        $certificate = Work::latest()->paginate(500);

        // Agar postlar topilmasa, 404 xatolikni qaytaradi
        if ($certificate->isEmpty()) {
            return response()->json([
                'message' => 'No records found'
            ], 404);
        }

        // Postlarni foydalanuvchi tiliga moslashtirish
        $translatedPosts = collect($certificate->items())->map(function ($certificate) use ($locale) {
            return [
                'id' => $certificate->id,
                'title' => $certificate->title[$locale] ?? null, // Mahsulotning nomi (locale bo'yicha)
                'desc' => $certificate->desc[$locale] ?? null, // Mahsulotning ta'rifi (locale bo'yicha)

                // Rasmning to'liq URL manzili, turli o'lchamlar uchun
                'images' => $certificate->workImages->map(function ($image) {
                    return [
                        'lg' => $image->lg_img, // Katta o'lchamdagi rasm URL
                        'md' => $image->md_img, // O'rta o'lchamdagi rasm URL
                        'sm' => $image->sm_img, // Kichik o'lchamdagi rasm URL
                    ];
                })->toArray(),
                'youtube_link' => $certificate->youtube_link,

            ];
        });


        // Postlar va paginate ma'lumotlarini JSON formatida qaytarish
        return response()->json([
            'data' => $translatedPosts,             // Tilga mos postlar
            'total' => $certificate->total(),             // Umumiy postlar soni
            'per_page' => $certificate->perPage(),        // Har bir sahifadagi postlar soni
            'current_page' => $certificate->currentPage(), // Hozirgi sahifa raqami
            'last_page' => $certificate->lastPage(),      // Oxirgi sahifa raqami
            'next_page_url' => $certificate->nextPageUrl(), // Keyingi sahifa URLi
            'prev_page_url' => $certificate->previousPageUrl(), // Oldingi sahifa URLi
        ]);
    }

    public function show_catalogs($slug)
    { // Foydalanuvchi tilini olish
        $locale = App::getLocale();

        // Slug orqali postni olish
        $certificate = Service::where('slug', $slug)->first();

        if (is_null($certificate)) {
            return response()->json(['message' => 'Post not found or URL is not null'], 404);
        }

        // Postni foydalanuvchi tiliga moslashtirish
        $translatedPost = [
            'id' => $certificate->id,
            'title' => $certificate->title[$locale] ?? null, // Mahsulotning nomi (locale bo'yicha)
            'desc' => $certificate->desc[$locale] ?? null, // Mahsulotning ta'rifi (locale bo'yicha)

            // Rasmning to'liq URL manzili, turli o'lchamlar uchun
            'images' => $certificate->workImages->map(function ($image) {
                return [
                    'lg' => $image->lg_img, // Katta o'lchamdagi rasm URL
                    'md' => $image->md_img, // O'rta o'lchamdagi rasm URL
                    'sm' => $image->sm_img, // Kichik o'lchamdagi rasm URL
                ];
            })->toArray(),
            'youtube_link' => $certificate->youtube_link,
        ];

        return response()->json($translatedPost);
    }

    // start categories
    public function get_categories()
    {
        $locale = App::getLocale();

        // Asosiy kategoriyalarni olish (faqat parent_id = null bo'lganlar)
        $categories = PostsCategory::whereNull('parent_id')->with('children')->latest()->paginate(500);

        if ($categories->isEmpty()) {
            return response()->json([
                'message' => 'No records found'
            ], 404);
        }

        // Rekursiv funksiya: barcha `children` larni chuqurlik bilan olish
        $mapCategory = function ($category) use ($locale, &$mapCategory) {
            return [
                'id' => $category->id,
                'title' => $category->title[$locale] ?? null,
                'desc' => $category->desc[$locale] ?? null,
                'images' => [
                    'lg' => $category->lg_img,
                    'md' => $category->md_img,
                    'sm' => $category->sm_img,
                ],
                'in_main' => $category->in_main,
                'view' => $category->view,
                'slug' => $category->slug,
                'children' => $category->children->map(fn($child) => $mapCategory($child)), // Rekursiv chaqirish
            ];
        };

        // Asosiy kategoriyalarni map qilish
        $translatedPosts = collect($categories->items())->map(fn($category) => $mapCategory($category));

        return response()->json([
            'data' => $translatedPosts,              // Tilga mos kategoriyalar
            'total' => $categories->total(),        // Umumiy kategoriyalar soni
            'per_page' => $categories->perPage(),   // Har bir sahifadagi kategoriyalar soni
            'current_page' => $categories->currentPage(), // Hozirgi sahifa raqami
            'last_page' => $categories->lastPage(), // Oxirgi sahifa raqami
            'next_page_url' => $categories->nextPageUrl(), // Keyingi sahifa URLi
            'prev_page_url' => $categories->previousPageUrl(), // Oldingi sahifa URLi
        ]);
    }

    public function show_categories($slug)
    {
        // Foydalanuvchi tilini olish
        $locale = App::getLocale();

        // Kategoriyani ID orqali topish
        $category = PostsCategory::with('children')->where('slug', $slug)->first();

        // Agar kategoriya topilmasa, xato xabarini qaytarish
        if (is_null($category)) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        // Kategoriya ma'lumotlarini foydalanuvchi tiliga moslashtirish
        $translatedCategory = [
            'id' => $category->id,
            'title' => $category->title[$locale] ?? null, // Foydalanuvchi tiliga mos sarlavha
            'desc' => $category->desc[$locale] ?? null,   // Foydalanuvchi tiliga mos tavsif
            'children' => $category->children->map(function ($child) use ($locale) {
                return [
                    'id' => $child->id,
                    'title' => $child->title[$locale] ?? null,
                    'desc' => $child->desc[$locale] ?? null,
                    'first' => $child->first[$locale] ?? null,
                    'second' => $child->second[$locale] ?? null,
                    'third' => $child->third[$locale] ?? null,
                    'images' => [
                        'lg' => $child->lg_img, // Katta rasm URL
                        'md' => $child->md_img, // O'rta rasm URL
                        'sm' => $child->sm_img, // Kichik rasm URL
                    ],
                ];
            }),
            'images' => [
                'lg' => $category->lg_img, // Katta rasm URL
                'md' => $category->md_img, // O'rta rasm URL
                'sm' => $category->sm_img, // Kichik rasm URL
            ],
            'in_main' => $category->in_main,
            'view' => $category->view,
            'slug' => $category->slug,

        ];

        // Ma'lumotlarni JSON formatida qaytarish
        return response()->json($translatedCategory);
    }

    public function show_categor_product($slug)
    {
        // Foydalanuvchi tilini olish
        $locale = App::getLocale();

        // Kategoriyani slug orqali topish
        $category = PostsCategory::with(['children', 'posts.postImages'])
            ->where('slug', $slug)
            ->first();

        // Agar kategoriya topilmasa, xato xabarini qaytarish
        if (is_null($category)) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        // Mahsulotlarni 12 ta qilib paginate qilish
        $paginatedProducts = $category->posts()->with('postImages')->paginate(500);

        // Kategoriya ma'lumotlarini foydalanuvchi tiliga moslashtirish
        $translatedCategory = [
            'id' => $category->id,
            'title' => $category->title[$locale] ?? null,
            'desc' => $category->desc[$locale] ?? null,

            'info' => $category->info[$locale] ?? $category->info,
            'slug' => $category->slug,
            'children' => $category->children->map(function ($child) use ($locale) {
                return [
                    'id' => $child->id,
                    'title' => $child->title[$locale] ?? null,
                    'desc' => $child->desc[$locale] ?? null,

                    'slug' => $child->slug,
                    'images' => [
                        'lg' => $child->lg_img,
                        'md' => $child->md_img,
                        'sm' => $child->sm_img,
                    ],
                ];
            }),
            'images' => [
                'lg' => $category->lg_img,
                'md' => $category->md_img,
                'sm' => $category->sm_img,
            ],
            'in_main' => $category->in_main,
            'view' => $category->view,
            'posts' => [
                'data' => $paginatedProducts->map(function ($product) use ($locale) {
                    return [
                        'id' => $product->id,
                        'title' => $product->title[$locale] ?? $product->title[$this->main_lang->code],
                        'description' => $product->desc[$locale] ?? $product->desc[$this->main_lang->code],
                        'date' => $product->date ?? null,
                        'slug' => $product->slug,
                        'images' => $product->postImages->map(function ($image) {
                            return [
                                'lg' => $image->lg_img,
                                'md' => $image->md_img,
                                'sm' => $image->sm_img,
                            ];
                        }),
//                        'meta_keywords' => $product->meta_keywords[$locale] ?? $product->meta_keywords,
//                        'meta_desc' => $product->meta_desc[$locale] ?? $product->meta_desc,
//                        'stock' => $product->stock,
                    ];
                }),
                'pagination' => [
                    'current_page' => $paginatedProducts->currentPage(),
                    'last_page' => $paginatedProducts->lastPage(),
                    'per_page' => $paginatedProducts->perPage(),
                    'total' => $paginatedProducts->total(),
                ]
            ]
        ];

        // Ma'lumotlarni JSON formatida qaytarish
        return response()->json($translatedCategory);
    }


    public function get_tours(Request $request)
    {
        $locale = App::getLocale();

        $query = Product::query();

        // status bo‘yicha filter
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // info bo‘yicha filter (masalan 1 bo‘lsa)
        if ($request->has('info')) {
            $query->where('info', $request->info);
        }

        // narx sortlash
        if ($request->has('price_sort')) {
            if ($request->price_sort === 'asc') {
                $query->orderBy('price', 'asc'); // pastdan tepaga
            } elseif ($request->price_sort === 'desc') {
                $query->orderBy('price', 'desc'); // tepadan pastga
            }
        } else {
            $query->latest(); // default
        }

        $categories = $query->paginate(500);

        if ($categories->isEmpty()) {
            return response()->json([
                'message' => 'No records found'
            ], 404);
        }

        $mapCategory = function ($category) use ($locale) {
            return [
                'id' => $category->id,
                'title' => $category->title[$locale] ?? null,
                'desc' => $category->desc[$locale] ?? null,
                'info' => $category->info ?? null,
                'date' => $category->date[$locale] ?? null,
                'groupsize' => $category->groupsize[$locale] ?? null,
                'language' => $category->language[$locale] ?? null,
                'meta_keywords' => $category->meta_keywords[$locale] ?? null,
                'meta_desc' => $category->meta_desc[$locale] ?? null,
                'views_count' => $category->views_count,
                'price' => $category->price,
                'status' => $category->status,
                'map' => $category->map,
                'slug' => $category->slug,
                'images' => $category->productImages->map(function ($image) {
                    return [
                        'lg' => $image->lg_img ?? null,
                        'md' => $image->md_img ?? null,
                        'sm' => $image->sm_img ?? null,
                    ];
                }),
            ];
        };

        $translatedPosts = collect($categories->items())->map(fn($category) => $mapCategory($category));

        return response()->json([
            'data' => $translatedPosts,
            'total' => $categories->total(),
            'per_page' => $categories->perPage(),
            'current_page' => $categories->currentPage(),
            'last_page' => $categories->lastPage(),
            'next_page_url' => $categories->nextPageUrl(),
            'prev_page_url' => $categories->previousPageUrl(),
        ]);
    }


//    public function show_tour($slug)
//    {
//        $locale = App::getLocale();
//
//        $category = Product::where('slug', $slug)->first();
//
//        if (!$category) {
//            return response()->json([
//                'message' => 'No records found'
//            ], 404);
//        }
//
//        $mapCategory = function ($category) use ($locale) {
//            return [
//                'id' => $category->id,
//                'title' => $category->title[$locale] ?? null,
//                'desc' => $category->desc[$locale] ?? null,
//                'info' => $category->info[$locale] ?? null, // locale bo‘yicha
//                'date' => $category->date[$locale] ?? null,
//                'groupsize' => $category->groupsize[$locale] ?? null,
//                'language' => $category->language[$locale] ?? null,
//                'meta_keywords' => $category->meta_keywords[$locale] ?? null,
//                'meta_desc' => $category->meta_desc[$locale] ?? null,
//                'views_count' => $category->views_count,
//                'price' => $category->price,
//                'status' => $category->status,
//                'map' => $category->map,
//                'slug' => $category->slug,
//                'images' => $category->productImages->map(function ($image) {
//                    return [
//                        'lg' => $image->lg_img ?? null,
//                        'md' => $image->md_img ?? null,
//                        'sm' => $image->sm_img ?? null,
//                    ];
//                }),
//            ];
//        };
//
//        return response()->json([
//            'data' => $mapCategory($category)
//        ]);
//    }

    public function show_tour($slug)
    {
        $locale = App::getLocale();

        $category = Product::where('slug', $slug)
            ->with('feedbacks') // feedbacklarni ham birga olib kelamiz
            ->first();

        if (!$category) {
            return response()->json([
                'message' => 'No records found'
            ], 404);
        }

        $mapCategory = function ($category) use ($locale) {
            return [
                'id' => $category->id,
                'title' => $category->title[$locale] ?? null,
                'desc' => $category->desc[$locale] ?? null,
                'info' => $category->info[$locale] ?? null,
                'date' => $category->date[$locale] ?? null,
                'groupsize' => $category->groupsize[$locale] ?? null,
                'language' => $category->language[$locale] ?? null,
                'meta_keywords' => $category->meta_keywords[$locale] ?? null,
                'meta_desc' => $category->meta_desc[$locale] ?? null,
                'views_count' => $category->views_count,
                'price' => $category->price,
                'status' => $category->status,
                'map' => $category->map,
                'slug' => $category->slug,
                'images' => $category->productImages->map(function ($image) {
                    return [
                        'lg' => $image->lg_img ?? null,
                        'md' => $image->md_img ?? null,
                        'sm' => $image->sm_img ?? null,
                    ];
                }),
                // 🔽 Feedbacklarni qo‘shamiz
                'feedbacks' => $category->feedbacks->map(function ($fb) use ($locale) {
                    return [
                        'id' => $fb->id,
                        'name' => $fb->name[$locale] ?? null,
                        'feedback' => $fb->feedback[$locale] ?? null,
                        'images' => [
                            'lg' => $fb->lg_img,
                            'md' => $fb->md_img,
                            'sm' => $fb->sm_img,
                            ]
                    ];
                }),
            ];
        };
        return response()->json([
            'data' => $mapCategory($category)
        ]);
    }


    public function show_documents($slug)
{
    // Foydalanuvchi tilini olish
    $locale = App::getLocale();

    // Kategoriyani ID orqali topish
    $category = DocumentCategory::with('children')->where('slug', $slug)->first();

    // Agar kategoriya topilmasa, xato xabarini qaytarish
    if (is_null($category)) {
        return response()->json(['message' => 'Documents not found'], 404);
    }

    // Kategoriya ma'lumotlarini foydalanuvchi tiliga moslashtirish
    $translatedCategory = [
        'id' => $category->id,
        'title' => $category->title[$locale] ?? null, // Foydalanuvchi tiliga mos sarlavha
        'desc' => $category->desc[$locale] ?? null,   // Foydalanuvchi tiliga mos tavsif
        'children' => $category->children->map(function ($child) use ($locale) {
            return [
                'id' => $child->id,
                'title' => $child->title[$locale] ?? null,
                'desc' => $child->desc[$locale] ?? null,
                'first' => $child->first[$locale] ?? null,
                'second' => $child->second[$locale] ?? null,
                'third' => $child->third[$locale] ?? null,
            ];
        }),
        'in_main' => $category->in_main,
        'view' => $category->view,
        'slug' => $category->slug,
    ];

    // Ma'lumotlarni JSON formatida qaytarish
    return response()->json($translatedCategory);
}
    public function show_document($slug)
    {
        // Foydalanuvchi tilini olish
        $locale = App::getLocale();

        // Kategoriyani ID orqali topish
        $category = Document::where('slug', $slug)->first();

        // Agar kategoriya topilmasa, xato xabarini qaytarish
        if (is_null($category)) {
            return response()->json(['message' => 'Documents not found'], 404);
        }

        // Kategoriya ma'lumotlarini foydalanuvchi tiliga moslashtirish
        $translatedCategory = [
            'id' => $category->id,
            'title' => $category->title[$locale] ?? $category->title[$this->main_lang->code],
            'description' => $category->desc[$locale] ?? $category->desc[$this->main_lang->code],
            'date' => $category->date ?? null,
            'images' => [
                'lg' => $category->lg_img,
                'md' => $category->md_img,
                'sm' => $category->sm_img,
            ],
            'slug' => $category->slug,
            'link' => $category->link,
        ];

        // Ma'lumotlarni JSON formatida qaytarish
        return response()->json($translatedCategory);
    }

    public function show_category_documents($slug)
    {
        // Foydalanuvchi tilini olish
        $locale = App::getLocale();

        // Kategoriyani slug orqali topish
        $category = DocumentCategory::with(['children'])
            ->where('slug', $slug)
            ->first();

        // Agar kategoriya topilmasa, xato xabarini qaytarish
        if (is_null($category)) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        // Mahsulotlarni 12 ta qilib paginate qilish
        $paginatedProducts = $category->documents()->paginate(500);

        // Kategoriya ma'lumotlarini foydalanuvchi tiliga moslashtirish
        $translatedCategory = [
            'id' => $category->id,
            'title' => $category->title[$locale] ?? null,
            'desc' => $category->desc[$locale] ?? null,

            'info' => $category->info[$locale] ?? $category->info,
            'slug' => $category->slug,
            'children' => $category->children->map(function ($child) use ($locale) {
                return [
                    'id' => $child->id,
                    'title' => $child->title[$locale] ?? null,
                    'desc' => $child->desc[$locale] ?? null,

                    'slug' => $child->slug,
                    'images' => [
                        'lg' => $child->lg_img,
                        'md' => $child->md_img,
                        'sm' => $child->sm_img,
                    ],
                ];
            }),
            'images' => [
                'lg' => $category->lg_img,
                'md' => $category->md_img,
                'sm' => $category->sm_img,
            ],
            'in_main' => $category->in_main,
            'view' => $category->view,
            'documents' => [
                'data' => $paginatedProducts->map(function ($product) use ($locale) {
                    return [
                        'id' => $product->id,
                        'title' => $product->title[$locale] ?? $product->title,
                        'description' => $product->desc[$locale] ?? $product->desc,
                        'date' => $product->date ?? null,
                        'images' => [
                            'lg' => $product->lg_img,
                            'md' => $product->md_img,
                            'sm' => $product->sm_img,
                        ],
                        'slug' => $product->slug,
                        'link' => $product->link,

                    ];
                }),
                'pagination' => [
                    'current_page' => $paginatedProducts->currentPage(),
                    'last_page' => $paginatedProducts->lastPage(),
                    'per_page' => $paginatedProducts->perPage(),
                    'total' => $paginatedProducts->total(),
                ]
            ]
        ];

        // Ma'lumotlarni JSON formatida qaytarish
        return response()->json($translatedCategory);
    }


    //end categories



    public function getCompany()
    {
        // Hozirgi foydalanuvchi tilini olish
        $locale = App::getLocale();

        // SiteInfo ma'lumotlarini olish (oxirgi kiritilgan)
        $site_info = SiteInfo::latest()->first();

        if (!$site_info) {
            return response()->json(['message' => 'Site information not found'], 404);
        }

        // Foydalanuvchi tiliga moslashtirilgan ma'lumotlar
        $translatedSiteInfo = [
            'id' => $site_info->id,
            'title' => $site_info->title[$locale] ?? $site_info->title,  // Foydalanuvchi tiliga mos nom
            'logo' => $site_info->logo,  // Logo
            'logo_dark' => $site_info->logo_dark,  // Qorong'u logo
            'desc' => $site_info->desc[$locale] ?? $site_info->desc,  // Tavsif
            'address' => $site_info->address[$locale] ?? $site_info->address,  // Manzil
            'phone_number' => $site_info->phone_number,  // Telefon raqami
            'email' => $site_info->email,  // Elektron pochta
            'work_time' => $site_info->work_time[$locale] ?? $site_info->work_time ?? null, // Ish vaqti
            'map' => $site_info->map,  // Xarita
            'exchange' => $site_info->exchange,  // Kurs o'zgarishlari
            'favicon' => $site_info->favicon,  // Favicon
            'telegram' => $site_info->telegram,  // Telegram
            'instagram' => $site_info->instagram,  // Instagram
            'facebook' => $site_info->facebook,  // Facebook
            'youtube' => $site_info->youtube,  // YouTube
        ];

        // JSON formatida natijalarni qaytarish
        return response()->json([
            'data' => $translatedSiteInfo,  // Foydalanuvchi tiliga mos kompaniya ma'lumotlari
        ]);
    }
    public function settings()
    {
        // Hozirgi foydalanuvchi tilini olish
        $locale = App::getLocale();

        // SiteInfo ma'lumotlarini olish (oxirgi kiritilgan)
        $site_info = AdditionalFunction::latest()->first();

        if (!$site_info) {
            return response()->json(['message' => 'Site information not found'], 404);
        }

        // Foydalanuvchi tiliga moslashtirilgan ma'lumotlar
        $translatedSiteInfo = [
            'id' => $site_info->id,
            'telegram_bot_token' => $site_info->telegram_bot_token,  // Logo
            'telegram_group_id' => $site_info->telegram_group_id,  // Logo
            'livechat' => $site_info->livechat,  // Logo
            'yandex_index' => $site_info->yandex_index,  // Logo
            'google_index' => $site_info->google_index,  // Logo
            'yandex_metrika' => $site_info->yandex_metrika,  // Logo
            'google_analytics' => $site_info->google_analytics,  // Logo
            'yandex_metrika' => $site_info->sitemap,  // Logo

        ];

        // JSON formatida natijalarni qaytarish
        return response()->json([
            'data' => $translatedSiteInfo,  // Foydalanuvchi tiliga mos kompaniya ma'lumotlari
        ]);
    }
//    public function store(Request $request)
//    {
//        // Requestdagi ma'lumotlarni tekshirish (validatsiya)
//        $request->validate([
//            'name' => 'required|string|max:255',
//            'phone_number' => 'nullable|string|max:20',
//            'message' => 'required|string',
//            'product_id' => 'nullable|exists:products,id', // product_id mavjud bo'lsa tekshiradi
//        ]);
//
//        // Ma'lumotni saqlash
//        $contact = Application::create([
//            'name' => $request->name,
//            'phone_number' => $request->phone_number,
//            'message' => $request->message,
//            'product_id' => $request->product_id ?? null, // Agar product_id berilmasa null bo'ladi
//        ]);
//
//        // Yangi Application ma'lumotlarini qaytarish
//        return response()->json([
//            'message' => 'Contact information saved successfully.',
//            'data' => $contact,
//        ], 201);
//    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:500',
            'phone_number' => 'nullable|string|max:1000',
            'message' => 'nullable|string|max:1000',
            'product_id' => 'nullable|integer|exists:products,id',
            'company' => 'nullable|string|max:1000',
        ]);

        // `page` ustuniga 0 qiymatini qo'shish
        $application = Application::create($validated + ['page' => 0]);

        // product nomini olish
        $productName = null;
        if ($application->product_id) {
            $product = Product::find($application->product_id);
            $productName = $product ? ($product->title['uz'] ?? $product->title['en'] ?? $product->title) : null;
        }

        // Telegramga xabar yuborish
        $token = "8093233167:AAFVnnvGEfDSZNNI-fcLumNFm0MFo1OtyBY"; // bot tokeningiz
        $chatId = "-1003044483683"; // kanal username yoki chat_id

        $text = "📩 Yangi ariza keldi!\n\n"
            . "👤 Ism: {$application->name}\n"
            . "📧 Email: {$application->email}\n"
            . "📱 Telefon: {$application->phone_number}\n"
            . "📦 Tur: " . ($productName ?? '-') . "\n"
            . "✉️ Xabar: {$application->message}";

        try {
            Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'HTML'
            ]);
        } catch (\Exception $e) {
            \Log::error('Telegramga yuborishda xatolik: '.$e->getMessage());
        }

        return response()->json(['success' => 'Message saved and sent to Telegram successfully']);
    }


}
