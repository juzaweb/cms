import Main from "./layouts/main";
import Content from "./template-parts/content";

export default function Index({ title, posts }: {title: string, posts: any}) {
    return (
        <Main>
            <section>
                <div className="container">
                    <div className="row">
                        <div className="col-md-8">
                            <aside className="wrapper__list__article ">
                                <h4 className="border_section">{title}</h4>

                                <div className="row">
                                    {posts.data.map((post: any) => {
                                        return (
                                            <div className="col-md-6" key={post.id}>
                                                <Content post={post} />
                                            </div>
                                        );
                                    })}
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
                        <div className="pagination wow fadeIn animated"
                             data-wow-duration="2s"
                             data-wow-delay="0.5s"
                             style={{visibility: 'visible', animationDuration: '2s', animationDelay: '0.5s', animationName: 'fadeIn'}} >
                            {/*{{$posts->links('theme::components.pagination')}}*/}
                        </div>
                    </div>
                </div>
            </section>
        </Main>
    )
}
