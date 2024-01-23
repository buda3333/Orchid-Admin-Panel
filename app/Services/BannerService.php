<?php

namespace App\Services;

use App\Models\Banner;


class BannerService
{

    public function getBanner($id)
    {
        $banner = Banner::find($id);

        $data =$banner->get()->map(function($item) {
            return [
                'title' => $item->title,
                'speed' => $item->speed
            ];
        });

        $bannerUrl = $banner->attachment()->get()->map(function($item) {
            return [
                'url' => $item->url
            ];
        });
        return $data->merge($bannerUrl);

        //->concat($data);
        //return collect(array_merge_recursive($bannerUrl->toArray(),$data->toArray()));

    }

}
