import React, { useState } from "react";
import Comments from "./comments";
import { CommentPaginate, Post } from "@/types/posts";
import { __ } from "@/helpers/functions";
import { usePage } from "@inertiajs/react";
import { postComment } from "@/helpers/fetch";

export default function CommentForm({ post, comments }: { post: Post, comments?: CommentPaginate }) {
    const [message, setMessage] = useState<null | { status: boolean, message: string }>(null);
    const { guest } = usePage().props;
    const [content, setContent] = useState<string>('');
    const [name, setName] = useState<string>('');
    const [email, setEmail] = useState<string>('');
    const [website, setWebsite] = useState<string>('');

    const handleComment = (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();

        //document.getElementById('submit').setAttribute('disabled', 'disabled');

        postComment(post, content, name, email, website).then((res) => {
            setContent('');
            setMessage({ status: res.data.status, message: res.data.data.message });
            setTimeout(() => setMessage(null), 3000);
        }).catch((err) => {
            console.log(err)
            setMessage({ status: false, message: err.response.data.message });
        });

        return false;
    }

    return (
        <div id="comments" className="comments-area">
            <Comments comments={comments} />

            <div className="comment-respond">
                <h3 className="comment-reply-title">{__('Leave a Reply')}</h3>

                {message && (message.status ?
                    <div className="alert alert-success">{message.message}</div> :
                    <div className="alert alert-danger">{message.message}</div>
                )}

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
                            cols={45}
                            rows={5}
                            maxLength={65525}
                            required={true}
                            onChange={(e) => setContent(e.currentTarget.value)}
                                  value={content}
                        ></textarea>
                    </p>

                    {guest ? (
                        <>
                            <p className="comment-form-author">
                                <label htmlFor="name">{__('Name')} <span
                                    className="required">*</span></label>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    required={true}
                                    value={name}
                                    onChange={(e) => setName(e.currentTarget.value)}
                                />
                            </p>

                            <p className="comment-form-email">
                                <label htmlFor="email">{__('Email')} <span
                                    className="required">*</span></label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    required={true}
                                    value={email}
                                    onChange={(e) => setEmail(e.currentTarget.value)} />
                            </p>

                            <p className="comment-form-url">
                                <label htmlFor="website">{__('Website')}</label>
                                <input
                                    type="text"
                                    id="website"
                                    name="website"
                                    value={website}
                                    onChange={(e) => setWebsite(e.currentTarget.value)}
                                />
                            </p>
                        </>
                    ) : ''}

                    <p className="form-submit">
                        <input type="submit" name="submit" id="submit" className="submit"
                            value={__('Post Comment')} />
                    </p>
                </form>
            </div>
        </div>
    )
}
