<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'file',
        'link',
        'category_id',
        'date',
        'desc',
        'slug'
    ];

    protected $casts = [
        'title' => 'array',
        'desc' => 'array'
    ];

    public function document_category()
    {
        return $this->belongsTo(DocumentCategory::class);
    }
    protected $appends = [
        'lg_img',
        'md_img',
        'sm_img'
    ];

    public function getLgImgAttribute() {
        return $this->file ? url('').'/upload/images/'.$this->file : null;
    }

    public function getMdImgAttribute() {
        return $this->file ? url('').'/upload/images/600/'.$this->file : null;
    }

    public function getSmImgAttribute() {
        return $this->file ? url('').'/upload/images/200/'.$this->file : null;
    }
}
