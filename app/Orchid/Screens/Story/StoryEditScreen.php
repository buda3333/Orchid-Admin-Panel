<?php
declare(strict_types=1);

namespace App\Orchid\Screens\Story;

use App\Models\Story;
use App\Orchid\Layouts\Story\StoryEditLayout;
use Illuminate\Http\Request;
use Orchid\Screen\Action;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class StoryEditScreen extends Screen
{
    /**
     * @var Story
     */
    public $story;

    /**
     * Fetch data to be displayed on the screen.
     *
     * @param Story $story
     *
     * @return array
     */
    public function query(Story $story): array
    {
        $story->load('attachment');

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
        return $this->story->exists ? 'Edit Story' : 'Create story';
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
            Layout::block(StoryEditLayout::class)
                ->title(__('Story Information'))
                ->description(__('Update your story\'s story  information.'))
                ->commands(
                    Button::make(__('Save'))
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->canSee($this->story->exists)
                        ->method('save')
                ),
        ];
    }

    public function save(Story $story, Request $request)
    {

        $request->validate([
            'story.title' => 'required|max:255',
        ]);
        if ($story->id) {
            $story = Story::findOrFail($story->id);
        } else {
            $story = new Story();
        }

        $story->fill($request->get('story'))->save();

        $story->attachment()->sync(
            $request->input('story.attachment', [])
        );

        Alert::info(__('Story was saved.'));
        return redirect()->route('platform.systems.stories');
    }

}
