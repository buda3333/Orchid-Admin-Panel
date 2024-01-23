<?php

namespace App\Services;

use App\Models\Story;


class StoryService
{

    public function getStory($id)
    {
        $story = Story::find($id);

        $video = $story->get()->map(function($item) {
            $data = [
                'title' => $item->title,
                'urlVideo' => $item->urlVideo,
            ];
            if ($item->descriptionOn === true) {
                $data['description'] = $item->description;
            }
            return $data;
        });

        $attachm = $story->attachment()->get()->map(function($item) {
            return [
                'url' => $item->url,
            ];
        });

        return $video->merge($attachm);

    }

}
