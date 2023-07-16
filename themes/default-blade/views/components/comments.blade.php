<h3 class="comments-title">{{ total }} {{ __('Comments') }}:</h3>

<ol class="comment-list">
    {% for comment in comments.data %}
    <li class="comment">
        <aside class="comment-body">
            <div class="comment-meta">
                <div class="comment-author vcard">
                    <img src="{{ comment.avatar }}" class="avatar" alt="image">
                    <b class="fn">{{ comment.name }}</b>
                    <span class="says">{{ __('says') }}:</span>
                </div>

                <div class="comment-metadata">
                    <a href="#">
                        <span>{{ comment.created_at }}</span>
                    </a>
                </div>
            </div>

            <div class="comment-content">
                {{ comment.content }}
            </div>

            <div class="reply">
                <a href="?reply={{ comment.id }}#comment-form" class="comment-reply-link">{{ __('Reply') }}</a>
            </div>
        </aside>
    </li>
    {% endfor %}
</ol>



