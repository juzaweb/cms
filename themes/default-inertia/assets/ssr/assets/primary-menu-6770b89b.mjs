import { j as jsx } from "../ssr.mjs";
import { usePage } from "@inertiajs/react";
import MenuItem from "./menu_item-c22bc602.mjs";
import "react/jsx-runtime";
import "react-dom/server";
import "@inertiajs/react/server";
function PrimaryMenu() {
  const { menu_items } = usePage().props;
  return /* @__PURE__ */ jsx("ul", { className: "navbar-nav mr-auto", children: menu_items && /* @__PURE__ */ jsx(MenuItem, { items: menu_items }) });
}
export {
  PrimaryMenu as default
};
