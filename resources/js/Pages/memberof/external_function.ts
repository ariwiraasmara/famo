import axios from 'axios';
import Swal from 'sweetalert2';

export function elementTrigger() {
    $('#btn-join-membership').click(function(){
        $('#modal-join-membership').addClass('is-active');
    });

    $('.close-modal-join-membership').click(function(){
        $('#modal-join-membership').removeClass('is-active');
    });
}

export function sendInvitation(event, idrequestor, idrecipient) {
    if (event.keyCode === 13) {
        event.preventDefault(); // Menghindari pengiriman form saat menekan tombol Enter
        return;
    }
    
    axios.post('api/member/confirmation/store', {
            id_requestor: idrequestor,
            id_recipient: idrecipient,
            type: 'invite'
    }).then(response => (
        Swal.fire({
            title: 'Success!',
            icon: 'success',
            text: 'You\'re Invitation has been sent!',
            confirmButtonText: 'OK',
        }).then((result) => {})
    ))
    .catch(err => (
        Swal.fire({
            title: 'Can Not Send You\'re Invitation!',
            icon: 'error',
            confirmButtonText: 'OK',
        }).then((result) => {})
    ))
}

export function deleteMember(event, member_name, mid) {
    if (event.keyCode === 13) {
        event.preventDefault(); // Menghindari pengiriman form saat menekan tombol Enter
        return;
    }

    axios.post(`api/member/delete/${mid}`).then(response => (
        Swal.fire({
            title: 'Success!',
            icon: 'success',
            text: `You have remove this member (${member_name}) from your membership!`,
            confirmButtonText: 'OK',
        }).then((result) => {})
    ))
    .catch(err => (
        Swal.fire({
            title: 'Can Not Remove This Member!',
            icon: 'error',
            text: 'Check Connection!',
            confirmButtonText: 'OK',
        }).then((result) => {})
    ))
    .finally(() => this.loading = false)
}

export function deleteMembership(event, member_name, mid) {
    if (event.keyCode === 13) {
        event.preventDefault(); // Menghindari pengiriman form saat menekan tombol Enter
        return;
    }

    Swal.fire({
        title: 'Are You Sure?',
        icon: 'warning',
        text: `You will be removed from this membership (${member_name})!\nAfter that you have to send an invitation to join again`,
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(`api/membership/delete/${mid}`).then(response => (
                Swal.fire({
                    title: 'Success!',
                    icon: 'success',
                    text: `You have beed removed from this membership (${member_name})!`,
                    confirmButtonText: 'OK',
                }).then((result) => {
                    window.location.reload();
                })
            ))
            .catch(err => (
                Swal.fire({
                    title: 'Can Not Remove This Membership!',
                    icon: 'error',
                    confirmButtonText: 'OK',
                }).then((result) => {})
            ))
        } else if (
          /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
        ) {
            Swal.fire(
                'Cancelled',
                'Your Membership is safe :)',
                'error'
          )
        }
    })
}
