<template>
    <div class="form-group">
        <label class="col-form-label" :for="id || name">
            {{ label || name }} <abbr v-if="required">*</abbr>
        </label>

        <input
            type="text"
            autocomplete="off"
            :name="name"
            :class="'form-control ' + (className || '')"
            :id="id || name"
            :value="value || defaultValue || ''"
            :placeholder="placeholder"
        />
    </div>
</template>

<script>
    export default {
        name: 'InputField',
        props: {
            name: String,
            label: String,
            default: String,
            className: String,
            placeholder: String,
            required: Boolean,
            defaultValue: String,
        },
    }
</script>
