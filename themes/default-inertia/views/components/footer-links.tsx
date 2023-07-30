import { getMenu } from "@/helpers/fetch";
import { MenuItem } from "@/types/menu";
import {Link, usePage} from "@inertiajs/react";
import { useEffect, useState } from "react";

export default function FooterLinks() {
    const { config } = usePage<{ config: {title: string}}>().props;
    const [menus, setMenus] = useState<Array<MenuItem>>([]);

    useEffect(() => {
        getMenu({location: 'footer_links'}).then(res => {
            setMenus(res.data.items);
        })
    }, []);

    return (
        <ul className="list-inline">
            <li className="list-inline-item">
                <span>
                    Copyright © 2021
                    <Link href="/">{config.title}</Link>
                </span>
            </li>

            {menus.map(item => {
                return (
                    <li className="list-inline-item" key={item.id}>
                        <Link href={item.link}>{item.label}</Link>
                    </li>
                )
            })}
        </ul>
    )
}
