import {upload_url} from "@/helpers/functions";

export default function Show({ data }: { data: any }) {
    return (
        <aside className="wrapper__list__article">
            <h4 className="border_section">{data.title}</h4>
            <a href={ data.link } target={'_blank'}>
                <figure>
                    <img src={ upload_url(data.banner) } alt="" className="img-fluid"/>
                </figure>
            </a>
        </aside>
    );
}
