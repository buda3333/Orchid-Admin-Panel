<?php

namespace App\Http\Controllers;
use App\Models\Story;
use App\Services\BannerService;
use App\Services\StoryService;
use Illuminate\Http\Request;


class GenerateController extends Controller
{
    public function showBanner($id)
    {
        $banner = new BannerService();
        $data = $banner->getBanner($id);
        return view('vendor.platform.banner.showBanner', compact('data'));
    }
    public function showStory($id)
    {
        $banner = new StoryService();
        $data = $banner->getStory($id);
        $story = $data['0'];
        return view('vendor.platform.banner.showVideoURL', compact('story'));
    }
    public function updateOrder(Request $request)
    {
        $storyOrder = $request->input('storyOrder');

        foreach ($storyOrder as $index => $storyId) {
            $story = Story::find($storyId);
            $story->order = $index + 1;
            $story->save();
        }

        return response()->json(['message' => 'Order updated successfully']);
    }
}
