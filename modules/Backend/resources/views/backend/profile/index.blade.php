@extends('cms::layouts.backend')

@section('content')
    <div class="card">
        <div class="card-header card-header-flex flex-column">
            <div class="d-flex flex-wrap kit__profile__info pt-3 pb-4 border-bottom mb-3">
                <div class="mr-5">
                    <div class="text-dark font-size-21 font-weight-bold">David Beckham</div>
                    <div class="text-gray-6">@david100</div>
                </div>
                <div class="mr-5 text-center">
                    <div class="text-dark font-size-21 font-weight-bold">100</div>
                    <div class="text-gray-6">Posts</div>
                </div>
                <div class="mr-5 text-center">
                    <div class="text-dark font-size-21 font-weight-bold">17,256</div>
                    <div class="text-gray-6">Followers</div>
                </div>
            </div>
            <div class="d-flex align-items-stretch mt-auto">
                <ul
                    class="nav nav-tabs nav-tabs-line nav-tabs-line-bold nav-tabs-noborder nav-tabs-stretched"
                >
                    <li class="nav-item">
                        <a
                            class="nav-link active"
                            href="#tab-wall-content"
                            data-toggle="tab"
                            aria-selected="true"
                            id="tab-wall"
                        >Agent Wall</a
                        >
                    </li>
                    <li class="nav-item">
                        <a
                            class="nav-link"
                            href="#tab-messages-content"
                            data-toggle="tab"
                            aria-selected="false"
                            id="tab-messages"
                        >Messages</a
                        >
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tab-settings-content" data-toggle="tab" id="tab-settings"
                        >Settings</a
                        >
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div
                    class="tab-pane fade show active"
                    id="tab-wall-content"
                    role="tabpanel"
                    aria-labelledby="tab-wall-content"
                >
                    <div class="mb-4">
                        <div>
                            <div class="d-flex flex-nowrap align-items-start pt-4">
                                <div class="kit__utils__avatar kit__utils__avatar--size64 mr-4 flex-shrink-0 align-self-start">
                                    <img src="../../components/kit-core/img/avatars/3.jpg" alt="Mary Stanform" />
                                </div>
                                <div class="flex-grow-1">
                                    <div class="kit__g15__contentContainer">
                                        <div class="d-flex flex-wrap mb-2">
                                            <div class="mr-auto">
                                                <div class="text-gray-6">
                                                    <span class="text-dark font-weight-bold">Helen maggie</span> posted
                                                </div>
                                                <div>Few seconds ago</div>
                                            </div>
                                            <div class="nav-item dropdown">
                                                <a
                                                    class="nav-link dropdown-toggle pt-sm-0"
                                                    data-toggle="dropdown"
                                                    href="#"
                                                    role="button"
                                                    aria-haspopup="true"
                                                    aria-expanded="false"
                                                >Actions</a
                                                >
                                                <div class="dropdown-menu dropdown-menu-right" role="menu">
                                                    <a class="dropdown-item" href="javascript:void(0)"
                                                    ><i class="dropdown-icon fe fe-edit"></i> Edit Post</a
                                                    >
                                                    <a class="dropdown-item" href="javascript:void(0)"
                                                    ><i class="dropdown-icon fe fe-trash"></i> Delete Post</a
                                                    >
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="javascript:void(0)"
                                                    ><i class="dropdown-icon fe fe-repeat"></i> Mark as Spam</a
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            Lorem ipsum dolor sit amit,consectetur eiusmdd tempory<br />
                                            incididunt ut labore et dolore magna elit
                                        </div>
                                        <div class="d-flex flex-wrap justify-content-start align-items-start mb-3">
                                            <a class="text-blue mr-3" href="#"><i class="fe fe-heart mr-1"></i> 61 Likes</a>
                                            <a class="text-blue mr-3" href="#"><i class="fe fe-message-square mr-1"></i> 2 Comments</a>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-nowrap align-items-start pt-4">
                                        <div
                                            class="kit__utils__avatar kit__utils__avatar--size64 mr-4 flex-shrink-0 align-self-start"
                                        >
                                            <img src="../../components/kit-core/img/avatars/3.jpg" alt="Mary Stanform" />
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="kit__g15__contentContainer">
                                                <div class="d-flex flex-wrap mb-2">
                                                    <div class="mr-auto">
                                                        <div class="text-gray-6">
                                                            <span class="text-dark font-weight-bold">Helen maggie</span> posted
                                                        </div>
                                                        <div>Few seconds ago</div>
                                                    </div>
                                                    <div class="nav-item dropdown">
                                                        <a
                                                            class="nav-link dropdown-toggle pt-sm-0"
                                                            data-toggle="dropdown"
                                                            href="#"
                                                            role="button"
                                                            aria-haspopup="true"
                                                            aria-expanded="false"
                                                        >Actions</a
                                                        >
                                                        <div class="dropdown-menu dropdown-menu-right" role="menu">
                                                            <a class="dropdown-item" href="javascript:void(0)"
                                                            ><i class="dropdown-icon fe fe-edit"></i> Edit Post</a
                                                            >
                                                            <a class="dropdown-item" href="javascript:void(0)"
                                                            ><i class="dropdown-icon fe fe-trash"></i> Delete Post</a
                                                            >
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item" href="javascript:void(0)"
                                                            ><i class="dropdown-icon fe fe-repeat"></i> Mark as Spam</a
                                                            >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    Lorem ipsum dolor sit amit,consectetur eiusmdd tempory<br />
                                                    incididunt ut labore et dolore magna elit
                                                </div>
                                                <div class="d-flex flex-wrap justify-content-start align-items-start mb-3">
                                                    <a class="text-blue mr-3" href="#"><i class="fe fe-heart mr-1"></i> 61 Likes</a>
                                                    <a class="text-blue mr-3" href="#"
                                                    ><i class="fe fe-message-square mr-1"></i> 2 Comments</a
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-nowrap align-items-start pt-4">
                                        <div
                                            class="kit__utils__avatar kit__utils__avatar--size64 mr-4 flex-shrink-0 align-self-start"
                                        >
                                            <img src="../../components/kit-core/img/avatars/3.jpg" alt="Mary Stanform" />
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="kit__g15__contentContainer">
                                                <div class="d-flex flex-wrap mb-2">
                                                    <div class="mr-auto">
                                                        <div class="text-gray-6">
                                                            <span class="text-dark font-weight-bold">Helen maggie</span> posted
                                                        </div>
                                                        <div>Few seconds ago</div>
                                                    </div>
                                                    <div class="nav-item dropdown">
                                                        <a
                                                            class="nav-link dropdown-toggle pt-sm-0"
                                                            data-toggle="dropdown"
                                                            href="#"
                                                            role="button"
                                                            aria-haspopup="true"
                                                            aria-expanded="false"
                                                        >Actions</a
                                                        >
                                                        <div class="dropdown-menu dropdown-menu-right" role="menu">
                                                            <a class="dropdown-item" href="javascript:void(0)"
                                                            ><i class="dropdown-icon fe fe-edit"></i> Edit Post</a
                                                            >
                                                            <a class="dropdown-item" href="javascript:void(0)"
                                                            ><i class="dropdown-icon fe fe-trash"></i> Delete Post</a
                                                            >
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item" href="javascript:void(0)"
                                                            ><i class="dropdown-icon fe fe-repeat"></i> Mark as Spam</a
                                                            >
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    Lorem ipsum dolor sit amit,consectetur eiusmdd tempory<br />
                                                    incididunt ut labore et dolore magna elit
                                                </div>
                                                <div class="d-flex flex-wrap justify-content-start align-items-start mb-3">
                                                    <a class="text-blue mr-3" href="#"><i class="fe fe-heart mr-1"></i> 61 Likes</a>
                                                    <a class="text-blue mr-3" href="#"
                                                    ><i class="fe fe-message-square mr-1"></i> 2 Comments</a
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
