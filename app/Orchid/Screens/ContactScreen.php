<?php

namespace App\Orchid\Screens;

use App\Orchid\Layouts\OperatingModelListLayout;
use App\View\Components\OperatingMode;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\DateRange;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Map;
use Orchid\Screen\Fields\Matrix;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;

class ContactScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'ContactScreen';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::tabs([
                'Основная информация' => Layout::rows([
                Input::make('title')
                    ->title('Full Title:')
                    ->placeholder('Enter full name')
                    ->required()
                    ->help('Please enter your full name'),
                Input::make('legal_information')
                    ->title('Legal_information:')
                    ->placeholder('Enter full name')
                    ->required()
                    ->help('Please enter your full name'),
                Input::make('city')
                    ->title('Город:')
                    ->placeholder('Enter full name')
                    ->required()
                    ->help('Please enter your full name'),
                Input::make('address')
                    ->title('Адрес:')
                    ->placeholder('Enter full name')
                    ->required()
                    ->help('Please enter your full name'),

                Map::make('place')
                    ->title('Object on the map')
                    ->value([
                        'lat'=>55.4409357,
                        'lng'=>65.3421169
                    ])
                    ->help('Enter the coordinates, or use the search'),

                Matrix::make('phone')
                    ->columns([
                            'Телефон'
                        ])
                    ->fields([
                            'Телефон'   => Input::make('phone')
                                ->mask('+7(999) 999-9999')
                                ->placeholder('Enter phone number')
                                ->help('Number Phone'),
                        ]),
                    DateRange::make('open')
                        ->title('Opening between'),



                        Button::make(__('Save'))
                            ->type(Color::DEFAULT())
                            ->icon('check')
                            //->canSee($this->company->exists)
                            ->method('save')

                    ]),

                'Доп. точки продаж' => Layout::rows([


                    ]),

                'настройка карты' => Layout::rows([


                    ]),

                'Соцсети и приложения' => Layout::rows([


                ]),
            ]),
        ];
    }
}
