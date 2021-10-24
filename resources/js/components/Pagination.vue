 <template>
    <div v-if="links.length > 3">
        <div class="flex flex-wrap -mb-2">
            <template v-for="(link, p) in links" :key="p">
                <div v-if="link.url === null" class="mr-1 mb-1 px-4 py-3 text-sm leading-4 text-gray-400 border rounded"
                    v-html="link.label" />
                <jet-nav-link v-else
                    class="h-10 px-5 text-gray transition-colors duration-150 bg-white-600 focus:shadow-outline"
                    :class="{ 'bg-indigo-400 text-white': link.active }" :href="link.url" v-html="link.label" >
                </jet-nav-link>
            </template>
        </div>
    </div>
</template>
<script>
    import JetNavLink from '@/Jetstream/NavLink.vue'
    export default {
        components:{
            JetNavLink
        },
        props: {
            links: Array
        },
    }
</script>