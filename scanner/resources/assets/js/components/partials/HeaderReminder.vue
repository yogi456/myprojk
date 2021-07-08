<template>  
    <div id="HeaderRemInner" class="btn-accordion m-0 border-0" role="tablist"> 
        <div v-for="(e,i) in events"  class="card p-0 border-0" v-bind:data-vv-scope="'form-'+i"  >
            <div class="col-auto d-flex flex-column icon-vertical py-3">
                <div><p><img v-bind:src="siteUrl+'images/envelop-fill.png'"/></p></div>
            </div>
            <div class="card-header p-0" role="tab" v-bind:id="'header-rem-heading-'+i" @click="openAccords(i,e.id)">
                <h5 class="mb-0 card-header px-0">
                    <a class='card-link d-block mb-0 py-3 px-4 fw-400 border-0' data-toggle="collapse" v-bind:href="'#header-rem-collaps-'+i" role="button" aria-expanded="false" v-bind:aria-controls="'header-rem-collaps-'+i" >
                        <div class="row row w-100 m-0">
                            <div class="pl-0 col-8 fw-600">{{e.geteventtype.name}}</div>
                            <div class="px-0 col-4">
                                <span>Contact:</span>
                                <b-dropdown menu-class="p-3" class="ticket-email-action w-auto">
                                    <template v-slot:button-content class="min-h-0 px-0 notranslate">                                        
                                        <span>{{e.name}}</span>
                                    </template>
                                    <p class='border-bottom pb-2 fw-600'>Current Details</p>
                                    <table class="border-0 lh-1-5">
                                        <tr>
                                            <th>Conversation Type:</th>
                                            <td class="pl-2 notranslate">{{e.conversation_type}}</td>
                                        </tr>
                                        <tr>
                                            <th>Contact Status:</th>
                                            <td class="pl-2 notranslate">{{e.visitor_status}}</td>
                                        </tr>
                                        <tr>
                                            <th>Lead Score:</th>
                                            <td class="pl-2 notranslate">{{e.lead_scoring}}</td>
                                        </tr>
                                        <tr>
                                            <th>Priority:</th>
                                            <td class="pl-2 notranslate">{{e.priority}}</td>
                                        </tr>
                                        <tr>
                                            <th>Help Center Status:</th>
                                            <td class="pl-2 notranslate"></td>
                                        </tr>
                                    </table>
                                </b-dropdown>
                            </div>
                        </div>
                        <div class="row row w-100 m-0 mt-2 notranslate">
                            <div class="pl-0 col-8 text-success"><span class="translate">Status:</span>{{getStatus(e.status)}}</div>
                            <div class="px-0 col-4"><span class="translate">Time:</span>{{e.time}} {{e.event_date}}</div>
                        </div>
                    </a>
                </h5>
            </div>
            <div v-bind:id="'header-rem-collaps-'+i" class="collapse px-0" role="tabpanel" v-bind:aria-labelledby="'header-rem-heading-'+i" data-parent="#HeaderRemInner">
                <div class="card-body p-0 w-100 border-top">
                    <form>
                        <div class='row mx-0 p-3'>
                            <div class='col-6 mb-3'>
                                <div class="form-group row">
                                    <label  class="col-auto col-form-label text-right">Event Status</label>
                                    <div class="col notranslate" id="select-ceventStatus">
                                        <select v-validate="'required'" v-model="event_data.status" class="form-control dd-abs-menu" name="status" v-bind:data-vv-scope="'form-'+i">
                                            <option value="" class="translate">Select</option>
                                            <option value="2">Completed</option>
                                            <option value="3">No Show</option>
                                            <option value="4" class="translate">Missed</option>
                                            <option value="5">Canceled</option>
                                        </select>
                                        <span class="text-danger colore-red translate">{{ errors.first('form-'+i+'.status')}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class='col-6 mb-3'>
                                <div class="form-group row">
                                    <label  class="col-auto col-form-label text-right ">Conversation Type</label>
                                    <div class="col notranslate" id="select-conversation">
                                        <select  v-validate="'required'" v-model="event_data.con_type" class="form-control dd-abs-menu" name="conversation type" v-bind:data-vv-scope="'form-'+i">
                                            <option value="" class="translate">Select</option>
                                            <option value="1">Sales Support</option>
                                            <option value="2">Other Support</option>
                                            <option value="3">Complaint</option>
                                            <option value="4">Website Issue</option>
                                            <option value="5">Sales Issue</option>
                                            <option value="6">Positive Feedback</option>
                                            <option value="7">Other</option>
                                            <option value="8">No Response</option>
                                        </select>
                                        <span class="text-danger colore-red translate">{{ errors.first('form-'+i+'.conversation type') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class='col-6 mb-3'>
                                <div class="form-group row">
                                    <label  class="col-auto col-form-label text-right ">Contact Status</label>
                                    <div class="col notranslate" id="select-contact-status">
                                        <select v-validate="'required'" v-model="event_data.visitor_status"  class="form-control dd-abs-menu" name="contact status" v-bind:data-vv-scope="'form-'+i">
                                            <option value="" class="translate">Select</option>
                                            <option value="1">Sales Lead </option>
                                            <option value="2">Sale Lost</option>
                                            <option value="3">Customer</option>
                                            <option value="4">Customer Lost</option>
                                            <option value="5">Employee Lead</option>
                                            <option value="6">Employee</option>
                                            <option value="7">Vendor</option>
                                            <option value="8">Other</option>
                                        </select>
                                        <span class="text-danger colore-red translate">{{ errors.first('form-'+i+'.contact status') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class='col-6 mb-3'>
                                <div class="form-group row">
                                    <label  class="col-auto col-form-label text-right ">Lead Score</label>
                                    <div class="col notranslate" id="select-lead-score">
                                        <select  v-validate="{ required:(event_data.visitor_status==1)}" v-model="event_data.lead_score"  class="form-control dd-abs-menu" name="lead score" v-bind:data-vv-scope="'form-'+i">
                                            <option value="" class="translate">Select</option>
                                            <option value="1">High</option>
                                            <option value="2">Medium</option>
                                            <option value="3">low</option>
                                        </select>
                                        <span class="text-danger colore-red translate">{{ errors.first('form-'+i+'.lead score') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class='col-6 mb-3'>
                                <div class="form-group row">
                                    <label  class="col-auto col-form-label text-right ">Priority</label>
                                    <div class="col notranslate" id="select-periority">
                                        <select v-validate="'required'" v-model="event_data.priority"  class="form-control dd-abs-menu" name="priority" v-bind:data-vv-scope="'form-'+i">
                                            <option value="" class="translate">Select</option>
                                            <option value="1">High</option>
                                            <option value="2">Medium</option>
                                            <option value="3">Low</option>
                                        </select>
                                        <span class="text-danger colore-red translate">{{ errors.first('form-'+i+'.priority') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class='col-6 mb-3'>
                                <div class="form-group row">
                                    <label  class="col-auto col-form-label text-right ">Help Center Status</label>
                                    <div class="col notranslate">
                                        <select class="form-control dd-abs-menu">
                                            <option value="">Select</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class='col-12'>
                                <div class="form-group row">
                                    <label  class="col-auto col-form-label text-right ">Note</label>
                                    <div class="col notranslate">
                                        <textarea v-model="event_data.note" class="form-control" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class='row mx-0 border-top p-3'>
                            <div class='col'>
                                <a href="#" class='btn btn-orange' @click="updateCrm">Update CRM</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</template>
<script>
    import {site_root} from './../../Utitlity.js';
    export default {
        name: "header-reminder",
        data() {
            return {
                siteUrl: site_root,
                modalTitle: "",
                btnmodalText: "",
                events: [],
                selected_index: '',
                event_data: {
                    status: '',
                    con_type: '',
                    visitor_status: '',
                    lead_score: '',
                    priority: '',
                    note: '',
                    email: '',
                    id: ''
                }
            }
        },
        computed: {

        },
        components: {
        },
        watch: {

        },
        methods: {
            setModal: function (title, btnText) {
                this.modalTitle = this.btnmodalText = title;
                if (btnText) {
                    this.btnmodalText = btnText;
                }
            },
            getReminderEvent: function () {
                var thisObject = this;
                axios.get(thisObject.siteUrl + 'get-event-reminder',
                        )
                        .then(function (response) {
                            if (response.data.status == 1) {
                                thisObject.events = response.data.record;
                            }
                        })
                        .catch(function (error) {
                            console.error(error.message);
                        });
            },
            getStatus(args) {
                if (args == 1) {
                    return "Scheduled"
                } else if (args == 2) {
                    return "Completed"
                } else if (args == 3) {
                    return "No Show"
                } else if (args == 4) {
                    return "Missed"
                } else {
                    return "Canceled"
                }
            },
            openAccords: function (index, id) {
                this.event_data = {
                    status: '',
                    con_type: '',
                    visitor_status: '',
                    lead_score: '',
                    priority: '',
                    note: '',
                    email: '',
                    id: ''
                };
                this.$validator.reset();
                setTimeout(() => {
                    $("#select-conversation select").selectpicker('refresh');
                    $("#select-periority select").selectpicker('refresh');
                    $("#select-contact-status select").selectpicker('refresh');
                    $("#select-ceventStatus select").selectpicker('refresh');
                    $("#select-lead-score select").selectpicker('refresh');
                }, 1000);

                this.selected_index = index;
                this.event_data.id = id;
                this.event_data.email = this.events[index].email;
            },
            updateCrm: function () {
                var self = this;
                this.$validator.validateAll('form-' + self.selected_index).then((result) => {
                    if (result) {
                        axios.post(self.siteUrl + 'update-crm', self.event_data
                                )
                                .then(function (response) {
                                    if (response.data.status == 1) {
                                        self.getReminderEvent();
                                        $(".card div:nth-child(2) a").attr('aria-expanded', false);
                                        $(".card div:nth-child(3)").removeClass('show');
                                    }
                                })
                                .catch(function (error) {
                                    console.error(error.message);
                                });
                    }
                });
            }
        },
        mounted: function () {
            var thisObject = this;
            thisObject.getReminderEvent();

        },
        props: []
    }
</script>



