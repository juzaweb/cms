import {__} from '@/helpers/functions'
import {Post} from "@/types/posts";
import {Link} from "@inertiajs/react";

export default function Content({ post }: {post: Post}) {
    return (
        <div className="article__entry">
            <div className="article__image">
                <a href={ post.url } title={ post.title }>
                    <img src={ post.thumbnail } alt={ post.title } className="img-fluid" />
                </a>
            </div>

            <div className="article__content">
                {post.taxonomies?.map((taxonomy) => {
                    return (
                        <div className="article__category">
                            {taxonomy.name}
                        </div>
                    )
                })}

                <ul className="list-inline">
                    <li className="list-inline-item">
                        <span className="text-primary">
                            {__('by')} {post.author?.name}
                        </span>
                    </li>

                    <li className="list-inline-item">
                        <span className="text-dark text-capitalize">
                            {post.created_at}
                        </span>
                    </li>
                </ul>

                <h5>
                    <Link href={ post.url } title={ post.title }>
                        {post.title}
                    </Link>
                </h5>

                <p>{post.description}</p>

                <Link href={ post.url } className="btn btn-outline-primary mb-4 text-capitalize">{ __('read more') }</Link>
            </div>
        </div>
    );
}
