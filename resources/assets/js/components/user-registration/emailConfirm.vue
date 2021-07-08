<template> 
    <div class="row">
        <div class="col mw-560 mx-auto text-center ">
            <h2 class="fs-48 fw-600 mb-4 pb-3 border-bottom border-black">Email Confirmation</h2>            
            <div class="fs-16">
                <div v-if="status==false" class="alert alert-warning" style="margin-top: 8px">
                    {{message_data}}
                </div>
                <div v-if="status==true" class="alert alert-success">
                    {{message_data}}
                           <a :href="nextUrl" class="btn px-5 bg-black text-white" >Go To Remaining Process</a>
                </div>
            </div>

        </div>
    </div>
</template>
<script>
    import {siteUrl, site_root} from './../../Utitlity.js';
    export default {
        name: "email-confirm",
        data() {
            return {
                siteUrl: site_root,
                nextUrl :'',
            }
        },
        watch: {

        },
        computed: {

        },
        components: {

        },
        methods: {
           
        },
        mounted: function () {
           this.nextUrl = this.siteUrl+'/chat-feature/'+this.userid;
        },
        props: ['userid', 'message_data','status']
    }
</script>

