import React from "react";
import { Inertia } from "@inertiajs/inertia";
import { InertiaLink, usePage } from "@inertiajs/inertia-react";

const Media = () => {
    const { mediaItems } = usePage().props;

    return (
        <div id="media-container">
            <div className="row mb-2">
                <div className="col-md-8">
                    <form action="" method="get" className="form-inline">
                        <input type="text" className="form-control w-25" name="search" placeholder="" autoComplete="off" />

                        <select name="type" className="form-control w-25 ml-1">
                            <option value=""></option>

                        </select>

                        <button type="submit" className="btn btn-primary ml-1">Search</button>
                    </form>
                </div>

                <div className="col-md-4">
                    <div className="btn-group float-right">
                        <a href="" className="btn btn-success" data-toggle="modal" data-target="#add-folder-modal"><i className="fa fa-plus"></i> Folder</a>
                        <a href="" className="btn btn-success" data-toggle="modal" data-target="#upload-modal"><i className="fa fa-cloud-upload"></i> Upload</a>
                    </div>
                </div>
            </div>

            <div className="list-media mt-5">
            <ul className="media-list">
                {mediaItems.map(({ id, name, is_file, thumb }) => (
                    <li key={id} className="media-item">
                        <InertiaLink href="">
                            <div className="attachment-preview">
                                <div className={'thumbnail '+ (is_file ? 'media-folder' : '')}>
                                    <div className="centered">
                                        {thumb && (
                                            <img src={thumb} alt={name} />
                                        )}

                                        {!thumb && (
                                            <i className={'fa '+ icon +' fa-3x'}></i>
                                        )}

                                    </div>
                                </div>
                            </div>
                        </InertiaLink>
                    </li>
                ))}
            </ul>

            {mediaItems.length === 0 && (
                <h4>Media not found</h4>
            )}
            </div>
        </div>
    );
};

export default Media;
