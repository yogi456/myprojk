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
            isWindowShow: false,
            isRunningChat: false,
            isRunningChatCloseByAgent: false,
            lcMenuBtnChatWindowFlag: false,
            isSessionThreadBtnShowing: false,
            
            isAdminView: false, // for login subscriber "isAdminView = true" for visitor "isAdminView = false"
        },
        chatMessages: [
            {"id":1,"m_type":"system","created_at":"2019-11-20 09:47:46","agent_id":2,"agent_name":"Super","visitor_name":"Website Visitor","message":"Super entered the conversation"},
            {"id":2,"m_type":"visitor","created_at":"2019-11-20 09:47:35","agent_id":0,"agent_name":"","visitor_name":"Website Visitor","message":"hello this is test messaeg by visitor<br>"},
            {"id":3,"m_type":"agent","created_at":"2019-11-20 09:48:37","agent_id":2,"agent_name":"Super","agent_dp":"steve.png","visitor_name":"Website Visitor","is_edited":0,"is_unread":1,"message":"hi this is test by agent message","message_link":"","message_en":"","message_oq":""},
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
            historyThreads: [],
            historyBotThreads: []
        },
        BotData:{
           actionCount:0
        },
        selectedforms:[],
        activeTemplate:'',
        forms:[],
        alldata: {
            online_button: '',
            all_window: '',
            accentBgColor: ''
        },
        trigger:[],
        isBrowserStorageAvailable: false,
        BotCurrentThreadId:''
    },
    mutations: {
        
    },
    getters: {
        
    },
});


