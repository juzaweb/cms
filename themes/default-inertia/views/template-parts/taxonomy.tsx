import {__} from "@/helpers/functions";
import {PostPaginate, Taxonomy} from "@/types/posts";
import Main from "../layouts/main";
import {Link} from "@inertiajs/react";
import Pagination from "../components/pagination";
import Content from "./content";

export default function ({ taxonomy, page }: {taxonomy: Taxonomy, page: PostPaginate}) {
    return (
        <Main>
            <section>
                <div className="container">
                    <div className="row">
                        <div className="col-md-12">
                            <ul className="breadcrumbs bg-light mb-4">
                                <li className="breadcrumbs__item">
                                    <Link href={'/'} className="breadcrumbs__url">
                                        <i className="fa fa-home"></i> {__('Home')}</Link>
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
                                {page.data.map((post: any) => {
                                        return (
                                            <div className="col-md-6" key={post.id}>
                                                <Content post={post} />
                                            </div>
                                        );
                                    })}
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
                             style={{visibility: 'visible', animationDuration: '2s', animationDelay: '0.5s', animationName: 'fadeIn'}}>
                           <Pagination data={page}></Pagination>
                        </div>
                    </div>
                </div>
            </section>
        </Main>
    )
}
