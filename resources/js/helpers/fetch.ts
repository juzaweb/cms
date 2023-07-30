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

export interface MenuOptions {
    location: string
}

/**
 * Retrieves related posts for a given post.
 *
 * @param {Post} post - The post object for which to retrieve related posts.
 * @param {RelatedPostOptions} [options] - The options for retrieving related posts. Default is {limit: 10}.
 * @returns {Promise<any>} - A promise that resolves to the response containing the related posts.
 */
export async function getRelatedPosts(post: Post, options: RelatedPostOptions = {limit: 10}) {
    const res = await axios.get('/ajax/related-posts?post_slug='+ post.slug);

    return res;
}

/**
 * Retrieves the menu for the specified location.
 *
 * @param {MenuOptions} options - The options for retrieving the menu.
 * @return {Promise<any>} A Promise that resolves to the menu data.
 */
export async function getMenu(options: MenuOptions) {
    const res = await axios.get('/ajax/menu?location='+ options.location);

    return res;
}

/**
 * Logs in a user with the given email and password.
 *
 * @param {string} email - The user's email address.
 * @param {string} password - The user's password.
 * @param {boolean} remember - (optional) Indicates if the user wants to be remembered.
 * @return {Promise<any>} A promise that resolves to the server response.
 */
export async function login(email:string, password:string, remember:boolean = true) {
    const res = await axios.post('/auth/login', { email: email, password: password, remember: remember ? 1 : 0 });

    return res;
}

export async function getSidebar(name: string) {
    const res = await axios.get(`/ajax/sidebar?sidebar=${name}`);

    return res;
}
