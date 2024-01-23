<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Orchid\Attachment\Attachable;
use Orchid\Screen\AsSource;




class Banner extends Model
{
    use HasFactory,AsSource, Attachable;
    protected $fillable = [
        'title',
        'speed',
        'select'
    ];

    public function getUrl()
    {
        return URL::route('banner.show', ['id' => $this->id]);
    }

}
