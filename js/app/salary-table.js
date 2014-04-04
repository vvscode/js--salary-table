'use strict';

var salaryTableApp = angular.module('salaryTableApp', ['salaryTableServices', 'xeditable']);

salaryTableApp.run(function(editableOptions) {
    editableOptions.theme = 'bs2'; // bootstrap3 theme. Can be also 'bs2', 'default'
    editableOptions.buttons = 'no'; // default value - no buttons
});

// Код добавлен для обработки blur в xeditable
$(document).on('blur','.editable-input', function(event){
    var mevt = document.createEvent("MouseEvent");
    mevt.initMouseEvent("click",true,true, window, 0,
        event.screenX, event.screenY, event.clientX, event.clientY,
        event.ctrlKey, event.altKey, event.shiftKey, event.metaKey,
        0, null);
    document.dispatchEvent(mevt);
});