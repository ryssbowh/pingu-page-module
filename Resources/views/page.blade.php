<div class="{{ $classes }}">
    @foreach($blocks)
        {!! $block->render() !!}
    @endforeach
</div>