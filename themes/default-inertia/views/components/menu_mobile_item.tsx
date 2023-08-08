import {Link} from "@inertiajs/react";

export default function MenuMobileItem({items}: { items: any }) {
    return items.map((item: any) => {
        return (
            <li className="nav-item {% if item.children %} dropdown {% endif %}">
                {item.children ? (
                    <>
                        <a className="nav-link active dropdown-toggle text-dark"
                           href={item.link} data-toggle="dropdown">
                            {item.label}
                        </a>

                        <ul className="dropdown-menu dropdown-menu-left">
                            {item.children.map((child: any) => (
                                <li>
                                    <Link className="dropdown-item text-dark" href={child.link}>{child.label}</Link>
                                </li>
                            ))}
                        </ul>
                    </>
                ) : (
                    <a className="nav-link active text-dark"
                       href={item.link}>
                        {item.label}
                    </a>
                )}
            </li>
        )
    })
}

