/**
 * Created by erdub on 3/21/2016.
 */

// Help dialog
$("#dialog").dialog({
    autoOpen: false,
    dialogClass: "no-close",
    draggable: false,
    modal: true,
    resizable: false,
    width: 400,
    height: 250,
    buttons: [
        {
            text: "Employee Login",
            click: function () {
                $(this).dialog("close");
                if (location.pathname.substring(location.pathname.lastIndexOf('/') + 1) == "") {
                    var $redirect = "index.php";
                } else {
                    var $redirect = location.pathname.substring(location.pathname.lastIndexOf('/') + 1);
                }
                window.location.href = "employee-login.php?redirect=" + $redirect;
            }
        },
        {
            text: "Close",
            click: function () {
                $(this).dialog("close");
                selectInput();
            }
        }
    ]
});

// Employee options dialog
$("#emp-options").dialog({
    autoOpen: false,
    dialogClass: "",
    draggable: true,
    resizable: false,
    width: 275,
    height: 475,
    position: {my: "left", at: "left top"}
});

// Employee options dialog
$("#bconfirm").dialog({
    autoOpen: false,
    dialogClass: "",
    draggable: true,
    resizable: false,
    width: 275,
    height: 475,
    position: {my: "left", at: "left top"}
    
});

// Link to open help dialog (round)
$("#dialog-link").click(function (event) {
    $("#dialog").dialog("open");
    event.preventDefault();
});

// Link to open help dialog (rectangle)
$("#help-button").click(function (event) {
    $("#dialog").dialog("open");
    event.preventDefault();
});

// Link to open help dialog (employee)
$("#emp-help-button").click(function (event) {
    $("#dialog").dialog("open");
    event.preventDefault();
});

// Link to open employee dialog (text)
$("#emp-footer").click(function (event) {
    $("#emp-options").dialog("open");
    event.preventDefault();
});

