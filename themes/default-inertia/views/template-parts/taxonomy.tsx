import {__} from "@/helpers/functions";
import {Taxonomy} from "@/types/posts";

export default function ({ taxonomy }: {taxonomy: Taxonomy}) {
    return (
        <section>
            <div className="container">
                <div className="row">
                    <div className="col-md-12">
                        <ul className="breadcrumbs bg-light mb-4">
                            <li className="breadcrumbs__item">
                                <a href="{{ home_url() }}" className="breadcrumbs__url">
                                    <i className="fa fa-home"></i> {__('Home')}</a>
                            </li>

                            <li className="breadcrumbs__item breadcrumbs__item--current">
                                {taxonomy.name}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div className="container">
                <div className="row">
                    <div className="col-md-8">
                        <aside className="wrapper__list__article ">
                            <h4 className="border_section">{taxonomy.name}</h4>

                            <div className="row">
                                {/*@foreach($posts as $post)
                                <div className="col-md-6">
                                    {{get_template_part($post, 'content')}}
                                </div>
                                @endforeach*/}
                            </div>
                        </aside>

                    </div>
                    <div className="col-md-4">
                        <div className="sidebar-sticky">
                            {/*{{dynamic_sidebar('sidebar')}}*/}
                        </div>
                    </div>

                    <div className="clearfix"></div>
                </div>

                <div className="pagination-area">
                    <div className="pagination wow fadeIn animated" data-wow-duration="2s" data-wow-delay="0.5s"
                         style="visibility: visible; animation-duration: 2s; animation-delay: 0.5s; animation-name: fadeIn;">
                        {/*{{$posts->links('theme::components.pagination')}}*/}
                    </div>
                </div>
            </div>
        </section>
    )
}
