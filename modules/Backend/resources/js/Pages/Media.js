import React from "react";
import { InertiaLink, useForm } from "@inertiajs/inertia-react";

const Media = () => {
    const { data, setData, errors, post } = useForm({
        title: "",
        description: "",
    });

    function handleSubmit(e) {
        e.preventDefault();
        post(route("posts.store"));
    }

    return (
        <div className="mt-20">
adadas
        </div>
    );
};

export default Media;
