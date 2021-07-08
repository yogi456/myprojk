<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

use Illuminate\Http\Request;

Auth::routes();

Route::get('/home', function () {
    return redirect('login');
});

//Route::get('/start-tour', function () {
//    return view('start_tour');
//});
//Route::get('/appoint/test', 'AppointmentsController@test');
//Route::get('google', function () {
//    return view('googleAuth');
//});
Route::get('/', function () {
    return redirect('/home');
});

Route::get('/logout', 'UsersController@logout');

Route::group(['middleware' => 'web', 'middleware' => ['auth', 'CheckSubscriber', 'custom2fa', 'CheckSteps']], function () {

    //    Route::get('/colab-insert', 'UsersController@colaborationDefaultInsert');
    Route::get('/colab-insert', 'UsersController@colaborationDefaultInsertUser');
    Route::get('/mailsend', 'UsersController@mailsend');
    Route::get('/guest/{token?}', 'UsersController@getGuest');
    Route::get('/payment/{token}', 'UsersController@paymentPage');
    Route::get('/chat247-payment', 'UsersController@payment');
    Route::post('/guest-register', 'UsersController@InsertInviteUser');
    Route::get('/visitors-ajax-window-iframe', 'WebController@chatIframeWindowCode');
    Route::post('/send-ebook-chat-visitor', 'WebController@sendEbookChatVisitor');
    Route::post('/send-subscriber-data', 'WebController@sendSubscriberData');
    Route::post('/send-trial-data', 'WebController@sendTrialData');
    Route::post('/send-webinar-data', 'WebController@sendWebinarData');
    Route::post('/send-article-search-data', 'WebController@articleSearch');
    ///Route::post('/iframe-article-search', 'WebController@iframeArticleSearch');
    Route::post('/iframe-article-news', 'WebController@iframeArticleNews');

    Route::get('/stipe', 'UsersController@getstipecust');

    Route::get('/set', 'UsersController@setsession');
    Route::get('/get', 'UsersController@getsession');

    Route::post('/paymentTest', 'UsersController@paymentTest');
    Route::post('/paymentNow', 'UsersController@paymentNow');
    Route::get('/articleByLink/{key}', 'UsersController@articleByLink');
    Route::post('/get-category-column-user', 'UsersController@getCategoryColumn');

    Route::post('/payment-by-client', 'UsersController@paymentByClient');
    Route::get('/get-timezone-list-registration', 'UsersController@getTimezoneList');
    Route::post('/articlelikedislike', 'UsersController@articleLikeDislike');
    Route::post('/get-related-article', 'UsersController@getRelatedArticle');
    Route::post('/getIndustryCountryempoloyeeNumber', 'UsersController@getIndustryCountryempoloyeeNumber');
    Route::post('/getRoles', 'UsersController@getRoles');
    Route::get('/draggable', 'UsersController@draggable');
    Route::post('/getArticleListGroupByArticle1', 'UsersController@getArticleListGroupByArticle1');
    Route::post('/article-search-subscriber', 'UsersController@articleSearch');

    Route::post('/getWebsiteHelpCenter1', 'UsersController@getWebsiteHelpCenter');
    Route::post('/getcompanyName1', 'UsersController@getcompanyName');
    Route::get('/ChekMailCronJob', 'UsersController@ChekMailCronJob');
    Route::get('/chek-email-conversation', 'EmailConversationController@ChekEmailConversation');
    Route::get('/deletecpanelemail', 'UsersController@deletecpanelemail');
    Route::get('/statusInsert', 'UsersController@StatusInsert');
    Route::get('/SourceInsert', 'UsersController@SourceInsert');

    Route::post('/getsession', 'UsersController@getsession');
    Route::post('/addWebsite/register', 'UsersController@addWebsiteRegister');

    Route::post('/company-list', 'UsersController@getCompanyList');
    Route::post('/check-company-exist', 'UsersController@checkCompanyExist');
    Route::post('/subscribe/chatagent', 'UsersController@subscribeAschatagent');
    Route::post('/checkuseremail', 'UsersController@checkUserEmail');
    Route::post('/register-update-insert-subscriber-features', 'UsersController@updateInsertSubscriberFeatures');
    Route::post('/register-get-subscriber-features', 'UsersController@getSubscriberFeatures');


    //    Route::get('/guest/{token?}', 'UsersController@getGuest');
    Route::get('/insert-triggers', 'CompanyController@insertTriggersinwebsites');


    Route::post('/message-payment', 'AddonsController@messagePayment');
    Route::post('/plan-invoice-payment', 'AddonsController@planInvoicePayment');

    Route::post('/added-custmer-cards-payment', 'AddonsController@addedCustmerCardsPayment');
    Route::post('/upload-addons-branding-images', 'AddonsController@addonBrandingImage');
    Route::post('/website-selected-branding', 'AddonsController@addonReplaceBranding');

    Route::post('/saveScript', 'ScriptsController@saveScript');
    Route::any('/getAllScripts', 'ScriptsController@getAllScripts');
    Route::any('/getScriptDetails', 'ScriptsController@getScriptDetails');
    Route::post('/deleteScript', 'ScriptsController@deleteScript');
    Route::post('/updateScript', 'ScriptsController@updateScript');
    Route::post('/add_transcript_email', 'TranscriptArchiveController@addTranscriptEmail');
    Route::post('/get-transcript-email', 'TranscriptArchiveController@getTranscriptEmail');
    Route::post('/delete_email_transcript', 'TranscriptArchiveController@deleteEmailTranscript');
    Route::post('/update_transcript_email', 'TranscriptArchiveController@updateTranscriptEmail');
    Route::get('/settings', 'SettingsController@index');
    Route::post('/addMoreCompany', 'CompanyController@addMoreCompany');
    Route::post('/get_role_permission_category', 'CompanyController@getRolePermissionCategory');
    Route::post('/update_permission', 'CompanyController@updatePermission');
    Route::post('/getAllCompany', 'CompanyController@getAllCompany');
    Route::post('/allwebsites', 'CompanyController@allwebsites');
    Route::post('/deleteWebsite', 'CompanyController@deleteWebsite');
    Route::post('/updateCompany', 'CompanyController@updateCompany');
    Route::post('/deleteCompany', 'CompanyController@deleteCompany');
    Route::post('/company', 'CompanyController@websiteCRUD');
    Route::post('/addupdateWebsite', 'CompanyController@addupdateWebsite');
    Route::post('/edit-theme', 'DesignController@getThemebyId');
    Route::post('/theme', 'DesignController@themeCRUD');
    Route::post('/delete-theme', 'DesignController@deleteTheme');
    Route::post('/editTheme', 'DesignController@editTheme');
    Route::get('/current-created-theme/{theme_id}', 'DesignController@currentCreatedTheme');

    //reminder route
    Route::get('/get-event-reminder', 'ReminderController@getReminderEvent');
    Route::get('/get-reminder-task', 'ReminderController@getReminderTask');
    Route::get('/get-reminder-ticket', 'ReminderController@getReminderTicket');
    Route::post('/update-crm', 'ReminderController@updateCRM');
    Route::post('/update-task-crm', 'ReminderController@updateTaskCRM');
    Route::post('/update-ticket-reminder', 'ReminderController@updateTicketreminder');
    Route::post('/ebook/upload/file', 'DesignController@uploadFile');
    Route::post('/addTheme', 'DesignController@addTheme');
    Route::post('/usesDetails', 'CompanyController@getusesDetails')->middleware('CheckPermission:company_profile_departments_websites_payment_processing');
    Route::post('/addon-payment', 'CompanyController@addonPayment');
    Route::post('/getIndustryList', 'CompanyController@getIndustryList');
    Route::post('/getCountyList', 'CompanyController@getCountyList');
    Route::post('/getStateList', 'CompanyController@getStateList');
    Route::post('/export-invite', 'CompanyController@exportInvite');
    Route::get('/download-teammate-sample', 'CompanyController@downloadTeammateSample');
    Route::post('/upload-teammate-data', 'CompanyController@uploadTeammateData');
    Route::post('/getEmployeeNumber', 'CompanyController@getEmployeeNumberList');
    Route::post('/profileUpdate', 'CompanyController@profileUpdate');
    Route::get('/get-tag-manage-state', 'TicketController@getStatusmanageState');
    Route::get('/get-leadscore-manage-state', 'TicketController@getLeadscoreManageState');
    Route::post('/addEditDepartment', 'CompanyController@addEditDepartment');
    Route::post('/getDepartment', 'CompanyController@getDepartment');
    Route::post('/AddAgent', 'CompanyController@AddAgent');
    Route::post('/send_invitation', 'CompanyController@sendInvitationToinvitee');
    Route::post('/invitee-import-from-sheet', 'CompanyController@inviteeImportFromSheet');
    Route::post('/update_invitation', 'CompanyController@updateInvitation');
    Route::get('/getSubscriber', 'CompanyController@getSubscriberDetail');
    Route::post('/get-role-list', 'UsersController@getRoleList');
    Route::post('/get-skill-list', 'UsersController@getSkillList');
    Route::post('/add-skills', 'UsersController@addSkill');
    Route::post('/agent_skill_update', 'UsersController@UpdateSkill');
    Route::post('/agent_skill_delete', 'UsersController@DeleteSkill');
    Route::post('/getUserGeneratedKey', 'UsersController@getCurrentLoggedInUser');
    Route::post('/getStartIntro', 'WebController@getStartIntro');


    Route::post('/editAgent', 'CompanyController@EditAgent');
    Route::post('/get-invitee-column-thead', 'CompanyController@getInviteeColumnThead');
    Route::post('/update-invitee-column-thead', 'CompanyController@updateColumnTheadInvitee');
    Route::post('/deleteDepartment', 'CompanyController@deleteDepartment');
    Route::post('/add-card', 'CompanyController@addcard');
    Route::post('/get-card', 'CompanyController@getCard');
    Route::post('/remove-brand', 'CompanyController@removeBrand');

    Route::post('/get-invitee-list', 'CompanyController@getInviteeList')->middleware('CheckPermission:company_teammates_invite_edit_and_delete');
    Route::post('/get-invitee-list-all', 'CompanyController@getInviteeListAll');
    Route::get('/get-subscriber-data', 'CompanyController@getSubscriberData');

    // Route::post('/get-contact-sortBy-priority', 'CompanyController@getContactSortByPriority');

    Route::post('/get-standard-field-list', 'CompanyController@getStandardFieldList');
    Route::post('/insert-stripe-keys', 'CompanyController@insertStripeKeys');
    Route::post('/get-stripe-keys', 'CompanyController@getStripeKeys');
    Route::post('/search-invitee-list', 'CompanyController@searchInviteeList');
    Route::post('/get-client-list', 'CompanyController@getClientList');
    Route::post('/article_shortcut_list', 'SettingsController@getShortcutList');
    Route::post('/article_shortcut', 'SettingsController@createShortcut');
    Route::post('/article_shortcut_update', 'SettingsController@UpdateShortcut');
    Route::post('/article_shortcut_delete', 'SettingsController@deleteShortcut');


    Route::post('/getTicketList', 'TicketController@getTicketList');
    Route::post('/update-head', 'TicketController@updateHead');
    Route::post('/deleteTicket', 'TicketController@deleteTicket');
    Route::post('/sendPopup-email', 'TicketController@ticketPopup');
    Route::post('/getEmailByTickets', 'TicketController@getEmailByTickets');
    Route::any('/getClientList', 'CompanyController@getClientList');
    Route::post('/searchIn-tickets', 'TicketController@searchIntickets');
    Route::post('/insert_ticket_note', 'TicketController@InsertTicketNotes');
    Route::post('/get_ticket_note', 'TicketController@getTicketNotes');
    Route::post('/update_ticket_notes', 'TicketController@updateTicketNotes');
    Route::post('/update_column_thead', 'TicketController@updateColumnThead');
    Route::post('/get-column-thead', 'TicketController@getColumnThead');
    Route::post('/export-ticket', 'TicketController@ExportTicket');
    Route::post('/add-lead-scoring', 'TicketController@addTicketLeadScoring');
    Route::post('/ticket-lead-scoring', 'TicketController@getTicketLeadScoring');
    Route::post('/lead-scoring-contact', 'ContactController@getContactLeadScoring');
    Route::post('/get-contact-subscription', 'ContactController@getSubscription');
    Route::post('/update-subscription-draggable', 'ContactController@updateSubscriptionDraggable');
    Route::post('/get-contact-campaign', 'ContactController@getCampaign');
    Route::post('/add-lead-scoring-contact', 'ContactController@addContactLeadScoring');
    Route::post('/add-subscription-contact', 'ContactController@addContactSubscription');
    Route::post('/add-campaign-contact', 'ContactController@addContactCampaign');
    Route::post('/update-ticket-lead-scoring', 'TicketController@updateTicketLeadScoring');
    Route::post('/update-ticket', 'TicketController@updateTicket');
    Route::post('/update-ticket-by-console', 'TicketController@updateTicketByConsole');
    Route::post('/update-tag-draggable', 'TicketController@updateTagDraggable');
    Route::post('/update-leadscore-draggable', 'TicketController@updateLeadscoreDraggable');
    Route::post('/update-lead-scoring-contact', 'ContactController@updateContactLeadScoring');
    Route::post('/update-subscription-contact', 'ContactController@updateContactSubscription');
    Route::post('/update-campaign-contact', 'ContactController@updateContactCampaign');
    Route::post('/send-to-update-multiple-value', 'ContactController@updatemultiplename');
    Route::post('/get-sms-mms-message-history', 'ContactController@getAllSmsMmsMessagesSentToUser');
    Route::get('get-chat-history', 'ContactController@getChatHistory');
    Route::get('get-whatsapp-subscription', 'Twillio\TwillioController@getWhatsappSubscribe');
    Route::get('get-sms-history', 'ContactController@getSmsHistory');
    Route::get('get-whatsapp-history', 'ContactController@getWhatsappHistory');
    Route::get('get-messenger-history', 'ContactController@getMessengerHistory');
    Route::get('get-contact-dropdown-array', 'ContactController@getContactDropdownsArray');
    Route::get('get-contact-bulk-editable-fileds', 'ContactController@getContactBulkEditableFields');
    Route::post('get-all-task', 'ContactController@getAllTask');
    Route::post('get-all-event', 'ContactController@getAllEvent');
    Route::post('/not-added-website', 'SettingsController@notAddedWebsite');
    Route::post('/websites', 'SettingsController@website');
    Route::post('/getFontFamily', 'SettingsController@getFontFamily');
    Route::post('/saveAllWindow', 'DesignController@saveAllWindow');
    Route::post('/save-library', 'DesignController@saveLibrary');
    Route::post('/get-design-form-data', 'DesignController@getDesignFormData');
    Route::post('/update-template-draggable', 'DesignController@updateTemplateOrder');
    Route::post('/update-Online-buton-html', 'DesignController@updateOnlineButonHtml');
    Route::post('/article-search-header', 'KnowledgebaseController@articleSearch');
    Route::post('/get-single-article', 'KnowledgebaseController@getSingleArticle');
    Route::get('/knowledgebase', 'KnowledgebaseController@index');
    Route::post('/update-category-column', 'KnowledgebaseController@updateCategoryColumn');
    Route::post('/article_knowledgebase-by-category', 'KnowledgebaseController@articleKnowledgebaseByCategory');
    Route::get('/get-know-article-count', 'KnowledgebaseController@getKnowArticleCount');
    Route::post('/article_knowledgebase-by-category-conv', 'KnowledgebaseController@articleKnowledgebaseByCategoryConv');
    Route::post('/get-article-website-conv', 'KnowledgebaseController@getArticleWebsiteConv');
    Route::post('/article-search-knowledgebase-conv', 'KnowledgebaseController@articleSearchKnowledgeConv');
    Route::post('/article-search-store-keyword-conv', 'KnowledgebaseController@articleSearchStoreKeyword');
    Route::get('/get-subscriber-website', 'KnowledgebaseController@getSubscriberWebsite');
    Route::post('/get-category-column', 'KnowledgebaseController@getCategoryColumn');
    //Route::post('/knowledgebase', 'KnowledgebaseController@addeditArticle');
    Route::post('/checkNewsArticle', 'KnowledgebaseController@checkNewsArticle');
    Route::post('/add-knowledgebase-article', 'KnowledgebaseController@addeditArticle')->middleware('CheckPermission:knowledgebase_documents_create_and_edit');
    Route::post('/article_knowledgebase', 'KnowledgebaseController@getArticleList');
    // Route::post('/article-image-upload','KnowledgebaseController@imageUpload');

    Route::post('/search-knowledge-base', 'KnowledgebaseController@searchKnowledgeBase');
    Route::post('/getArticleListGroupByArticle', 'KnowledgebaseController@getArticleListGroupByArticle');
    Route::post('/article_knowledgebase_category', 'KnowledgebaseController@getArticleCategoryList');
    Route::post('/article_knowledgebase_category_update', 'KnowledgebaseController@updateArticleCategory');
    Route::post('/article_knowledgebase_category_delete', 'KnowledgebaseController@deleteArticleCategory');
    Route::post('/article_knowledgebase_category_add', 'KnowledgebaseController@addArticleCategory');
    Route::post('/article_knowledgebase_delete', 'KnowledgebaseController@deleteArticle')->middleware('CheckPermission:knowledgebase_documents_delete');
    Route::post('/send-knowledgebase-email', 'KnowledgebaseController@sendKnowledgebaseEmail');
    Route::post('/getcompanyName', 'KnowledgebaseController@getcompanyName');
    Route::get('/get-subscriber-id', 'KnowledgebaseController@getSubscriberId');
    Route::post('/updateHelpCenter', 'KnowledgebaseController@updateHelpCenter');
    Route::post('/getWebsiteHelpCenter', 'KnowledgebaseController@getWebsiteHelpCenter')->middleware('CheckPermission:knowledgebase_website_help_center_setup');
    Route::post('/getMatchedKeyword', 'KnowledgebaseController@getMatchedKeywords');
    Route::get('/get-website-url', 'KnowledgebaseController@getWebsiteUrl');
    Route::get('/routing', 'RoutingController@index')->middleware('CheckPermission:routing_set_up');
    Route::post('/update-routing', 'RoutingController@updateRouting');
    Route::post('/delete-page-routing', 'RoutingController@deletePageRouting');
    Route::get('/del-routing/{rId}', 'RoutingController@deleteRouting');
    Route::get('/playbook', 'PlaybookController@index')->middleware('CheckPermission:playbooks_view');
    Route::get('/code', 'CodeController@index')->middleware('CheckPermission:chat_settings');
    Route::get('/check-website-install', 'CodeController@checkWebsiteInstall')->middleware('CheckPermission:chat_settings');
    Route::get('/connect', 'ConnectController@index');
    Route::get('/contact', 'ContactController@index')->middleware('CheckPermission:contacts_view');
    Route::post('/import-from-sheet', 'ContactController@importFromSheet')->middleware('CheckPermission:contacts_export');
    Route::post('/upload-contact-data', 'ContactController@uploadContactData')->middleware('CheckPermission:contacts_export');
    Route::post('/get-subscription-and-campaings', 'ContactController@getSubscriptionAndCampaings');
    Route::post('/export-contact', 'ContactController@exportContact')->middleware('CheckPermission:contacts_export');
    Route::post('/segment-export-contact', 'ContactController@segmentExportContact')->middleware('CheckPermission:contacts_export');
    Route::post('/add-contact', 'ContactController@addContact')->middleware('CheckPermission:contacts_create_and_edit');
    Route::post('/update-contact', 'ContactController@updateContact')->middleware('CheckPermission:contacts_create_and_edit');
    Route::post('/get-subscription-manage-state', 'ContactController@getSubscriptionManageState');
    Route::post('/update-campaign-draggable', 'ContactController@updateCampaignDraggable');
    Route::post('/update-contact-column-thead', 'ContactController@updateContactColumnThead');
    Route::post('/get-contact-column-thead', 'ContactController@getContactColumnThead');
    Route::post('/set-table-head', 'ContactController@setContactColumnThead');
    Route::post('/add-table-head', 'ContactController@addContactColumnThead');
    Route::get('/get-all-header', 'ContactController@getContactColumnTheader');
    Route::post('/get-campaign-manage-state', 'ContactController@getCampaignManageState');
    Route::post('/search-contact', 'ContactController@searchContacts');
    Route::post('/delete-contact', 'ContactController@deleteContact')->middleware('CheckPermission:contacts_delete');
    Route::post('/get-contact-list', 'ContactController@getContactList');
    //Route::post('/get-contact-list-id', 'ContactController@getContactListById');
    Route::post('/get-contact-list-id', 'CompanyController@getInviteeContactOnEdit');
    Route::post('/update-file-alias', 'ContactController@updateFileAlias');
    Route::post('/contact-multiple-delete', 'ContactController@contactMultipleDelete')->middleware('CheckPermission:contacts_delete');
    Route::post('/contactup-multiple-delete', 'ContactController@contactupMultipleDelete')->middleware('CheckPermission:contacts_delete');
    Route::post('/contact-multiple-update', 'ContactController@contactMultipleUpdate')->middleware('CheckPermission:contacts_create_and_edit');
    Route::post('/filter-recent-imported-data', 'ContactController@filterRecentImporteData');
    Route::get('/company', 'CompanyController@index');
    Route::get('/reports', 'ReportsController@index');
    Route::post('sendEmailInstall', 'CodeController@sendEmailInstall');


    Route::get('/users-time-zone', 'PlaybookEmailController@getUsersTimeZone');

    ///====		REPORTS ROUTES 		=====	//////	

    Route::get('/smsreport', 'ReportsController@smsreport');
    Route::get('/emailreportbycategory', 'ReportsController@emailreportbycategory');
    Route::get('/emailreportbyperformance', 'ReportsController@emailreportbyperformance');


    Route::get('/channelsmsbytype', 'ReportsController@channelsmsreportbytype');
    Route::get('/channelsmsbyuse', 'ReportsController@channelsmsreportbyuse');
    Route::get('/channelsmsbyoptsource', 'ReportsController@channelsmsreportbyoptsource');


    Route::get('/channelchattotalchats', 'ReportsController@chatByTotalChats');
    Route::get('/channelchatbytimeinqueue', 'ReportsController@chatByTimeInQueue');
    Route::get('/channelchatbyconversationstatus', 'ReportsController@chatByConversationStatus');
    Route::get('/channelchatbytriggerwebpage', 'ReportsController@channelChatByTriggerWebPage');
    Route::get('/channelchatbytriggeractivationsource', 'ReportsController@channelChatByTriggerActivationSource');
    Route::get('/channelchatbynonbushr', 'ReportsController@channelChatByNonBusHr');
    Route::get('/channelchatbymischatbushr', 'ReportsController@channelChatByMisChatBusHr');

    Route::get('/supportknowledgebaserating', 'ReportsController@supportKnowledgeBaseRating');
    Route::get('/supportknowledgebase', 'ReportsController@supportKnowledgeBase');
    Route::get('/supportknowledgenoresserch', 'ReportsController@supportKnowledgenoResSerch');
    Route::get('/supportknowledgeresserch', 'ReportsController@supportKnowledgeResSerch');

    Route::get('/supportknowledgenoresserchinapp', 'ReportsController@supportKnowledgenoResSerchInApp');
    Route::get('/supportknowledgeresserchinapp', 'ReportsController@supportKnowledgeResSerchInApp');

    Route::get('/convhuvinboxbytotalbystatus', 'ReportsController@inboxByTotalbyStatus');
    Route::get('/convhuvinboxbychannel', 'ReportsController@inboxByTotalbyChannel');
    Route::get('/subscriberwebsite', 'ReportsController@subScriberWebsite');

    Route::get('/salescontcatbynew', 'ReportsController@salesContactByNew');
    Route::get('/salescontcatbysource', 'ReportsController@salesContactBySource');
    Route::get('/salesscheduleeventcomplete', 'ReportsController@SalesScheduleEventCompleted');
    Route::get('/salesscheduleeventname', 'ReportsController@SalesScheduleEventName');
    Route::get('/salesscheduletaskongoing', 'ReportsController@SalesScheduleTaskOnGoing');
    Route::get('/salesscheduletaskcompleted', 'ReportsController@SalesScheduleTaskCompleted');
    Route::get('/salesscheduleteammate', 'ReportsController@SalesScheduleTeammate');

    Route::get('/salesbysource', 'ReportsController@salesBySource');
    Route::get('/pipelinebysource', 'ReportsController@pipeLineBySource');
    Route::get('/salebyproductservice', 'ReportsController@saleByProductService');
    Route::get('/pipelinebyproductservice', 'ReportsController@pipeLineByProductService');


    Route::get('/collbteamsuggesionbycategory', 'ReportsController@collbTeamSuggesionByCategory');
    Route::get('/collbteamsuggesionbyteammate', 'ReportsController@collbTeamSuggesionByTeammate');

    Route::get('/convhubmontbyvisitor', 'ReportsController@convHubMontByVisitor');
    Route::get('/convhubmontbyvisitorbouncerate', 'ReportsController@convHubMontByVisitorBounceRate');
    Route::get('/convhubmontbydevice', 'ReportsController@convHubMontByDevice');

    Route::get('/msgbytotalconversion', 'ReportsController@msgByTotalConversion');
    Route::get('/msgbyconversionstatus', 'ReportsController@msgByConversionStatus');

    Route::get('/teammsgbygroup', 'ReportsController@teamMsgByGroup');
    Route::get('/teammsgbyteammate', 'ReportsController@teamMsgByTeammate');

    Route::get('/inboxbyagentconversations', 'ReportsController@inboxByAgentConversations');
    Route::get('/inboxbyagentresponcetime', 'ReportsController@inboxByAgentresponceTime');
    Route::get('/smsbyagentrestime', 'ReportsController@smsByAgentResTime');

    Route::get('/chatbychatsrated', 'ReportsController@chatByChatsRated');

    Route::get('/ticketbycategory', 'ReportsController@ticketByCategory');
    Route::get('/ticketbyhandletime', 'ReportsController@ticketByHandleTime');
    Route::get('/ticketbyteammate', 'ReportsController@ticketByTeammate');

    Route::post('/pipelinebyleadstage', 'ReportsController@pipeLineByLeadStage');
    Route::post('/pipelinebydealstage', 'ReportsController@pipeLineByDealStage');
    Route::post('/leadbyproductservice', 'ReportsController@leadByProductService');
    Route::post('/dealbyproductservice', 'ReportsController@dealByProductService');
    Route::post('/leadbyfirstcontactsource', 'ReportsController@leadByFirstContactSource');
    Route::post('/dealbyfirstcontactsource', 'ReportsController@dealByFirstContactSource');
    Route::post('/salesbyfirstcontactsource', 'ReportsController@salesByFirstContactSource');
    Route::post('/salesbyproductsource', 'ReportsController@salesByProductSource');


    ///====		END REPORTS ROUTES 		=====	//////	
    ///====		START CUSTOM VIEW  ROUTES 		=====	//////	

    Route::get('/customviewlisting', 'CustomviewController@viewlist');
    Route::post('/repordetails', 'CustomviewController@reportbyid');
    Route::get('/reportlist', 'CustomviewController@reportlist');
    Route::post('/addreportlist', 'CustomviewController@addreportlist');
    Route::post('/updatereportlist', 'CustomviewController@updatereportlist');
    Route::post('/reportlist/delete', 'CustomviewController@deletereportlist');
    Route::post('/reportlist/reportlistbyid', 'CustomviewController@reportListById');


    ///====		END CUSTOM VIEW  ROUTES 		=====	//////	
    ///====		START TRENDS ROUTES 		=====	//////	

    Route::post('/trend/metric', 'TrendController@metricList');
    Route::post('/trend/addtrendalert', 'TrendController@addTrendAlert');
    Route::post('/trend/masteralertlist', 'TrendController@masterAlertList');
    Route::post('/trend/alertdatalist', 'TrendController@alertDataList');
    Route::post('/trend/chngestatus', 'TrendController@changeStatus');
    Route::post('/trend/editmasteralert', 'TrendController@editMasterAlert');
    Route::post('/trend/deletemasteralert', 'TrendController@deleteMasterAlert');
    Route::post('/trend/updatemasteralert', 'TrendController@updateMasterAlert');
    Route::get('/trend/addnewalertdatacron', 'TrendController@addNewAlertDataCron');
    Route::get('/trend/sendalertfromcronontime', 'TrendController@sendAlertFromCronOnTime');
    Route::get('/trend/updatealertresult', 'TrendController@updateAlertResult');
    Route::post('/trend/searchmetric', 'TrendController@searchMetricList');

    ///====		END TRENDS ROUTES 		=====	//////	

    Route::get('/chat-scheduling', 'ChatSchedulingController@index')->middleware('CheckPermission:chat_settings');
    Route::get('/activity-dashboard', 'ActivityDashboardController@index');
    Route::post('/save_chatscheduling_app', 'ChatSchedulingController@saveChatschedulingApp');
    Route::post('/get-all-plan', 'ChatSchedulingController@getSchedulePlanName')->middleware('CheckPermission:company_teammates_invite_edit_and_delete');
    Route::post('/get-business-hours-data', 'ChatSchedulingController@getBusinessHoursData');

    /** START holiday Routes * */
    Route::post('/get-country-holidays', 'Holidays\Holiday@getHoidaysForCurrentYear');
    Route::post('/add-custom-holiday', 'Holidays\Holiday@addCustomHoliday');
    Route::post('/add-shifts-holidays', 'Holidays\Holiday@addShiftHolidays');
    Route::post('/add-single-shift-holidays', 'Holidays\Holiday@addSingleShiftHolidays');
    Route::post('get-countrycode', 'ContactController@getcountrycode');

    /** END holiday Routes * */
    Route::post('/get_time_table', 'ChatSchedulingController@geTimetable');
    Route::post('/get_schedule_day_time_table', 'ChatSchedulingController@getScheduleDayTimeTable');
    Route::post('/filter-chat-time', 'ChatSchedulingController@getFilterChatTime');
    Route::post('/dele_schedule_day_time_table', 'ChatSchedulingController@DeleteScheduleDayTimeTable');
    Route::post('/get_all_schedule_list', 'ChatSchedulingController@getAlScheduleList');
    Route::post('/get-invitee-by-plan', 'ChatSchedulingController@getInviteeByPlan');
    Route::post('/update-plan', 'ChatSchedulingController@updatePlan');
    Route::post('/delete_plan', 'ChatSchedulingController@deletePlan');

    Route::post('/create-plan', 'ChatSchedulingController@createPlan');
    Route::post('/update-plans', 'ChatSchedulingController@updatePlans');
    Route::get('/get-all-shift', 'ChatSchedulingController@getPlanShift');

    Route::get('/visitor', 'VisitorController@index')->middleware('CheckPermission:monitoring_access');
    Route::post('/get-real-time-chat', 'VisitorController@getRealTimeChat');
    Route::get('/transcript-archive', 'TranscriptArchiveController@index');
    Route::get('/ticket', 'TicketController@index')->middleware('CheckPermission:help_center_all');
    Route::get('/ticket-email', 'TicketEmailController@index')->middleware('CheckPermission:email_settings');
    Route::get('/facebook', 'FacebookController@index')->middleware('CheckPermission:facebook_messenger_settings');
    Route::get('/triggers', 'TriggersController@index')->middleware('CheckPermission:forms_view');
    Route::post('/deleteTrigger', 'TriggersController@deleteTrigger');
    Route::post('/triggers', 'TriggersController@addEditTrrigger')->middleware('CheckPermission:forms_view');
    Route::post('/triggersList', 'TriggersController@getTriggerList');
    Route::post('/create-trigger', 'TriggersController@createTrigger');
    Route::post('/update-trigger-status', 'TriggersController@updateTriggerStatus');
    Route::post('/update-trigger', 'TriggersController@updateTrigger');
    Route::post('/filter-trigger', 'TriggersController@filterTrigger');
    Route::get('/trigger-center-iframe', 'TriggersController@TriggerCenter');
    Route::post('/get-buttonuse-list', 'TriggersController@getButtonuseList');
    Route::post('/trigger-websites', 'TriggersController@getTriggerWebsites');

    Route::get('/trigger-iframe', 'IframeController@getTriggerIframe');
    Route::get('/console', 'ConsoleController@index');
    //Route::post('/console/upload-file', 'ConsoleController@uploadFile');
    Route::post('/console/delete-file', 'ConsoleController@deleteFile');
    Route::post('/console/delete-msg', 'ConsoleController@deleteMessage');
    Route::post('/console/update-msg', 'ConsoleController@updateMessage');
    Route::post('/update-insert-console-features', 'ConsoleController@updateInsertConsoleFeatures');
    Route::post('/get-console-features', 'ConsoleController@getConsoleFeatures');
    Route::post('/add-conversation-type', 'ConsoleController@addConversationType');
    Route::post('/edit-conversation-type', 'ConsoleController@editConversationType');
    Route::post('/delete-conversation-type', 'ConsoleController@deleteConversationType');
    Route::post('/get-article-count', 'ConsoleController@getArticleCount');


    /**
     * Collaboration Routes
     */
    Route::post('/getstarted-default-view-login', 'UsersController@GetStartedDefaultupdate');
    Route::get('/user/get-loggedin-user', 'UsersController@getCurrentLoggedInUser');
    Route::get('/user/company-details', 'UsersController@getCurrentUserComany');
    Route::get('/collaboration', 'CollaborationController@index');
    Route::get('/suggestion-box', 'SuggestionBoxController@index');
    Route::get('/customer-feedback-forum', 'CustomerFeedbackForumController@index');
    Route::get('/collaboration/get-all-groups-with-members/{user_id}', 'CollaborationController@getAllGroupsWithMembers');
    Route::get('/collaboration/fetch-thread-detail/{thread_id}/{user_id}/{count?}', 'CollaborationController@fetchThreadDetail');
    Route::post('/collaboration/get-group-threads', 'CollaborationController@getGroupThreads');
    Route::post('collaboration/get-search-message-threads', 'CollaborationController@getSearchMessageThreads');
    Route::post('/collaboration/delete-thread', 'CollaborationController@deleteThread');
    Route::post('/collaboration/send-msg', 'CollaborationController@insertMessage');
    Route::get('/collaboration/fetch-all-teammates', 'CollaborationController@fetchAllTeammates');
    Route::get('/collaboration/get-message-count', 'CollaborationController@getMessageCount');
    Route::post('/collaboration/sound-on-Off', 'CollaborationController@soundOnOff');
    Route::post('/collaboration/get-sound-detail', 'CollaborationController@getSoundDetail');
    Route::post('/collaboration/update-msg', 'CollaborationController@updateMessage');
    Route::post('/collaboration/delete-msg', 'CollaborationController@deleteMessage');
    Route::post('/collaboration/delete-file-from-msg', 'CollaborationController@deleteFileFromMessage');
    Route::post('/send-guest-request', 'CollaborationController@sendGuestRequest');
    Route::post('/get-all-groups', 'CollaborationController@getAllGroupsList');
    Route::post('/get-all-channel', 'CollaborationController@getAllChannelsList');
    Route::post('/collaboration/save-post', 'PostController@saveTeamPost');
    Route::post('/collaboration/share-post', 'PostController@shareTeamPost');
    Route::post('/get-all-drafted-post', 'PostController@getAllDraftedPost');
    Route::post('collaboration/delete-Drafted-post', 'PostController@deleteDraftedPost');
    Route::get('/showPost/{messegeid}', 'PostController@showPost');
    Route::get('/showSavedPost/{messegeid}', 'PostController@showSavedPost');
    Route::post('/post/getall-post', 'PostController@getPost');
    Route::any('/get-tm-media-file/{token}', 'CollaborationMediaController@getFileFromUrl');
    Route::any('/get-tm-media-download/{token}', 'CollaborationMediaController@getMediaFileDownload');
    Route::post('/collaboration/check-user-login-status', 'CollaborationController@checkUserLoginStatus');
    Route::get('/collaboration/test', 'CollaborationController@test');
    Route::get('/collaboration/loggedin-user-acl', 'CollaborationController@loginUserAcl');
    Route::post('/collaboration/search-default', 'CollaborationController@searchTeamMessagingData');
    Route::post('/collaboration/search-tm', 'CollaborationController@searchTeamMessagingInConversationData');

    Route::get('/collaboration/check-for-new-message/{user_id}/{thread_id}', 'CollaborationController@checkForNewMessage');
    Route::get('/collaboration/mark-thread-starred/{user_id}/{thread_id}/{is_starred}', 'CollaborationController@markThreadStarred');
    Route::get('/collaboration/mark-message-starred/{user_id}/{message_id}/{is_starred}', 'CollaborationController@markMessageStarred');
    Route::get('/collaboration/mark-message-as-pinned/{message_id}/{is_pinned}/{pinned_by}', 'CollaborationController@markMessageAsPinned');
    Route::post('/collaboration/add-new-thread', 'CollaborationController@addNewThread');
    Route::post('/collaboration/add-new-user-to-thread', 'CollaborationController@addNewUserToThread');
    Route::post('/collaboration/update-group-name', 'CollaborationController@updateGroupName');
    Route::post('/collaboration/leave-group', 'CollaborationController@leaveGroup');
    Route::post('/collaboration/mute-unmute-group', 'CollaborationController@muteUnmuteGroup');
    Route::post('/collaboration/removed-from-group', 'CollaborationController@removedFromGroup');
    Route::post('/collaboration/join-public-group', 'CollaborationController@joinPublicGroup');
    Route::post('/collaboration/hide-group', 'CollaborationController@hideGroup');
    Route::post('/collaboration/unhide-group', 'CollaborationController@unHideGroup');
    Route::post('/collaboration/show-group', 'CollaborationController@showGroup');
    Route::get('/collaboration/get-all-users', 'CollaborationController@getAllUsers');
    Route::post('/collaboration/search-result', 'CollaborationController@searchResult');
    Route::post('/collaboration/upload-file', 'CollaborationController@uploadFile');
    Route::post('/collaboration/delete-file', 'CollaborationController@deleteFile');
    Route::get('/collaboration/fetch-admin-manager', 'CollaborationController@fetchAdminManager');
    Route::post('/search-thread', 'CollaborationController@searchThreadDetails');
    Route::post('/collaboration/start-forum', 'CollaborationController@startForum');
    Route::post('/collaboration/send-forum-reply-msg', 'CollaborationController@sendForumReplyMsg');
    Route::get('/collaboration/fetch-forums', 'CollaborationController@fetchForums');
    Route::post('/collaboration/fetch-single-forum', 'CollaborationController@fetchSingleForum');
    Route::post('/collaboration/unfollow-forum', 'CollaborationController@unfollowForum');
    Route::post('/collaboration/get-all-new-forum', 'CollaborationController@getAllNewForum');
    Route::post('/collaboration/mark-forum-visited', 'CollaborationController@markForumVisited');
    Route::post('/collaboration/save-activity-data', 'CollaborationController@saveActivityData');
    Route::post('/collaboration/get-activity-data', 'CollaborationController@getActivityData');
    Route::post('/collaboration/get-activity-messege', 'CollaborationController@getActivityTypeMessege');


    /**
     * Suggestions Routes
     */
    Route::get('/suggestions/get-categories', 'SuggestionBoxController@index');
    Route::get('/suggestions/get-categories', 'SuggestionBoxController@getCategories');
    Route::post('/suggestions/create-category', 'SuggestionBoxController@createCategory');
    Route::post('/suggestions/delete-category', 'SuggestionBoxController@deleteCategory');
    Route::get('/suggestions/get-suggestion-by-category-id/{category_id}', 'SuggestionBoxController@getSuggestionsByCategoryId');
    Route::get('/suggestions/get-all-suggestions', 'SuggestionBoxController@getAllSuggestions');
    Route::get('/suggestions/get-suggestion-by-id/{suggestion_id}', 'SuggestionBoxController@getSuggestionById');
    Route::post('/suggestions/create-suggestion', 'SuggestionBoxController@createSuggestion');
    Route::post('/suggestions/hide-suggestion', 'SuggestionBoxController@hideSuggestion');
    Route::post('/suggestions/create-comment', 'SuggestionBoxController@createComment');
    Route::post('/suggestions/delete-comment', 'SuggestionBoxController@deleteComment');
    Route::post('/suggestions/do-vote', 'SuggestionBoxController@doVote');
    Route::post('/suggestions/delete-suggestion', 'SuggestionBoxController@deleteSuggestion');
    Route::get('/suggestions/get-status', 'SuggestionBoxController@getStatus');
    Route::post('/suggestions/edit-suggestion', 'SuggestionBoxController@editSuggestion');
    Route::post('/suggestions/mark-suggestion-starred', 'SuggestionBoxController@markSuggestionStarred');
    Route::post('/suggestions/mark-category-starred', 'SuggestionBoxController@markCategoryStarred');
    Route::post('/suggestions/cat_update', 'SuggestionBoxController@catUpdate');

    Route::post('/suggestions/status-enable-disabled-change', 'SuggestionBoxController@statusEnableDisabledChange');
    Route::get('/suggestions/get-categories-enabled-disabled', 'SuggestionBoxController@getCategoryEnabledDisabled');
    Route::post('/suggestions/change-status', 'SuggestionBoxController@changestatus');

    /**
     * Customer Feedback Forum Routes
     */
    Route::get('/customerfeedbackforum/get-categories', 'CustomerFeedbackForumController@@index');
    Route::get('/customerfeedbackforum/get-categories', 'CustomerFeedbackForumController@getCategories');
    Route::post('/customerfeedbackforum/create-category', 'CustomerFeedbackForumController@createCategory');
    Route::post('/customerfeedbackforum/delete-category', 'CustomerFeedbackForumController@deleteCategory');
    Route::get('/customerfeedbackforum/get-suggestion-by-category-id/{category_id}', 'CustomerFeedbackForumController@getSuggestionsByCategoryId');
    Route::get('/customerfeedbackforum/get-all-suggestions', 'CustomerFeedbackForumController@getAllSuggestions');
    Route::get('/customerfeedbackforum/get-suggestion-by-id/{suggestion_id}', 'CustomerFeedbackForumController@getSuggestionById');
    Route::post('/customerfeedbackforum/create-suggestion', 'CustomerFeedbackForumController@createSuggestion');
    Route::post('/customerfeedbackforum/hide-suggestion', 'CustomerFeedbackForumController@hideSuggestion');
    Route::post('/customerfeedbackforum/create-comment', 'CustomerFeedbackForumController@createComment');
    Route::post('/customerfeedbackforum/delete-comment', 'CustomerFeedbackForumController@deleteComment');
    Route::post('/customerfeedbackforum/do-vote', 'CustomerFeedbackForumController@doVote');
    Route::post('/customerfeedbackforum/delete-suggestion', 'CustomerFeedbackForumController@deleteSuggestion');
    Route::get('/customerfeedbackforum/get-status', 'CustomerFeedbackForumController@getStatus');
    Route::post('/customerfeedbackforum/edit-suggestion', 'CustomerFeedbackForumController@editSuggestion');
    Route::post('/customerfeedbackforum/mark-suggestion-starred', 'CustomerFeedbackForumController@markSuggestionStarred');
    Route::post('/customerfeedbackforum/mark-category-starred', 'CustomerFeedbackForumController@markCategoryStarred');
    Route::post('/customerfeedbackforum/mark-category-starred', 'CustomerFeedbackForumController@markCategoryStarred');
    Route::post('/customerfeedbackforum/cat_update', 'CustomerFeedbackForumController@catUpdate');

    /**
     * Feedback
     * */
    Route::get('/feedback/get-categories', 'FeedbackController@getCategories');
    Route::post('/feedback/create-category', 'FeedbackController@createCategory');
    Route::post('/feedback/delete-category', 'FeedbackController@deleteCategory');
    Route::get('/feedback/get-suggestion-by-category-id/{category_id}', 'FeedbackController@getSuggestionsByCategoryId');
    Route::get('/feedback/get-all-suggestions', 'FeedbackController@getAllSuggestions');
    Route::get('/feedback/get-suggestion-by-id/{suggestion_id}', 'FeedbackController@getSuggestionById');
    Route::post('/feedback/create-suggestion', 'FeedbackController@createSuggestion');
    Route::post('/feedback/hide-suggestion', 'FeedbackController@hideSuggestion');
    Route::post('/feedback/create-comment', 'FeedbackController@createComment');
    Route::post('/feedback/delete-comment', 'FeedbackController@deleteComment');
    Route::post('/feedback/do-vote', 'FeedbackController@doVote');
    Route::post('/feedback/delete-suggestion', 'FeedbackController@deleteSuggestion');
    Route::get('/feedback/get-status', 'FeedbackController@getStatus');
    Route::post('/feedback/edit-suggestion', 'FeedbackController@editSuggestion');
    Route::post('/feedback/mark-suggestion-starred', 'FeedbackController@markSuggestionStarred');
    Route::post('/feedback/mark-category-starred', 'FeedbackController@markCategoryStarred');
    Route::post('/feedback/mark-category-starred', 'FeedbackController@markCategoryStarred');
    Route::post('/feedback/cat_update', 'FeedbackController@catUpdate');
    /* status change */
    Route::get('/feedback/get-categories-enabled-disabled', 'FeedbackController@getCategoriesEnabledDisabled');
    Route::post('/feedback/change-feedback-status', 'FeedbackController@changeFeedStatus');
    Route::post('/feedback/change-enabled-disabled-status', 'FeedbackController@changeEnabledDisabledStatus');

    //Route::post('/allwebsites', 'CompanyController@allwebsites')->middleware('CheckPermission:company_profile_departments_websites_payment_processing');

    /* Status Change */



    Route::get('/features', 'FeaturesController@index');
    Route::post('/update-insert-subscriber-features', 'FeaturesController@updateInsertSubscriberFeatures');
    Route::post('/get-subscriber-features', 'FeaturesController@getSubscriberFeatures');
    Route::get('/hire-agent', 'HireOurAgentController@index');
    Route::get('/addons', 'AddonsController@index');
    Route::get('/branding', 'AddonsController@AddonsCenter');

    Route::get('/apps', 'AppsController@index');
    Route::get('/feedback', 'FeedbackController@index');
    Route::get('/tasks', 'TasksController@index');
    /**
     * Event type
     */
    Route::get('/events', 'EventsController@index');
    Route::post('/create-event', 'EventsController@createEvent');
    Route::get('/get-subject', 'EventsController@getSubject');
    Route::get('/eventList', 'EventsController@getEvent');
    Route::post('/add-subject', 'EventsController@AddSubject');
    Route::post('/edit-subject', 'EventsController@EditSubject');
    Route::post('delete-subject', 'EventsController@DeleteSubject');
    Route::post('/updateEventtype', 'EventsController@updateEvent');
    Route::get('/removeEventtype/{id}', 'EventsController@removeEventtype');
    Route::get('/checkingBotForEvent', 'EventsController@checkingBotForEvent');
    Route::get('/getAgentList', 'EventsController@getAgentList');
    Route::get('/get-user-timezone', 'EventsController@getUserTimezone');
    //    Route::post('/eventListdata', 'EventsController@getmeetingList');
    //    Route::get('/event-link/{url}/{id}', 'EventsController@getEventLink');
    //    Route::get('/event-link-visitor/{id}', 'EventsController@getEventLinkVisitor');
    //    Route::get('/event-cancel/{url}/{id}', 'EventsController@eventCancel');
    //    Route::get('/cancel-event/{id}', 'EventsController@deleteEvent');


    Route::get('/shortcuts', 'ShortcutsController@index')->middleware('CheckPermission:chat_settings');
    Route::get('/scripts', 'ScriptsController@index')->middleware('CheckPermission:chat_settings');
    Route::get('/notifications', 'NotificationController@index');

    /* START Notification Routes */
    Route::get('/notifications-sources-types', 'Notifications\NotificationsController@sourcesAndTypes');
    Route::get('/notifications-sources-types-header', 'Notifications\NotificationsController@sourcesAndTypesHeader');
    Route::post('/update-noticfication-settings', 'Notifications\NotificationsController@updateUserSettings');
    Route::post('/get-user-noticfication', 'Notifications\NotificationsController@getUserNotifications');
    Route::post('/update-user-noticfication-delivered', 'Notifications\NotificationsController@updateUserNotificationsDelivered');
    Route::post('/update-user-noticfication-dismissed', 'Notifications\NotificationsController@dismissUserNotifications');

    /* END Notification Routes */

    Route::get('/get-noticfication-services', 'NotificationController@getNoticficationServices');
    Route::post('/update-noticfication-values', 'NotificationController@updateNoticficationValues');
    Route::post('/update_no_response', 'RoutingController@updateNoResponseData');
    Route::post('/get_no_response', 'RoutingController@getNoResponseData');
    Route::post('/get-no-response-messege', 'RoutingController@getNoResponseMsgData');
    Route::post('/insert-no-response-messege', 'RoutingController@insertNoResponseMessege');
    Route::post('/change-no-response-message-status', 'RoutingController@changeNoResponseMessageStatus');
    Route::post('/update-no-response-messege', 'RoutingController@updateNoResponseMessege');
    Route::post('/delete-no-response-messege', 'RoutingController@deleteNoResponseMessege');
    Route::post('/filter-no-response-messege', 'RoutingController@filterNoResponseMessege');

    Route::post('/get-router-list', 'RoutingController@getRouterRist');
    Route::post('/update-router', 'RoutingController@updateRouter');
    Route::post('/update-router-status', 'RoutingController@updateRouterStatus');
    Route::post('/replicate-router', 'RoutingController@replicateRouter');


    Route::get('/get-noticfication-sounds', 'NotificationController@getNoticficationSounds');
    Route::get('/get-noticfication-emailSms', 'NotificationController@getNoticficationEmailSms');
    Route::get('/languages', 'LanguagesController@index');
    Route::get('/banned-visitor', 'BannedVisitorController@index')->middleware('CheckPermission:chat_settings');
    Route::get('/integrations', 'IntegrationController@index');
    Route::get('/appointments', 'AppointmentsController@index');
    Route::post('/subscriber-appointment-schedule', 'AppointmentsController@appointmentSchedule');
    Route::post('/update-subscriber-appointment-schedule', 'AppointmentsController@updateappointmentSchedule');
    Route::post('/get-subscriber-schedule', 'AppointmentsController@getappointmentSchedule');
    Route::post('/get-contact-by-email', 'AppointmentsController@getContactByEmail');
    Route::post('/convert-appointment-schedule-time', 'AppointmentsController@convertAppointmentScheduleTimezone');
    Route::post('/schedule_appointment', 'AppointmentsController@scheduleAppointment');
    Route::post('/add-appmt-subject', 'AppointmentsController@addAppmtSubject');
    Route::post('/get-appmt-subjects', 'AppointmentsController@getAppmtSubjects');
    Route::post('/update-appmt-subject', 'AppointmentsController@updateAppmtSubjects');
    Route::post('/delete-appmt-subject', 'AppointmentsController@deleteAppmtSubjects');
    Route::post('/add-task', 'AppointmentsController@addTask');
    Route::post('/edit-task', 'AppointmentsController@editTask');
    Route::post('/update-task', 'AppointmentsController@updateTask');
    Route::post('/delete-task', 'AppointmentsController@deleteTask');
    Route::post('/get-contact', 'AppointmentsController@getContact');
    Route::post('/get-thread-contact', 'AppointmentsController@getThreadContact');
    Route::post('/get-filter-list', 'AppointmentsController@getFilterTask');
    Route::post('/get-task-list', 'AppointmentsController@getTaskList');
    Route::post('/search-task-for-terms', 'AppointmentsController@searchTaskforTerms');

    Route::get('/get-timezone-base-date', 'AppointmentsController@getTimezoneBaseDate');
    Route::post('/save-user-availability', 'AppointmentsController@saveUserAvailability');
    Route::post('/save-user-availability-timeslot', 'AppointmentsController@addUserAvailabilityTimeslot');
    Route::post('/get-user-availability', 'AppointmentsController@getUserAvailability');
    Route::post('/get-time-slot', 'AppointmentsController@getTimeSlot');
    Route::post('/booking-event', 'AppointmentsController@bookingEvent');
    //    Route::post('/booking-event-visitor', 'AppointmentsController@bookingEventvisitor');
    Route::post('/booking-event-conversation', 'AppointmentsController@bookingEventFromConversation');

    Route::post('/get-booking-event', 'AppointmentsController@getEventList');
    Route::post('/serach-events-names', 'AppointmentsController@searchEventsName');
    Route::post('/delete-booking-event', 'AppointmentsController@deleteBookingEvent');

    /*
     * Emai Signature
     */

    Route::get('/email-signature', 'AppointmentsController@getEmailSignature');
    Route::get('/get-task-contact-list', 'AppointmentsController@getTaskContactLists');

    Route::post('/ticket', 'TicketController@addticket');
    Route::post('/getProdServeList', 'TicketController@getProdServeList');
    Route::post('/getProdServeList_pagination', 'TicketController@getProdServeList_pagination');
    Route::post('/tag_add', 'TicketController@tag_add');
    Route::any('/getTagList', 'TicketController@getTagList');
    Route::post('/prodServe_add', 'TicketController@prodServe_add');
    Route::post('/prodServe_update', 'TicketController@prodServe_update');
    Route::post('/ticket_Prodeseve_update', 'TicketController@ticketProdeseveupdate');
    Route::post('/tag_update', 'TicketController@tag_update');
    Route::post('/ticket_Prodeseve_delete', 'TicketController@deleteProdServe');
    Route::post('/ticket_email_forward', 'TicketController@ticketEmailForward');

    Route::post('/ticket_email_forward_delete', 'TicketController@ticketEmailForwardDelete');
    Route::post('/update-auto-response', 'TicketController@updateAutoResponse');
    Route::post('/get-auto-response', 'TicketController@getAutoResponse');
    Route::post('/update-auto-response-status', 'TicketController@updateAutoResponseStatus');
    Route::post('/get-auto-response-status', 'TicketController@getAutoResponseStatus');
    Route::post('/getTicketSupportEmail', 'TicketController@getTicketSupportEmail');
    Route::post('/tag_delete', 'TicketController@tag_delete');
    Route::post('/getSource', 'TicketController@getSource');
    Route::post('/add-source', 'TicketController@addSource');
    Route::post('/update-source', 'TicketController@updateSource');
    Route::post('/delete-source', 'TicketController@deleteSource');
    Route::post('/remove-source', 'TicketController@removeSource');
    Route::post('/confirm-delete-source', 'TicketController@updateSourceZero');
    Route::post('/getWebsite', 'TicketController@getWebsite');
    Route::post('/search-product-service-name', 'TicketController@searchProductServices');
    Route::post('add-product-service-category', 'TicketController@addProductServiceCategory');
    Route::get('/getProductServiceCategories', 'TicketController@getProductServiceCategories');
    Route::post('delete-product-service-category', 'TicketController@deleteProductServiceCategory');
    Route::post('update-product-service-category', 'TicketController@editProductServiceCategory');
    Route::get('import-product-service-sample-file', 'TicketController@importProductServiceSampleFile');
    Route::post('save-mapped-csv-product-service', 'TicketController@saveMappedCsvProductServices');
    Route::get('/get-import-log/{module_name}', 'TicketController@getImportLog');



    Route::post('/getTicketListById', 'TicketController@getTicketListById');
    Route::post('/add-ticket-via-console', 'TicketController@InsertTicketViaConsole');
    Route::post('/create-sms-conversation', 'SmsController@createSmsConversation');
    Route::post('/reply-of-sms-conversation', 'SmsReplyController@replyOfSmsConversation');

    Route::get('/button-design', 'DesignController@index')->middleware('CheckPermission:chat_settings');
    Route::post('/button-design', 'DesignController@index')->middleware('CheckPermission:chat_settings');
    Route::post('/website-preview-image-url', 'DesignController@websitePreviewImageUrl');
    Route::post('/assign-theme-website', 'DesignController@assignThemeWebsite');
    Route::post('/get-chat-agents', 'DesignController@getChatAgents');
    Route::post('/remove-window-template', 'DesignController@removeWindowTemplate');

    Route::get('/admin-sms', 'AdminSMSController@index');

    Route::get('/chat', 'ConsoleController@chat');
    Route::get('/operator-thread', 'ConsoleController@operatorThread');

    Route::post('/agent-list', 'DesignController@agentList');
    Route::post('/set-agent-status', 'CompanyController@setAgentStatus');
    Route::post('/delete-invitee', 'CompanyController@deleteInvitee');
    Route::post('/deactivate-agent', 'CompanyController@deactivateAgent');
    Route::post('/update-invitee-time-plan', 'CompanyController@updateInviteeTimePlan');
    Route::post('/get-invitee-time-plan', 'CompanyController@getInviteeTimePlan');
    Route::post('/get-admin-contact-filter', 'CompanyController@getAdminContactFilter');
    Route::post('/add-admin-contact-filter', 'CompanyController@addAdminContactFilter');
    Route::post('/update-agent-signature', 'CompanyController@updateAgentSignature');
    Route::post('/get-agent-signature', 'CompanyController@getAgentSignature');
    Route::post('/get-agent-signature-image', 'CompanyController@getAgentSignatureImage');
    Route::post('/upload-chat-signature-images', 'CompanyController@getCompanyLogoImage');
    Route::post('/check-email', 'CompanyController@checkEmail');

    Route::get('import-teammate-sample-file', 'CompanyController@importTeammateSampleFile');
    Route::post('save-mapped-csv-teammates', 'CompanyController@saveMappedCsvTeammates');
    Route::get('/get-teammate-import-log/{module_name}', 'CompanyController@getTeammateImportLog');
    Route::post('/get-imported-file-errors', 'CompanyController@getTeammateImportLogError');

    Route::get('/code-script', 'CodeController@codeScript');

    Route::get('/visitors-ajax-window', 'WebController@chatWindowCode');
    Route::get('/pdf', 'WebController@sendTranscriptMailviaget');
    Route::get('/checkNotificationstatus', 'WebController@checkNotificationstatus');
    Route::get('/visitors-ajax-window-prechat', 'WebController@preChatWindowCode');
    Route::get('/visitors-ajax-window-offline', 'WebController@offlineChatWindowCode');
    Route::post('/end-chat-by-visitor', 'WebController@closeChatByVisitor');
    Route::post('/upload-attachment-by-thread', 'WebController@uploadAttachmentByThread');
    Route::post('/send-transcript-mail', 'WebController@sendTranscriptMail');

    Route::post('/agent-chat-console', 'ConsoleController@chatConsole');
    Route::post('/add-window-template', 'DesignController@addWindowTemplate');
    Route::post('/update-window-template', 'DesignController@updateWindowTemplate');
    Route::post('/delete-window-template', 'DesignController@deleteWindowTemplate');
    Route::post('/get-subscriber-form', 'DesignController@getSubscriberForm');
    Route::post('/get-all-window', 'DesignController@getAllWindow');
    Route::post('/save-visitor', 'ConsoleController@saveVisitor');
    Route::get('/get-assignee', 'ConsoleController@getAssignee');
    Route::post('/get-filter-data', 'ConsoleController@getFilterData');
    Route::post('/get-search-data', 'ConsoleController@getSearchData');
    Route::post('/chat-related-info', 'ConsoleController@chatRelatedInfo');
    Route::get('/get-starred-chat', 'ConsoleController@getStarredChat');
    Route::post('/get-date-thread', 'ConsoleController@getDateThread');
    Route::post('/get-search-starred-thread', 'ConsoleController@getSearchStarredThread');
    Route::post('/get-search-chat-message', 'ConsoleController@getSearchChatMsg');


    Route::post('/ban-ip-address', 'ConsoleController@banIpAddress');
    Route::post('/update-ban-ip-address', 'ConsoleController@UpdateBanIpAddress');
    Route::post('/delete-ban-ip-address', 'ConsoleController@DeleteBanIpAddress');
    Route::post('/add-crm-users', 'ConsoleController@addCrmUsers');
    Route::post('/get-crm-data', 'ConsoleController@getAllCrmData');
    Route::post('/get-all-banned-ip', 'ConsoleController@getAllBannedIp');

    Route::get('/all-window', 'IframeController@AllWindow');
    Route::get('/all-window-non', 'IframeController@AllWindowNon');
    Route::get('/all-window-bot/{botid}', 'IframeController@AllWindowBot');
    Route::get('/active-window', 'IframeController@activeWindow');
    Route::get('/active-window-mobile', 'IframeController@activeWindowMobile');
    Route::get('/prechat-window', 'IframeController@prechatWindow');
    Route::get('/prechat-window-mobile', 'IframeController@prechatWindowMobile');
    Route::get('/offline-window', 'IframeController@offlineWindow');
    Route::get('/offline-window-mobile', 'IframeController@offlineWindowMobile');
    Route::get('/demo-window', 'IframeController@demoWindow');
    Route::get('/demo-window-mobile', 'IframeController@demoWindowMobile');

    //Notification
    //    Route::get('/notification', 'NotificationController@getNotificationData');
    Route::post('/replicate-theme', 'DesignController@replicateTheme');
    Route::post('/upload-chat-button-images', 'DesignController@uploadImage');
    Route::post('/upload-chat-trigger-images', 'TriggersController@uploadTriggerImage');

    Route::get('/get-timezone-list', 'CompanyController@getTimezoneList');
    Route::post('/get-invitee-on-edit', 'CompanyController@getInviteeOnEdit');
    Route::post('/get-invitee-on-show-profile', 'CompanyController@getInviteeOnShowProfile');
    Route::post('/get-invitee-on-edit-contact', 'CompanyController@getInviteeContactOnEdit');

    Route::get('/save-prechatwindow', 'WebController@chatIframeWindowCode');
    Route::get('/save-offlinechatwindow', 'TicketController@saveOfflineChatWindow');

    Route::get('/track-ajax', 'TrackController@trackCode');
    //    Route::post('/user/availablity-status', 'UsersController@availablityStatus');
    Route::post('/get-all-select-list', 'ConsoleController@getAllSelectList');
    Route::post('/get-visitor-deal-list', 'ConsoleController@visitorRunningDealList');
    Route::post('/save-lead-type', 'ConsoleController@saveLeadType');

    // content builder
    Route::get('/content-builder', 'ContentBuilderController@index');


    //super admin section

    Route::get('/admin/contact', 'Admin\ContactController@index');
    Route::post('/admin/subscriber', 'Admin\ContactController@getSubscribers');

    Route::get('/hire-our-chat-agents', 'HireOurAgentController@hireOurChatAgents');
    Route::post('/hire-our-agent', 'HireOurAgentController@savehireOurChatAgents');
    Route::post('/free-code-installation', 'AddonsController@saveFreeCodeInstallation');
    Route::post('/free-programming-consultation', 'AddonsController@saveFreeProgrammingConsultation');

    Route::post('/website-script-info', 'ConsoleController@websiteScriptInfo');
    Route::post('/website-offer-info', 'ConsoleController@websiteOfferInfo');
    Route::post('/save-product', 'ConsoleController@saveProduct');
    Route::post('/get-selected-prod', 'ConsoleController@getSelectedProd');
    Route::post('/check-visitor-lang', 'TranslateController@checkVisitorLang');
    Route::post('/share-transcript-via-email', 'ConsoleController@shareTranscriptViaEmail');


    Route::get('/chat-window/{subscriber_id}/{theme_id}', 'WebIframeController@chatWindow');
    //this route should be above CheckSubscriber middleware because it is using in iframe visitor
    //Route::post('/search-article-data', 'WebIframeController@searchArticleData');
    //Route::post('/search-article-data', 'WebIframeController@searchArticleData');

    Route::post('/search-article-data-more-results', 'WebIframeController@searchArticleDataMoreResult');

    Route::post('/iframe-article-news-by-id', 'WebIframeController@newsArticleDataById');

    Route::post('/upload-background-image', 'DesignController@uploadBackgroundImage');

    /*
      |--------------------------------------------------------------------------
      | Start: Conversation Hub Routes
      |--------------------------------------------------------------------------
     */
    Route::get('/conversation-hub', 'ConversationHubController@index');
    Route::post('/run-conversations', 'ConversationHubController@chatConsole');
    Route::post('/agent-chat-close', 'ConversationHubController@closeChatByAgent');
    Route::post('/show-hide-action', 'ConversationHubController@showHideAction');
    Route::post('/conversation-hub/save-visitor', 'ConversationHubController@saveVisitor');
    Route::post('/save-visitor-status', 'ConversationHubController@saveVisitorStatus');
    Route::post('/update-chat-note', 'ConversationHubController@updateChatNote');
    Route::post('/ban-visitor-ip-address', 'ConversationHubController@banVisitorIpAddress');
    Route::get('/conversation-hub-test-chat-iframe/{subscriberGeneratedId}/{subscriberId}/{activeThemeId}/{websiteId}/{refererUrl}', 'ConversationHubController@testChatIframe');
    Route::post('/test-chat-window-setting-data', 'ConversationHubController@chatWindowSettingdata');
    Route::post('/run-conversations-other-pages', 'ConversationHubController@chatConsoleOtherPages');
    Route::post('/do-star-conversation', 'ConversationHubController@doStarConversation');
    Route::post('/console/upload-file', 'ConversationHubController@uploadFile');
    Route::any('/test-oq', 'ConversationHubController@oqtic');
    Route::post('/check-ban-ip', 'ConversationHubController@checkBanIP');
    Route::post('/send-email-to-thread-visitor', 'ConversationHubController@sendEmailToThreadVisitor');
    Route::post('/get-team-open-conv-activity', 'ConversationHubController@getTeamOpenConversationActivity');
    Route::post('/subscriber-products', 'ConversationHubController@getProducts');
    Route::post('/get-email-chat-history', 'ConversationHubController@getEmailChatHistory');
    Route::post('/all-script-websites', 'ConversationHubController@allScriptWebsites');


    /*
      |--------------------------------------------------------------------------
      | Start: User Availablity
      |--------------------------------------------------------------------------
     */
    Route::get('/change-user-availablity-status', 'UsersController@changeUserAvailablityStatus');
    /**
     * ------------------------------------------------------------------------
     * START Holidays routes
     * ------------------------------------------------------------------------
     */
    Route::get('/get-subscriber-countries', 'UsersController@changeUserAvailablityStatus');

    /**
     * ------------------------------------------------------------------------
     * END Holidays routes
     * ------------------------------------------------------------------------
     */
    /**
     * START Analytics Routes
     */
    Route::post('/store-google-analytics-data', 'Analytics\GoogleAnalyticsController@storeGoogleIntegrationData');
    Route::post('/get-google-analytics-data', 'Analytics\GoogleAnalyticsController@getGoogleIntegrationData');
    Route::post('/delete-ga-tracker', 'Analytics\GoogleAnalyticsController@deleteGaTracker');
    /**
     * END  Analytics Routes
     */
    Route::get('/get-started', function () {
        return view('get_started');
    });

    Route::get('/m-get-started', function () {
        return view('m_get_started');
    });


    // Connect Google Calendar Routes
    Route::get('oauth', ['as' => 'oauthCallback', 'uses' => 'GoogleCalendarController@oauth']);
    Route::get('/connect-calendar', 'GoogleCalendarController@index');
    // Calendar routes
    Route::post('/calendar/upload', 'AppointmentsController@uploadCalendarFile');
    Route::post('/calendar/save', 'AppointmentsController@calendarSave');
    Route::get('/get/calendar', 'AppointmentsController@getCalendarData');
    Route::get('get-calendar-email', 'GoogleCalendarController@getCalendarEmail');
    Route::get('deactivate-calendar', 'GoogleCalendarController@deActivateEmail');


    Route::get('import-contacts-sample-file', 'ContactController@importContactsSampleFile');
    Route::get('column-for-mapping', 'ContactController@getColumnForMapping');
    Route::post('save-mapped-csv-contact', 'ContactController@saveMappedCsvContact');

    Route::get('get-chat-history', 'ContactController@getChatHistory');
    Route::get('get-chat-activity', 'ContactController@getChatActivity');
    Route::get('get-from-email', 'ContactController@getFromEmail');
    Route::get('get-recent-emails', 'ContactController@getRecentEmails');
    Route::get('get-event-type-list', 'ContactController@getEventTypeList');
    Route::get('get-user-email-signature', 'ContactController@getUserEmailSignature');
    Route::get('is-sms-plan-purchased', 'ContactController@isSmsPlanPurchased');

    Route::post('create-contact', 'Support\SupportTicketController@createContact');

    Route::post('create-support-ticket', 'Support\SupportTicketController@createSupportTicket');
    Route::get('get-support-ticket', 'Support\SupportTicketController@getSupportTicket');

    /* START Goog;e 2FA routes */
    Route::get('/google2fa', 'Google2fa\Auth2fa@getQrCode');
    Route::get('/google2fa-status', 'Google2fa\Auth2fa@getCurrentStatus');
    Route::post('/google2fa-deactivate', 'Google2fa\Auth2fa@revoke2Fa');
    Route::post('/google2fa-deactivate-teammate', 'Google2fa\Auth2fa@revoke2FaAll');
    Route::post('/2fa-activate', 'Google2fa\Auth2fa@check2Fa')->middleware('2fa');
    Route::post('/2fa-for-all', 'Google2fa\Auth2fa@enable2FaAllTeamates')->middleware('2fa');
    /* END Goog;e 2FA routes */


    /* webhook get customer data & Stripe  */


    Route::get('connect/customer_data/{id}', 'Connect\ConnectController@customer_data');
    Route::get('connect/customer_data_all', 'Connect\ConnectController@customer_data_all');
    Route::get('connect/stripe_connect_url', 'Connect\ConnectController@connecturl');
    Route::get('connect/stripe_connect_url', 'Connect\ConnectController@connecturl');
    Route::get('connect/stripe_connect_return_url', 'Connect\ConnectController@connectReturnurl');
    Route::get('connect/stripe_disconnect/{id}', 'Connect\ConnectController@stripe_disconnect');

    Route::get('stripe/customers/', 'Connect\ConnectController@stripeCustomer');
    Route::get('stripe/allPrices/', 'Connect\ConnectController@allPrices');
    Route::post('stripe/createCustomerInvoice', 'Connect\ConnectController@createCustomerInvoice');
    Route::get('stripe/getAllCustomer/', 'Connect\ConnectController@getAllCustomer');
    Route::get('stripe/getinvoices/{id}', 'Connect\ConnectController@getinvoices');
    /*  End webhook */

    /* for ticket modal in CRM contact */
    Route::get('get-ticket-history', 'Support\SupportTicketController@getticketHistory');
    Route::get('/getDepartment', 'Support\SupportTicketController@getDepartment');
    Route::get('/getTicketCategories', 'Support\SupportTicketController@getTicketCategories');
    Route::post('update-ticket-category', 'Support\SupportTicketController@editTicketCategory');
    Route::post('add-ticket-category', 'Support\SupportTicketController@addTicketCategory');
    Route::post('delete-ticket-category', 'Support\SupportTicketController@deleteTicketCategory');

    /* For Ticket Edit */
    Route::post('edit-support-ticket', 'Support\SupportTicketController@editSupportTicket');
    Route::get('support-ticket-column', 'Support\SupportTicketController@SupportTicketColumn');
    Route::post('support-ticket-email-content', 'Support\SupportTicketController@SupportTicketEmailContent');
    Route::post('support/TicketForwardEmailContent', 'Support\SupportTicketController@TicketForwardEmailContent_post');

    ///====		START DEALS ROUTES 		=====	//////	

    Route::get('/deals', 'DealsController@index')->middleware('CheckPermission:deal_view');
    Route::post('/deal/stagelist', 'DealsController@subscriberDealStage');
    Route::post('/deal/leadstagelist', 'DealsController@subscriberLeadStage');
    Route::post('/deal/proserve', 'DealsController@subscriberprdservices');
    Route::post('/deal/assigneelist', 'DealsController@assigneeList');
    Route::post('/currency', 'DealsController@currency');
    Route::post('/deal/company', 'DealsController@company');
    Route::post('/deal/contact', 'DealsController@contact');
    Route::post('/deal/get-deal', 'DealsController@getDeal');
    Route::get('/deal/get-custom-fields', 'DealsController@getCustomFields');
    Route::post('/deal/add-custom-feild', 'DealsController@addCustomField');
    Route::post('/deal/delete-custom-field', 'DealsController@deleteCustomField');
    Route::get('/deal/get-custom-attributes', 'DealsController@getDealCustomAttributes');
    Route::post('/deal/create', 'DealsController@createDeal');
    Route::post('/deal/set-table-head', 'DealsController@setCompanyColumnThead');
    Route::get('/deal/get-table-head', 'DealsController@getCompanyTheader');
    Route::post('/deal/multiple-delete', 'DealsController@dealsMultipleDelete');
    Route::post('/deal/single-delete', 'DealsController@dealsSingleDelete');
    Route::post('/deal/update', 'DealsController@updateDeal');
    Route::post('/deal/get-on-edit', 'DealsController@getDealOnEdit');
    Route::get('/deal/get-dropdown-array', 'DealsController@getCompanytDropdownsArray');
    Route::get('/deal/get-bulk-editable-fileds', 'DealsController@getDealBulkEditableFields');
    Route::post('/deal/multiple-update', 'DealsController@dealsMultipleUpdate');
    Route::post('/deal/delete-dealstage', 'DealsController@deleteStage');
    Route::post('/deal/create-dealstage', 'DealsController@createDealStage');
    Route::post('/deal/update-dealstage', 'DealsController@updateDealStage');
    Route::post('/get-stage-column', 'DealsController@getDealStageColumn');
    Route::post('/get-lead-stage-column', 'DealsController@getLeadStageColumn');
    Route::post('/update-stage-column', 'DealsController@updateStageColumn');

    Route::post('/deal/get-contact-deals', 'ContactController@getContactDeals');

    ///====		END DEALS ROUTES 		=====	//////	
    ///Bots Route
    Route::post('SaveBot', 'BotsController@SaveBot');
    Route::any('Getallbots', 'BotsController@Getallbots');
    Route::post('ChangeStatus', 'BotsController@ChangeStatus');
    Route::post('deleteBots', 'BotsController@deleteBots');
    Route::post('Update', 'BotsController@Update');
    Route::post('sortBots', 'BotsController@sortBots');
    Route::post('saveDafault', 'BotsController@saveDafault');
    Route::post('/bots-report', 'BotsController@botReport');
    Route::get('/bots', 'BotsController@index')->middleware('CheckPermission:bots');

    // bots action routes
    Route::get('/bots/action/get-bot-chart-flow-order', 'Bots\BotActionController@getBotChartFlowOrder');
    Route::post('/bots/action/create-new-action', 'Bots\BotActionController@saveBotBuildingAction');
    Route::get('/bots/action/delete-child-action', 'Bots\BotActionController@deleteChildAction');
    Route::get('/bots/action/action-dropdown-array', 'Bots\BotActionController@getActionDropdownsArray');
    Route::post('/bots/action/get-article', 'Bots\BotActionController@getArticleWithSearch');
    Route::get('/bots/action/get-category', 'Bots\BotActionController@getBotActionCategory');
    Route::get('createsvg', 'BotsController@createsvg');


    Route::get('get-support-ticket-body', 'Support\SupportTicketController@getTicketBody');

    Route::get('is-email-connected', 'Settings\Email\AddressSelectionController@isEmailConnected');

    Route::get('bot/get-template', 'BotsController@getTemplate');

    //sms appprove status subscriber
    Route::get('get-bandwidth-sms-status', 'AdminSMSController@bandwidthSmsStatus');
    Route::post('get-bandwidth-sms-queue', 'AdminSMSController@bandwidthSmsMsg');
    Route::post('msg-status-update', 'AdminSMSController@msg_status_update');
    Route::post('subscriber-status-update', 'AdminSMSController@subscriberApprove');

    //get configuration for checking 
    Route::get('checkConfigurations', 'UsersController@checkConfigurations');
    Route::get('interrested-feature-getdata', 'UsersController@interrested_feature_getdata');


    // company routes 
    Route::get('/companies', 'CompaniesController@index')->middleware('CheckPermission:companies_view');

    Route::get('/company/get-contact-company', 'CompaniesController@getContactCompany');
    Route::post('/company/get-contact-company', 'CompaniesController@getContactCompanyWithSearch');
    Route::post('/company/get-company', 'CompaniesController@getCompany');
    Route::get('/company/get-standard-fields', 'CompaniesController@getStandardFieldList');
    Route::post('/company/set-table-head', 'CompaniesController@setCompanyColumnThead');
    Route::get('/company/get-table-head', 'CompaniesController@getCompanyTheader');
    Route::post('/company/create', 'CompaniesController@createCompany');
    Route::post('/company/multiple-delete', 'CompaniesController@companyMultipleDelete');
    Route::get('/company/get-bulk-editable-fileds', 'CompaniesController@getCompanyBulkEditableFields');
    Route::get('/company/get-dropdown-array', 'CompaniesController@getCompanytDropdownsArray');
    Route::post('/company/multiple-update', 'CompaniesController@companyMultipleUpdate');
    Route::post('/company/get-on-edit', 'CompaniesController@getCompanyOnEdit');
    Route::post('/company/update', 'CompaniesController@updateCompany');
    Route::get('/company/get-custom-fields', 'CompaniesController@getCustomFields');
    Route::post('/company/add-custom-feild', 'CompaniesController@addCustomField');
    Route::post('/company/delete-custom-field', 'CompaniesController@deleteCustomField');
    Route::get('/company/get-custom-attributes', 'CompaniesController@getCompanyCustomAttributes');
    Route::get('/company/get-chat-activity', 'CompaniesController@getChatActivity');


    Route::get('/get-import-log/{module_name}', 'ContactController@getImportLog');
    // team messaging
    Route::post('setColaborationVisited', 'UsersController@setColaborationVisited');

    Route::get('/get-sms-current-details', 'PlaybookController@getSmsCurrentDetails');
    Route::post('/visual-tick-mark', 'UsersController@setVisualTickMark');


    Route::get('/get-forward-bcc-data', 'Settings\Email\AddressSelectionController@getForwardAndBcc');

    /* Viddeo website  */
    Route::get('viddeo/project/', 'Connect\ConnectController@viddeoProject');
    Route::get('viddeo/projectAll/', 'Connect\ConnectController@viddeoProjectall');
    Route::post('viddeo/newproject/', 'Connect\ConnectController@viddeoProjectnew');
    Route::get('viddeo/Singleproject/{id}', 'Connect\ConnectController@Singleproject');
    /*  End webhook */


    /* for twillio messages */
    Route::get('sendTwillioMsg', 'Twillio\TwillioController@sendMessage');
    Route::get('twillio/allMsgs', 'Twillio\TwillioController@AllMessage');
    Route::get('twillio/messages', 'Twillio\TwillioController@index');
    Route::post('sendTwillioMsgForm', 'Twillio\TwillioController@sendTwillioMsgForm');
    Route::any('/get-twillio-file-url/{token?}', 'MmsMediaCotroller@getFileurlFromstorage');

    Route::post('create-twilio-registration', 'Twillio\TwillioController@twilioRegistration_submit');
     //////=====	 	PRODUCT WISE SIDE MENU 	=======//////
	
	Route::get('assign-product-menu', 'Ngaggeproduct\ProductMenu@index');
	Route::post('side-menu-data', 'Ngaggeproduct\ProductMenu@productMenuData');
	Route::get('getDirectRoute', 'Ngaggeproduct\ProductMenu@getDirectRoute');
	
	
	
    /*Bot whatsapp route Start*/
    Route::any('GetallbotsWhatsapp', 'BotsController@GetallbotsWhatsapp');
    Route::post('saveDafaultwhatsapp', 'BotsController@saveDafaultwhatsapp');
    Route::post('UpdatewhatsappBot', 'BotsController@UpdatewhatsappBot');
    Route::post('ChangeStatusBotWhatspap', 'BotsController@ChangeStatusBotWhatspap');
    Route::post('deleteBotsWhatsapp', 'BotsController@deleteBotsWhatsapp');
    Route::post('sortBotswhatsapp', 'BotsController@sortBotswhatsapp');
    Route::post('/bots-whatsapp/action/create-new-action', 'BotWhatsapp\BotWhatsappActionController@saveBotBuildingAction');
    Route::post('bots-whatsapp/action/allaction','BotWhatsapp\BotWhatsappActionController@allActionBot');
    Route::get('/bots-whatsapp/action/delete-child-action', 'BotWhatsapp\BotWhatsappActionController@deleteChildAction');
    Route::post('bots-whatsapp-report', 'BotWhatsapp\BotWhatsappActionController@GetactionReport');
    
    /*Bot whatsapp route End*/
});

