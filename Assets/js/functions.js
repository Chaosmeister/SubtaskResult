KB.on('dom.ready', function () {
    var Subtasks = document.getElementsByClassName('subtasks-table')[0];

    const Cells = [...Subtasks.getElementsByClassName('subtaskResultEdit')];
    for (const Cell of Cells) {
        Cell.addEventListener("click", toggleEdit);
    }
})

function findTD(Element) {
    var td = Element;

    while (td.className != "subtaskResult") {
        td = td.parentElement;
    }
    return td;
}

function toggleEdit(event) {
    var td = findTD(event.target);
    var subtaskId = td.parentElement.attributes['data-subtask-id'].nodeValue;

    KB.http.get("?controller=SubtaskResultController&action=get&plugin=SubtaskResult&Id=" + subtaskId)
        .success(function (result) {
            const Markdown = td.querySelector('.subtaskResultDisplay');
            Markdown.style.display = "none";

            const TextArea = document.createElement("textarea");
            TextArea.className = "subtaskResultInput";

            const textnode = document.createTextNode(result);
            TextArea.appendChild(textnode);
            TextArea.id = subtaskId;

            TextArea.style.width = td.clientWidth + "px";
            TextArea.style.display = "";

            td.appendChild(TextArea);

            const Buttons = document.createElement("div");
            Buttons.className = "subtaskResultButtons"

            const SaveButton = document.createElement("div");
            SaveButton.className = "subtaskResultSave";

            SaveButton.innerHTML = '<i class="fa fa-fw fa-save button" aria-hidden="true" style="cursor: pointer;"/>';

            Buttons.appendChild(SaveButton);

            const CloseButton = document.createElement("div");
            CloseButton.className = "subtaskResultClose";

            CloseButton.innerHTML = '<i class="fa fa-fw fa-close button" aria-hidden="true" style="cursor: pointer;"/>';

            Buttons.appendChild(CloseButton);

            Buttons.style.display = "flex"

            td.appendChild(Buttons);

            TextArea.addEventListener("input", resizeEvent);
            SaveButton.addEventListener("click", save);
            CloseButton.addEventListener("click", close);

            resize(TextArea);
        });
}

function resizeEvent(event) {
    resize(event.target);
}

function resize(element) {
    element.style.height = "";
    element.style.height = element.scrollHeight - 8 + "px";
}

function close(event) {
    var td = findTD(event.target);

    var markdown = td.querySelector('.subtaskResultDisplay');
    markdown.style.display = "";

    td.removeChild(td.querySelector('.subtaskResultInput'));
    td.removeChild(td.querySelector('.subtaskResultButtons'));

    event.stopPropagation();
}

function save(e) {
    const link = '?controller=SubtaskResultController&action=save&plugin=SubtaskResult';

    var subtaskResultJson = {};

    const Inputs = [...document.getElementsByClassName('subtaskResultInput')];
    for (const Input of Inputs) {
        subtaskResultJson[Input.id] = Input.value;
    }

    KB.http.postJson(link, subtaskResultJson);
}