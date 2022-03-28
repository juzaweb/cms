<template>
    <app-layout :title="$page.props.title">
        <div class="row mb-3">
            <div class="col-md-12">
                <div class="btn-group float-right">
                    <Link :href="$page.props.linkCreate" class="btn btn-success"><i class="fa fa-plus-circle"></i> {{ $page.props.lang.add_new }}</Link>

                    <!--@do_action("post_type.{$setting->get('key')}.btn_group")-->
                </div>
            </div>
        </div>


    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import { Head, Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        components: {
            AppLayout,
            Link,
        }
    })
</script>
