import React from "react";
import Header from "../header";
import Footer from "../footer";

export default function Main({ children }) {
    return (
        <>
            <Header />
            {children}
            <Footer />
        </>
    );
}
