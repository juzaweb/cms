{% extends 'cms::layouts.frontend' %}

{% block content %}

    {% if input_get('page') is empty %}
        {{ dynamic_block(post, 'content') }}
    {% endif %}

    {% set items = get_posts('posts', {
        'taxonomy': data.taxonomy,
        'paginate': 10
    }) %}

    <section class="pt-0">
        <!-- Popular news category -->
        <div class="mt-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">

                        <aside class="wrapper__list__article">
                            <h4 class="border_section">{{ __('Latest') }}</h4>

                            <div class="wrapp__list__article-responsive">
                                {% for item in items.data %}

                                    {% set category = get_post_taxonomy(item, 'categories') %}

                                <!-- Post Article List -->
                                <div class="card__post card__post-list card__post__transition mt-30">
                                    <div class="row ">
                                        <div class="col-md-5">
                                            <div class="card__post__transition">
                                                <a href="{{ item.url }}">
                                                    <img src="{{ item.thumbnail }}" class="img-fluid w-100" alt="{{ item.title }}">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-md-7 my-auto pl-0">
                                            <div class="card__post__body ">
                                                <div class="card__post__content">

                                                    {% if category %}
                                                    <div class="card__post__category ">
                                                        {{ category.name }}
                                                    </div>
                                                    {% endif %}

                                                    <div class="card__post__author-info mb-2">
                                                        <ul class="list-inline">
                                                            <li class="list-inline-item">
                                <span class="text-primary">
                                    {{ __('by') }} {{ item.author.name }}
                                </span>
                                                            </li>
                                                            <li class="list-inline-item">
                                <span class="text-dark text-capitalize">
                                    {{ item.created_at }}
                                </span>
                                                            </li>

                                                        </ul>
                                                    </div>
                                                    <div class="card__post__title">
                                                        <h5>
                                                            <a href="{{ item.url }}">
                                                                {{ item.title }}
                                                            </a>
                                                        </h5>
                                                        <p class="d-none d-lg-block d-xl-block mb-0">
                                                            {{ item.description }}
                                                        </p>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                {% endfor %}
                            </div>
                        </aside>
                    </div>

                    <div class="col-md-4">
                        <div class="sticky-top">
                            {{ dynamic_sidebar('sidebar') }}
                        </div>
                    </div>

                    <div class="mx-auto">
                        <!-- Pagination -->
                        <div class="pagination-area">
                            <div class="pagination wow fadeIn animated" data-wow-duration="2s" data-wow-delay="0.5s" style="visibility: visible; animation-duration: 2s; animation-delay: 0.5s; animation-name: fadeIn;">
                                {{ paginate_links(items, 'theme::components.pagination') }}
                            </div>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </section>

{% endblock %}