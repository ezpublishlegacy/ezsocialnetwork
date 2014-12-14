Ext.define('eZDashBoard',{
    extend: 'Ext.data.Model',
    proxy: {
        type: 'ajax',
        reader: 'json'
    },
    fields: [
        // set up the fields mapping into the xml doc
        // The first needs mapping, the others are very basic
        "id",
        "site_id",
        "name",
        "url",
        "class_identifier",
        "image",
        {
            name: "date_create",
            type: 'date',
            dateFormat: 'timestamp'
        },
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
