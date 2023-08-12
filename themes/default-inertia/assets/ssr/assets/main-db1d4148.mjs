import { a as jsxs, F as Fragment, j as jsx } from "../ssr.mjs";
import Header from "./header-f6b6cb55.mjs";
import Footer from "./footer-995c808a.mjs";
import { usePage, Head } from "@inertiajs/react";
import "react/jsx-runtime";
import "react-dom/server";
import "@inertiajs/react/server";
import "./functions-7d1a8c11.mjs";
import "./primary-menu-6770b89b.mjs";
import "./menu_item-c22bc602.mjs";
import "./footer-links-46318c85.mjs";
import "./fetch-f134b4f2.mjs";
import "axios";
import "react";
function Main({ children }) {
  const { title, description, canonical } = usePage().props;
  return /* @__PURE__ */ jsxs(Fragment, { children: [
    /* @__PURE__ */ jsxs(Head, { children: [
      /* @__PURE__ */ jsx("title", { children: title }),
      /* @__PURE__ */ jsx("meta", { property: "og:title", content: title }),
      /* @__PURE__ */ jsx("meta", { property: "og:type", content: "website" }),
      canonical ? /* @__PURE__ */ jsx("meta", { property: "og:url", content: canonical }) : "",
      /* @__PURE__ */ jsx("meta", { property: "og:description", content: description }),
      /* @__PURE__ */ jsx("meta", { name: "description", content: description }),
      /* @__PURE__ */ jsx("meta", { property: "twitter:title", content: title }),
      /* @__PURE__ */ jsx("meta", { property: "twitter:description", content: description })
    ] }),
    /* @__PURE__ */ jsx(Header, {}),
    children,
    /* @__PURE__ */ jsx(Footer, {})
  ] });
}
export {
  Main as default
};
