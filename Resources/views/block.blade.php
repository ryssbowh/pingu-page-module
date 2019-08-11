<div class="block {{ kebab_case($block::friendlyName()) }}">
	@include('page::blocks.'.kebab_case($block::friendlyName()))
</div>