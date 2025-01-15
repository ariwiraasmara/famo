import axios from 'axios';
import Swal from 'sweetalert2';

export function navbar() {
    // Get all "navbar-burger" elements
    const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

    // Add a click event on each of them
    $navbarBurgers.forEach( el => {
        el.addEventListener('click', () => {
            // Get the target from the "data-target" attribute
            const target = el.dataset.target;
            const $target = document.getElementById(target);

            // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
            el.classList.toggle('is-active');
            $target.classList.toggle('is-active');
        });
    });
}

export function elementTrigger() {
    $('#about').click(function() {
        $('#modal-about').addClass('is-active');
    });

    $('.close-modal-about').click(function(){
        $('#modal-about').removeClass('is-active');
    });
}

export function confirmation(mid, val, iduser) {
    if(val == 1) {
        axios.post('api/member/confirmation/update', {
            id_invite: mid,
            id_user: iduser
        }).then(response => (
            Swal.fire({
                title: 'Success!',
                icon: 'success',
                text: 'You have accepted this invitation!',
                confirmButtonText: 'OK',
            }).then((result) => {
                window.location.reload()
            })
        ))
        .catch(err => (
            Swal.fire({
                title: 'Something\'s Wrong!',
                icon: 'error',
                confirmButtonText: 'OK',
            }).then((result) => {
                console.log('result', err)
            })
        ))
    }

    if(val == 0) {
        axios.post('api/member/confirmation/reject', {
            idc: mid
        }).then(response => (
            Swal.fire({
                title: 'Success!',
                icon: 'success',
                text: 'You have rejected this invitation!',
                confirmButtonText: 'OK',
            }).then((result) => {
                window.location.reload()
            })
        ))
        .catch(err => (
            Swal.fire({
                title: 'Something\'s Wrong!',
                icon: 'error',
                confirmButtonText: 'OK',
            }).then((result) => {
                console.log('result', err)
            })
        ))
    }

}
