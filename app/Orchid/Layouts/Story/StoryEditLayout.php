<?php
declare(strict_types=1);
namespace App\Orchid\Layouts\Story;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Cropper;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layouts\Rows;



class StoryEditLayout extends Rows
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

            Input::make('story.title')
                ->title('Title')
                ->placeholder('Enter name')
                ->help('The name of the banner.'),

            Cropper::make('story.image')
                ->title('WEB')
                ->width(450)
                ->height(800)
                ->targetRelativeUrl(),

            Upload::make('story.attachment')
                ->title('All files')
                ->media()
                ->closeOnAdd(),

            Input::make('story.urlVideo')
                ->type('url')
                ->title('url')
                ->help('You might use this when asking to input their website address for a business directory'),

            CheckBox::make('story.descriptionOn')
                ->sendTrueOrFalse()
                ->title('Добавить описание?')
                ->placeholder('yes'),

            TextArea::make('story.description')
                ->title('Description')
                ->rows(3)
                ->maxlength(200)
                ->placeholder('Brief description for preview'),




        ];
    }
}
