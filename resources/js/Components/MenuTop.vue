<template>
    <div class="juzaweb__topbar">
        <div class="mr-4">
            <a href="/" class="mr-2" target="_blank">
                <i class="dropdown-toggle-icon fa fa-home" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Visit website"></i> {{ $page.props.lang.view_website }}
            </a>
        </div>

        <div class="mr-auto">
            <div class="dropdown mr-4 d-none d-sm-block">
                <a href="javascript:void(0)" class="dropdown-toggle text-nowrap" data-toggle="dropdown">
                    <i class="fa fa-plus"></i>
                    <span class="dropdown-toggle-text"> {{ $page.props.lang.new }}</span>
                </a>

                <div class="dropdown-menu" role="menu">
                    <a class="dropdown-item" :href="route('admin.posts.create', ['posts'])"></a>

                    <a class="dropdown-item" :href="route('admin.posts.create', ['pages'])"></a>

                    <!--<a class="dropdown-item" href=""></a>-->

                </div>
            </div>
        </div>

        <div class="juzaweb__topbar__actionsDropdown dropdown mr-4 d-none d-sm-block">
            <a href="javascript:void(0)" class="dropdown-toggle text-nowrap" data-toggle="dropdown" aria-expanded="false" data-offset="0,15">
                <i class="dropdown-toggle-icon fa fa-bell-o"></i>
            </a>


            <div class="juzaweb__topbar__actionsDropdownMenu dropdown-menu dropdown-menu-right" role="menu">
                <div style="width: 350px;">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="jw__l1">
                                <div class="text-uppercase mb-2 text-gray-6 mb-2 font-weight-bold"></div>
                                <hr>
                                <ul class="list-unstyled">

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="dropdown">
            <a href="" class="dropdown-toggle text-nowrap" data-toggle="dropdown" aria-expanded="false" data-offset="5,15">
                <img class="dropdown-toggle-avatar" :src="$page.props.user.avatar" alt="User avatar" width="30" height="30"/>
            </a>

            <div class="dropdown-menu dropdown-menu-right" role="menu">
                <a class="dropdown-item" href="{{ route('admin.users.edit', [$jw_user->id]) }}">
                    <i class="dropdown-icon fe fe-user"></i>

                </a>

                <div class="dropdown-divider"></div>
                <a href="javascript:void(0)" data-turbolinks="false" class="dropdown-item auth-logout">
                    <i class="dropdown-icon fe fe-log-out"></i>
                </a>
            </div>
        </div>
    </div>
</template>


<script>
    import { defineComponent } from 'vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        components: {
            Head,
            Link,
        },

        props: {

        }
    })
</script>
