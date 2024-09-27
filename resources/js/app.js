import "./bootstrap";

import Alpine from "alpinejs";

import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

window.Alpine = Alpine;

Alpine.start();

ClassicEditor.create(document.querySelector("#editor"))
    .then((editor) => {
        window.editor = editor;
    })
    .catch((error) => {
        console.error("There was a problem initializing the editor.", error);
    });
