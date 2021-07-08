import Vue from 'vue';
import Vuex from 'vuex';


Vue.use(Vuex);


export default new Vuex.Store({
    state: {
        "appHeader": {
            "incoming": "0",
            "self_running": "0",
            "other_agent_running": "0",
            "other_agent_tran_colla_req": "0",
            "agent_capacity": "0%",
            "average_wait_time": "0 Seconds",
            "reminders": 0
        },
        count: [5, 6, 7],
        designs: '',
        forms: [],
        designsSortingOrderOffline: '',
        designsSortingOrderPrechat: '',
        tempFormData: '',
        library: '',
        online_button: '',
        all_window: '',
        user: '',
        activeTempIndex: '',
        tempFormLibData: '',
        currentFormActiveIndex: '',
        activeType: '',
        currentFormStep: '',
        stepCount: 1,
        deleteTempIndex:'',
        deleteTempType:'',
        selectedBrandingWebsite:''
    },
    mutations: {
        headerChatWatch(state) {
            var $self = this;
            var siteUrl = $('#appBaseUrl').val();
            //return;
            axios.post(siteUrl + '/run-conversations-other-pages',null,{showLoader:false})
                    .then(function (response) {
                        state.appHeader.incoming = response.data.records.incoming;
                        state.appHeader.self_running = response.data.records.self_running;
                        state.appHeader.other_agent_running = response.data.records.other_agent_running;
                        state.appHeader.other_agent_tran_colla_req = response.data.records.other_agent_tran_colla_req;
                        state.appHeader.average_wait_time = response.data.records.average_wait_time;
                        state.appHeader.reminders = response.data.records.reminders;
                        if (response.data.records.incoming_audio_alert_count && jQuery('#chatAudio').length > 0) {
                            jQuery('#chatAudio')[0].play();
                        }
                        if (response.data.records.self_running_unread_msg_count && jQuery('#chatAudio').length > 0) {
                            jQuery('#chatAudio')[0].play();
                        }
                        if (response.data.audio_alert_unread_messages_tm && jQuery('#chatAudio').length > 0) {
                            var playedPromise = jQuery('#chatAudio')[0].play();
                            if (playedPromise) {
                                playedPromise.catch((e) => {
                                     //console.log(e)
                                     if (e.name === 'NotAllowedError' || e.name === 'NotSupportedError') { 
                                           console.error(e.name);
                                      }
                                 }).then(() => {
                                      //console.log("playing sound !!!");
                                 });
                             }
                        }
                    })
                    .catch(function (error) {
                        console.error(error.message);
                    });
               
        },
        loginUser(state, payload) {
            state.user = payload;
        },
        increment(state) {
            state.count++
        },
        addCount(state, payload) {
            state.count.push(payload);
        },
        setDesign(state, payload) {
            state.designs = payload;
        },
        designsSortingOrderOffline(state, payload) {
            state.designsSortingOrderOffline = payload;
        },
        designsSortingOrderPrechat(state, payload) {
            state.designsSortingOrderPrechat = payload;
        },
        mylibrary(state, payload) {
            state.library = payload;
        },
        addBlogArticle(state, artical) {
            state.designs[3].formData.articles.push(artical);
        },
        addTempFormData(state, temp) {
            state.tempFormData = temp;
        },
        addTempFormLibData(state, temp) {
            state.tempFormLibData = temp;
        },
        addActiveTempIndex(state, temp) {
            state.activeTempIndex = temp;
        },
        addCurrentActiveTempIndex(state, temp) {
            state.currentFormActiveIndex = temp;
        },
        addAllWindow(state, temp) {
            state.all_window = temp;
        },
        addOnlineButton(state, temp) {
            state.online_button = temp;
        },
        addActiveType(state, temp) {
            state.activeType = temp;
        },
        addCurrentFormStep(state, temp) {
            state.currentFormStep = temp;
        },
        addStepCount(state, temp) {
            state.stepCount = temp;
        },
        addDeleteTempIndex(state, temp) {
            state.deleteTempIndex = temp;
        },
        addDeleteTempType(state, temp) {
            state.deleteTempType = temp;
        },
        addSelectedWebsite(state,temp){
            state.selectedBrandingWebsite=temp;
        }       
    },
    getters: {
        getSelectedWebsite(state){
            return state.selectedBrandingWebsite;
        },
        getLoginUserDetail(state) {
            return state.user;
        },
        getCount(state) {
            return state.count;
        },
        getSumOfCount(state) {
            let total = 0;
            state.count.forEach((element) => {
                total += element;
            });
            return total;
        },
        getDesign(state) {
            return state.designs;
        },
        getTempFormData(state) {
            return state.tempFormData;
        },
        getTempFormLibData(state) {
            return state.tempFormLibData;
        },
        getLoginUserDetail(state) {
            return state.user;
        },
        getLibrary(state) {
            return state.library;
        },
        getActiveTempIndex(state) {
            return state.activeTempIndex;
        },
        getCurrentActiveTempIndex(state) {
            return state.currentFormActiveIndex;
        },
        getDesignsSortingOrderOffline(state) {
            return state.designsSortingOrderOffline;
        },
        getDesignsSortingOrderPrechat(state) {
            return state.designsSortingOrderPrechat;
        },
        getAllPreChat(state) {
//            return state.designs.filter((d)=>{
//                return d.component == 'Prechat';
//            });
        },
        getAllWindow(state) {
            return state.all_window;
        },
        getActiveType(state) {
            return state.activeType;
        },
        getCurrentFormStep(state) {
            return state.currentFormStep;
        },
        getStepCount(state) {
            return state.stepCount;
        },
        getOnlineButton(state) {
            return state.online_button;
        },
        getDeleteTempIndex(state) {
            return state.deleteTempIndex;
        },
        getDeleteTempType(state) {
            return state.deleteTempType;
        },
        getAllDesignForm(state) {

            var forms = [];

            for (var i = 0; i < state.designs.length; i++) {
                if (state.designs[i].formData != null && state.designs[i].formData != '') {
                    if (state.designs[i].component == 'Prechat') {
                        forms.push({component: state.designs[i].component, formname: state.designs[i].component + '-' + state.designs[i].formData.name})
                    } else if (state.designs[i].component == 'Announcements') {
                        forms.push({component: state.designs[i].component, formname: state.designs[i].component + '-' + state.designs[i].formData.name})
                    } else if (state.designs[i].component == 'Blog') {
                        forms.push({component: state.designs[i].component, formname: state.designs[i].component + '-' + state.designs[i].formData.name})
                    } else if (state.designs[i].component == 'Ebook') {
                        forms.push({component: state.designs[i].component, formname: state.designs[i].component + '-' + state.designs[i].formData.name})
                    } else if (state.designs[i].component == 'Search') {
                        forms.push({component: state.designs[i].component, formname: state.designs[i].component + '-' + state.designs[i].formData.name});
                    } else if (state.designs[i].component == 'FreeTrial') {
                        forms.push({component: state.designs[i].component, formname: state.designs[i].component + '-' + state.designs[i].formData.name});
                    } else if (state.designs[i].component == 'Webinar') {
                        forms.push({component: state.designs[i].component, formname: state.designs[i].component + '-' + state.designs[i].formData.name});
                    } else if (state.designs[i].component == 'Employeement') {
                        forms.push({component: state.designs[i].component, formname: state.designs[i].component + '-' + state.designs[i].formData.name});
                    } else if (state.designs[i].component == 'Subscribe') {
                        forms.push({component: state.designs[i].component, formname: state.designs[i].component + '-' + state.designs[i].formData.name});
                    } else if (state.designs[i].component == 'Demo') {
                        forms.push({component: state.designs[i].component, formname: state.designs[i].component + '-' + state.designs[i].formData.name});
                    } else if (state.designs[i].component == 'Feedback') {
                        forms.push({component: state.designs[i].component, formname: state.designs[i].component + '-' + state.designs[i].formData.name});
                    }
                }
                if (state.designs[i].component == 'Offline') {
                    forms.push({component: state.designs[i].component, formname: state.designs[i].component + '-' + state.designs[i].formData.name});
                    if (state.designs[i].formData == '') {
                        state.designs[i].formData = {
                            name: 'chat247',
                            Off_formEmailField: true,
                            Off_formPhoneField: false,
                            Off_formNameField: false,
                            Off_formCompanyField: false,
                            Off_formMlineIptField: true,
                            Off_formDropdownField: false,
                            Off_formDepartmentField: false,
                            Off_FieldsAddMoreEmailRequired: '1',
                            Off_FieldsAddMoreEmailLabelText: 'Email',
                            Off_FieldsAddMoreEmailPlaceHolderText: 'Email Address',
                            Off_FieldsAddMorePhoneRequired: '1',
                            Off_FieldsAddMorePhoneLabelText: 'Phone',
                            Off_FieldsAddMorePhonePlaceholderText: 'Phone Number',
                            Off_FieldsAddMoreNameRequired: '1',
                            Off_FieldsAddMoreNameLabelText: 'Your Name',
                            Off_FieldsAddMoreNamePlaceholderText: 'Name',
                            Off_FieldsAddMoreCompanyRequired: '1',
                            Off_FieldsAddMoreCompanyLabelText: 'Company',
                            Off_FieldsAddMoreCompanyPlaceholderText: 'Company',
                            Off_FieldsAddMoreSingleLineInputRequired: '1',
                            Off_FieldsAddMoreSingleLineVariableText: 'Variable Name',
                            Off_FieldsAddMoreMultiLineInputRequired: '1',
                            Off_FieldsAddMoreMultiLineInputLabelText: 'Message',
                            Off_FieldsAddMoreMultiLineInputPlaceholderText: 'Message',
                            Off_FieldsAddMoreDropdownRequired: '1',
                            Off_FieldsAddMoreDropdownInputLabelText: 'What would you like to discuss?',
                            Off_FieldsAddMoreDropdownInputPlaceholderText: '',
                            Off_FieldsAddMoreDropdown: [
                                {label: "1", value: "1"},
                            ],
                            Off_FieldsAddMoreDepartmentRequired: '1',
                            Off_FieldsAddMoreDepartmentLabelText: 'Department',
                            Off_FieldsAddMoreDepartmentPlaceholderText: '',
                            Off_FieldsAddMoreDepartment: [
                                {deptt: 'Sales'},
                                {deptt: 'Billing'},
                                {deptt: 'Support'},
                            ],
                            FrmOfflineNameText: '',
                            FrmOfflineHeadertext: "Leave your email address and a message. Our team usually replies in 24 hours",
                            FrmOfflineButtontext: "Submit",
                            isdel: false
                        };
                    }
                }
            }
            return forms;
        },
        getAllSelectedForm(state) {
            var forms = [];
            for (var i = 0; i < state.designs.length; i++) {
                if (state.designs[i].formData != null && state.designs[i].formData != '' && state.designs[i].saved) {
                    if (forms.indexOf(state.designs[i].component) == -1) {
                        forms.push(state.designs[i].component);
                    }
                }
            }
            return forms;
        },
        getBusinessSelectedForm(state) {
            var forms = [];
            for (var i = 0; i < state.designs.length; i++) {
                if (state.designs[i].formData != null && state.designs[i].formData != '' && state.designs[i].component != "Offline") {
                    if (forms.indexOf(state.designs[i].component) == -1) {
                        forms.push(state.designs[i].component);
                    }
                }
            }
            return forms;
        },
        getNonBusinessSelectedForm(state) {
            var forms = [];
            for (var i = 0; i < state.designs.length; i++) {
                if (state.designs[i].formData != null && state.designs[i].formData != '' && state.designs[i].component != "Prechat") {
                    if (forms.indexOf(state.designs[i].component) == -1) {
                        forms.push(state.designs[i].component);
                    }
                }
            }
            return forms;
        },
    },

});


