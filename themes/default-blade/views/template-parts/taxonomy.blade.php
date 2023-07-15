{% extends 'cms::layouts.frontend' %}

{% block content %}
    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- Breadcrumb -->
                    <ul class="breadcrumbs bg-light mb-4">
                        <li class="breadcrumbs__item">
                            <a href="{{ home_url() }}" class="breadcrumbs__url">
                                <i class="fa fa-home"></i> {{ __('Home') }}</a>
                        </li>

                        <li class="breadcrumbs__item breadcrumbs__item--current">
                            {{ title }}
                        </li>

                    </ul>

                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <aside class="wrapper__list__article ">
                        <h4 class="border_section">{{ title }}</h4>

                        <div class="row">
                            {% for post in page.data %}
                            <div class="col-md-6">
                                <!-- Post Article -->
                                {{ get_template_part(post, 'content') }}
                            </div>
                            {% endfor %}
                        </div>
                    </aside>

                </div>
                <div class="col-md-4">
                    <div class="sidebar-sticky">
                        {{ dynamic_sidebar('sidebar') }}
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>
            <!-- Pagination -->
            <div class="pagination-area">
                <div class="pagination wow fadeIn animated" data-wow-duration="2s" data-wow-delay="0.5s" style="visibility: visible; animation-duration: 2s; animation-delay: 0.5s; animation-name: fadeIn;">
                    {{ paginate_links(page, 'theme::components.pagination') }}
                </div>
            </div>
        </div>
    </section>
{% endblock %}
