var store = Ext.create('Ext.data.JsonStore', {
    model: 'eZSocialNetwork',
    proxy: {
        type: 'ajax',
        url: '/dashboard/data/content?ContentType=json',
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