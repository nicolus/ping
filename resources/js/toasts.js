import {Toast as BootstrapToast} from 'bootstrap';

export default class Toaster {
    static makeToast(header, text, type) {
        let container = document.getElementById('toast-container');
        let template = document.getElementById('toast-template');
        let toast = template.content.firstElementChild.cloneNode(true);

        let icons = {
            'info' :  `<i class="bi bi-info-square-fill text-primary me-2 fs-4"></i>`,
            'danger' : `<i class="bi bi-exclamation-square-fill text-danger me-2 fs-4"></i>`,
            'success' : `<i class="bi bi-check-square-fill text-success me-2 fs-4"></i>`,
        }

        console.log(type);
        header = `${icons[type]} <strong>${header}</strong>`;

        toast.querySelectorAll('.toast-body')[0].innerHTML = text;
        toast.querySelectorAll('.toast-header')[0].innerHTML = header;

        container.appendChild(toast);

        new BootstrapToast(toast).show();
    }
}