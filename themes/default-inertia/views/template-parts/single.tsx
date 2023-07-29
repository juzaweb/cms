import {__, url} from "@/helpers/functions";
import {Post, Taxonomy, CommentPaginate} from "@/types/posts";
import {Link, Head} from "@inertiajs/react";
import Main from "../layouts/main";
import React, {useState} from "react";
import Comments from "../components/comments";
import axios from "axios";

export default function Single({ post, canonical, comments, guest }: {post: Post, canonical?: string, comments?: CommentPaginate, guest: boolean}) {
    const categories = post.taxonomies?.filter((item: Taxonomy) => item.taxonomy === 'categories');
    const tags: Array<Taxonomy> = post.taxonomies?.filter((item: Taxonomy) => item.taxonomy === 'tags');
    const [message, setMessage] = useState<{status: string, message: string}>(null);

    const handleComment = (e: React.FormEvent) => {
        e.preventDefault();

        //document.getElementById('submit').setAttribute('disabled', 'disabled');

        axios.post('', {content: e.target['content'].value}).then((res) => {
            e.target['content'].value = '';
            setMessage({status: res.data.status, message: res.data.data.message});
        });

        return false;
    }

    return (
        <Main>
            <section className="pb-80">
                <div className="container">
                    <div className="row">
                        <div className="col-md-12">

                            <ul className="breadcrumbs bg-light mb-4">
                                <li className="breadcrumbs__item">
                                    <Link href={ url('/') } className="breadcrumbs__url">
                                        <i className="fa fa-home"></i> {__('Home')}
                                    </Link>
                                </li>

                                {/*@if($cat)
                            <li className="breadcrumbs__item breadcrumbs__item--current">
                                {{$cat->name}}
                            </li>
                            @endif*/}

                            </ul>
                        </div>
                        <div className="col-md-8">
                            <div className="wrap__article-detail">
                                <div className="wrap__article-detail-title">
                                    <h1>
                                        {post.title}
                                    </h1>
                                    <h3>
                                        {post.description}
                                    </h3>
                                </div>
                                <hr />
                                <div className="wrap__article-detail-info">
                                    <ul className="list-inline">
                                        {/*<li class="list-inline-item">
                                            <figure class="image-profile">
                                            <img src="images/placeholder/logo.jpg" alt="">
                                            </figure>
                                            </li>*/}

                                        <li className="list-inline-item">
                                            <span>
                                                {__('by')}
                                            </span>
                                            <a href="#">
                                                {post.author?.name},
                                            </a>
                                        </li>

                                        <li className="list-inline-item">
                                            <span className="text-dark text-capitalize ml-1">
                                                {post.created_at}
                                            </span>
                                        </li>

                                        <li className="list-inline-item">
                                            <span className="text-dark text-capitalize ml-1 mr-1">
                                                {__('in') }
                                            </span>

                                            {categories?.map((item: Taxonomy) => (
                                                <Link href={item.url} key={item.id}>
                                                    {item.name}
                                                </Link>
                                            ))}
                                        </li>

                                    </ul>
                                </div>

                                <div className="wrap__article-detail-image mt-4">
                                    <figure>
                                        <img src={ post.thumbnail } alt={ post.title }
                                             className="img-fluid"/>
                                    </figure>
                                </div>

                                <div className="wrap__article-detail-content">
                                    <div className="total-views">
                                        <div className="total-views-read">{post.views}<span>
                                            {__('views')}
                                            </span>
                                        </div>

                                        <ul className="list-inline">
                                            <span className="share">{__('share on')}:</span>
                                            <li className="list-inline-item">
                                                <a className="btn btn-social-o facebook"
                                                   href={`https://www.facebook.com/sharer/sharer.php?u=${canonical}&t=${post.title}`}>
                                                    <i className="fa fa-facebook-f"></i>
                                                    <span>facebook</span>
                                                </a>
                                            </li>

                                            <li className="list-inline-item">
                                                <a className="btn btn-social-o twitter"
                                                   href={`https://twitter.com/intent/tweet?url=${canonical}&text=${post.title}`}>
                                                    <i className="fa fa-twitter"></i>
                                                    <span>twitter</span>
                                                </a>
                                            </li>

                                            <li className="list-inline-item">
                                                <a className="btn btn-social-o telegram"
                                                   href={`https://t.me/share/url?url=${canonical}&text=${post.title}`}>
                                                    <i className="fa fa-telegram"></i>
                                                    <span>telegram</span>
                                                </a>
                                            </li>

                                            <li className="list-inline-item">
                                                <a className="btn btn-linkedin-o linkedin"
                                                   href={`https://www.linkedin.com/shareArticle?url=${canonical}&mini=true`}>
                                                    <i className="fa fa-linkedin"></i>
                                                    <span>linkedin</span>
                                                </a>
                                            </li>

                                        </ul>
                                    </div>

                                    <div dangerouslySetInnerHTML={{__html: post?.content || ''}}></div>
                                </div>
                            </div>

                            <div className="blog-tags">
                                <ul className="list-inline">
                                    <li className="list-inline-item">
                                        <i className="fa fa-tags"></i>
                                    </li>

                                    {tags.map((item: Taxonomy) => (
                                        <li className="list-inline-item" key={item.id}>
                                            <Link href={item.url}>
                                                {item.name}
                                            </Link>
                                        </li>
                                    ))}
                                </ul>
                            </div>


                        <div id="comments" className="comments-area">
                            <Comments comments={comments} />

                            <div className="comment-respond">
                                <h3 className="comment-reply-title">{__('Leave a Reply')}</h3>

                                {message ? (message.status ?
                                        <div className="alert alert-success">{message.message}</div> :
                                        <div className="alert alert-danger">{message.message}</div>
                                ) : ''}

                                <form onSubmit={handleComment} method="post" className="comment-form" id="comment-form">
                                    <p className="comment-notes">
                                        <span id="email-notes">{__('Your email address will not be published.')}</span>
                                        {__('Required fields are marked')}
                                        <span className="required">*</span>
                                    </p>

                                    <p className="comment-form-comment">
                                        <label htmlFor="content">{__('Comment')}
                                            <span className="required">*</span>
                                        </label>
                                        <textarea name="content"
                                                  id="content"
                                                  cols="45"
                                                  rows="5"
                                                  maxLength="65525"
                                                  required="required"></textarea>
                                    </p>

                                    {guest ? (
                                        <>
                                            <p className="comment-form-author">
                                                <label htmlFor="author">{__('Name')} <span
                                                    className="required">*</span></label>
                                                <input type="text" id="author" name="name" required="required"/>
                                            </p>

                                            <p className="comment-form-email">
                                                <label htmlFor="email">{__('Email')} <span
                                                    className="required">*</span></label>
                                                <input type="email" id="email" name="email" required="required"/>
                                            </p>

                                            <p className="comment-form-url">
                                                <label htmlFor="website">{__('Website')}</label>
                                                <input type="text" id="website" name="website"/>
                                            </p>
                                        </>
                                    ) : ''}

                                    <p className="form-submit">
                                        <input type="submit" name="submit" id="submit" className="submit"
                                               value={ __('Post Comment') }/>
                                    </p>
                                </form>
                            </div>
                        </div>

                            {/*<div className="row">
                            <div className="col-md-6">
                                @php $previousPost = get_previous_post($post) @endphp

                                @if($previousPost)
                                <div className="single_navigation-prev">
                                    <a href="{{ $previousPost->url }}">
                                        <span>{{__('previous post')}}</span>
                                        {{$previousPost->title}}
                                    </a>
                                </div>
                                @endif
                            </div>

                            <div className="col-md-6">
                                @php $nextPost = get_next_post($post) @endphp

                                @if($nextPost)
                                <div className="single_navigation-next text-left text-md-right">
                                    <a href="{{ $nextPost->url }}">
                                        <span>{{__('next post')}}</span>
                                        {{$nextPost->title}}
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>*/}

                            <div className="clearfix"></div>

                            {/*<Related post={post} />*/}
                        </div>

                        <div className="col-md-4">
                            <div className="sticky-top">
                                {/*{{dynamic_sidebar('sidebar')}}*/}
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </Main>
    )
}
