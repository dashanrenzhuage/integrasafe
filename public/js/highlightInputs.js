let original_value = {}

function init() {
    let inputs = [].slice.call(document.getElementsByTagName('input'));

    inputs.forEach(setOnchange);
}

function setOnchange(input) {
    let id = input.getAttribute('id');
    input.setAttribute('onchange', 'highlightChanges(this)');
    original_value[id] = input.getAttribute('value');
}

function highlightChanges(changed) {
    let id = changed.getAttribute('id');

    if (changed.value == original_value[id]) {
        changed.style.borderColor = "";
    } else if (changed.value == "") {
        changed.style.borderColor = "red";
    } else {
        changed.style.borderColor = "orange";
    }
}
window.onload = init;
