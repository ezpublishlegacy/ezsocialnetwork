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
        
    var bookTpl = Ext.create('Ext.Template', bookTplMarkup);
    window.generateData = function(n, floor){
        var data = [],
            p = (Math.random() *  11) + 1,
            i;
            
        floor = (!floor && floor !== 0)? 20 : floor;
        
        for (i = 0; i < (n || 12); i++) {
            data.push({
                name: Ext.Date.monthNames[i % 12],
                data1: Math.floor(Math.max((Math.random() * 100), floor)),
                data2: Math.floor(Math.max((Math.random() * 100), floor)),
                data3: Math.floor(Math.max((Math.random() * 100), floor)),
                data4: Math.floor(Math.max((Math.random() * 100), floor)),
                data5: Math.floor(Math.max((Math.random() * 100), floor)),
                data6: Math.floor(Math.max((Math.random() * 100), floor)),
                data7: Math.floor(Math.max((Math.random() * 100), floor)),
                data8: Math.floor(Math.max((Math.random() * 100), floor)),
                data9: Math.floor(Math.max((Math.random() * 100), floor))
            });
        }
        return data;
    };
    window.store1 = Ext.create('Ext.data.JsonStore', {
        fields: ['name', 'data1', 'data2', 'data3', 'data4', 'data5', 'data6', 'data7', 'data9', 'data9'],
        data: generateData()
    });
    // store1.loadData(generateData(6, 20));
    var chart = Ext.create('Ext.chart.Chart', {
        xtype: 'chart',
        animate: true,
        store: store1,
        shadow: true,
        legend: {
            position: 'right'
        },
        // layout: 'hbox',
        insetPadding: 90,
        theme: 'Base:gradients',
        series: [{
            type: 'pie',
            field: 'data1',
            showInLegend: true,
            // donut: donut,
            tips: {
                trackMouse: true,
                renderer: function(storeItem, item) {
                    //calculate percentage.
                    var total = 0;
                    store1.each(function(rec) {
                        total += rec.get('data1');
                    });
                    this.setTitle(storeItem.get('name') + ': ' + Math.round(storeItem.get('data1') / total * 100) + '%');
                }
            },
            highlight: {
                segment: {
                    margin: 20
                }
            },
            label: {
                field: 'name',
                display: 'rotate',
                contrast: true,
                font: '18px Arial'
            }
        }]
    });
    
    // define a template to use for the detail view
    var bookTplMarkup = [
        'Title: <a href="/{url}" target="_blank">{name}</a> (date modified : {date_modified:date("Y-m-d h:i:s")})<br/>',
        'Author: {author}<br/>',
        // ': {<Manufactur></Manufactur>er}<br/>',
        // 'Product Group: {ProductGroup}<br/>',
        chart
    ];
    // var columnRight = Ext.create('widget.panel', {
    //     width: 800,
    //     height: 600,
    //     title: 'Semester Trends',
    //     renderTo: Ext.getBody(),
    //     layout: 'fit',
    //     items: [
            
    //     ]
    // });

    Ext.create('Ext.Panel', {
        renderTo: 'list-dashboard',
        frame: true,
        title: 'List Content',
        width: "100%",
        height: 600,
        layout: 'border',
        items: [
            grid,
            gridDetail,
            // chart
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