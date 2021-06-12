@if(get_config('comment_able'))
    <div class="htmlwrap clearfix">
        @php
            $comment_type = get_config('comment_type');
            $comments_per_page = get_config('comments_per_page');
            if($comments_per_page <= 0) {
                $comments_per_page = 5;
            }
        @endphp

        @if($comment_type == 'facebook')
            <div class="fb-comments"  data-href="{{ url()->current() }}" data-width="100%" data-mobile="true" data-colorscheme="dark" data-numposts="{{ $comments_per_page }}" data-order-by="reverse_time"></div>
        @endif

        @if($comment_type == 'site')
            @if(Auth::check())
                <form action="{{ route('watch.comment', [$info->id]) }}" method="post" class="form-ajax comment-form">
                    <div class="row">
                        <div class="col-xs-10 col-sm-11 col-md-11">
                            <textarea class="form-control" name="content" placeholder="@lang('theme::app.write_your_comment')"></textarea>
                        </div>

                        <div class="col-xs-2 col-sm-1 col-md-1">
                            <button class="btn pull-right btn-main" data-toggle="tooltip" title="Publish">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                            </button>
                        </div>
                    </div>
                </form>
            @else
                <h5 class="text-center">@lang('theme::app.you_must_be_logged_in_to_comment')</h5>
            @endif

            <hr class="color-text">
            <div class="comment-list">
                @php
                $comments = $info->comments()
                    ->publiced()
                    ->orderBy('created_at', 'DESC')
                    ->paginate($comments_per_page);
                @endphp

                @foreach($comments as $comment)
                    @include('watch.component.comment_item')
                @endforeach

                {{ $comments->links() }}
            </div>
        @endif
    </div>
@endif