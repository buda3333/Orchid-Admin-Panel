<?php
declare(strict_types=1);
namespace App\Orchid\Layouts\Banner;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;


class BannerEditLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     * @throws \Throwable
     */

    public function fields(): array
    {
        return [
            Input::make('banner.title')
                ->title('Title')
                ->placeholder('Enter name')
                ->help('The name of the banner.'),
            Input::make('banner.speed')
                ->title('Speed')
                ->type('range')
                ->help('The speed of banner.')
                ->min(1)
                ->max(5),
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
                ->title('Select')
                ->help('Select the placement'),
            Upload::make('banner.attachment')
                ->title('Upload with catalog')
                ->media()
                ->closeOnAdd(),
            Cropper::make('banner.web')
                ->title('WEB')
                ->width(736)
                ->height(506)
                ->targetRelativeUrl(),
            Cropper::make('banner.mobile')
                ->title('Mobile')
                ->width(320)
                ->height(480)
                ->targetRelativeUrl(),
            Cropper::make('banner.app')
                ->title('APP')
                ->width(320)
                ->height(480)
                ->targetRelativeUrl(),
            Cropper::make('banner.vk')
                ->title('vk.com')
                ->width(1080)
                ->height(607)
                ->targetRelativeUrl(),

        ];
    }
}
