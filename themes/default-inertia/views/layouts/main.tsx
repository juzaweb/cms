import React from "react";
import Header from "../header";

export default function Main({ children }) {
    return (
        <>
            <Header />
            {children}
        </>
    );
}