Route::group(['middleware' => 'web', 'middleware' => 'hasRouteAccess'], function () {
    Route::any('/get-ch-media-file/{token}', 'ConversationHubMediaController@getThreadFileFromUrl'); //->middleware('basicAuth');
    Route::any('/get-ch-media-file-download/{token}', 'ConversationHubMediaController@getFileFromUrl'); //->middleware('basicAuth');                                       
    /*
      |--------------------------------------------------------------------------
      | Start: Visitor end chat button and window functionality Routes
      |--------------------------------------------------------------------------
     */
    Route::get('/visitors-ajax', 'WebController@chatButtonCode');
    Route::get('/visitors-chat-button-window-iframe/{subscriberGeneratedId}/{subscriberId}/{activeThemeId}/{websiteId}/{refererUrl}/{open?}/{training_type?}/{contactId?}', 'WebIframeController@visitorsChatButtonWindowIframe');
    Route::get('/get-subscriber-as-contact', 'WebIframeController@GetSubscriberAsContact');
    Route::post('/chat-window-setting-data', 'WebIframeController@chatWindowSettingdata');
    Route::post('/start-chat-by-visitor', 'WebController@initializeChatCode');
    Route::post('check-history-chat-active', 'WebController@checkHistoryChatActive');
    Route::post('/visitors-chat', 'WebController@visitorsChat');
    Route::get('/get-timezone-list', 'WebIframeController@getTimezoneList');
    Route::post('/eventListdata', 'WebIframeController@getmeetingList');
    Route::post('/get-time-slot-visitor', 'WebIframeController@getTimeSlotVisitor');
    Route::post('/set-non-business-visitor-info', 'WebIframeController@setNonBusinessVisitorInfo');
    Route::post('/submit-offline-form', 'WebIframeController@submitOfflineForm');
    Route::post('/submit-subscribe-form', 'WebIframeController@submitSubscribeForm');
    Route::post('/submit-ebook-form', 'WebIframeController@submitEbookForm');
    Route::post('/submit-prechat-form', 'WebIframeController@submitPrechatForm');
    Route::post('/get-trigger', 'WebIframeController@getTrigger');
    Route::get('/get-selected-agent/{id}', 'WebIframeController@getSelectedAgent');
    Route::post('/visitor-all-chats', 'WebIframeController@visitorAllChats');
    Route::get('/update-task-status', 'WebIframeController@updateTaskStatus');
    Route::post('/visitor/upload-file', 'WebIframeController@uploadFile');
    Route::post('/update-message-thread', 'WebIframeController@updateMessageThread');
    Route::any('/test-shiv', 'WebController@testGoogleCalendarApi');
    Route::any('/test-sms-incoming', 'WebController@testSmsIncoming');
    Route::post('/get-company-name', 'WebIframeController@getCompanyName');
    Route::post('/get-department', 'WebIframeController@getDepartment');
    Route::post('/iframe-article-news', 'WebController@iframeArticleNews');
    Route::post('/iframe-article-news-by-id', 'WebIframeController@newsArticleDataById');
    Route::get('/get-category-column', 'WebIframeController@getCategoryColumn');
    Route::get('/articleByLink/{key}/{id}', 'WebIframeController@articleByLink');
    Route::post('/article-search-subscriber-iframe', 'WebIframeController@articleSearchIframe');
    Route::post('/getWebsiteHelpCenterIframe', 'WebIframeController@getWebsiteHelpCenterIframe');
    Route::get('/articlepage/{subid}/{articleid}', 'WebIframeController@showArticlePage');
    Route::post('/get-related-article', 'WebIframeController@getRelatedArticle');
    Route::post('/articlelikedislike', 'WebIframeController@articleLikeDislike');
    Route::post('/update-message-emj', 'WebIframeController@updateMessageRateThread');
    Route::post('/send-message-comment', 'WebIframeController@sendMessageFeedBack');
    Route::post('/get-article-website', 'WebIframeController@getArticleWebsite');
    Route::post('/article-search-store-keyword', 'WebIframeController@storeArticleSearchKeyword');
    Route::post('/get-article-by-category', 'WebIframeController@getArticleByCategory');
    Route::post('/article-satisfy', 'WebIframeController@articleSatisfiable');
    Route::post('/increase-article-view', 'WebIframeController@increaseArticleView');
    /*
      |--------------------------------------------------------------------------
      | Start: Application users registration Routes
      |--------------------------------------------------------------------------
     */
    Route::get('/signup', 'UsersController@signup');
    Route::post('/register-type', 'UsersController@RegisterEmail');
    Route::get('/confirm/{userid}', 'UsersController@rgconfirm');
    Route::post('/resend-email/{userid}', 'UsersController@Resendemail');
    Route::get('/chat-feature/{userid}', 'UsersController@chatFeature');
    Route::get('/get-details/{userid}', 'UsersController@getRegisterDetails');
    Route::post('/chat-feature-type', 'UsersController@chatFeatureType');
    Route::get('/industry-employee', 'UsersController@getIndustryEmp');
    Route::get('/get-timezone', 'UsersController@getTimezoneregister');
    Route::get('/help-us/{userid}/{detailid}/{websiteid}', 'UsersController@getActivity');
    Route::get('/chatHelpusData', 'UsersController@chatHelpusData');
    Route::post('/chat-help-us', 'UsersController@chatHelpus');
    Route::post('/get-chat-help-us', 'UsersController@getChatHelpUs');
    Route::get('/feature-interested/{userid}/{detailid}/{websiteid}', 'UsersController@getFeatureInt');
    Route::post('/interrested-feature', 'UsersController@featureInterrested');
    Route::get('/start-tour/{userid}/{detailid}', 'UsersController@getStartTour');

    Route::get('/get-started-configure', 'UsersController@getStartConfigure');
    Route::get('/explore', 'UsersController@explore');





    Route::get('/step1', 'UsersController@getStep1');
    Route::post('/step-one-save', 'UsersController@stepOneSave');
    Route::post('/step2save', 'UsersController@step2Save');
    Route::get('/step2', 'UsersController@getstep2');
    Route::post('/step3', 'UsersController@step3save');
    Route::get('/step5', function () {
        return view('pages.user.register-step5');
    });
    Route::get('/step6', function () {
        return view('pages.user.register-step6');
    });
    Route::get('/step4', function () {
        return view('pages.user.register-step4');
    });
    Route::post('/step4', function () {
        return view('user.register-step4');
    });
    Route::post('/step5', 'UsersController@finalSave');
    Route::get('/step3', 'UsersController@getstep3');
    Route::get('/articlepage/{articleid}', 'UsersController@showArticlePage');

    // segments
    Route::get('/get-all-segments', 'SegmentController@listAllSegments'); //;
    Route::get('/get-all-segment-combinations', 'SegmentController@getAllPossibleSegmentCombinations'); //;

    Route::post('/get-edit-segment-data', 'SegmentController@getEditSegmentData'); //;
    Route::post('/update-segment', 'SegmentController@updateSegment');
    Route::post('/update-segment-is-filter', 'SegmentController@updateSegmentIsFilter');

    Route::post('/get-data-unsaved-segment', 'SegmentController@unsavedSegmentData');
    Route::post('/save-segment', 'SegmentController@storeSegment');
    Route::post('/delete-segments', 'SegmentController@deleteSegment');
    Route::post('/get-segment-filtered-contacts', 'SegmentController@getFilteredInviteeListAll');
    Route::post('/get-total-contacts', 'SegmentController@getTotalAvaliableContacts');
    Route::get('/get-custom-avaliable-feilds', 'SegmentController@getCustomAvaliableFeilds');
    Route::post('/check-segment-name-exists', 'SegmentController@checkSegmentNameExistsForUser');

    Route::get('/syncronize-segments', 'SegmentController@syncronizecontactsWithSegment');

    Route::any('get-user-segments', 'SegmentController@testContactInSegment');

    Route::post('/export-segment-contact', 'SegmentController@exportSegmentContact');

    //Route::get('/playbook', 'PlaybookController@index');
    Route::post('/export-playbooksms', 'PlaybookController@exportplaybooksms');
    Route::post('/add-playbook-sms', 'PlaybookController@addPlaybookSms');
    Route::post('/upadate-playbook-sms', 'PlaybookController@updatePlaybookSmsid');
    Route::post('/add-keyword-playbook', 'PlaybookController@addPlaybookkeyword');
    Route::post('/playbooksms-update', 'PlaybookController@updatePlaybookSms');
    Route::post('/playbooksms-multiple-delete', 'PlaybookController@playbooksmsMultipleDelete');
    Route::post('/playbook-activate-deactivate-change', 'PlaybookController@playbookActivateDeactivate');
    Route::post('/get-short-url', 'PlaybookController@getShortUrl');



    Route::get('/get-playbooksms-list', 'PlaybookController@getPlaybooksmsList');
    Route::post('/get-playbooksms-messagetypelist', 'PlaybookController@getPlaybookMessageTypelist');

    Route::post('/search-plabook-name', 'PlaybookController@searchPlaybookname');
    Route::post('/get-playbooksms-sortByStagelist', 'PlaybookController@getPlaybookSortByStagelist');
    Route::post('/get-playbooksms-categorytypelist', 'PlaybookController@getPlaybookCategoryTypelist');
    Route::get('/get-playbooksms-findkeyword/{keywordAutoReplyFromExternal}/{playbook_id?}', 'PlaybookController@getPlaybookKeyword');
    Route::get('/get-playbooksms-findname/{smsPlaybookName}', 'PlaybookController@getPlaybookName');

    Route::get('/get-playbooksms-id-base-list', 'PlaybookController@updatePlaybookSms');
    //Route::get('/send-mail','PlaybookController@sendMail');// this was test code
    Route::post('/dontshow-about-keyword', 'PlaybookController@insertDotshowKeyword');
    Route::post('/dontshow-sms-mmspopup', 'PlaybookController@insertDotshowallsmsmmspopup');


    Route::get('/get-playbooksms-popup', 'PlaybookController@getplaybookSmsPopup');
    Route::get('/get-playbooksmsmms-popup', 'PlaybookController@getplaybookSmsMmsPopup');

    Route::get('/get-playbooksms-bandwidth-allotted-localtollfree-number', 'PlaybookController@getpbsmsbandwidthallottednumber');

    Route::get('/get-playbooksms-bandwidth-allotted-localtollfree-number', 'PlaybookController@getpbsmsbandwidthallottednumber');

    Route::post('/add-playbooksmstemplate', 'PlaybookController@insertmessagetemplate');

    Route::get('/get-playbook-smstemplate', 'PlaybookController@getplaybooksmstemplate');
    Route::post('/delete-playbooksmstemplate', 'PlaybookController@deletePLaybookSmsTemplate');


    // start email playbook
    Route::get('/get-playbookemail-findemailname/{emailPlaybookName}', 'PlaybookEmailController@getPlaybookEmailName');
    Route::post('/add-playbook-email', 'PlaybookEmailController@addPlaybookEmail');
    Route::get('/get-playbookemail-list', 'PlaybookEmailController@getPlaybookemailList');
    Route::post('/playbookemail-multiple-delete', 'PlaybookEmailController@playbookEmailMultipleDelete');
    Route::post('/update-emailplaybook', 'PlaybookEmailController@updateEmailPlaybook');
    Route::post('/save-update-emailplaybook', 'PlaybookEmailController@saveUpdatePlaybookEmail');
    Route::post('/export-playbookEmail', 'PlaybookEmailController@exportplaybookEmail');
    Route::post('/playbookemail-sortby-categoryStage', 'PlaybookEmailController@sortEmailPlaybook');
    Route::post('/search-email-name', 'PlaybookEmailController@searchEmailName');
    Route::get('/findPlaybook-email-conatct', 'PlaybookEmailController@searchContactType');
    Route::post('/applyContact-list-playbookEmail', 'PlaybookEmailController@applyContactlistSave');
    Route::post('/manage-playbook-email-status', 'PlaybookEmailController@managePlaybookStatus');


    // start Email Transfer

    Route::any('/get-all-client-list', 'EmailTransferController@getAllClientList');
    Route::post('/add-email-transfer', 'EmailTransferController@addEmailTransfer');
    Route::get('/get-all-transfer-email', 'EmailTransferController@getAllTransferEmail');
    Route::post('/delete-email-transfer', 'EmailTransferController@deleteEmailTransfer');
    Route::post('/edit-email-transfer-data', 'EmailTransferController@editEmailTransferData');
    Route::post('/update-email-transfer-data', 'EmailTransferController@updateEmailTransferData');



    Route::post('/calendar-file-change', 'WebIframeController@fileChanged');
    Route::post('/booking-event-visitor', 'WebIframeController@bookingEventVisitor');
    Route::get('/event-link-visitor/{company}/{url}/{id}', 'WebIframeController@getEventLinkVisitor');
    Route::get('/event-link-visitor/{company}/{url}', 'WebIframeController@getEventLinkVisitor');
    Route::get('/event-cancel/{company}/{url}/{id}', 'WebIframeController@eventCancel');
    Route::get('/cancel-event/{id}', 'WebIframeController@deleteEvent');
    Route::get('/get-event-type/{id}', 'WebIframeController@getEventType');
    Route::get('/notification-email', 'WebIframeController@notification');
    Route::post('/get-available-days', 'WebIframeController@getAvailableDays');
    // routes for functionality of custom attributes
    Route::post('/check-if-feild-label-exists', 'CustomAttributes@checkLableExistsForSelectedUser');
    Route::post('deleteCustomField', 'CustomAttributes@deleteCustomField');
    Route::post('/check-if-feild-label-readable-code-exists', 'CustomAttributes@checkLableCodeReadExistsForSelectedUser');

    Route::post('/create-custom-feild', 'CustomAttributes@storeCustomSubscriberFeild')->middleware('CheckPermission:contacts_custom_field_add');

    Route::get('/get-custom-attributes', 'CustomAttributes@getAllUserCustomAttributes');

    //trigget ip work
    Route::post('/get-shift-temp', 'WebIframeController@getShiftTemp');
    Route::post('/get-website', 'WebIframeController@getWebsite');
    Route::get('/update-event-status', 'WebIframeController@updateEventStatus');

    // START routes for bandwith interaction
    Route::get('/get-bandwith-info', 'Bandwidth\Bandwidth@index');
    Route::get('/bandwith-sms-test', 'Bandwidth\SmsSender@index');
    Route::any('/callback-playbook', 'Bandwidth\CallbackHandler@index'); //->middleware('basicAuth');
    // END routes for bandwith interaction
    // START routes for SMS addons display
    Route::get('/get-sms-plan-templates', 'AddOns\SmsMessaging@getAllPlans');
    Route::post('/purchase-addon', 'AddOns\SmsMessaging@purchaseAddon');
    Route::get('/date-test', 'AddOns\SmsMessaging@test');
    Route::get('/get-sms-additional-purchase-plan-templates', 'AddOns\SmsMessaging@getSmsAdditionalPurchasePlans');
    //    Route::post('/purchase-sms-extra', 'AddOns\SmsMessaging@purchaseAddonSms');
    // END routes for SMS addons display
    // START routes for Additional addons display
    Route::get('/get-additional-addons-template', 'AddOns\AdditionalAddons@getAdditionalAddonsTemplate');

    // END routes for Additional addons display
    // START Addons Routes
    Route::get('/get-my-addons-list', 'AddOns\MyAddOns@getMyAddonsList');
    Route::get('/get-my-purchase-history', 'AddOns\MyAddOns@getMyPurchaseHistory');
    Route::get('/get-my-sms-summary', 'AddOns\MyAddOns@getMySmsSummary');
    Route::get('/get-my-sms-details', 'AddOns\MyAddOns@getMySmsDetails');
    Route::get('/get-message-logs', 'AddOns\MyAddOns@getMessageLogs');
    Route::post('/get-custmer-cards', 'AddOns\MyAddOns@getCustmerCards');
    Route::post('/save-card-for-further-subscription', 'AddOns\MyAddOns@saveCardToStripeForProcessing');
    Route::post('/set-card-as-default-card', 'AddOns\MyAddOns@setCardAsDefaultForEverything');
    Route::post('/subscribe-to-plan', 'AddOns\MyAddOns@subscribePlanWithTheCard');
    Route::post('/subscribe-to-branding-plan', 'AddOns\MyAddOns@subscribeBrandingWithTheCard');
    Route::post('/purchase-sms-extra-using-card', 'AddOns\MyAddOns@purchaseAdditionalSms');
    Route::post('/sms-addon-purchase-accept-tandc', 'AddOns\MyAddOns@smsAddonAcceptTandc');
    Route::post('/sms-addon-purchase-accept-tandc-status', 'AddOns\MyAddOns@smsAddonAcceptTandcStatus');

    Route::post('/purchase-additional-addon', 'AddOns\MyAddOns@purchaseAdditionalAddonWithTheCard');


    Route::post('/order-bandwidth-number', 'AddOns\MyAddOns@orderNumberFromBandwidth');

    Route::post('/cancel-addon', 'AddOns\MyAddOns@cancelAnAddon');

    Route::any('/get-all-countries', 'Countries@getAllCountries');
    Route::any('/get-all-countries-default', 'Countries@getAllCountries_default');


    // END Addons Routes
    /* SMS sending Routes */
    Route::post('/send-sms-to-individual-person', 'ContactController@sendSmsToContact');
    Route::post('/send-whatsapp-to-individual-person', 'Twillio\TwillioController@sendWtsappToContact');
    Route::get('/get-all-thread-msg', 'Social\Google\ApiController@getThreadMessage');
    Route::get('/makeAttachmentStructure', 'Social\Google\ApiController@makeAttachmentStructure');
    Route::get('/get-all-gmail-attachment', 'Social\Google\ApiController@getAllAttachment');
    Route::get('/get-gmail-attachment/{gmail_message_id}/{attachment_id}', 'Social\Google\ApiController@getGmailMessageAttachment');
    Route::get('/download-gmail-attachment/{gmail_message_id}', 'Social\Google\ApiController@downloadGmailMessageAttachment');
    /* END sending Routes */
    Route::any('/get-media-file/{token}', 'MmsMediaCotroller@getFileFromUrl'); //->middleware('basicAuth');
    Route::any('/get-thread-media-file/{token}', 'MmsMediaCotroller@getThreadFileFromUrl');
    Route::any('/get-ebook/', 'MmsMediaCotroller@GetfileEbook');


    Route::post('/upload-a-file-for-mms', 'UploadFiles@uploadFileForMMS'); //->middleware('basicAuth');
    //Route::any('/simulate-deductions', 'Bandwidth\CallbackHandler@simulateDeductions');
    //Route::any('/test', 'Test@index');
    Route::any('/test', 'Test@index');
    Route::any('artisan', 'Test@artisan');
    Route::any('dkim', 'Test@dkimFetch');
    Route::any('phpmailer', 'Test@sendMailUsingPHPMailer');



    /* Email Api Routes */
    Route::get('/authenticate/google', 'Social\Google\AuthController@googleRedirect')->name('authenticate/google');
    Route::get('/authenticate/callback/google', 'Social\Google\AuthController@googleCallback')->name('authenticate/callback/google');
    Route::any('/google/refresh-token', 'Social\Google\AuthController@refreshAccessToken')->name('google/refresh-token');

    Route::post('send-mail-via-gmail', 'Social\Google\ApiController@sendMessage')->name('send-mail-via-gmail');
    Route::get('send-mail-reply-via-gmail', 'Social\Google\ApiController@testSendReply');
    Route::any('get-gmail-message-history', 'Social\Google\ApiController@getcontactMessage');
    /* email test route */
    Route::any('get-gmail-message-with-filter', 'Social\Google\ApiController@getEmailsWithFilter');
    Route::any('sync-gmail-message', 'Social\Google\ApiController@syncMessageFromGmail');

    /* Start chrome extension Routes */
    Route::any('user-existance/{user_email}', 'Extension\ChromeController@userExistance');
    Route::any('check-contact-existance', 'Extension\ChromeController@checkContactExistance');
    Route::any('add-new-contact', 'Extension\ChromeController@addNewContact');
    Route::any('open-gmail-compose-box', 'Extension\ChromeController@openComposeBox');
    Route::any('gmail-message-opened/{track_code}', 'Extension\ChromeController@messageOpened');
    Route::any('add-message-tracker', 'Extension\ChromeController@addMessageTracker');
    /* End chrome extension Routes */
    Route::any('contact-test', 'Extension\ChromeController@smsContactCheck');
    Route::any('getMetadataHeaders', 'Social\Google\ApiController@getMetadataHeaders');

    Route::any('test-msg-activated-schedule', 'Sms\SmsMessageController@testAllActivatedPlaybookToScheduleMsg');
    Route::get('updateValueToJson', 'Social\Google\ApiController@makeMultipleContactReference');


    /* Email Selection Routes */
    Route::get('/get-all-social-data', 'Settings\Email\AddressSelectionController@getSocialData')->name('get-all-social-data');
    Route::get('/get-all-teammates-data', 'Settings\Email\AddressSelectionController@getTeammatesData');
    Route::get('/get-all-websites-data', 'Settings\Email\AddressSelectionController@getWebsitesData');
    Route::get('/check-selected-domain-branding', 'Settings\Email\AddressSelectionController@checkSelectedDomainBranding');
    Route::post('/link-email-with-purchased-domain', 'Settings\Email\AddressSelectionController@linkEmailWithPurchasedDomain');
    Route::post(
        'setting/email/display-add-selection-info-popup',
        'Settings\Email\AddressSelectionController@dontDisplayEmailSelectionInfoPopup'
    );
    Route::post('/set-inbox-accessibility', 'Settings\Email\AddressSelectionController@setinboxAccessibility');
    Route::post('/update-selected-email-address', 'Settings\Email\AddressSelectionController@updateSelectedEmailAddress');
    Route::post('/delete-selected-email-address', 'Settings\Email\AddressSelectionController@deleteSelectedEmailAddress');
    Route::post('/send-to-developer', 'Settings\Email\AddressSelectionController@sendToDeveloper');

    Route::get('/get_spf', 'Playbook\CompanyEmailController@getSPF');
    Route::get('/fetch_dkim', 'Playbook\CompanyEmailController@fetchDKIM');
    Route::get('/send-company-mail', 'Playbook\CompanyEmailController@sendCompanyMail');
    Route::get('/verify-company-mail/{team_id}', 'Playbook\CompanyEmailController@verifyTeamEmail');
    Route::get('/get-company-mail', 'Playbook\CompanyEmailController@getCompanyMail');
    /* Start FaceBook Ads */

    Route::any('get-facebook-accountads', 'FacebookController\PlaybookFacebookController@get_Ads_accounts');
    Route::any('get-facebook-account-compaign', 'FacebookController\PlaybookFacebookController@get_Ads_accounts_comapaign');
    Route::any('get-target-location', 'FacebookController\PlaybookFacebookController@fetchAllLocation');
    Route::any('get-target-language', 'FacebookController\PlaybookFacebookController@getFacebookAdsTargetLanguage');
    Route::any('get-all-audience', 'FacebookController\PlaybookFacebookController@getFacebookAdsAudience');
    Route::any('get-all-targeting', 'FacebookController\PlaybookFacebookController@getAllTargenting');
    //Route::any('get-all-type-preview','FacebookController\PlaybookFacebookController@getAdsPreview');
    Route::any('get-request-type-preview', 'FacebookController\PlaybookFacebookController@getAdsPreviews');
    Route::any('get-compaign-id-through-ads-set', 'FacebookController\PlaybookFacebookController@getCompaignIdBaseadssetList');
    Route::post('createphoto-getfacebook-post_id', 'FacebookController\PlaybookFacebookController@createphotoGetFacebookPostId');
    Route::post('get-change-image-text-with-preview', 'FacebookController\PlaybookFacebookController@getAdsImageTextChangePreview');
    Route::get('get-all-facebook-Ads', 'FacebookController\PlaybookFacebookController@getAllads');
    Route::any('get-all-targeting-ads', 'FacebookController\PlaybookFacebookController@getAlltargetingLocation');

    Route::post('fb-all-data-activate', 'FacebookController\PlaybookFacebookController@fbAlldataActivate');
    Route::post('fbads-all-data-update', 'FacebookController\PlaybookFacebookController@fbAdsAlldataUpdate');

    Route::post('delete-facebook-ads', 'FacebookController\PlaybookFacebookController@deletefbFacebookAds');

    Route::post('search-messenger-name', 'FacebookController\PlaybookFacebookController@searchMessengerName');
    Route::get('get-all-facebook-pages', 'FacebookController\PlaybookFacebookController@getAllFacebookPages');
    Route::get('get-all-ads-account', 'FacebookController\PlaybookFacebookController@getAllAdsAcount');
    Route::any('edit-facebook-ads', 'FacebookController\PlaybookFacebookController@editFacebookAds');
    Route::any('edit-facebook-ads1', 'FacebookController\PlaybookFacebookController@editFacebookAds1');

    Route::any('edit-campaign-ads', 'FacebookController\PlaybookFacebookController@editCampaignAds');
    Route::any('get-messenger-welcome-screen', 'FacebookController\PlaybookFacebookController@getwelcomeScreenActivePagesresponse');

    /* START Monitoring */

    Route::any('get-all-open-conversation/{channel_id}', 'Monitoring\openConversationController@getAllOpenConversation');
    Route::post('monitoring-open-conversation-channel-set', 'Monitoring\openConversationController@monitoringOpenConversationChannelSet');
    Route::any('monitoring-open-conversation-channel-setup', 'Monitoring\openConversationController@monitoringOpenConversationChannelSetup');

    Route::any('get-all-in-queue/{inQueueChannelId}', 'Monitoring\openConversationController@getAllInQueue');
    Route::post('monitoring-in-queue-channel-set', 'Monitoring\openConversationController@monitoringInQueueChannelSet');
    Route::any('monitoring-in-queue-channel-setup', 'Monitoring\openConversationController@monitoringInQueueChannelSetup');
    /* END Monitoring */

    /**   Separate Campaign    */
    Route::any('activate-campaign-separate', 'FacebookController\PlaybookFacebookController@activateCampaignSeparate');
    Route::any('activate-adset-separate', 'FacebookController\PlaybookFacebookController@activateAdsetSeparate');

    Route::any('update-adset-separate', 'FacebookController\PlaybookFacebookController@updateAdsetSeparate');

    /**   Separate Campaign    */
    Route::any('all-page-get-facebook-account', 'FacebookController\PlaybookFacebookController@allPageGetFacebookAccount');

    Route::any('connecte-page-using-facebookTable', 'FacebookController\PlaybookFacebookController@connectPageUsingFbTable');
    Route::any('activate-facebook-messanger', 'FacebookController\PlaybookFacebookController@activateFacebookMassanger');
    Route::any('update-facebook-messanger', 'FacebookController\PlaybookFacebookController@updateFacebookMassanger');
    Route::any('get-social-user', 'FacebookController\PlaybookFacebookController@getSocialUser');
    Route::any('fb-exchange-token', 'FacebookController\PlaybookFacebookController@fbexchangetoken');

    Route::get('/get-user-social-app', 'IntegrationController@getUserSocialInte');

    Route::any('get-fbmarketing-api-user', 'FacebookController\PlaybookFacebookController@getFbMarketingSocialUser');
    Route::any('de-activate-facebook-user-account', 'FacebookController\PlaybookFacebookController@deActivateFbMarketingApi');
    Route::any('delete-facebook-user-account', 'FacebookController\PlaybookFacebookController@deleteFacebookUserAccount');

    Route::any('delete-facebook-active-page', 'FacebookController\PlaybookFacebookController@delteFacebookActivePage');

    Route::any('edit-facebook-active-page', 'FacebookController\PlaybookFacebookController@editFacebookActivePage');
    Route::any('get-adset-details', 'FacebookController\PlaybookFacebookController@getadsetDetails');


    /** Start MailChimp Route */
    Route::any('mc-connect', 'MailChimpController\MailChimpAuthentication@beginMailChimpConnect');
    Route::any('get-mc-connect', 'MailChimpController\MailChimpController@getMailChimp');
    Route::any('disconnect-mc-connect', 'MailChimpController\MailChimpController@disConnectMailChimp');
    Route::any('get-mc-listid', 'MailChimpController\MailChimpController@getMailChimplist');
    //Route::any('get-mailChimpListId-through-get-segment-details','MailChimpController\MailChimpController@getMailChimplistThroughSegmentDetails');

    Route::any('get-mailChimp-contact-all-list', 'MailChimpController\MailChimpController@getMailChimpContactAllList');

    Route::any('send-to-contact-mailchimp', 'MailChimpController\MailChimpController@sendToContactMailChimp');
    Route::any('update-to-contact-mailchimp', 'MailChimpController\MailChimpController@updateToContactMailChimp');
    Route::any('get-mailchimp-dynamicData', 'MailChimpController\MailChimpController@getMailChimpDynamicData');
    Route::any('send-recieved-contact-dynamic', 'MailChimpController\MailChimpController@sendRecievedContact');
    Route::any('segment-contact-sendto-mailchimp', 'MailChimpController\MailChimpSegmentSynchronization@segmentContactSendToMailChimp');
    Route::any('resend-segment-contact-sendto-mailchimp', 'MailChimpController\MailChimpSegmentSynchronization@resendSegmentContactSendToMailChimp');

    /** End MailChimp Route */
    /** START Facebook Routes */
    Route::any('fb-index', 'FacebookController\FacebookAuthentication@index');
    Route::any('fb-connect', 'FacebookController\FacebookAuthentication@beginFacebookConnect');
    Route::any('fb-messenger-connect', 'FacebookController\FacebookAuthentication@beginFacebookMessengerConnect');
    Route::any('fb-connect-check', 'FacebookController\FacebookAuthentication@checkFacebookConnect');
    Route::any('fb-connect-callback/{source}', 'FacebookController\FacebookAuthentication@facebookAuthorizeCallbackHandeler');
    Route::any('fb-disconnect-callback', 'FacebookController\FacebookWebhookHandler@facebookDeautorizeCallbackHandeler');
    Route::any('fb-delete-data-callback', 'FacebookController\FacebookWebhookHandler@facebookDeleteDataCallbackHandeler');
    //Route::any('verifytoken','FacebookController\FacebookAuthentication@veryfy_token');



    /*  Start WebHook Massage */
    /*
      Route::any('get-all-webhook-senderId','FacebookController\FacebookWebhookHandler@getAllWebhookSenderId');
      Route::any('reply-message-using-psid','FacebookController\FacebookWebhookHandler@replyMessageUsingPSID'); */

    Route::any('get-all-webhook-senderId', 'FacebookController\facebookMessengerCommunication@getAllWebhookSenderId');
    Route::any('reply-message-using-psid', 'FacebookController\facebookMessengerCommunication@replyMessageUsingPSID');
    Route::any('testing-sendig-message', 'FacebookController\facebookMessengerCommunication@testSending');
    Route::any('show-communication-page-valid', 'FacebookController\facebookMessengerCommunication@showcommunicationpagevalid');




    /*  End  WebHook Massage */



    /** END Facebook Routes */
    /** roles and permissions Route */
    Route::get('/forbidden', 'Role\RolesPermissionsController@forbidden');
    Route::get('/get-system-roles', 'Role\RolesPermissionsController@getSystemRoles');
    Route::get('/get-roles-permissions-data', 'Role\RolesPermissionsController@getRolesPermissionsData')->middleware('CheckPermission:company_roles_and_permissions_setup');
    Route::get('/set-default-roles', 'Role\RolesPermissionsController@setDefaultRole');
    Route::get('/set-default-permissions', 'Role\RolesPermissionsController@setDefaultPermission');
    Route::post('/update-role-permission', 'Role\RolesPermissionsController@updateRolePermission');
    Route::get('/get-user-role-permission', 'Role\RolesPermissionsController@getUserRolePermissions');
    Route::get('/getCpanelEmailData', 'Playbook\CompanyEmailController@getCpanelEmailData');
    Route::any('/set-event-availablity-timeslots', 'AppointmentsCronController@index');

    Route::get('auth/google', 'Auth\AuthController@redirectToProvider');
    Route::get('auth/google/callback', 'Auth\AuthController@handleProviderCallback');

    /* START Goog;e 2FA routes */
    Route::post('/2fa', function () {
        return redirect(URL()->previous());
    })->name('2fa')->middleware(['throttle:3', '2fa']);
    Route::get('/2fa', function () {
        return redirect('/');
    });
    /* END Goog;e 2FA routes */

    Route::any('mailchimpverify', 'MailChimpController\MailChimpWebhook@veryfyToken');


    /* webhook get customer data & Stripe  */

    Route::post('connect/webhook', 'Connect\ConnectController@index');


    Route::post('getBotDetails', 'WebIframeController@getBotDetails');
    Route::post('getBotDetailsByid', 'WebIframeController@getBotDetailsByid');


    // bots action routes

    Route::post('/getEventTypeDetail', 'WebIframeController@getEventTypeDetail');
    Route::post('start-bot', 'WebController@initializebot');
    Route::post('saveOrUpdateContact', 'WebIframeController@saveOrUpdateContact');
    Route::post('SaveContactChatThread', 'WebIframeController@SaveContactChatThread');
    Route::post('update-bot-response', 'WebIframeController@UpdateBotResponse');
    Route::post('/visitor-all-chats-bots', 'WebIframeController@visitorAllChatsBot');

    Route::post('/checkVisitorBylocal', 'WebIframeController@checkVisitorBylocal');
    Route::post('ticket-create-by-bot', 'Support\SupportTicketController@ticketCreateByBot');
    Route::post('loadEventFormdata', 'WebIframeController@loadEventFormdata');

    Route::post('save-botOpenClose', 'WebIframeController@savebotOpenClose');
    Route::get('get-botOpenClose', 'WebIframeController@GetbotOpenClose');
    Route::post('CheckCurrent-bot', 'WebController@CheckCurrentBot');
    Route::post('CheckContactLocal', 'WebController@CheckContactLocal');
    Route::post('bot-thread-closed', 'WebIframeController@BotThreadClosed');
    Route::post('transfer-bot-to-chat', 'WebController@BotToChat');
    Route::post('productService', 'WebIframeController@productService');
    Route::post('getbotthreadData', 'WebIframeController@getbotthreadData');
    Route::post('getbotthreadDataByBotthreadid', 'WebIframeController@getbotthreadDataByBotthreadid');
    Route::any('get-bot-history-inbox/{id}', 'WebIframeController@GetBotHistoryInbox');

    ///verify email  
    Route::get('verify-email/{string}', 'UsersController@Verifyemail');

    //playbook unsubscribe
    Route::get('unsubscribe/{stringId}', 'UsersController@unsubscribe');
    Route::post('PlaybookUnsubscribe', 'UsersController@PlaybookUnsubscribe');

    Route::get('getFileUrlEBook', 'MmsMediaCotroller@GetfileEbook');

    Route::post('/checkInvitee', 'UsersController@checkInvitee');

    Route::post('/iframe-article-search', 'WebController@iframeArticleSearch');
    Route::post('/search-article-data', 'WebIframeController@searchArticleData');
    Route::post('/search-article-data-more-results', 'WebIframeController@searchArticleDataMoreResult');

    // invitee teammate
    Route::get('/inviteesetup/{invitetoken}', 'UsersController@invitetoken');
    Route::post('/setinvitee', 'UsersController@saveInviteeAsUser');
    /* Viddeo website  */
    Route::get('viddeo/un-subscribe/{id}', 'Connect\ConnectController@viddeoUnsubscribe');
    Route::post('viddeo/unsubscribe-post', 'Connect\ConnectController@viddeoUnsubscribePost');
    /*  End webhook */
    Route::post('smsCallback', 'Twillio\TwillioController@smsContactCheckallback');
    Route::post('receiveMessage', 'Twillio\TwillioController@receiveMessage');
    Route::any('/get-twillio-file/{token?}', 'MmsMediaCotroller@getFileFromstorage'); //->middleware('basicAuth');
    Route::get('addSubAccount', 'Twillio\TwillioController@addSubAccount');

    Route::any('/console_log_errors', 'ErrorsLogController@saveConsoleError');

    Route::post('/update-google-trans-language', 'UsersController@updateGoogleTransLanguage');
    Route::post('/get-google-trans-language', 'UsersController@getGoogleTransLanguage');

    /*Bot whatsapp route Start*/
    Route::get('getalltimeList', 'BotsController@getalltimeList');
    Route::get('/bots-whatsapp/action/get-category', 'BotWhatsapp\BotWhatsappActionController@getBotActionCategory');
    Route::get('/bots-whatsapp/action/get-bot-chart-flow-order', 'BotWhatsapp\BotWhatsappActionController@getBotChartFlowOrder');
    Route::get('/bots-whatsapp/action/get-bot-chart-flow-order-fn', 'BotWhatsapp\BotWhatsappActionController@getBotChartFlowOrderfn');
     Route::get('getActionId/{id}','Twillio\TwillioController@getActionId');
    /*Bot whatsapp route End*/

   /*bot whatsapp no response crone close thred*/
    Route::get('botwhatsapp/checkBotNoReponse/','Twillio\TwillioController@checkBotNoReponse');

});
