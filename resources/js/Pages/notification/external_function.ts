import axios from 'axios';
import Swal from 'sweetalert2';

export function elementTrigger() {

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

export function deleteNotif(id) {
    axios.delete(`../api/member/confirmation/delete/${id}`).then(response => (
        Swal.fire({
            title: 'Success!',
            icon: 'success',
            text: 'You have deleted this notification!',
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

export function deleteAllNotif(id) {
    axios.delete(`../api/member/confirmation/delete/all/${id}`).then(response => (
        Swal.fire({
            title: 'Success!',
            icon: 'success',
            text: 'You have deleted all notification!',
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