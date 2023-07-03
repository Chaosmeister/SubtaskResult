KB.on('dom.ready', function () {
    $(document).on('click', '.js-subtask-result-edit', function (e) {
        var el = $(this);
        var url = el.attr('href');

        e.preventDefault();

        $.ajax({
            cache: false,
            url: url,
            success: function (data) {
                var Elements = $(el).closest('.subtaskResult');
                var td = Elements[0];
                
                var MarkdownDisplay = td.children[0];
                MarkdownDisplay.style.display="none";

                td.innerHTML += data;

                var TextArea = td.children[1].children[0];
                TextArea.style.width = "100%";
                TextArea.style.padding = "0px";
                resize(TextArea);
            }
        });
    });

    $(document).on('input', '.subtaskResultInput', function (e) {
        e.preventDefault();
        resizeEvent(e);
    });

    $(document).on('click', '.js-subtask-result-save', function (e) {
        e.preventDefault();
        
        const link = '?controller=SubtaskResultController&action=save&plugin=SubtaskResult';
    
        var subtaskResultJson = {};
    
        const Inputs = [...document.getElementsByClassName('subtaskResultInput')];
        for (const Input of Inputs) {
            subtaskResultJson[Input.id] = Input.value;
        }
    
        KB.http.postJson(link, subtaskResultJson);
    });

    $(document).on('click', '.js-subtask-result-close', function (e) {
        e.preventDefault();
        var el = $(this);

        td = el.closest(".subtaskResult")[0];
        var markdown = td.querySelector('.subtaskResultDisplay');
        markdown.style.display = "";
    
        td.removeChild(td.querySelector('.subtaskResultEdit'));
    });
});

function resizeEvent(event) {
    resize(event.target);
}

function resize(element) {
    element.style.height = "";
    element.style.height = element.scrollHeight + "px";
}