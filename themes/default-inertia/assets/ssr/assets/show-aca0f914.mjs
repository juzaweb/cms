import { a as jsxs, j as jsx } from "../ssr.mjs";
import { a as upload_url } from "./functions-7d1a8c11.mjs";
import "react/jsx-runtime";
import "react-dom/server";
import "@inertiajs/react";
import "@inertiajs/react/server";
function Show({ data }) {
  return /* @__PURE__ */ jsxs("aside", { className: "wrapper__list__article", children: [
    /* @__PURE__ */ jsx("h4", { className: "border_section", children: data.title }),
    /* @__PURE__ */ jsx("a", { href: data.link, target: "_blank", children: /* @__PURE__ */ jsx("figure", { children: /* @__PURE__ */ jsx("img", { src: upload_url(data.banner), alt: "", className: "img-fluid" }) }) })
  ] });
}
export {
  Show as default
};
