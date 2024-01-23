<!DOCTYPE html>
<html lang="en">
<body>
<div id="sortable-container" style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 10px;">

    @foreach($story as $key => $item)
        <div class="sortable-item" data-id="{{ $item['id'] }}" style="background-color: lightgray; padding: 10px;">
            <h4>{{ $item['title'] }}</h4>
            @if(isset($item['attachment'][0]))
                <img src="{{ $item['attachment'][0]['url'] }}" class="d-block w-100" alt="..." width="" height="">
                @if($item['descriptionOn'] != false)
                <h4>{{ $item['description'] }}</h4>
                @endif
            @endif
        </div>
    @endforeach
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.13.0/Sortable.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    let sortableContainer = document.getElementById('sortable-container');
    Sortable.create(sortableContainer, {
        onEnd: function(event) {
            let sortedItems = Array.from(sortableContainer.getElementsByClassName('sortable-item'));
            let storyOrder = [];

            sortedItems.forEach(function(item, index) {
                let id = item.getAttribute('data-id');
                storyOrder.push(id);
            });

            $.ajax({
                url: '/stories/update-order',
                type: 'POST',
                data: {
                    "_token":"{{csrf_token()}}",
                    storyOrder: storyOrder
                },
                success: function(response) {
                    console.log(response.message);
                },
                error: function(response) {
                    console.error('Error updating order');
                }
            });
        }
    })
</script>
</body>
</html>
