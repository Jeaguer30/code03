function MultiSelectTag_2(el, customs = { shadow: false, rounded: true }) {
    var element = document.getElementById(el);
    if (!element) return; // Si el elemento no existe, salir de la función

    var options = getOptions_2();
    element.classList.add('hidden');

    var customSelectContainer = document.createElement('div');
    customSelectContainer.classList.add('mult-select-tag');

    var wrapper = document.createElement('div');
    wrapper.classList.add('wrapper');

    var body = document.createElement('div');
    body.classList.add('body');
    if (customs.shadow) {
        body.classList.add('shadow');
    }
    if (customs.rounded) {
        body.classList.add('rounded');
    }

    var inputContainer = document.createElement('div');
    inputContainer.classList.add('input-container');

    var input = document.createElement('input');
    input.classList.add('input');
    input.placeholder = `${customs.placeholder || 'Buscar...'}`;

    var inputBody = document.createElement('div');
    inputBody.classList.add('input-body');
    inputBody.append(input);

    body.append(inputContainer);

    var btnContainer = document.createElement('div');
    btnContainer.classList.add('btn-container');

    var button = document.createElement('button');
    button.type = 'button';
    btnContainer.append(button);

    const icon = domParser.parseFromString(`<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="18 15 12 21 6 15"></polyline></svg>`, 'image/svg+xml').documentElement;
    button.append(icon);

    body.append(btnContainer);
    wrapper.append(body);

    var drawer = document.createElement('div');
    drawer.classList.add('drawer', 'hidden');
    if (customs.shadow) {
        drawer.classList.add('shadow');
    }
    if (customs.rounded) {
        drawer.classList.add('rounded');
    }
    drawer.append(inputBody);
    var ul = document.createElement('ul');

    drawer.appendChild(ul);

    customSelectContainer.appendChild(wrapper);
    customSelectContainer.appendChild(drawer);

    if (element.nextSibling) {
        element.parentNode.insertBefore(customSelectContainer, element.nextSibling);
    } else {
        element.parentNode.appendChild(customSelectContainer);
    }

    init();

    function init() {
        initOptions_2();
        enableItemSelection_2();
        setValues_2(false);

        button.addEventListener('click', () => {
            if (drawer.classList.contains('hidden')) {
                initOptions_2();
                enableItemSelection_2();
                drawer.classList.remove('hidden');
                input.focus();
            }
        });

        input.addEventListener('keyup', (e) => {
            initOptions_2(e.target.value);
            enableItemSelection_2();
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !e.target.value && inputContainer.childElementCount > 1) {
                const child = body.children[inputContainer.childElementCount - 2].firstChild;
                const option = options.find((op) => op.value == child.dataset.value);
                option.selected = false;
                removeTag_2(child.dataset.value);
                setValues_2();
            }
        });

        window.addEventListener('click', (e) => {
            if (!customSelectContainer.contains(e.target)) {
                drawer.classList.add('hidden');
            }
        });
    }

    function initOptions_2(val = null) {
        ul.innerHTML = '';
        for (var option of options) {
            if (option.selected) {
                !isTagSelected_2(option.value) && createTag_2(option);
            } else {
                const li = document.createElement('li');
                li.innerHTML = option.label;
                li.dataset.value = option.value;

                if (val && option.label.toLowerCase().startsWith(val.toLowerCase())) {
                    ul.appendChild(li);
                } else if (!val) {
                    ul.appendChild(li);
                }
            }
        }
    }

    function createTag_2(option) {
        const itemDiv = document.createElement('div');
        itemDiv.classList.add('item-container');
        itemDiv.style.color = tagColor.textColor || '#2c7a7b';
        itemDiv.style.borderColor = tagColor.borderColor || '#81e6d9';
        itemDiv.style.background = tagColor.bgColor || '#e6fffa';
        const itemLabel = document.createElement('div');
        itemLabel.classList.add('item-label');
        itemLabel.style.color = tagColor.textColor || '#2c7a7b';
        itemLabel.innerHTML = option.label;
        itemLabel.dataset.value = option.value;
        const itemClose = domParser.parseFromString(`<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="item-close-svg"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>`, 'image/svg+xml').documentElement;

        itemClose.addEventListener('click', (e) => {
            const unselectOption = options.find((op) => op.value == option.value);
            unselectOption.selected = false;
            removeTag_2(option.value);
            initOptions_2();
            setValues_2();
        });

        itemDiv.appendChild(itemLabel);
        itemDiv.appendChild(itemClose);
        inputContainer.append(itemDiv);
    }

    function enableItemSelection_2() {
        for (var li of ul.children) {
            li.addEventListener('click', (e) => {
                options.find((o) => o.value == e.target.dataset.value).selected = true;
                input.value = null;
                initOptions_2();
                setValues_2();
                input.focus();
            });
        }
    }

    function isTagSelected_2(val) {
        for (var child of inputContainer.children) {
            if (!child.classList.contains('input-body') && child.firstChild.dataset.value == val) {
                return true;
            }
        }
        return false;
    }

    function removeTag_2(val) {
        for (var child of inputContainer.children) {
            if (!child.classList.contains('input-body') && child.firstChild.dataset.value == val) {
                inputContainer.removeChild(child);
            }
        }
    }

    function setValues_2(fireEvent = true) {
        selected_values = [];
        for (var i = 0; i < options.length; i++) {
            element.options[i].selected = options[i].selected;
            if (options[i].selected) {
                selected_values.push({ label: options[i].label, value: options[i].value });
            }
        }
        if (fireEvent && customs.hasOwnProperty('onChange')) {
            customs.onChange(selected_values);
        }
    }

    function getOptions_2() {
        return [...element.options].map((op) => {
            return {
                value: op.value,
                label: op.label,
                selected: op.selected,
            };
        });
    }
}
