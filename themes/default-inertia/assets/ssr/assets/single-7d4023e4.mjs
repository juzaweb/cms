import { j as jsx, a as jsxs } from "../ssr.mjs";
import { u as url, _ as __ } from "./functions-e021afb9.mjs";
import { Link } from "@inertiajs/react";
import Main from "./main-187d38ba.mjs";
import "react/jsx-runtime";
import "react-dom/server";
import "@inertiajs/react/server";
import "./header-513d9ecb.mjs";
import "./footer-3e174a1c.mjs";
function Single({ post, title }) {
  var _a;
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
              (_a = post.author) == null ? void 0 : _a.name,
              ","
            ] })
          ] }),
          /* @__PURE__ */ jsx("li", { className: "list-inline-item", children: /* @__PURE__ */ jsx("span", { className: "text-dark text-capitalize ml-1", children: post.created_at }) }),
          /* @__PURE__ */ jsx("li", { className: "list-inline-item", children: /* @__PURE__ */ jsx("span", { className: "text-dark text-capitalize", children: __("in") }) })
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
              post.views,
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
                  href: "https://www.facebook.com/sharer.php?u={{ url()->current() }}",
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
                  href: "https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ $title }}",
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
                  href: "https://t.me/share/url?url={{ url()->current() }}&text={{ $title }}",
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
                  href: "https://www.linkedin.com/sharing/share-offsite/?url={{ url()->current() }}",
                  children: [
                    /* @__PURE__ */ jsx("i", { className: "fa fa-linkedin" }),
                    /* @__PURE__ */ jsx("span", { children: "linkedin" })
                  ]
                }
              ) })
            ] })
          ] }),
          post.content
        ] })
      ] }),
      /* @__PURE__ */ jsx("div", { className: "blog-tags", children: /* @__PURE__ */ jsx("ul", { className: "list-inline", children: /* @__PURE__ */ jsx("li", { className: "list-inline-item", children: /* @__PURE__ */ jsx("i", { className: "fa fa-tags" }) }) }) }),
      /* @__PURE__ */ jsx("div", { className: "clearfix" })
    ] }),
    /* @__PURE__ */ jsx("div", { className: "col-md-4", children: /* @__PURE__ */ jsx("div", { className: "sticky-top" }) })
  ] }) }) }) });
}
export {
  Single as default
};
