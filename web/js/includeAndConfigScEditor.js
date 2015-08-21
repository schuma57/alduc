/**
 * Created by schuma on 21/08/15.
 */

$(function() {
    $.sceditor.command.set("headers", {
        exec: function(caller) {
            var editor = this, $content = $("<div />");

            for (var i=2; i<= 5; i++) {
                $(
                    '<a class="sceditor-header-option" href="#">' +
                    '<h' + i + '>Heading ' + i + '</h' + i + '>' +
                    '</a>'
                )
                .data('headersize', i)
                .click(function (e) {
                    editor.execCommand("formatblock", "<h" + $(this).data('headersize') + ">");
                    editor.closeDropDown(true);

                    e.preventDefault();
                })
                .appendTo($content);
            }

            editor.createDropDown(caller, "header-picker", $content);
        },
        tooltip: "Format Headers"
    });

    $.sceditor.plugins.bbcode.bbcode
        .set("h2", { tags: { h2: null }, format: "[h2]{0}[/h2]", html: "<h2>{0}</h2>" })
        .set("h3", { tags: { h3: null }, format: "[h3]{0}[/h3]", html: "<h3>{0}</h3>" })
        .set("h4", { tags: { h4: null }, format: "[h4]{0}[/h4]", html: "<h4>{0}</h4>" })
        .set("h5", { tags: { h5: null }, format: "[h5]{0}[/h5]", html: "<h5>{0}</h5>" });

    $(".bb-editor").sceditor({
        plugins: "bbcode",
        style: "bbcode/jquery.sceditor.default.min.css",
        width: "98.2%",
        height: "4em",
        resizeMaxHeight: -1,
        resizeWidth: false,
        toolbar: "bold,italic,underline|left,center,right,justify|"
        + "font,headers|bulletlist,orderedlist,quote|image|source"
    });
});
