export interface Taxonomy {
    url: any;
    id: string,
    name: string,
    slug: string,
    taxonomy: string,
    thumbnail: string,
    total_post: string,
    level: Number,
}

export interface PostMeta {
    meta_key: string
    meta_value?: string
}

export interface Post {
    id: string
    title: string
    slug: string
    url: string
    status: string
    thumbnail?: string
    description?: string
    created_at?: string
    rating: Number
    total_comment: Number
    total_rating: Number
    views: Number
    type: string
    updated_at?: string
    taxonomies?: Array<Taxonomy>
    metas?: Array<PostMeta>
    content?: string
    author?: {
        avatar?: string
        name: string
    }
}

export interface Comment {
    id: string
    name: string
    avatar?: string
    content?: string
    created_at?: string
}

export interface CommentMeta {
    meta_key: string
    meta_value?: string
}

export interface PostPaginate {
    meta: {
        current_page: Number
        from: Number
        last_page: Number
        path: string
        per_page: Number
        to: Number
        total: Number
        links: {
            first: string
            last: string
            next?: string
            prev?: string
        }
    }
    data: Array<Post>
}

export interface CommentPaginate {
    meta: {
        current_page: Number
        from: Number
        last_page: Number
        path: string
        per_page: Number
        to: Number
        total: Number
        links: {
            first: string
            last: string
            next?: string
            prev?: string
        }
    }
    data: Array<Comment>
}
