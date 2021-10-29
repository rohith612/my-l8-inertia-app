<template>
    <app-layout title="createItem">

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
                                   
                                   
                                    <div class="rounded-md border-2 border-gray-100 overflow-auto">
                                        <div class="m-4">
                                            <jet-label for="photo" value="Product Image" />

                                            <div class="my-4" v-show="photoPreview">
                                                <span class="block w-40 h-40 bg-cover bg-no-repeat bg-center border-solid border-4 border-green-500 rounded-md"
                                                    :style="'background-image: url(\'' + photoPreview + '\');'">
                                                    <button @click.prevent="removeMainPreview"><i class="fa fa-times text-red-800 z-20 hover:text-white m-2"></i></button>
                                                </span>
                                            
                                            </div>

                                            <jet-secondary-button class="mt-2 mr-2" type="button" @click.prevent="selectNewPhoto">
                                                upload image
                                            </jet-secondary-button>
                                            <jet-input-error :message="form.errors.picture_path " class="mt-2" />
                                        </div>
                                    </div>
                                </div>

                                <div class="my-4 col-span-6 sm:col-span-4">
                                    <input type="file" class="hidden" ref="additional_imgs" @change="updatePhotosPreview" multiple>

                                    <jet-label for="photo" value="Additional Product Image" />


                                    <div class="rounded-md border-2 border-gray-100 overflow-auto">
                                        <div class="w-8 m-4">

                                            <div class="relative h-12 w-20">
                                                <div class="absolute inset-x-0 top-0 h-12 w-32">
                                                    <jet-secondary-button class="" type="button" @click.prevent="selectMultiplePhoto">Add images</jet-secondary-button>
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
    // import JetValidationErrors from '@/Jetstream/ValidationErrors.vue'

    export default defineComponent({
        components: {
            AppLayout, JetFormSection, JetInput, JetLabel, Link, JetButton, JetInputError, JetSecondaryButton
        },
        props: {
            categories: Object,
        },
        data() {
            return {
                form: this.$inertia.form({
                    name: '',
                    description: '',
                    price: '',
                    category: null,
                    quantity: null,
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
                const photo = this.$refs.picture_path.files[0]
                if (! photo) return
                this.form.picture_path = photo
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.photoPreview = e.target.result;
                };
                reader.readAsDataURL(photo);
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
            submit() {
                this.form.post(this.route('products-master.store'), {
                    onFinish: () => this.form.reset(),
                })
            }
        },
    })

    const tabs = document.querySelectorAll(".tabs");
const tab = document.querySelectorAll(".tab");
const panel = document.querySelectorAll(".tab-content");

function onTabClick(event) {

  // deactivate existing active tabs and panel

  for (let i = 0; i < tab.length; i++) {
    tab[i].classList.remove("active");
  }

  for (let i = 0; i < panel.length; i++) {
    panel[i].classList.remove("active");
  }


  // activate new tabs and panel
  event.target.classList.add('active');
  let classString = event.target.getAttribute('data-target');
  console.log(classString);
  document.getElementById('panels').getElementsByClassName(classString)[0].classList.add("active");
}

for (let i = 0; i < tab.length; i++) {
  tab[i].addEventListener('click', onTabClick, false);
}
</script>
