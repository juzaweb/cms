import {usePage} from "@inertiajs/react";
import MenuItem from "./menu_item";

export default function PrimaryMenu() {
    const { menu_items }: { menu_items: Array<any> } = usePage().props;

    return (
        <ul className="navbar-nav mr-auto">
            {menu_items && <MenuItem items={menu_items}></MenuItem>}
        </ul>
    );
}
