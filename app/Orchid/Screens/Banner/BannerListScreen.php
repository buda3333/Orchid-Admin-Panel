<?php
declare(strict_types=1);
namespace App\Orchid\Screens\Banner;

use App\Models\Banner;
use App\Orchid\Layouts\Banner\BannerListLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class BannerListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(Banner $banner): array
    {
        $banner = Banner::paginate();
        $banners = $banner->load('attachment');

        return [
            'banners' => $banners
        ];
    }
    public function name(): ?string
    {
        return 'Banner';
    }
    public function commandBar(): iterable
    {
        return [
            Link::make(__('AddOpen'))
                ->icon('plus')
                ->route('platform.systems.banners.create'),
            ModalToggle::make('Add Banner')
                ->modal('bannerModal')
                ->method('create')
                ->icon('plus'),
        ];
    }


    /**
     * @throws \Throwable
     */
    public function layout(): iterable
    {
        return [

                BannerListLayout::class,
           Layout::modal('bannerModal', [
                Layout::rows([
                    Input::make('banner.title')
                        ->title('Title')
                        ->placeholder('Enter name')
                        ->help('The name of the banner to create.'),
                    Input::make('banner.speed')
                        ->title('Speed')
                        ->type('range')
                        ->min(1)
                        ->max(100),
                    Select::make('banner.select')
                        ->options([
                            'ПК'   => 'ПК',
                            'Мобайл' => 'Мобайл',
                            'Приложение' => 'Приложение',
                            'ВК' => 'ВК',
                            'Telegram' => 'Telegram',
                            'Приложение iPhone' => 'Приложение iPhone',
                            'Приложение Android' => 'Приложение Android',
                        ])
                        ->title('Select tags')
                        ->help('Allow search bots to index'),
                    Upload::make('banner.attachment')
                        ->title('Upload with catalog')
                        ->media()
                        ->closeOnAdd()
                        ->horizontal(),
                ]),

            ])->title('Create Banner')
        ];
    }

    public function createOr(Banner $banner, Request $request): void
    {
        $banner->fill($request->get('banner'))->save();

        $banner->attachment()->syncWithoutDetaching(
            $request->input('banner.attachment', []));
        $banner->attachment()->syncWithoutDetaching(
            $request->input('banner.mobile', []));
        $banner->attachment()->syncWithoutDetaching(
            $request->input('banner.app', []));
        $banner->attachment()->syncWithoutDetaching(
            $request->input('banner.vk', []));
        $banner->attachment()->syncWithoutDetaching(
            $request->input('banner.web', []));
        Alert::info('You have successfully created.');
    }

    public function create(Request $request): void
    {
        $request->validate([
            'banner.title' => 'required|max:255',
            'banner.speed' => 'required|max:255',

        ]);
        $banner = new Banner();
        $banner->title = $request->input('banner.title');
        $banner->speed = $request->input('banner.speed');
        $banner->select = $request->input('banner.select');
        $banner->save();

        $this->createOr($banner, $request);
    }
    public function remove(Request $request): void
    {
        $banner = Banner::findOrFail($request->get('id'));
        $attachmentIds = $request->input('banner.attachment', []);
        $banner->attachment()->sync($attachmentIds);
        $banner->delete();
        Toast::info(__('Banner was removed'));
    }
}
