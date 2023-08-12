import axios from "axios";
async function postComment(post, content, name, email, website) {
  const res = await axios.post(post.url, { content, name, email, website });
  return res;
}
async function getRelatedPosts(post, options = { limit: 10 }) {
  const res = await axios.get("/ajax/related-posts?post_slug=" + post.slug);
  return res;
}
async function getMenu(options) {
  const res = await axios.get("/ajax/menu?location=" + options.location);
  return res;
}
async function login(email, password, remember = true) {
  const res = await axios.post("/auth/login", { email, password, remember: remember ? 1 : 0 });
  return res;
}
async function getSidebar(name) {
  const res = await axios.get(`/ajax/sidebar?sidebar=${name}`);
  return res;
}
export {
  getMenu as a,
  getSidebar as b,
  getRelatedPosts as g,
  login as l,
  postComment as p
};
