const prefix = '.pelk__';
const file_upload_input = document.querySelector(`${prefix}file-upload`);
let file_destination__path = null;


let upload_file_btns = document.querySelectorAll(`${prefix}upload-file`);
let remove_btns = document.querySelectorAll('.remove');
let create_dir_btns = document.querySelectorAll(`${prefix}create-dir`);
let names = document.querySelectorAll(`${prefix}name`);
let treeRoot = document.querySelector('.tree-container');



function request(method = "GET", url, data, cb) {

    let xhr = new XMLHttpRequest();
    xhr.open(method, url);
    xhr.send(data);
    xhr.onload = () => cb(xhr.response);
}

function renewTree() {

    let data = new FormData;
    data.append('method', 'tree_get');

    request('POST', '/api/v1/', data, function (resp) {
        treeRoot.innerHTML = JSON.parse(resp)['data']['tree'];
        upload_file_btns = document.querySelectorAll(`${prefix}upload-file`);
        remove_btns = document.querySelectorAll('.remove');
        create_dir_btns = document.querySelectorAll(`${prefix}create-dir`);
        names = document.querySelectorAll(`${prefix}name`);
        treeRoot = document.querySelector('.tree-container');
        SetEventListeners();
    });
}


file_upload_input.addEventListener('change', function () {

    let data = new FormData;
    data.append('file', this.files[0]);
    data.append('path', file_destination__path);
    data.append('method', 'files_upload');

    request('POST', '/api/v1/', data, function (resp) {
        renewTree();
    })

});

function SetEventListeners(){
    for (let i = 0; i < upload_file_btns.length; i++) {
        upload_file_btns[i].addEventListener('click', function () {
            file_destination__path = this.dataset.destination;
            file_upload_input.click();
        });
    }


    for (let i = 0; i < remove_btns.length; i++) {
        remove_btns[i].addEventListener('click', function () {
            let data = new FormData;
            data.append('path', this.dataset.destination);
            data.append('type', this.classList.contains('remove__file') ? 'file' : 'dir');
            data.append('method', 'entity_delete');

            request('POST', '/api/v1/', data, function (resp) {
                renewTree();
            });

        });
    }


    for (let i = 0; i < create_dir_btns.length; i++) {
        create_dir_btns[i].addEventListener('click', function () {
            let dirName = prompt('Enter dir name');

            let data = new FormData;
            data.append('path', this.dataset.destination);
            data.append('dir_name', dirName);
            data.append('method', 'dirs_create');

            request('POST', '/api/v1', data, function (resp) {
                renewTree();
            })

        });
    }

    for (let i = 0; i < names.length; i++) {
        names[i].addEventListener('click', function () {
            let newName = prompt('Enter new name', this.getAttribute("title"))
            if (newName != null && newName != this.getAttribute("title")) {
                let data = new FormData;
                data.append('path', this.dataset.destination);
                data.append('new_name', newName);
                data.append('method', 'entity_rename');

                request('POST', 'api/v1', data, function (resp) {
                    renewTree();
                })
            }
        });
    }
}
SetEventListeners();

