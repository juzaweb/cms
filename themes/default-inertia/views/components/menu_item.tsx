import {Link} from "@inertiajs/react";

export default function MenuItem({items}: {items: Array<any>}) {
    return items.map((item) => {
        return (
            <li key={item.id} className={'nav-item'+ (item.children ? ' dropdown has-submenu menu-large hidden-md-down hidden-sm-down hidden-xs-down' : '')}>
                {item.children ? (
                        <>
                            <Link className={'nav-link dropdown-toggle'}
                               href={ item.link }
                               id={`dropdown-${item.id}`}
                               data-toggle="dropdown"
                               aria-haspopup="true"
                               aria-expanded="false"
                            >{ item.label }</Link>
                            <ul className="dropdown-menu megamenu" aria-labelledby={`dropdown-${item.id}`}>
                                <MenuItem items={item.children}></MenuItem>
                            </ul>
                        </>
                ) : (
                    <Link className={'nav-link'} href={ item.link }>{ item.label }</Link>
                )}
            </li>
        )
    })
}
