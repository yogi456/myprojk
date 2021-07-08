<template>  
    <div id="HeaderEventInner" class=" m-0 border-0" role="tablist" v-bind:data-list-count="events.length" v-bind:class="{'btn-accordion':events.length}"> 
        <div v-for="(e,i) in events"  class="card p-0 border-0" v-bind:data-vv-scope="'form-'+i"  >
            <div class="card-header p-0" role="tab" v-bind:id="'header-event-heading-'+i" @click="openAccords(i,e.id)">
                <h5 class="mb-0 card-header has-stripe px-0">
                    <a class='card-link d-block mb-0 p-4 fw-400 border-0' data-toggle="collapse" v-bind:href="'#header-event-collaps-'+i" role="button" aria-expanded="false" v-bind:aria-controls="'header-event-collaps-'+i" >
                        <div class="row">
                            <div class="col-auto d-flex flex-column p-0 pl-2">
                                <p class='bg-transparent p-0'><img class='br-4 mw-100' v-bind:src="siteUrl+'images/icon-gs-5.png'" width="40"/></p>
                            </div>
                            <div class="col">
                                <div class="row row w-100 m-0">
                                    <div class="pl-0 col-6 fw-600">{{e.geteventtype.name}} </div>
                                    <div class="px-0 col-6" v-if="e.subscriber_inv">
                                        <span>Contact:</span>
                                        <b-dropdown menu-class="p-3" class="ticket-email-action w-auto">
                                            <template v-slot:button-content class="min-h-0 px-0 notranslate">                                        
                                                <span>{{e.subscriber_inv.agentname}}  </span>
                                            </template>
                                            <p class='border-bottom pb-2 fw-600'>Current Details</p>
                                            <table class="border-0 lh-1-5">
                                                <tr>
                                                    <th>Conversation Type:</th>
                                                    <td class="pl-2 notranslate">{{getConType(e.subscriber_inv.conversation_type)}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Contact Status:</th>
                                                    <td class="pl-2 notranslate">{{getConStatus(e.subscriber_inv.visitor_status)}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Lead Score:</th>
                                                    <td class="pl-2 notranslate">{{getLeadScore(e.subscriber_inv.lead_scoring)}}</td>
                                                </tr>
                                                <tr>
                                                    <th>Priority:</th>
                                                    <td class="pl-2 notranslate">{{getPeriority(e.subscriber_inv.priority)}}</td>
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
                                    <div class="pl-0 col-6">Status: <span class="text-success">{{getStatus(e.status)}}</span></div>
                                    <div class="pl-0 col-6 event-link-text" v-if="e.geteventtype.eventMeeting==8">Link:                                          
                                        <span class="text-success text-black ml-1">https://meet.jit.si/ngagge-t-event-{{e.id}}</span>
                                        <span class="text-primary ctt-tooltip" ctt-title="Copy" ctt-placement="top" @click.stop="CopyLink(e.id)"><i class="fa fa-clone" aria-hidden="true"></i></span>
                                    </div>
                                    <div class="px-0 col-12 mt-2 pt-1"><span>Time:</span>{{e.time}} {{e.event_date}}</div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <span class="stripe" v-bind:class="[e.status == 1 || e.status == 6 ? 'bg-success' : e.status == 2 ? 'bg-dgray' : e.status == 3 || e.status == 5 ? 'bg-warning' : e.status == 4 ? 'bg-danger' : '']"></span>
                </h5>
            </div>
            <div v-bind:id="'header-event-collaps-'+i" class="collapse px-0" role="tabpanel" v-bind:aria-labelledby="'header-event-heading-'+i" data-parent="#HeaderEventInner">
                <div class="card-body p-0 w-100 border-top">
                    <form>
                        <div class='row mx-0 p-3'>
                            <div class='col-6 mb-3'>
                                <div class="form-group row">
                                    <label  class="col-auto col-form-label text-right ">Event Status</label>
                                    <div class="col notranslate" id="select-ceventStatus">
                                        <select v-validate="'required'" v-model="event_data.status" class="form-control dd-abs-menu" name="status" v-bind:data-vv-scope="'form-'+i">
                                            <option value="">Select</option>
                                            <option value="2">Completed</option>
                                            <option value="3">No Show</option>
                                            <option value="4">Missed</option>
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
                                        <select  v-model="event_data.con_type" class="form-control dd-abs-menu" name="conversation type">
                                            <option value="">Select</option>
                                            <option value="1">Sales Support</option>
                                            <option value="2">Other Support</option>
                                            <option value="3">Complaint</option>
                                            <option value="4">Website Issue</option>
                                            <option value="5">Sales Issue</option>
                                            <option value="6">Positive Feedback</option>
                                            <option value="7">Other</option>
                                            <option value="8">No Response</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class='col-6 mb-3'>
                                <div class="form-group row">
                                    <label  class="col-auto col-form-label text-right ">Contact Status</label>
                                    <div class="col notranslate" id="select-contact-status">
                                        <select v-validate="'required'" v-model="event_data.visitor_status"  class="form-control dd-abs-menu" name="contact status" v-bind:data-vv-scope="'form-'+i">
                                            <option value="">Select</option>
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
                                            <option value="">Select</option>
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
                                            <option value="">Select</option>
                                            <option value="1">High</option>
                                            <option value="2">Medium</option>
                                            <option value="3">Low</option>
                                        </select>
                                        <span class="text-danger colore-red translate">{{ errors.first('form-'+i+'.priority') }}</span>
                                    </div>
                                </div>
                            </div>
                            <!--                            <div class='col-6 mb-3'>
                                                            <div class="form-group row">
                                                                <label  class="col-auto col-form-label text-right ">Help Center Status</label>
                                                                <div class="col">
                                                                    <select class="form-control dd-abs-menu">
                                                                        <option value="">Select</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>-->
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
        <div v-if="events.length==0 && $attrs['msgg1']==1">
            <h3>No Events Found.</h3>
        </div>
        <alert-message-popup
            v-bind:alertMessage="alertMessage"
            v-bind:allTypeClass="allTypeClass"
            ></alert-message-popup>  
    </div>
</template>
<script>
    import {site_root} from './../../Utitlity.js';
    import AlertMessagePopup from '../alertMessagePopup.vue';
    import { EventBus } from "../../EventBus.js";
    export default {
        name: "header-reminder-event",
        data() {
            return {
                siteUrl: site_root,
                alertMessage: '',
                allTypeClass: '',
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
            'alert-message-popup': AlertMessagePopup
        },
        watch: {

        },
        methods: {
            CopyLink(id) {

                const el = document.createElement('textarea');
                el.value = 'https://meet.jit.si/ngagge-t-event-' + id;
                el.setAttribute('readonly', '');
                el.style.position = 'absolute';
                el.style.left = '-9999px';
                document.body.appendChild(el);
                el.select();
                document.execCommand('copy');
                document.body.removeChild(el);
                var obj = {
                    msg: 'Updated Successfully',
                    alert_class: 'alert-success',
                };
                this.showSubmitAlert(obj);

            },
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
                            } else {
                                thisObject.events = [];
                            }

                            thisObject.$emit('geteventlength', thisObject.events.length);
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
                } else if (args == 5) {
                    return "Canceled"
                } else {
                    return "Reschedule"
                }
            },
            getConType: function (args) {
                if (args == 1) {
                    return "Sales Support"
                } else if (args == 2) {
                    return "Other Support"
                } else if (args == 3) {
                    return "Complaint"
                } else if (args == 4) {
                    return "Website Issue"
                } else if (args == 5) {
                    return "Sales Issue"
                } else if (args == 6) {
                    return "Positive Feedback"
                } else if (args == 7) {
                    return "Other"
                } else {
                    return "No Response"
                }
            },
            getConStatus: function (args) {
                if (args == 1) {
                    return "Sales Lead"
                } else if (args == 2) {
                    return "Sale Lost"
                } else if (args == 3) {
                    return "Customer"
                } else if (args == 4) {
                    return "Customer Lost"
                } else if (args == 5) {
                    return "Employee Lead"
                } else if (args == 6) {
                    return "Employee"
                } else if (args == 7) {
                    return "Vendor"
                } else {
                    return "Other"
                }
            },
            getLeadScore: function (args) {
                if (args == 1) {
                    return "High"
                } else if (args == 2) {
                    return "Medium"
                } else if (args == 3) {
                    return "low"
                }
            },
            getPeriority: function (args) {
                if (args == 1) {
                    return "High"
                } else if (args == 2) {
                    return "Medium"
                } else if (args == 3) {
                    return "low"
                }
            },
            openAccords: function (index, id) {
                this.selected_index = index;
                this.event_data.id = id;
                this.event_data.email = this.events[index].email;
                this.event_data.status = '';
                this.event_data.con_type = '';
                this.event_data.visitor_status = this.events[index].subscriber_inv.visitor_status;
                this.event_data.lead_score = this.events[index].subscriber_inv.lead_scoring;
                this.event_data.priority = this.events[index].subscriber_inv.priority;
                this.event_data.note = this.events[index].subscriber_inv.note;
                this.$validator.reset();
                setTimeout(() => {
                    $("#select-conversation select").selectpicker('refresh');
                    $("#select-periority select").selectpicker('refresh');
                    $("#select-contact-status select").selectpicker('refresh');
                    $("#select-ceventStatus select").selectpicker('refresh');
                    $("#select-lead-score select").selectpicker('refresh');
                }, 1000);
            },
            showSubmitAlert: function (obj) {
                this.alertMessage = obj.msg;
                this.allTypeClass = obj.alert_class;
                this.resetSubmitAlert();
            },
            resetSubmitAlert: function () {
                var thisObject = this;
                setTimeout(function () {
                    thisObject.alertMessage = '';
                    thisObject.allTypeClass = '';
                }, 1000);
            },
            updateCrm: function () {
                var self = this;
                this.$validator.validateAll('form-' + self.selected_index).then((result) => {
                    if (result) {
                        axios.post(self.siteUrl + 'update-crm', self.event_data
                                )
                                .then(function (response) {
                                    if (response.data.status == 1) {
                                        var obj = {
                                            msg: 'Updated Successfully',
                                            alert_class: 'alert-success',
                                        };
                                        self.showSubmitAlert(obj);
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
            EventBus.$on("refresh-reminder", function (reminder) {
                //console.log("test reminder");
                thisObject.getReminderEvent()
            })

        },
        props: []
    }
</script>



