@extends('layouts.base')

@section('body')
<body>
	<div id="app">
		<div class="container">
			@foreach($regions as $region)
				<div class="region {{ kebab_case($region->name) }}" style="width:{{ $region->width }}%">
					@foreach($region->getBlocks() as $block)
						@include('page::block', ['provider'=> $block->block_provider, 'block' => $block->loadBlock()])
					@endforeach
				</div>
			@endforeach
		</div>
	</div>
</body>
@endsection