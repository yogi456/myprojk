import Vue from 'vue';
import Vuex from 'vuex';


Vue.use(Vuex);


export default new Vuex.Store({
    state: {
        chat: {
            subscriberGeneratedId: '',
            subscriberId: 0,
            themeId: 0,
            websiteId: 0,
            threadId: 0,
            lastMsgId: 0, // this is last message id showing on chat window
            lastMsgSeenVisitor: 0,
            lastMsgSeenAgent: 0,
            agentTyping: 0, // 0 => not typing, 1 => typing
            isButtonShow: false,
            isWindowShow: true,
            isRunningChat: false,
            isRunningChatCloseByAgent: false,
            lcMenuBtnChatWindowFlag: false,
            isSessionThreadBtnShowing: false,            
            isAdminView: true, // for login subscriber "isAdminView = true" for visitor "isAdminView = false"
        },
        chatMessages: [
            {"id":1,"m_type":"system","created_at":"2019-11-20 09:47:46","agent_id":2,"agent_name":"Super","visitor_name":"Website Visitor","message":"Joan entered the conversation"},
            {"id":2,"m_type":"visitor","created_at":"2019-11-20 09:47:35","agent_id":0,"agent_name":"","visitor_name":"Website Visitor","message":"Hi Joan. I would like to know the status of my order?"},
            {"id":3,"m_type":"agent","created_at":"2019-11-20 09:48:37","agent_id":2,"agent_name":"Super","agent_dp":"steve.png","visitor_name":"Website Visitor","is_edited":0,"is_unread":1,"message":"Sure. Your order is shipped already and will reach by tomorrow. ","message_link":"","message_en":"","message_oq":""},
            {"id":4,"m_type":"agent","created_at":"2019-11-20 09:48:37","agent_id":2,"agent_name":"Super","agent_dp":"steve.png","visitor_name":"Website Visitor","is_edited":0,"is_unread":1,"message":"Let me know if you need anything else &#x1f60a;","message_link":"","message_en":"","message_oq":""},
        ],
        agent: {
            acceptedChat: false,
            name: '',
            imageUrl: '',
        },
        chatWindow: {
            screen: {
                chat: false,
                forms: false,
            },
            unReadMessageCount: 0,
            unReadMessageIds: [],
            unReadLastMessage: '',
            historyThreads: []
        },
        selectedforms:[],
        activeTemplate:'',
        forms:[],
        alldata: {
            all_window: '',
            accentBgColor: ''
        },
        isBrowserStorageAvailable: false
    },
    mutations: {
        addAllWindow(state,temp){
            state.alldata.all_window=temp;
        },
        addAllForms(state,temp){
            state.chatWindowforms.screen.forms = temp;
        }
    },
    getters: {
       getAllWindow(state){
            return state.alldata.all_window;
        }, 
       getAllForms(state){
            return state.chatWindowforms.screen.forms;
        }, 
    },
});


