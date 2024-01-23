<?php
declare(strict_types=1);

namespace App\Orchid\Screens\Banner;

use App\Models\Banner;
use App\Orchid\Layouts\Banner\BannerEditLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class BannerEditScreen extends Screen
{
    /**
     * @var Banner
     */
    public $banner;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @param Banner $banner
     *
     * @return array
     */
    public function query(Banner $banner): array
    {
        $banner->load('attachment');

        return [
            'banner' => $banner,
        ];
    }
    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->banner->exists ? 'Edit Banner' : 'Create Banner';
    }
    /**
     * Display header description.
     *
     * @return string|null
     */
    public function description(): ?string
    {
        return 'Details such as ';
    }
    /**
     * The screen's action buttons.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make(__('Save'))
                ->icon('check')
                ->method('save'),
        ];
    }
    /**
     * @return \Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            Layout::block(BannerEditLayout::class)
                ->title(__('Banner Information'))
                ->description(__('Update your banner\'s banner information.'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->canSee($this->banner->exists)
                        ->method('save')
                ),
        ];
    }

    public function save(Banner $banner, Request $request)
    {
        $request->validate([
            'banner.title' => 'required|max:255',
            'banner.speed' => 'required|max:255',
        ]);

        if ($banner->id) {
            $banner = Banner::findOrFail($banner->id);
        } else {
            $banner = new Banner();
        }

        $banner->fill($request->get('banner'))->save();

        $banner->attachment()->sync($request->input('banner.attachment', []));

        Toast::info(__('Banner was saved.'));
        return redirect()->route('platform.systems.banners');
    }

}
