<template>
    <app-layout :title="$page.props.title">
        <div class="row">
            <div class="col-md-9">
                <InputField name="title" />

                <SelectField name="name" />

                <EditorField api-key='your-api-key' :init="{ /* your other settings */ }" />
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
    import InputField from '@/Fields/InputField';
    import EditorField from '@/Fields/EditorField';
    import SelectField from '@/Fields/SelectField';

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
