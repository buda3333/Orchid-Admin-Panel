<?php

namespace App\Orchid\Layouts\Banner;

use App\Models\Banner;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;


class BannerListLayout extends Table
{
    /**
     * Data source.
     *
     * @var string
     */
    public $target = 'banners';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [

            TD::make('title', 'Заголовок')->sort()
                ->width('100px')
                ->render(function (Banner $banner) {
                    return Link::make($banner->title)
                        ->route('platform.systems.banners.edit', $banner);
                }),
            TD::make('speed', 'Скорость')->sort()
                ->width('100px')
                ->render(function (Banner $banner) {
                    return Link::make($banner->speed)
                        ->route('platform.systems.banners.edit', $banner);
                }),
            TD::make('select', 'Select')->sort()
                ->width('100px')
                ->render(function (Banner $banner) {
                    return Link::make($banner->select)
                        ->route('platform.systems.banners.edit', $banner);
                }),
            TD::make('image', __('Image'))->sort()
                ->render(function(Banner $banner)
                {
                    $images = $banner->attachment()->get();
                    $output = '';
                    foreach ($images as $image) {
                        $output .= '<img src="' . $image->url . '" height="50px" />';
                    }
                    return $output;
                }),
            TD::make('image', 'Сылка')->sort()
                ->width('100px')
                ->render(function (Banner $banner) {
                    return  Link::make($banner->getUrl())->route('banner.show', $banner);
                }),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Banner $banner) => DropDown::make()
                    ->icon('options-vertical')
                    ->list([

                        Link::make(__('Edit'))
                            ->route('platform.systems.banners.edit', $banner->id)
                            ->icon('pencil'),

                        Button::make(__('Delete'))
                            ->icon('trash')
                            ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                            ->method('remove', [
                                'id' => $banner->id,
                            ]),
                        Link::make('Open')
                            ->route('banner.show', ['id' =>$banner->id])
                            ->icon('plus'),
                    ])),
        ];
    }
}
