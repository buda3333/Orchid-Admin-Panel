
<x-embed-styles />

    <div class="media small-media">
        <div class="media-body">
            <x-embed url="{{ $story['urlVideo'] }}" class="small" />
        </div>
        <style>
            .small-media {
                max-width: 200px;
            }

            .small-media .attachment {
                max-width: 100px;
                max-height: 100px;
            }
        </style>


