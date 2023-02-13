@if ($paginator->hasPages())
	<div class="pagination-container align-center justify-content-center m-3">
		<ul class="pagination pagination-warning justify-content-center">
			@if ($paginator->onFirstPage())
				<li class="page-item disabled">
					<a class="page-link" href="javascript:;" aria-label="Previous">
						<span aria-hidden="true"><i class="bi bi-chevron-compact-left" aria-hidden="true"></i></span>
					</a>
				</li>
			@else
				<li class="page-item">
					<a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
						<span aria-hidden="true"><i class="bi bi-chevron-compact-left" aria-hidden="true"></i></span>
					</a>
				</li>
			@endif

			@foreach ($elements as $element)
				@if (is_string($element))
					<li class="page-item">
						<a class="page-link" href="javascript:;">
							<span aria-hidden="true"><i class="bi bi-three-dots" aria-hidden="true"></i></span></a>
					</li>
				@endif
				
				@if (is_array($element))
					@foreach ($element as $page => $url)
						@if ($page == $paginator->currentPage())
							<li class="page-item active">
								<a class="page-link" href="javascript:;">{{ $page }}</a>
							</li>
						@else
							<li class="page-item">
								<a class="page-link" href="{{ $url }}">{{ $page }}</a>
							</li>
						@endif
					@endforeach
				@endif
			@endforeach
			
			@if ($paginator->hasMorePages())
				<li class="page-item">
					<a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
						<span aria-hidden="true"><i class="bi bi-chevron-compact-right" aria-hidden="true"></i></span>
					</a>
				</li>
			@else
				<li class="page-item disabled">
					<a class="page-link" href="javascript:;" aria-label="Next">
						<span aria-hidden="true"><i class="bi bi-chevron-compact-right" aria-hidden="true"></i></span>
					</a>
				</li>
			@endif
		</ul>
	</div>
@endif
