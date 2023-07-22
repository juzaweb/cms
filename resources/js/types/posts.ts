export type Taxonomy = {
    id: string
    name: string
    slug: string
    taxonomy: string
    thumbnail: string
    total_post: string
    level: Number
}

export type PostMeta = {
    meta_key: string
    meta_value?: string
}

export type Post = {
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

export type Comment = {
    id: string
    name: string
    content?: string
    created_at?: string
}
