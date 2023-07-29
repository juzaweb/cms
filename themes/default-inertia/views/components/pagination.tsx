import {Link} from "@inertiajs/react";

export default function Pagination({ data }:{data: any}) {
    return (
        data.meta.last_page > 1 && (
            data.meta.links.map(
                (page, index) => (
                    <Link
                        key={index}
                        href={page.url}
                        className={page.active ? 'active' : ''}
                    >
                        {page.label}
                    </Link>
                )
            )
        )
    );
}
