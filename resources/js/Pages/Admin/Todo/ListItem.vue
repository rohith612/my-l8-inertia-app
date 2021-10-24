<template>
    <app-layout title="Todo">
        <!-- <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Todos
            </h2>
        </template> -->

        <div class="max-w-6xl mx-auto py-7 sm:px-6 lg:px-8">
            <div class="block mb-6">
                <Link :href="route('todo-item.create')"><jet-button class="bg-black-500 hover:bg-indigo-400 text-white font-bold py-2 px-4 rounded">Create Item</jet-button></Link>
            </div>

            <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <div class="container flex px-2 py-2">              
                                <div class="relative">
                                    <input type="text" class="h-10 w-96 pr-8 pl-5 rounded z-0 focus:shadow focus:outline-none" v-model="seachKey" placeholder="Search..." @keyup.enter="quickSearch">
                                    <div v-if="seachKey" class="absolute top-2 right-9">
                                        <button @click="clearSearchBar">
                                            <i class="fa fa-times text-gray-400 z-20 hover:text-gray-500"></i>
                                        </button>
                                    </div>
                                    <div class="absolute top-2 right-3"> 
                                        <Link :href="route('todo-item.index', { 'key': seachKey } )">
                                       
                                        <i class="fa fa-search text-gray-400 z-20 hover:text-gray-500"></i>
                                        
                                        </Link> 
                                    </div>
                                </div>
                            </div>

                            <table class="min-w-full divide-y divide-gray-200 w-full">
                                <thead>
                                <tr>
                                    <th scope="col" width="50" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                                    <th scope="col" width="50" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="(item, index) in items.data" :key="item.id">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ index + 1 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ item.name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ item.created_date }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <Link :href="route('todo-item.edit', item.id)" type="button"><jet-button class="ml-4 hover:bg-indigo-400">Edit</jet-button></Link>
                                            <jet-button class="ml-4 hover:bg-indigo-400" @click="confirmUserDeletion(item.id)">Delete </jet-button></td>
                                    </tr>
                                </tbody>
                            </table>
                            <pagination class="" :links="items.links" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete item modal -->
        <jet-dialog-modal :show="confirmingUserDeletion" @close="closeModal">
            <template #title> Delete Item </template>
            <template #content>
                Are you sure you want to delete this item ?
                <div class="mt-4"></div>
            </template>
            <template #footer>
                <jet-secondary-button @click="closeModal">Cancel</jet-secondary-button>
                <jet-danger-button class="ml-2" @click="deleteitem" >Delete</jet-danger-button>
            </template>
        </jet-dialog-modal>


    </app-layout>
</template>
<script>
    import { defineComponent } from 'vue'
    import { Link } from '@inertiajs/inertia-vue3';
    import AppLayout from '@/Layouts/AppLayout.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetFormSection from '@/Jetstream/FormSection.vue'
    import Pagination from '@/Components/Pagination.vue'
    import JetDialogModal from '@/Jetstream/DialogModal.vue'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
    import JetDangerButton from '@/Jetstream/DangerButton.vue'
    import ActionMessage from '@/Jetstream/ActionMessage.vue'
    import JetInput from '@/Jetstream/Input.vue'

    export default defineComponent({
        components: {
            AppLayout,
            Link,
            JetButton,
            JetFormSection,
            Pagination,
            JetDialogModal, 
            JetDangerButton, 
            JetSecondaryButton, 
            ActionMessage,
            JetInput
        },
        props: {
            items: Object,
            success: String,
        },
        data(){
            return{
                confirmingUserDeletion: false,
                itemId : null,
                seachKey : route().params.key ? route().params.key : null,
                form: this.$inertia.form({
                    _method : 'DELETE',
                })
            }
        },
        methods:{
            quickSearch(){
                this.$inertia.get(route('todo-item.index', { 'key': this.seachKey } ),{

                })
            },
            clearSearchBar(){
                if(route().params.key){
                    this.$inertia.get(route('todo-item.index'),{})
                }else{
                    this.seachKey = null
                }
            },
            confirmUserDeletion(id) {
                this.itemId = id;
                this.confirmingUserDeletion = true;
            },
            deleteitem() {
                // if (!confirm('Are you sure want to remove?')) return;
                this.form.delete(route('todo-item.destroy', this.itemId), {
                    onSuccess: () => this.closeModal(),
                })
            },
            closeModal() {
                this.itemId = null;
                this.confirmingUserDeletion = false
            },
        }
    })
</script>
