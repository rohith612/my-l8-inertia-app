<template>
    <app-layout title="Todo">
        <!-- <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Todos
            </h2>
        </template> -->

        <div class="alert">
            
        </div>

        <div class="max-w-6xl mx-auto py-7 sm:px-6 lg:px-8">
            <div class="block mb-6">
                <!-- <alert-box  v-if="$page.props.flash.success" title="Informational message"  message="$page.props.flash.success" /> -->
                <Link :href="route('products-master.create')">
                <jet-secondary-button class="hover:bg-gray-100 text-black font-bold py-2 px-4 rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>add new 
                </jet-secondary-button></Link>
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
                                        <Link :href="route('products-master.index', { 'key': seachKey } )"><i class="fa fa-search text-gray-400 z-20 hover:text-gray-500"></i></Link> 
                                    </div>
                                </div>
                            </div>

                            <table class="min-w-full divide-y divide-white-200 w-full">
                                <thead>
                                <tr>
                                    <th scope="col" width="50" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SL</th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                     <th scope="col" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                    <th scope="col" width="50" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="(item, index) in products.data" :key="item.id">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ index + 1 }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ item.name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ item.product_code }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ item.price }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ item.quantity }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <Link :href="route('products-master.edit', item.id)" type="button"><jet-secondary-button class="ml-4 hover:bg-gray-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                            <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                            </svg>
                                            </jet-secondary-button></Link>
                                            <jet-secondary-button class="ml-4 hover:bg-red-500" @click="confirmDeletion(item.id)">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>    
                                            </jet-secondary-button></td>
                                    </tr>
                                </tbody>
                            </table>
                            <pagination class="" :links="products.links" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete item modal -->
        <jet-dialog-modal :show="confirmingProductDeletion" @close="closeModal">
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
    import AlertBox from '@/Components/AlertBox.vue'

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
            JetInput,
            AlertBox
        },
        props: {
            products: Object,
            success: String,
            status: Number,
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
                this.$inertia.get(route('products-master.index', { 'key': this.seachKey } ),{})
            },
            clearSearchBar(){
                if(route().params.key){
                    this.$inertia.get(route('products-master.index'),{})
                }else{
                    this.seachKey = null
                }
            },
            confirmDeletion(id) {
                this.itemId = id;
                this.confirmingProductDeletion = true;
            },
            deleteitem() {
                if (!this.itemId) return;
                this.form.delete(route('products-master.destroy', this.itemId), {
                    onSuccess: () => this.closeModal(),
                })
            },
            closeModal() {
                this.itemId = null;
                this.confirmingProductDeletion = false
            },
        }
    })
</script>
