import {__, url} from "@/helpers/functions";
import {Post} from "@/types/posts";
import {Link, Head} from "@inertiajs/react";
import Main from "../layouts/main";
import React from "react";
import Related from "./components/related";

export default function Single({ post, canonical }: {post: Post, canonical?: string}) {

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
                                            <span className="text-dark text-capitalize">
                                                {__('in')}
                                            </span>
                                            {/*@foreach($categories as $category)
                                            <a href="{{ $category->url }}">
                                                {$category->name}
                                            </a>
                                            @endforeach*/}
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

                                    {post.content}
                                </div>
                            </div>

                            <div className="blog-tags">
                                <ul className="list-inline">
                                    <li className="list-inline-item">
                                        <i className="fa fa-tags"></i>
                                    </li>

                                    {/*@foreach($tags as $tag)
                                <li className="list-inline-item">
                                    <a href="{{ $tag->url }}">
                                        #{$tag->name}
                                    </a>
                                </li>
                                @endforeach*/}
                                </ul>
                            </div>

                            {/*{% if errors.any() %}
                        <div className="alert alert-danger">
                            <ul className="list-group">
                                {% for error in errors.all() %}
                                <li className="list-group-item">{{error}}</li>
                                {% endfor %}
                            </ul>
                        </div>
                        {% endif %}

                        {% if status == 'success' %}
                        <div className="alert alert-success">
                            {{message}}
                        </div>
                        {% endif %}

                        <div id="comments" className="comments-area">
                            {{comment_template($post, 'theme::components.comments')}}

                            <div className="comment-respond">
                                <h3 className="comment-reply-title">{{__('Leave a Reply')}}</h3>
                                {{comment_form($post)}}
                            </div>
                        </div>*/}



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

                            <Related post={post} />
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
