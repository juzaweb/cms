import { Head } from '@inertiajs/react'

export default function index({ posts }) {
    return (
        <>
            <Head title="Welcome" />
            <h1>Welcome</h1>

            {posts.map((item) => {
                return (<p>{item.title}</p>)
            })}
        </>
    )
}
