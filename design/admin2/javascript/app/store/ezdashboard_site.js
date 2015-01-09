var storeSite = Ext.create('Ext.data.JsonStore', {
    model: 'eZSocialNetworkSite',
    proxy: {
        type: 'ajax',
        url: '/dashboard/data/site?ContentType=json',
        write: {
            type: 'json',
        },
        reader: {
            type: 'json',
            root: 'content',
            idProperty: 'id'
        }
    }
});