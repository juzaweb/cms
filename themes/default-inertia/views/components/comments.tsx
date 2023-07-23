import {__} from "@/helpers/functions";
import {Comment} from "@/types/posts";

export default function ({comments}: {comments: {data: Array<Comment>}}) {
    return (
        <>
            <h3 className="comments-title">{comments.meta.total} {__('Comments')}:</h3>

            <ol className="comment-list">
                {comments.data.map((comment) => {
                    return (
                        <li className="comment">
                            <aside className="comment-body">
                                <div className="comment-meta">
                                    <div className="comment-author vcard">
                                        <img src={ comment.avatar } className="avatar" alt="image"/>
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
                                    <a href={`?reply=${comment.id}#comment-form`} className="comment-reply-link">
                                        {__('Reply')}
                                    </a>
                                </div>
                            </aside>
                        </li>
                    )
                })}
            </ol>
        </>
    )
}
