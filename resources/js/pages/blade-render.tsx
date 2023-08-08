export default function BladeRender({ content }: { content: string }) {
    return <div dangerouslySetInnerHTML={{ __html: content }}></div>;
}
