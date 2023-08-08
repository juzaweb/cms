import { j as jsx } from "../ssr.mjs";
import { b as getSidebar } from "./fetch-f134b4f2.mjs";
import { useState, useEffect } from "react";
import Show from "./show-aca0f914.mjs";
import "react/jsx-runtime";
import "react-dom/server";
import "@inertiajs/react";
import "@inertiajs/react/server";
import "axios";
import "./functions-7d1a8c11.mjs";
function DynamicSidebar() {
  const [sidebar, setSidebar] = useState();
  useEffect(() => {
    getSidebar("sidebar").then(
      (res) => {
        setSidebar(res.data);
      }
    );
  }, []);
  return sidebar && sidebar.config && sidebar.config.map((item) => {
    switch (item.widget) {
      case "banner":
        return /* @__PURE__ */ jsx(Show, { data: item }, item.id);
      default:
        return "";
    }
  });
}
export {
  DynamicSidebar as default
};
