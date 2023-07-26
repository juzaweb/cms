import { a as jsxs, j as jsx } from "../ssr.mjs";
import { _ as __ } from "./functions-e021afb9.mjs";
import { Link } from "@inertiajs/react";
import "react/jsx-runtime";
import "react-dom/server";
import "@inertiajs/react/server";
function Content({ post }) {
  var _a, _b;
  return /* @__PURE__ */ jsxs("div", { className: "article__entry", children: [
    /* @__PURE__ */ jsx("div", { className: "article__image", children: /* @__PURE__ */ jsx("a", { href: post.url, title: post.title, children: /* @__PURE__ */ jsx("img", { src: post.thumbnail, alt: post.title, className: "img-fluid" }) }) }),
    /* @__PURE__ */ jsxs("div", { className: "article__content", children: [
      (_a = post.taxonomies) == null ? void 0 : _a.map((taxonomy) => {
        return /* @__PURE__ */ jsx("div", { className: "article__category", children: taxonomy.name });
      }),
      /* @__PURE__ */ jsxs("ul", { className: "list-inline", children: [
        /* @__PURE__ */ jsx("li", { className: "list-inline-item", children: /* @__PURE__ */ jsxs("span", { className: "text-primary", children: [
          __("by"),
          " ",
          (_b = post.author) == null ? void 0 : _b.name
        ] }) }),
        /* @__PURE__ */ jsx("li", { className: "list-inline-item", children: /* @__PURE__ */ jsx("span", { className: "text-dark text-capitalize", children: post.created_at }) })
      ] }),
      /* @__PURE__ */ jsx("h5", { children: /* @__PURE__ */ jsx(Link, { href: post.url, title: post.title, children: post.title }) }),
      /* @__PURE__ */ jsx("p", { children: post.description }),
      /* @__PURE__ */ jsx(Link, { href: post.url, className: "btn btn-outline-primary mb-4 text-capitalize", children: __("read more") })
    ] })
  ] });
}
export {
  Content as default
};
