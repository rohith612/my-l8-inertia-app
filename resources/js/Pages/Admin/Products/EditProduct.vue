<template>
    <app-layout title="createItem">

    <!-- <jet-validation-errors class="mb-4" /> -->

    <div class="max-w-6xl mx-auto py-8 sm:px-6 lg:px-8">
        <div class="block mb-6">
            <Link :href="route('products-master.index')" ><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
            </svg></Link>
        </div>
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" @submit.prevent="submit">

                                <div class="my-4 col-span-6 sm:col-span-4">
                                    
                                    <input type="file" class="hidden" ref="picture_path"  @change="updatePhotoPreview">

                                    <jet-label for="photo" value="Product Image" />

                                    <div class="rounded-md border-2 border-gray-100 overflow-auto">
                                        <div class="m-4">

                                            <div class="my-4" v-show="! photoPreview">
                                                <img :src="product.file_main_url" :alt="product.name" class="h-40 w-40 object-cover border-solid border-4 border-indigo-500 rounded-md">
                                            </div>

                                            <div class="my-4" v-show="photoPreview">
                                                <span class="block w-40 h-40 bg-cover bg-no-repeat bg-center border-solid border-4 border-green-500 rounded-md"
                                                    :style="'background-image: url(\'' + photoPreview + '\');'">
                                                    <button @click.prevent="removeMainPreview">
                                                    <i class="fa fa-times text-red-800 z-20 hover:text-white m-2"></i>
                                                    </button>
                                                </span>
                                            
                                            </div>

                                            <jet-secondary-button class="mt-2 mr-2" type="button" @click.prevent="selectNewPhoto">change image</jet-secondary-button>
                                            <jet-input-error :message="form.errors.picture_path " class="mt-2" />
                                        </div>
                                    </div>

                                </div>

                                <div class="my-4 col-span-6 sm:col-span-4">
                                    <input type="file" class="hidden" ref="additional_imgs" @change="updatePhotosPreview" multiple>

                                    <jet-label for="photo" value="Additional Product Images" />

                                    <div class="rounded-md border-2 border-gray-100 overflow-auto">
                                        <div class="w-8 m-4">

                                            <div class="relative h-12 w-20">
                                                <div class="absolute inset-x-0 top-0 h-12 w-32">
                                                    <jet-secondary-button class="" type="button" @click.prevent="selectMultiplePhoto">Add images</jet-secondary-button>
                                                </div>
                                            </div>

                                            <div class="my-4 flex flex-row space-x-4" v-show="product.additional_images.length">
                                                <div class="border-solid border-4 border-indigo-500 rounded-md"  v-for="(item, index) in product.additional_images" :key="index" >
                                                    <span  class="block w-40 h-40 bg-cover bg-no-repeat bg-center " :style="'background-image: url(\'' + item.file_main_url + '\');'">
                                                         <button @click.prevent="removeAdditionalImage(item.id)">
                                                        <i class="fa fa-times text-red-800 z-20 hover:text-white m-2"></i>
                                                         </button>
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="my-4 flex flex-row space-x-4" v-show="photoPreviews.length">
                                                <div class="border-solid border-4 border-green-500 rounded-md" v-for="(items,index) in photoPreviews" :key="index">
                                                <span  class="block w-40 h-40 bg-cover bg-no-repeat bg-center " :style="'background-image: url(\'' + items + '\');'">
                                                    <button @click.prevent="removeNewAdditionalImage(index)">
                                                        <i class="fa fa-times text-red-800 z-20 hover:text-white m-2"></i>
                                                    </button>
                                                </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <jet-input-error :message="form.errors.additional_imgs" class="mt-2" />
                                </div>

                                <div class="my-4 col-span-6 sm:col-span-4">
                                    <jet-label for="name" value="Name" />
                                    <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" />
                                    <jet-input-error :message="form.errors.name" class="mt-2" />
                                </div>
                                
                                <div class="my-4 col-span-6 sm:col-span-4">
                                    <jet-label for="name" value="Description" />
                                    <textarea class="form-textarea mt-1 block w-full" v-model="form.description" rows="3" placeholder=""></textarea>
                                    <jet-input-error :message="form.errors.description" class="mt-2" />
                                </div>


                                <div class="my-4 col-span-6 sm:col-span-4">
                                    <jet-label for="name" value="Price" />
                                    <jet-input id="price" type="text" class="mt-1 block" v-model="form.price" />
                                    <jet-input-error :message="form.errors.price" class="mt-2" />
                                </div>

                                <div class="my-4 col-span-6 sm:col-span-4">
                                    <jet-label for="name" value="Quantity" />
                                    <jet-input id="quantity" type="text" class="mt-1 block" v-model="form.quantity" />
                                    <jet-input-error :message="form.errors.quantity" class="mt-2" />
                                </div>

                                <div class="my-4 col-span-6 sm:col-span-4">
                                    <jet-label for="name" value="Category" />
                                    <select id="category" name="category" class="mt-1 block" v-model="form.category">
                                    <option value="null" :selected="true" >--SELECT CATEGORY--</option>
                                    <option v-for="(index, item) in categories" :key="index" :value="index">{{ item }}</option>
                                    </select>
                                    <jet-input-error :message="form.errors.category" class="mt-2" />
                                </div>

                                <div class="flex items-center justify-end px-4 py-3 text-right ">
                                    <button type="submit"
                                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                                        Save
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
    import JetFormSection from '@/Jetstream/FormSection.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetLabel from '@/Jetstream/Label.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetInputError from '@/Jetstream/InputError.vue'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'



    export default defineComponent({
        components: {
            AppLayout, 
            JetFormSection, 
            JetInput, 
            JetLabel, 
            Link, 
            JetButton, 
            JetInputError, 
            JetSecondaryButton
        },
        props: {
            categories: Object,
            product: Object,
        },
        data() {
            return {
                productId :  this.product.id,
                form: this.$inertia.form({
                    name: this.product.name,
                    description: this.product.description,
                    price: this.product.price,
                    category: this.product.category,
                    quantity: this.product.quantity,
                    picture_path: null,
                    additional_imgs: [] 
                }),
                photoPreview: null,
                photoPreviews: [],
            }
        },
        methods: {
            selectNewPhoto() {
                this.$refs.picture_path.click();
            },
            selectMultiplePhoto(){
                this.$refs.additional_imgs.click();
            },
            updatePhotoPreview() {
                const productImage = this.$refs.picture_path.files[0]
                if (! productImage) return
                this.form.picture_path = productImage
                const reader = new FileReader()
                reader.onload = (e) => {
                    this.photoPreview = e.target.result
                }
                reader.readAsDataURL(productImage)
            },
            updatePhotosPreview(){
                for (let file of this.$refs.additional_imgs.files) {
                    if (! file) continue
                    this.form.additional_imgs.push(file)
                    const reader = new FileReader()
                    reader.onload = (e) => {
                        this.photoPreviews.push(e.target.result)
                    }
                    reader.readAsDataURL(file)
                }
            },
            removeNewAdditionalImage(index){
                if(!this.form.additional_imgs.length || !this.photoPreviews.length) return false
                this.photoPreviews.splice(index, 1)
                this.form.additional_imgs.splice(index, 1)
            },
            removeMainPreview(){
                this.form.picture_path = null;
                this.photoPreview = null
            },
            removeAdditionalImage(imageId){
                if (confirm('Are you sure you want to delete this thing from the database?')) {
                    this.$inertia.post(this.route('products-master.product.remove-additional-image', { product: this.productId, image: imageId }) , {
                            onFinish:() => alert('item removed')
                    })
                } else {
                    return false
                }
                
            },
            submit() {
                this.form.put(this.route('products-master.update', this.productId), {
                    onFinish: () => this.form.reset(),
                })
            }
        },

        
    })
</script>
