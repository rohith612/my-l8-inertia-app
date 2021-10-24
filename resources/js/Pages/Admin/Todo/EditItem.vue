<template>
    <app-layout title="createItem">

    <!-- <jet-validation-errors class="mb-4" /> -->

    <div class="max-w-6xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="block mb-6">
            <Link :href="route('todo-item.index')" >Back to Items</Link> 
        </div>
        <div class="flex flex-col">
               
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" @submit.prevent="submit">
                                <jet-label for="name" value="Name" />
                                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" />
                                <jet-input-error :message="form.errors.name" class="mt-2" />
                                <div class="flex items-center justify-end px-4 py-3 text-right ">
                                    <button type="submit"
                                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                        Update
                                    </button>
                                </div>
                        </form>
                        
                    </div>
            </div>
        </div>
    </div>
    </app-layout>
</template>
<script>
    import { defineComponent } from 'vue'
    import { Link } from '@inertiajs/inertia-vue3'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    // import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'
    import JetFormSection from '@/Jetstream/FormSection.vue'
    import JetInputError from '@/Jetstream/InputError.vue'

    export default defineComponent({
        components: {
            AppLayout, JetButton, JetInput, JetLabel, JetFormSection, Link, JetInputError
        },
        props: {
            item: Object,
        },
        data() {
            return {
                itemId :  this.item.id,
                form: this.$inertia.form({
                    name: this.item.name
                })
            }
        },
        methods: {
            submit() {
                this.form.put(this.route('todo-item.update', this.itemId), {
                    onFinish: () => this.form.reset(),
                })
            },
        }
    })
</script>