<template>
    <app-layout title="Taxonomy">
        <div class="row">
            <div class="col-md-4">
                <h5>Bảng dữ liệu</h5>
                <div>
                    <bootstrap-table :columns="columns" :data="data" :options="options"></bootstrap-table>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import Welcome from '@/Jetstream/Welcome.vue'

    export default defineComponent({
        components: {
            AppLayout,
            Welcome
        },
        data() {
            return {
                items: [
                    { age: 40, first_name: 'Dickerson', last_name: 'Macdonald' },
                    { age: 21, first_name: 'Larsen', last_name: 'Shaw' },
                    { age: 89, first_name: 'Geneva', last_name: 'Wilson' },
                    { age: 38, first_name: 'Jami', last_name: 'Carney' }
                ]
            }
        }
    })
</script>
