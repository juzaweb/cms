import { a as jsxs, j as jsx } from "../ssr.mjs";
import { a as getMenu } from "./fetch-f134b4f2.mjs";
import { usePage, Link } from "@inertiajs/react";
import { useState, useEffect } from "react";
import "react/jsx-runtime";
import "react-dom/server";
import "@inertiajs/react/server";
import "axios";
function FooterLinks() {
  const { config } = usePage().props;
  const [menus, setMenus] = useState([]);
  useEffect(() => {
    getMenu({ location: "footer_links" }).then((res) => {
      setMenus(res.data.items);
    });
  }, []);
  return /* @__PURE__ */ jsxs("ul", { className: "list-inline", children: [
    /* @__PURE__ */ jsx("li", { className: "list-inline-item", children: /* @__PURE__ */ jsxs("span", { children: [
      "Copyright © 2021",
      /* @__PURE__ */ jsx(Link, { href: "/", children: config.title })
    ] }) }),
    menus.map((item) => {
      return /* @__PURE__ */ jsx("li", { className: "list-inline-item", children: /* @__PURE__ */ jsx(Link, { href: item.link, children: item.label }) }, item.id);
    })
  ] });
}
export {
  FooterLinks as default
};
