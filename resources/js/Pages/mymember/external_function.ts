import axios from 'axios';
import Swal from 'sweetalert2';

export function treeview() {
    var toggler = document.getElementsByClassName("caret");
    var i;

    for (i = 0; i < toggler.length; i++) {
        toggler[i].addEventListener("click", function() {
            this.parentElement.querySelector(".nested").classList.toggle("active");
            this.classList.toggle("caret-down");
        });
    }
}

export function elementTrigger() {
    $('#btn-add-member').click(function(){
        $('#modal-add-member').addClass('is-active');
    });
}

export function getAllMember(member) {
    if(member[0] != null) {
        $('#tree-member').empty();
        for(let x = 0; x < member.length; x++) {
            const mid           = member[x].mid;
            const member_name   = member[x].member_name;
            const email_member  = member[x].email_member;

            const button = $('<button>')
                            .addClass('buttontree')
                            .attr('id', `button-remove-member-${email_member}`)
                            .val(email_member)
                            .click((event: any) => deleteMember(event, member_name, mid))
                            .attr('title', 'Remove Member')
                            .html('<ion-icon name="remove-outline"></ion-icon>');

            const text = `${member_name}<br/>${email_member}`;
            const li = $('<li>').append(text, button);
            $('#tree-member').append(li);
        }
    }
}

export async function getChildMember(id, order, by) {
    const response = await axios.get(`api/member/child/all/${id}/${order}/${by}`);
    return response;
}

export function sendInvitation(event: any, idrequestor: Number, idrecipient: Number) {
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

export function openModal(name: any) {
    $(`#modal-${name}`).addClass('is-active');

    
}

export function deleteMember(event: any, member_name: String, mid: String) {
    // alert(`${member_name}`);
    if (event.keyCode === 13) {
        event.preventDefault(); // Menghindari pengiriman form saat menekan tombol Enter
        return;
    }

    Swal.fire({
        title: 'Are You Sure?',
        icon: 'warning',
        text: `You will remove this member (${member_name}) from your membership!`,
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(`api/member/delete/${mid}`).then(response => (
                Swal.fire({
                    title: 'Success!',
                    icon: 'success',
                    text: `You have remove this member (${member_name}) from your membership!`,
                    confirmButtonText: 'OK',
                }).then((result) => {
                    window.location.reload();
                })
            ))
            .catch(err => (
                Swal.fire({
                    title: 'Can Not Remove This Member!',
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
                'Your member is safe :)',
                'error'
          )
        }
    })
}
