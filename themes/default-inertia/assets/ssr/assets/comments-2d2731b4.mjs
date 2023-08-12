import { a as jsxs, F as Fragment, j as jsx } from "../ssr.mjs";
import { _ as __ } from "./functions-7d1a8c11.mjs";
import { Link } from "@inertiajs/react";
import "react/jsx-runtime";
import "react-dom/server";
import "@inertiajs/react/server";
function Comments({ comments }) {
  return comments && /* @__PURE__ */ jsxs(Fragment, { children: [
    /* @__PURE__ */ jsxs("h3", { className: "comments-title", children: [
      comments.meta.total.toString(),
      " ",
      __("Comments"),
      ":"
    ] }),
    /* @__PURE__ */ jsx("ol", { className: "comment-list", children: comments.data.map((comment) => {
      return /* @__PURE__ */ jsx("li", { className: "comment", children: /* @__PURE__ */ jsxs("aside", { className: "comment-body", children: [
        /* @__PURE__ */ jsxs("div", { className: "comment-meta", children: [
          /* @__PURE__ */ jsxs("div", { className: "comment-author vcard", children: [
            /* @__PURE__ */ jsx("img", { src: comment == null ? void 0 : comment.avatar, className: "avatar", alt: "image" }),
            /* @__PURE__ */ jsx("b", { className: "fn", children: comment.name }),
            /* @__PURE__ */ jsxs("span", { className: "says", children: [
              __("says"),
              ":"
            ] })
          ] }),
          /* @__PURE__ */ jsx("div", { className: "comment-metadata", children: /* @__PURE__ */ jsx("a", { href: "#", children: /* @__PURE__ */ jsx("span", { children: comment.created_at }) }) })
        ] }),
        /* @__PURE__ */ jsx("div", { className: "comment-content", children: comment.content }),
        /* @__PURE__ */ jsx("div", { className: "reply", children: /* @__PURE__ */ jsx(Link, { href: `?reply=${comment.id}#comment-form`, className: "comment-reply-link", children: __("Reply") }) })
      ] }) }, comment.id);
    }) })
  ] });
}
export {
  Comments as default
};
