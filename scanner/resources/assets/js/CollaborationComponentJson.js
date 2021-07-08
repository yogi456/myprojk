export var CollaborationComponentJson = {
    collaborateTogView: false,
    suggestCatTitle: '',
    ideaCatList: [
        {name: 'Sales', allInvitee: true, inviteeCount: 10},
        {name: 'Marketing', allInvitee: true, inviteeCount: 10},
        {name: 'Cust Service', allInvitee: true, inviteeCount: 10},
        {name: 'Products', allInvitee: true, inviteeCount: 10},
        {name: 'Services', allInvitee: true, inviteeCount: 10},
        {name: 'Productivity', allInvitee: true, inviteeCount: 10},
        {name: 'R&D', allInvitee: true, inviteeCount: 10},
        {name: 'IT', allInvitee: true, inviteeCount: 10},
        {name: 'HR', allInvitee: true, inviteeCount: 10},
        {name: 'Finance', allInvitee: true, inviteeCount: 10},
        {name: 'Legal', allInvitee: true, inviteeCount: 10},
        {name: 'Operations', allInvitee: true, inviteeCount: 10},
    ],
    ideas: {
        fields: {
            category: {
                sortable: true
            },
            suggestion: {
                sortable: true
            },
            created_by: {
                sortable: true
            },
            created_on: {
                sortable: true
            },
            status: {
                sortable: true
            },
            votes: {
                sortable: true
            },
            comments: {
                sortable: true
            },
            button_group: {
                label: ' '
            },
        },
        items: [
            {isActive: false, category: 'Marketing', suggestion: 'Auto Emails', created_by: 'D Jones', created_on: '5/23/2018', status: 'Considering', votes: '4', comments: '7', button_group: ''},
            {isActive: false, category: 'Products', suggestion: 'Modify large lock', created_by: 'Sally Smith', created_on: '--', status: 'Sales', votes: 'VIP', comments: 'High', button_group: ''},
            {isActive: false, category: 'Marketing', suggestion: 'Auto Emails', created_by: 'Sally Smith', created_on: '--', status: 'Sales', votes: 'VIP', comments: 'High', button_group: ''},
        ]
    },
}
