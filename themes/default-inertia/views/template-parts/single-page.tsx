import {Post} from "@/types/posts";
import {__, url} from "@/helpers/functions";
import {Link} from "@inertiajs/react";

export default function SinglePage({post}: { post: Post }) {
    return (
        <>
            <section className="pb-80">
                <div className="container">
                    <div className="row">
                        <div className="col-md-12">

                            <ul className="breadcrumbs bg-light mb-4">
                                <li className="breadcrumbs__item">
                                    <Link href={url('/')} className="breadcrumbs__url">
                                        <i className="fa fa-home"></i> {__('Home')}
                                    </Link>
                                </li>

                                <li className="breadcrumbs__item breadcrumbs__item--current">
                                    {post.title}
                                </li>

                            </ul>

                        </div>
                        <div className="col-md-8">

                            <div className="wrap__article-detail">
                                <div className="wrap__article-detail-title">
                                    <h1>
                                        {post.title}
                                    </h1>
                                </div>
                                <hr/>

                                <div className="wrap__article-detail-content">
                                    <div className="total-views">
                                        <div className="total-views-read">
                                            {post.views.toString()}
                                            <span>
                                                    {__('views')}
                                                </span>
                                        </div>

                                        <ul className="list-inline">
                                            <span className="share">{__('share on')}:</span>
                                            <li className="list-inline-item">
                                                <a className="btn btn-social-o facebook"
                                                   href="https://www.facebook.com/sharer.php?u={{ url()->current() }}">
                                                    <i className="fa fa-facebook-f"></i>
                                                    <span>facebook</span>
                                                </a>
                                            </li>

                                            <li className="list-inline-item">
                                                <a className="btn btn-social-o twitter"
                                                   href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ $title }}">
                                                    <i className="fa fa-twitter"></i>
                                                    <span>twitter</span>
                                                </a>
                                            </li>

                                            <li className="list-inline-item">
                                                <a className="btn btn-social-o telegram"
                                                   href="https://t.me/share/url?url={{ url()->current() }}&text={{ $title }}">
                                                    <i className="fa fa-telegram"></i>
                                                    <span>telegram</span>
                                                </a>
                                            </li>

                                            <li className="list-inline-item">
                                                <a className="btn btn-linkedin-o linkedin"
                                                   href="https://www.linkedin.com/sharing/share-offsite/?url={{ url()->current() }}">
                                                    <i className="fa fa-linkedin"></i>
                                                    <span>linkedin</span>
                                                </a>
                                            </li>

                                        </ul>
                                    </div>

                                    {post.content}
                                </div>
                            </div>

                        </div>

                        <div className="col-md-4">
                            <div className="sticky-top">
                                {/*{{dynamic_sidebar('sidebar')}}*/}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </>
    )
}
