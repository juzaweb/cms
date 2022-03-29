<template>
    <app-layout :title="$page.props.title">
        <div class="row">
            <div class="col-md-9">
                <InputField :label="$page.props.lang.title" name="title" />

                <EditorField :label="$page.props.lang.content" name="content" />
            </div>

            <div class="col-md-3">

            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue';
    import AppLayout from '@/Layouts/AppLayout.vue';
    import { Link } from '@inertiajs/inertia-vue3';
    import InputField from '@/Components/Fields/InputField';
    import EditorField from '@/Components/Fields/EditorField';
    import SelectField from '@/Components/Fields/SelectField';

    export default defineComponent({
        components: {
            AppLayout,
            Link,
            InputField,
            EditorField,
            SelectField,
        }
    })
</script>
