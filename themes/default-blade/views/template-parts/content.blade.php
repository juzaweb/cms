<div class="article__entry">
    {% set categories = get_post_taxonomies(post, 'categories', {limit: 1}) %}

    <div class="article__image">
        <a href="{{ post.url }}" title="{{ post.title }}">
            <img src="{{ post.thumbnail }}" alt="{{ post.title }}" class="img-fluid">
        </a>
    </div>

    <div class="article__content">
        {% for category in categories %}
        <div class="article__category">
            {{ category.name }}
        </div>
        {% endfor %}

        <ul class="list-inline">
            <li class="list-inline-item">
                <span class="text-primary">
                    {{ __('by') }} {{ post.author.name }}
                </span>
            </li>

            <li class="list-inline-item">
                <span class="text-dark text-capitalize">
                    {{ post.created_at }}
                </span>
            </li>
        </ul>

        <h5>
            <a href="{{ post.url }}" title="{{ post.title }}">
                {{ post.title }}
            </a>
        </h5>

        <p>{{ post.description }}</p>

        <a href="{{ post.url }}" class="btn btn-outline-primary mb-4 text-capitalize"> {{ __('read more') }}</a>
    </div>
</div>
