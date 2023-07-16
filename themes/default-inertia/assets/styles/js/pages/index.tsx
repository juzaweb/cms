import { Head } from '@inertiajs/react'

export default function index({ posts }: {posts: any}) {
    return (
        <>
            <Head title="Welcome" />
            <h1>Welcome</h1>

            {posts.data.map((item: any) => {
                return <p key={item.id}>{item.title}</p>
            })}
        </>
    )
}
