import {__} from "@/helpers/functions";
import Main from "../layouts/main";

export default function () {
    return (
        <Main>
            <section className="pt-0">
                <div className="mt-4">
                    <div className="container">
                        <div className="row">
                            <div className="col-md-8">

                                <aside className="wrapper__list__article">
                                    <h4 className="border_section">{__('Latest')}</h4>

                                    <div className="wrapp__list__article-responsive">
                                        {/*{% for item in items.data %}

                                    @php $category = get_post_taxonomy(item, 'categories') %}

                                    <div className="card__post card__post-list card__post__transition mt-30">
                                        <div className="row ">
                                            <div className="col-md-5">
                                                <div className="card__post__transition">
                                                    <a href={ item.url }>
                                                        <img src={ item.thumbnail } className="img-fluid w-100" alt={ item.title } />
                                                    </a>
                                                </div>
                                            </div>
                                            <div className="col-md-7 my-auto pl-0">
                                                <div className="card__post__body ">
                                                    <div className="card__post__content">

                                                        {% if category %}
                                                        <div className="card__post__category ">
                                                            {category.name}
                                                        </div>
                                                        {% endif %}

                                                        <div className="card__post__author-info mb-2">
                                                            <ul className="list-inline">
                                                                <li className="list-inline-item">
                                                                    <span className="text-primary">
                                                                        {__('by')} {item.author?.name}
                                                                    </span>
                                                                                                    </li>
                                                                                                    <li className="list-inline-item">
                                                                    <span className="text-dark text-capitalize">
                                                                        {item.created_at}
                                                                    </span>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                        <div className="card__post__title">
                                                            <h5>
                                                                <a href={ item.url }>
                                                                    {item.title}
                                                                </a>
                                                            </h5>
                                                            <p className="d-none d-lg-block d-xl-block mb-0">
                                                                {item.description}
                                                            </p>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    {% endfor %}*/}
                                    </div>
                                </aside>
                            </div>

                            <div className="col-md-4">
                                <div className="sticky-top">
                                    {/*{{dynamic_sidebar('sidebar')}}*/}
                                </div>
                            </div>

                            <div className="mx-auto">
                                <div className="pagination-area">
                                    <div className="pagination wow fadeIn animated" data-wow-duration="2s"
                                         data-wow-delay="0.5s"
                                         style="visibility: visible; animation-duration: 2s; animation-delay: 0.5s; animation-name: fadeIn;">
                                        {/*{{paginate_links(items, 'theme::components.pagination')}}*/}
                                    </div>
                                </div>
                            </div>

                            <div className="clearfix"></div>
                        </div>
                    </div>
                </div>
            </section>
        </Main>
    );
}
