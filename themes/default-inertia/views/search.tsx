export default function Search() {
    return (
        <section>
            <div className="container">
                <div className="row">
                    <div className="col-md-12">
                        <aside className="wrapper__list__article ">
                            {/*<h4 className="border_section">{{$title}}</h4>*/}

                            <div className="row">
                                {/*@foreach($posts as $post)*/}
                                {/*<div className="col-md-6">*/}
                                {/*    {{get_template_part($post, 'content')}}*/}
                                {/*</div>*/}
                                {/*@endforeach*/}
                            </div>
                        </aside>
                    </div>

                    <div className="clearfix"></div>
                </div>

                <div className="pagination-area">
                    <div className="pagination wow fadeIn animated"
                         data-wow-duration="2s"
                         data-wow-delay="0.5s"
                         style="visibility: visible; animation-duration: 2s; animation-delay: 0.5s; animation-name: fadeIn;">
                        {/*{{$posts->links('theme::components.pagination')}}*/}
                    </div>
                </div>
            </div>
        </section>
    )
}
