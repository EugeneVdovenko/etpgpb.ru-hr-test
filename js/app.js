Ext.onReady(function() {
var rt = Ext.data.Record.create([
    {name: 'date'},
    {name: 'time'},
    {name: 'ip'},
    {name: 'from'},
    {name: 'to'}
]);

var dataProxy = new Ext.data.HttpProxy({
    url: 'get.php'
});

var dataReader = new Ext.data.JsonReader({
    root: 'data',
}, rt);

var store = new Ext.data.Store({
    proxy: dataProxy,
    reader: dataReader
});

var grid = new Ext.grid.GridPanel({
    store: store,
    columns:[
    {
        id: 'date',
        header: "Дата",
        dataIndex: 'date'
    },
    {
        id: 'time',
        header: "Время",
        dataIndex: 'time'
    },
    {
        id: 'ip',
        header: "IP",
        dataIndex: 'ip'
    },
    {
        id: 'from',
        header: "Откуда",
        dataIndex: 'from'
    },
    {
        id: 'to',
        header: "Куда",
        dataIndex: 'to'
    }
    ],
    tbar: [
        new Ext.Button({
            text: 'New',
            handler: function(){}
        }),
        new Ext.Button({
            text: 'Edit',
            handler: function(){}
        }),
        new Ext.Button({
            text: 'Delete',
            handler: function(){}
        }),
    ],
    bbar: new Ext.PagingToolbar({
            pageSize: 10,
            store: store,
            displayInfo: true,
            displayMsg: 'Displaying topics {0} - {1} of {2}',
            emptyMsg: "No topics to display"
        })
});

var window = new Ext.Window({
    id: 'example-window',
    title : "Grid Example",
    layout: 'fit',
    width : 800,
    height : 400,
    items: [grid]
});
window.show();

grid.getStore().load();

});
