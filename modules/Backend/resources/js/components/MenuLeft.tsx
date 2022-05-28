import React, { useEffect } from 'react'
import { usePage, Link } from '@inertiajs/inertia-react'
import {Page, PageProps} from "@inertiajs/inertia";

interface MenuLeftPageProps extends Page<PageProps>
{
    props: {
        menuItems?: Array<any>; //Add Interface Object MenuItem
        adminPrefix?: string;
        errors: any;
    }
}

export default function MenuLeft() {
    const { menuItems, adminPrefix } = usePage<MenuLeftPageProps>().props

    return (
        <>
            <ul className="juzaweb__menuLeft__navigation">
            {
                menuItems.map((item, index) => {
                    if (item.children) {
                        return (
                            <li key={item.key} className={"juzaweb__menuLeft__item juzaweb__menuLeft__submenu juzaweb__menuLeft__item-"+ item.slug +" "+(item.active ? 'juzaweb__menuLeft__submenu--toggled' : '')}>
                                <span className="juzaweb__menuLeft__item__link">
                                    <i className={"juzaweb__menuLeft__item__icon "+ item.icon}></i>
                                    <span className="juzaweb__menuLeft__item__title">{item.title}</span>
                                </span>

                                <ul className="juzaweb__menuLeft__navigation">
                                    {
                                        item.children.map((child, index) => {
                                            return (
                                                <li key={child.key} className={"juzaweb__menuLeft__item juzaweb__menuLeft__item-"+child.slug}>
                                                    <Link className={"juzaweb__menuLeft__item__link "+(child.active ? 'juzaweb__menuLeft__item--active' : '')} href={child.url} >

                                                        <span className="juzaweb__menuLeft__item__title">{child.title}</span>

                                                        <i className={"juzaweb__menuLeft__item__icon "+ child.icon}></i>
                                                    </Link>
                                                </li>
                                            )
                                        })
                                    }
                                </ul>
                            </li>
                        )
                    } else {
                        return (
                            <li key={item.key} className="juzaweb__menuLeft__item juzaweb__menuLeft__item-{{ $item->get('slug') }}">
                                <Link className={"juzaweb__menuLeft__item__link "+(item.active ? 'juzaweb__menuLeft__item--active' : '')} href={item.url} >

                                    <span className="juzaweb__menuLeft__item__title">{item.title}</span>

                                    <i className={"juzaweb__menuLeft__item__icon "+ item.icon}></i>
                                </Link>
                            </li>
                        )
                    }
                })
            }
            </ul>
        </>
    )
}
