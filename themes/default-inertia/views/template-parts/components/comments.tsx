import {__} from "@/helpers/functions";
import {CommentPaginate} from "@/types/posts";
import {Link} from "@inertiajs/react";

export default function Comments({comments}: {comments?: CommentPaginate}) {
    return comments && (
        <>
            <h3 className="comments-title">{comments.meta.total.toString()} {__('Comments')}:</h3>

            <ol className="comment-list">
                {comments.data.map((comment) => {
                    return (
                        <li className="comment" key={comment.id}>
                            <aside className="comment-body">
                                <div className="comment-meta">
                                    <div className="comment-author vcard">
                                        <img src={ comment?.avatar } className="avatar" alt="image"/>
                                            <b className="fn">{comment.name}</b>
                                            <span className="says">{__('says')}:</span>
                                    </div>

                                    <div className="comment-metadata">
                                        <a href="#">
                                            <span>{comment.created_at}</span>
                                        </a>
                                    </div>
                                </div>

                                <div className="comment-content">
                                    {comment.content}
                                </div>

                                <div className="reply">
                                    <Link href={`?reply=${comment.id}#comment-form`} className="comment-reply-link">
                                        {__('Reply')}
                                    </Link>
                                </div>
                            </aside>
                        </li>
                    )
                })}
            </ol>
        </>
    )
}
