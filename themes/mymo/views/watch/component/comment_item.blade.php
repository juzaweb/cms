<div class="main-comment" data-id="{{ $comment->id }}" id="comment-{{ $comment->id }}">
    <div class="main-comment-data-sp">
        <div class="user-avatar pull-left">
            <img src="{{ $comment->user->getAvatar() }}" alt="Johnwalton">
        </div>

        <div class="user-name">
            <span class="pin"></span>
            <a href="javascript:void(0)">{{ $comment->user->name }}</a>
            <small>{{ $comment->created_at->diffForHumans() }}</small>
        </div>

        <div class="user-comment">
            <p class="comment-text color-text">{{ $comment->content }}</p>

            {{--<div class="width-100 div-vote-comment">
<span class="pointer comms-reply">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
</span>&nbsp;&nbsp;
                <span class="div-vote-comment-btn">
    <span data-comment-likes="5001">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up "><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg> <span>0</span>
    </span>&nbsp;&nbsp;
    <span onclick="PT_LikeComments(this,'down','5001');" data-comment-dislikes="5001">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-down "><path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"></path></svg> <span>0</span>
    </span>
</span>
            </div>--}}
        </div>
        <div class="clear"></div>
    </div>
    {{--<div style="width: 100%;overflow: hidden;">
        <div class="pt-comment-replies user-comment" style="width: 100%;padding: 0 0 0 60px;">
            <div class="pt-comment-item-replies-list" id="pt-comment-replies-cont-5001">

            </div>
            <div class="pt-comment-item-reply-form hidden" id="comm-reply-5001">
                <input type="text" class="form-control" placeholder="Write a comment and press ENTER" onkeydown="PT_RVReply(this.value,'5001',event,'2');">
            </div>

        </div>
    </div>--}}

    <div class="clear"></div>
</div>