<?php

namespace App\Orchid\Layouts\Story;


use App\Models\Story;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;



class StoryListLayout extends Table
{
    /**
     * Data source.
     *
     * @var string
     */
    public $target = 'story';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [

            TD::make('title', 'Заголовок')->sort()
                ->width('100px')
                ->livewire('user.pool-status')
                ->render(function (Story $story) {
                    return Link::make($story->title)
                        ->route('platform.systems.stories.edit', $story);
                }),
            TD::make('image', __('Image'))
                ->render(function(Story $story)
                {
                    $images = $story->attachment()->get();
                    $output = '';
                    foreach ($images as $image) {
                        $output .= '<img src="' . $image->url . '" height="50px" />';
                    }
                    return $output;
                }),

            TD::make('video')
                ->width('120')
                ->render(function (Story $story) {
                    return view('vendor.platform.banner.showVideoURL', [
                        'story' => $story
                    ]);
                }),

            TD::make('url', 'URL')->sort()
                ->width('100px')
                ->render(function (Story $story) {
                    return Link::make($story->urlVideo)
                        ->route('platform.systems.stories.edit', $story);
                }),

            TD::make('description', 'Description')->sort()
                ->render(function (Story $story) {
                    return Link::make($story->description)
                        ->route('platform.systems.stories.edit', $story);
                }),

            TD::make('image', 'Сылка')->sort()
                ->render(function (Story $story) {
                    return  Link::make($story->getUrl())->route('story.show', $story);
                }),

            TD::make(__('Actions'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(fn (Story $story) => DropDown::make()
                    ->icon('options-vertical')
                    ->list([

                        Link::make(__('Edit'))
                            ->route('platform.systems.stories.edit', $story->id)
                            ->icon('pencil'),

                        Button::make(__('Delete'))
                            ->icon('trash')
                            ->confirm(__('Once the account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.'))
                            ->method('remove', [
                                'id' => $story->id,
                            ]),
                        Link::make('Open')
                            ->route('story.show', ['id' =>$story->id])
                            ->icon('plus'),
                    ])),
        ];
    }
}
