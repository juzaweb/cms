import { a as jsxs, F as Fragment, j as jsx } from "../ssr.mjs";
import { usePage } from "@inertiajs/react";
import FooterLinks from "./footer-links-46318c85.mjs";
import "react/jsx-runtime";
import "react-dom/server";
import "@inertiajs/react/server";
import "./fetch-f134b4f2.mjs";
import "axios";
import "react";
function Footer() {
  const { config } = usePage().props;
  return /* @__PURE__ */ jsxs(Fragment, { children: [
    /* @__PURE__ */ jsx("section", { className: "wrapper__section p-0", children: /* @__PURE__ */ jsx("div", { className: "wrapper__section__components", children: /* @__PURE__ */ jsxs("footer", { children: [
      /* @__PURE__ */ jsxs("div", { className: "wrapper__footer bg__footer-dark pb-0", children: [
        /* @__PURE__ */ jsx("div", { className: "container", children: /* @__PURE__ */ jsxs("div", { className: "row", children: [
          /* @__PURE__ */ jsx("div", { className: "col-md-3" }),
          /* @__PURE__ */ jsx("div", { className: "col-md-3" }),
          /* @__PURE__ */ jsx("div", { className: "col-md-3" }),
          /* @__PURE__ */ jsx("div", { className: "col-md-3" })
        ] }) }),
        /* @__PURE__ */ jsx("div", { className: "mt-4", children: /* @__PURE__ */ jsx("div", { className: "container", children: /* @__PURE__ */ jsxs("div", { className: "row", children: [
          /* @__PURE__ */ jsx("div", { className: "col-md-4", children: /* @__PURE__ */ jsx("figure", { className: "image-logo", children: /* @__PURE__ */ jsx("img", { src: config.logo, alt: "", className: "logo-footer" }) }) }),
          /* @__PURE__ */ jsx("div", { className: "col-md-8 my-auto ", children: /* @__PURE__ */ jsx("div", { className: "social__media", children: /* @__PURE__ */ jsxs("ul", { className: "list-inline", children: [
            /* @__PURE__ */ jsx("li", { className: "list-inline-item", children: /* @__PURE__ */ jsx(
              "a",
              {
                href: "#",
                className: "btn btn-social rounded text-white facebook",
                children: /* @__PURE__ */ jsx("i", { className: "fa fa-facebook" })
              }
            ) }),
            /* @__PURE__ */ jsx("li", { className: "list-inline-item", children: /* @__PURE__ */ jsx(
              "a",
              {
                href: "#",
                className: "btn btn-social rounded text-white twitter",
                children: /* @__PURE__ */ jsx("i", { className: "fa fa-twitter" })
              }
            ) }),
            /* @__PURE__ */ jsx("li", { className: "list-inline-item", children: /* @__PURE__ */ jsx(
              "a",
              {
                href: "#",
                className: "btn btn-social rounded text-white whatsapp",
                children: /* @__PURE__ */ jsx("i", { className: "fa fa-whatsapp" })
              }
            ) }),
            /* @__PURE__ */ jsx("li", { className: "list-inline-item", children: /* @__PURE__ */ jsx(
              "a",
              {
                href: "#",
                className: "btn btn-social rounded text-white telegram",
                children: /* @__PURE__ */ jsx("i", { className: "fa fa-telegram" })
              }
            ) }),
            /* @__PURE__ */ jsx("li", { className: "list-inline-item", children: /* @__PURE__ */ jsx(
              "a",
              {
                href: "#",
                className: "btn btn-social rounded text-white linkedin",
                children: /* @__PURE__ */ jsx("i", { className: "fa fa-linkedin" })
              }
            ) })
          ] }) }) })
        ] }) }) })
      ] }),
      /* @__PURE__ */ jsx("div", { className: "wrapper__footer-bottom bg__footer-dark", children: /* @__PURE__ */ jsx("div", { className: "container ", children: /* @__PURE__ */ jsx("div", { className: "row", children: /* @__PURE__ */ jsx("div", { className: "col-md-12", children: /* @__PURE__ */ jsx("div", { className: "border-top-1 bg__footer-bottom-section", children: /* @__PURE__ */ jsx(FooterLinks, {}) }) }) }) }) })
    ] }) }) }),
    /* @__PURE__ */ jsx("a", { href: "", id: "return-to-top", children: /* @__PURE__ */ jsx("i", { className: "fa fa-chevron-up" }) })
  ] });
}
export {
  Footer as default
};
