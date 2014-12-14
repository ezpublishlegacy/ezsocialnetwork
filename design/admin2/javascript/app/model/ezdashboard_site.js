Ext.define('eZDashBoardSite',{
    extend: 'Ext.data.Model',
    proxy: {
        type: 'ajax',
        reader: 'json'
    },
    fields: [
        // set up the fields mapping into the xml doc
        // The first needs mapping, the others are very basic
        "id",
        "site",
        {
            name: "date_add",
            type: 'date',
            dateFormat: 'timestamp'
        },
        {
            name: "date_modified",
            type: 'date',
            dateFormat: 'timestamp'
        }
    ]
});
