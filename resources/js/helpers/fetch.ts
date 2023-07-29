import { Post } from "@/types/posts";
import axios from "axios";

/**
 * Posts a comment on a post.
 *
 * @param {Post} post - the post to comment on
 * @param {string} content - the content of the comment
 * @param {null|string} name - (optional) the name of the commenter
 * @param {null|string} email - (optional) the email of the commenter
 * @param {null|string} website - (optional) the website of the commenter
 * @return {Promise} a promise that resolves with the response from the server
 */
export async function postComment(
    post: Post,
    content: string,
    name?: null|string,
    email?: null|string,
    website?: null|string
) {
    const res = await axios.post(post.url, { content: content, name: name, email: email, website: website });

    return res;
}

export interface RelatedPostOptions {
    limit: number
}

/**
 * Retrieves related posts based on the provided post slug.
 *
 * @param {Post} post - The post object containing the slug.
 * @return {Promise<AxiosResponse>} The response from the AJAX call to retrieve related posts.
 */
export async function getRelatedPosts(post: Post, options: RelatedPostOptions = {limit: 10}) {
    const res = await axios.get('/ajax/related-posts?post_slug='+ post.slug);

    return res;
}
