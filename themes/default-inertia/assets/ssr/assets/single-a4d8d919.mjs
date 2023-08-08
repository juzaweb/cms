import { j as jsx, a as jsxs } from "../ssr.mjs";
import { u as url, _ as __ } from "./functions-7d1a8c11.mjs";
import { Link } from "@inertiajs/react";
import Main from "./main-db1d4148.mjs";
import CommentForm from "./comment-form-4c3eb98d.mjs";
import DynamicSidebar from "./dynamic-sidebar-95d235d2.mjs";
import "react/jsx-runtime";
import "react-dom/server";
import "@inertiajs/react/server";
import "./header-f6b6cb55.mjs";
import "./primary-menu-6770b89b.mjs";
import "./menu_item-c22bc602.mjs";
import "./footer-995c808a.mjs";
import "./footer-links-46318c85.mjs";
import "./fetch-f134b4f2.mjs";
import "axios";
import "react";
import "./comments-2d2731b4.mjs";
import "./show-aca0f914.mjs";
function Single({ post, canonical, comments }) {
  var _a, _b, _c;
  const categories = (_a = post == null ? void 0 : post.taxonomies) == null ? void 0 : _a.filter((item) => item.taxonomy === "categories");
  const tags = ((_b = post.taxonomies) == null ? void 0 : _b.filter((item) => item.taxonomy === "tags")) || null;
  return /* @__PURE__ */ jsx(Main, { children: /* @__PURE__ */ jsx("section", { className: "pb-80", children: /* @__PURE__ */ jsx("div", { className: "container", children: /* @__PURE__ */ jsxs("div", { className: "row", children: [
    /* @__PURE__ */ jsx("div", { className: "col-md-12", children: /* @__PURE__ */ jsx("ul", { className: "breadcrumbs bg-light mb-4", children: /* @__PURE__ */ jsx("li", { className: "breadcrumbs__item", children: /* @__PURE__ */ jsxs(Link, { href: url("/"), className: "breadcrumbs__url", children: [
      /* @__PURE__ */ jsx("i", { className: "fa fa-home" }),
      " ",
      __("Home")
    ] }) }) }) }),
    /* @__PURE__ */ jsxs("div", { className: "col-md-8", children: [
      /* @__PURE__ */ jsxs("div", { className: "wrap__article-detail", children: [
        /* @__PURE__ */ jsxs("div", { className: "wrap__article-detail-title", children: [
          /* @__PURE__ */ jsx("h1", { children: post.title }),
          /* @__PURE__ */ jsx("h3", { children: post.description })
        ] }),
        /* @__PURE__ */ jsx("hr", {}),
        /* @__PURE__ */ jsx("div", { className: "wrap__article-detail-info", children: /* @__PURE__ */ jsxs("ul", { className: "list-inline", children: [
          /* @__PURE__ */ jsxs("li", { className: "list-inline-item", children: [
            /* @__PURE__ */ jsx("span", { children: __("by") }),
            /* @__PURE__ */ jsxs("a", { href: "#", children: [
              (_c = post.author) == null ? void 0 : _c.name,
              ","
            ] })
          ] }),
          /* @__PURE__ */ jsx("li", { className: "list-inline-item", children: /* @__PURE__ */ jsx("span", { className: "text-dark text-capitalize ml-1", children: post.created_at }) }),
          /* @__PURE__ */ jsxs("li", { className: "list-inline-item", children: [
            /* @__PURE__ */ jsx("span", { className: "text-dark text-capitalize ml-1 mr-1", children: __("in") }),
            categories == null ? void 0 : categories.map((item) => /* @__PURE__ */ jsx(Link, { href: item.url, children: item.name }, item.id))
          ] })
        ] }) }),
        /* @__PURE__ */ jsx("div", { className: "wrap__article-detail-image mt-4", children: /* @__PURE__ */ jsx("figure", { children: /* @__PURE__ */ jsx(
          "img",
          {
            src: post.thumbnail,
            alt: post.title,
            className: "img-fluid"
          }
        ) }) }),
        /* @__PURE__ */ jsxs("div", { className: "wrap__article-detail-content", children: [
          /* @__PURE__ */ jsxs("div", { className: "total-views", children: [
            /* @__PURE__ */ jsxs("div", { className: "total-views-read", children: [
              post.views.toString(),
              /* @__PURE__ */ jsx("span", { children: __("views") })
            ] }),
            /* @__PURE__ */ jsxs("ul", { className: "list-inline", children: [
              /* @__PURE__ */ jsxs("span", { className: "share", children: [
                __("share on"),
                ":"
              ] }),
              /* @__PURE__ */ jsx("li", { className: "list-inline-item", children: /* @__PURE__ */ jsxs(
                "a",
                {
                  className: "btn btn-social-o facebook",
                  href: `https://www.facebook.com/sharer/sharer.php?u=${canonical}&t=${post.title}`,
                  children: [
                    /* @__PURE__ */ jsx("i", { className: "fa fa-facebook-f" }),
                    /* @__PURE__ */ jsx("span", { children: "facebook" })
                  ]
                }
              ) }),
              /* @__PURE__ */ jsx("li", { className: "list-inline-item", children: /* @__PURE__ */ jsxs(
                "a",
                {
                  className: "btn btn-social-o twitter",
                  href: `https://twitter.com/intent/tweet?url=${canonical}&text=${post.title}`,
                  children: [
                    /* @__PURE__ */ jsx("i", { className: "fa fa-twitter" }),
                    /* @__PURE__ */ jsx("span", { children: "twitter" })
                  ]
                }
              ) }),
              /* @__PURE__ */ jsx("li", { className: "list-inline-item", children: /* @__PURE__ */ jsxs(
                "a",
                {
                  className: "btn btn-social-o telegram",
                  href: `https://t.me/share/url?url=${canonical}&text=${post.title}`,
                  children: [
                    /* @__PURE__ */ jsx("i", { className: "fa fa-telegram" }),
                    /* @__PURE__ */ jsx("span", { children: "telegram" })
                  ]
                }
              ) }),
              /* @__PURE__ */ jsx("li", { className: "list-inline-item", children: /* @__PURE__ */ jsxs(
                "a",
                {
                  className: "btn btn-linkedin-o linkedin",
                  href: `https://www.linkedin.com/shareArticle?url=${canonical}&mini=true`,
                  children: [
                    /* @__PURE__ */ jsx("i", { className: "fa fa-linkedin" }),
                    /* @__PURE__ */ jsx("span", { children: "linkedin" })
                  ]
                }
              ) })
            ] })
          ] }),
          /* @__PURE__ */ jsx("div", { dangerouslySetInnerHTML: { __html: (post == null ? void 0 : post.content) || "" } })
        ] })
      ] }),
      /* @__PURE__ */ jsx("div", { className: "blog-tags", children: /* @__PURE__ */ jsxs("ul", { className: "list-inline", children: [
        /* @__PURE__ */ jsx("li", { className: "list-inline-item", children: /* @__PURE__ */ jsx("i", { className: "fa fa-tags" }) }),
        tags && tags.map((item) => /* @__PURE__ */ jsx("li", { className: "list-inline-item", children: /* @__PURE__ */ jsx(Link, { href: item.url, children: item.name }) }, item.id))
      ] }) }),
      /* @__PURE__ */ jsx(CommentForm, { post, comments }),
      /* @__PURE__ */ jsx("div", { className: "clearfix" })
    ] }),
    /* @__PURE__ */ jsx("div", { className: "col-md-4", children: /* @__PURE__ */ jsx("div", { className: "sticky-top", children: /* @__PURE__ */ jsx(DynamicSidebar, {}) }) })
  ] }) }) }) });
}
export {
  Single as default
};
