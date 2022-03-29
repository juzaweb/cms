<template>
    <div class="form-group">
        <label class="col-form-label" :for="id || name">
            {{ label || name }} <abbr v-if="required">*</abbr>
        </label>

        <Editor
                api-key="no-api-key"
                :init="{
                 height: 400,
                 menubar: false,
                 plugins: [
                   'advlist autolink lists link image charmap print preview anchor',
                   'searchreplace visualblocks code fullscreen',
                   'insertdatetime media table paste code help wordcount'
                 ],
                 toolbar:
                   'undo redo | formatselect | bold italic backcolor | \
                   alignleft aligncenter alignright alignjustify | \
                   bullist numlist outdent indent | removeformat | help'
               }"
        />
    </div>
</template>

<script>
    import Editor from '@tinymce/tinymce-vue'

    export default {
        name: 'EditorField',
        components: {
            Editor
        },
        props: {
            modelValue: [String, Array], // previously was `value: String`
            id: {
                type: String,
                default: ''
            },
            name: {
                type: String,
                default: ''
            },
            label: {
                type: String,
                default: ''
            },
            required: {
                type: Boolean,
                default: false
            }
        }
    }
</script>