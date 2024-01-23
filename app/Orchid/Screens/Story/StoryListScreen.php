<?php

namespace App\Orchid\Screens\Story;

use App\Models\Story;
use App\Orchid\Layouts\Story\StoryListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;


class StoryListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Story $stories): iterable
    {
        $stories = Story::orderBy('order')->paginate();
        $story = $stories->load('attachment');


        return [
            'story' => $story,
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Stories';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [

            Link::make(__('Add'))
                ->icon('plus')
                ->route('platform.systems.stories.create'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            StoryListLayout::class,
            Layout::view('vendor.platform.banner.stories'),
            /*Layout::sortable('models', [
                Sight::make('title'),
            ]),*/
        ];
    }
    public function remove(Request $request): void
    {
        $banner = Story::findOrFail($request->get('id'));
        $attachmentIds = $request->input('story.attachment', []);
        $banner->attachment()->sync($attachmentIds);
        $banner->delete();
        Toast::info(__('Banner was removed'));
    }

}
