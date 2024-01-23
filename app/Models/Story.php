<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Orchid\Attachment\Attachable;
use Orchid\Screen\AsSource;


class Story extends Model
{
    use HasFactory, AsSource, Attachable;
    protected $fillable = [
        'title',
        'urlVideo',
        'description',
        'descriptionOn',
        'order'
    ];
    public function getUrl()
    {
        return URL::route('story.show', ['id' => $this->id]);
    }

}
