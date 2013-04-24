
var menusForm = {};

//(jQuery(function($) {
//    $('#myTab a').click(function(e)
//    {
//        e.preventDefault();
//        $(this).tab('show');
//    });
//}))(jQuery);

//(function($) {
//    $(document).ready(function() {
//        // Handler for .ready() called.
//        var tab = $('<li class=" active"><a href="#general" data-toggle="tab">**Article Details**</a></li>');
//        $('#myTabTabs').append(tab);
//    });
//})(jQuery);
//
//jQuery(document).ready(function(){
//
//    SqueezeBox.initialize({});
//    SqueezeBox.assign($$('a.modal-button'), {
//        parse: 'rel'
//    });
//});
//
//$(document).ready(function() {
//    $("#modal-button").click(function () {
//        SqueezeBox.initialize({
//            size: {x: 350, y: 400}
//        });
//        SqueezeBox.open('http://txdev.net/sljml/administrator/index.php?option=com_media&amp;view=images&amp;tmpl=component&amp;e_name=jform_articletext&amp;asset=com_content&amp;author=', {handler: 'iframe'});
//    });
//});;






//function isBrowserIE()
//{
//    return navigator.appName == "Microsoft Internet Explorer";
//}

//function jInsertEditorText(text, editor)
//{
//    if (isBrowserIE())
//    {
//        if (window.parent.tinyMCE)
//        {
//            window.parent.tinyMCE.selectedInstance.selection.moveToBookmark(window.parent.global_ie_bookmark);
//        }
//    }
//    tinyMCE.execInstanceCommand(editor, 'mceInsertContent', false, text);
//}

var global_ie_bookmark = false;

//function IeCursorFix()
//{
//    if (isBrowserIE())
//    {
//        tinyMCE.execCommand('mceInsertContent', false, '');
//        global_ie_bookmark = tinyMCE.activeEditor.selection.getBookmark(false);
//    }
//    return true;
//}


$(document).ready(function($) {


    menusForm = $("#restaurant_menus").sheepIt({
        separator: '',
        allowRemoveLast: true,
        allowRemoveCurrent: true,
        allowRemoveAll: true,
        allowAdd: true,
        allowAddN: true,
        // Limits
        maxFormsCount: 10,
        minFormsCount: 0,
        iniFormsCount: 0,
        nestedForms: [
            {
                id: 'restaurant_menus_#index#_menu',
                options: {
                    indexFormat: '#index_item#',
                    maxFormsCount: 5
                }
            }
        ],
        data: [
            {
                'menu': 'MENU 1',
                // Embedded form data
                'restaurant_menus_#index#_items': [
                    {'item': 'ITEM 1'},
                    {'item': 'ITEM 2'}
                ]
            },
            {
                'menu': 'MENU 2',
                // Embedded form data
                'restaurant_menus_#index#_items': [
                    {'item': 'ITEM 3'},
                    {'item': 'ITEM 4'}
                ]
            }
        ],
        pregeneratedForms: ['pregenerated_form_1']

    });



});

function executeAPI() {

    // Using API

    // Inject data into main form
    alert('Inject data');
    menusForm.inject([
        {
            'menu': 'Injected menu'
        }
    ]);

    // Add a form
    alert('Add a form');
    menusForm.addForm();

    // Get all forms forms
    var forms = menusForm.getForms();

    // Inject new data on each form
    alert('Insert new data on each form');
    for (x in forms) {
        forms[x].inject({'menu': "Injected new menu"});
    }

    // Remove a form
    alert('Remove first form');
    menusForm.removeForm(0);

    // Get a nested form and inject data on it
    var itemForm = menusForm.getForm(0).getNestedForm(0);
    itemForm.inject([
        {'item': "Injected item"}
    ]);

    // Remove all forms
    alert('Remove all forms');
    menusForm.removeAllForms();

}
