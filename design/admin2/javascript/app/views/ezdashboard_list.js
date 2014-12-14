Ext.require([
    'Ext.grid.*',
    'Ext.data.*',
    'Ext.panel.*',
    'Ext.util.*',
    'Ext.layout.container.Border'
]);

Ext.onReady(function(){
    // create the grid
    var sites = [];
    storeSite.load({
        scope: this,
        callback: function(records, operation, success) {
            // the operation object
            // contains all of the details of the load operation
            for (var i = 0; i < records.length; i++) {
                var record = records[i];
                sites[record.internalId] = record.data;
            }
        }
    });
    var grid = Ext.create('Ext.grid.Panel', {
        store: store,
        columns: [
            {
                text: "ID",
                width: 50,
                dataIndex: 'id',
                sortable: true
            },
            {
                text: "Site",
                width: 110,
                dataIndex: 'site_id',
                sortable: true,
                renderer: function(value) {
                    return sites[value].site;
                }
            },
            {
                text: "<Title></Title>",
                flex: 1,
                dataIndex: 'name',
                sortable: false,
                renderer: function(value, metaData, record, rowIndex, colIndex, store) {
                    var url = "http://"+sites[record.data.site_id].site +"/"+ record.data.url;
                    return Ext.String.format('<a target="_blank" href="{0}">{1}</a>', url, value);
                }
            },
            {
                text: "Date creation",
                width: 125,
                dataIndex: 'date_create',
                sortable: true,
                // format the date using a renderer from the Ext.util.Format class
                renderer: Ext.util.Format.dateRenderer('m/d/Y h:i:s')
            }
        ],
        forceFit: true,
        height:410,
        split: true,
        width: "60%",
        region: 'center'
    });

    var gridDetail = Ext.create('Ext.Panel', {
        id: 'detailPanel',
        region: 'east',
        bodyPadding: 7,
        width: "40%",
        bodyStyle: "background: #ffffff;",
        html: 'Please select a row to see additional details.'
    });
        
    // define a template to use for the detail view
    var bookTplMarkup = [
        'Title: <a href="{DetailPageURL}" target="_blank">{name}</a><br/>',
        'Author: {Author}<br/>',
        'Manufacturer: {<Manufactur></Manufactur>er}<br/>',
        'Product Group: {ProductGroup}<br/>'
    ];
    var bookTpl = Ext.create('Ext.Template', bookTplMarkup);

    Ext.create('Ext.Panel', {
        renderTo: 'list-dashboard',
        frame: true,
        title: 'List Content',
        width: "100%",
        height: 600,
        layout: 'border',
        items: [
            grid,
            gridDetail
        ],
    });
    
    // update panel body on selection change
    grid.getSelectionModel().on('selectionchange', function(sm, selectedRecord) {
        if (selectedRecord.length) {
            var detailPanel = Ext.getCmp('detailPanel');
            detailPanel.update(bookTpl.apply(selectedRecord[0].data));
        }
    });

    store.load();
});