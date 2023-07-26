import { a as jsxs, F as Fragment, j as jsx } from "../ssr.mjs";
import Header from "./header-513d9ecb.mjs";
import Footer from "./footer-3e174a1c.mjs";
import { usePage, Head } from "@inertiajs/react";
import "react/jsx-runtime";
import "react-dom/server";
import "@inertiajs/react/server";
import "./functions-e021afb9.mjs";
function Main({ children }) {
  const { title, description, canonical } = usePage().props;
  return /* @__PURE__ */ jsxs(Fragment, { children: [
    /* @__PURE__ */ jsxs(Head, { children: [
      /* @__PURE__ */ jsx("title", { children: title }),
      /* @__PURE__ */ jsx("meta", { property: "og:title", content: title }),
      /* @__PURE__ */ jsx("meta", { property: "og:type", content: "website" }),
      /* @__PURE__ */ jsx("meta", { property: "og:url", content: canonical }),
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
