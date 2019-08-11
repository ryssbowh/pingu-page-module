@extends('layouts.base')

@section('body')
<body>
	<div id="app">
		<div class="container">
			@foreach($regions as $region)
				<div class="region {{ kebab_case($region->name) }}" style="width:{{ $region->width }}%">
					@foreach($region->blocks as $block)
						@include('page::block', ['block' => $block->instance])
					@endforeach
				</div>
			@endforeach
		</div>
	</div>
</body>
@endsection