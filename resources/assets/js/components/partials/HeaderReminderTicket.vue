<template>  
    <div id="HeaderTicketRemInner" class=" m-0 border-0" role="tablist" v-bind:class="{'btn-accordion':ticket.length}"> 
        <div v-for="(t,i) in ticket"  class="card task p-0 border-0" v-bind:data-vv-scope="'form-'+i"  >
            <div class="card-header p-0" role="tab" v-bind:id="'header-ticket-rem-heading-'+i" @click="openAccords(i,t.id)">
                <h5 class="mb-0 card-header has-stripe px-0 notranslate">
                    <a class='card-link d-block mb-0 p-4 fw-400 border-0' data-toggle="collapse" v-bind:href="'#header-ticket-rem-collaps-'+i" role="button" aria-expanded="false" v-bind:aria-controls="'header-ticket-rem-collaps-'+i" >
                        <div class="row">
                            <div class="col-auto d-flex flex-column p-0 pl-2">
                                <div>
                                    <p class='bg-transparent p-0'><img class='br-4 mw-100' v-bind:src="siteUrl + 'images/icon-ticket.png'"  width="40" /></p>
                                </div>
                            </div>
                            <div class="col">
                                <div class="row row w-100 m-0">
                                    <div class="pl-0 col-7 fw-600">{{t.subject}}</div>
                                    <div class="px-0 col-5">
                                        <span class="translate">Contact:</span>
                                        <span>{{t.agentname}}</span>
                                    </div>
                                </div>
                                <div class="row row w-100 m-0 mt-2">
                                    <div class="pl-0 col-7 text-success"><span class="translate">Status:</span>{{getStatus(t.status)}}</div>
                                    <div class="px-0 col-5"><span class="translate">Time:</span>{{t.st_time}} </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    <span class="stripe" v-bind:class="[t.status == 1 ? 'bg-success' : t.status == 2 ? 'bg-warning' : t.status == 3 ? 'bg-danger' : t.status == 4 ? 'bg-dgray' : '']"></span>
                </h5>
            </div>
            <!-- <div v-bind:id="'header-ticket-rem-collaps-'+i" class="collapse px-0" role="tabpanel" v-bind:aria-labelledby="'header-ticket-rem-heading-'+i" data-parent="#HeaderTicketRemInner">
                <div class="card-body p-0 w-100 border-top">
                    <form>
                        <div class='row mx-0 p-3'>
                            <div class='col-6 mb-3'>
                                <div class="form-group row">
                                    <label  class="col-auto col-form-label text-right ">Task Status</label>
                                    <div class="col" id="select-taskStatus">
                                        <select v-validate="'required'" v-model="task_data.status" class="form-control dd-abs-menu" name="status" v-bind:data-vv-scope="'taskform-'+i">
                                            <option value="">Select</option>
                                            <option value="1">Open</option>
                                            <option value="2">Pending</option>
                                            <option value="3">Closed</option>
                                        </select>
                                        <span class="text-danger colore-red">{{ errors.first('taskform-'+i+'.status')}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class='col-12'>
                                <div class="form-group row">
                                    <label  class="col-auto col-form-label text-right ">Note</label>
                                    <div class="col">
                                        <textarea v-model="task_data.discription" class="form-control" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class='row mx-0 border-top p-3'>
                            <div class='col'>
                                <a href="#" class='btn btn-orange' @click="updateTicket">Update</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div> -->
        </div>
        <div v-if="ticket.length==0 && $attrs['msgg']==1">
            <h3>No Ticket Found.</h3>
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
    export default {
        name: "header-reminder-ticket",
        props: ['msgg'],
        data() {
            return {
                siteUrl: site_root,
                alertMessage: '',
                allTypeClass: '',
                modalTitle: "",
                btnmodalText: "",
                ticket: [],
                selected_index: '',
                task_data: {
                    status: '',
                    discription: '',
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
            getTime(args) {
                var hour = args.split(':');
                var time = new Date();
                time.setHours(hour[0]);
                time.setMinutes(hour[1]);
                var hours = time.getHours();
                var minutes = time.getMinutes();
                var ampm = hours >= 12 ? 'PM' : 'AM';
                hours = hours % 12;
                hours = hours ? hours : 12; // the hour '0' should be '12'
                minutes = minutes < 10 ? '0' + minutes : minutes;
                var strTime = hours + ':' + minutes + ' ' + ampm;
                return strTime;
            },
            GetFormattedDate(arg) {
                var todayTime = new Date(arg);
                var month = todayTime.getMonth() + 1;
                var day = todayTime.getDate();
                var year = todayTime.getFullYear();
                return month + "/" + day + "/" + year;
            },
            setModal: function (title, btnText) {
                this.modalTitle = this.btnmodalText = title;
                if (btnText) {
                    this.btnmodalText = btnText;
                }
            },
            getReminderTask: function () {
                var thisObject = this;
                axios.get(thisObject.siteUrl + 'get-reminder-ticket',
                        )
                        .then(function (response) {
                          //console.log(response.data)
                            if (response.data.status == 1) {
                                thisObject.ticket = response.data.record;
                            } else {
                                thisObject.ticket = [];
                            }
                            thisObject.$emit('getticketlength', thisObject.ticket.length);
                        })
                        .catch(function (error) {
                            console.error(error.message);
                        });
            },
            getStatus(args) { 
                if (args == 1) {
                    return "Open"
                } else if (args == 2) {
                    return "Pending"
                } else if (args == 3) {
                    return "Closed"
                }
            },
            openAccords: function (index, id) {
                this.selected_index = index;
                this.task_data.id = id;
                this.task_data.status = this.ticket[index].status;
                /* if (this.ticket[index].status == 1) {
                 this.task_data.status = 2;
                 } else {
                 this.task_data.status = 4;
                 }*/
                this.task_data.discription = this.ticket[index].discription;
                this.$validator.reset();
                setTimeout(() => {
                    $("#select-taskStatus select").selectpicker('refresh');
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
            updateTicket: function () {
                var self = this;
                this.$validator.validateAll('taskform-' + self.selected_index).then((result) => {
                    if (result) {
                        axios.post(self.siteUrl + 'update-ticket-reminder', self.task_data
                                )
                                .then(function (response) {
                                    if (response.data.status == 1) {
                                        var obj = {
                                            msg: 'Updated Successfully',
                                            alert_class: 'alert-success',
                                        };
                                        self.showSubmitAlert(obj);
                                        self.getReminderTask();
                                        self.$forceUpdate();
                                        $(".task div:nth-child(2) a").attr('aria-expanded', false);
                                        $(".task div:nth-child(3)").removeClass('show');
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
            thisObject.getReminderTask();

        },
        props: []
    }
</script>



