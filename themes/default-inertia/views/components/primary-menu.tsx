import {usePage} from "@inertiajs/react";
import MenuItem from "./menu_item";
import { MenuItem as MenuItemType } from "@/types/menu";

export default function PrimaryMenu() {
    const { menu_items } = usePage<{menu_items: Array<MenuItemType>}>().props;

    return (
        <ul className="navbar-nav mr-auto">
            {menu_items && <MenuItem items={menu_items}></MenuItem>}
        </ul>
    );
}
