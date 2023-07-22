import { Head } from '@inertiajs/react'
import Main from "./layouts/main";

export default function Index({ title }) {
    return (
        <Main>
            <Head>
                <title>{title}</title>
            </Head>
            <h1>Welcome</h1>
            <p>welcome to your first Inertia app!</p>
        </Main>
    )
}
