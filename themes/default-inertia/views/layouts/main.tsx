import React from "react";
import Header from "../header";
import Footer from "../footer";
import {usePage, Head} from "@inertiajs/react";

export default function Main({children}: {children: React.ReactNode}) {
    const {title, description, canonical}: {title: string, description: string, canonical?: string} = usePage().props;

    return (
        <>
            <Head>
                <title>{title}</title>
                <meta property="og:title" content={ title }/>
                <meta property="og:type" content="website"/>
                {canonical ? <meta property="og:url" content={canonical}/>: ''}
                <meta property="og:description" content={ description }/>
                <meta name="description" content={ description }/>
                <meta property="twitter:title" content={ title }/>
                <meta property="twitter:description" content={ description }/>
            </Head>

            <Header/>
            {children}
            <Footer/>
        </>
    );
}
