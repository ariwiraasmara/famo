import axios from 'axios';
import Swal from 'sweetalert2';

export function elementTrigger() {
    $('#btn-modal-addfile').click(function(){
        $('#modal-addfile').addClass('is-active');
    });

    $('.close-modal-addfile').click(function(){
        $('#modal-addfile').removeClass('is-active');
    });

}

export async  function getAllFile(id:number) {
    try {
        axios.defaults.xsrfCookieName = 'csrftoken';
        axios.defaults.xsrfHeaderName = 'X-CSRFToken';
        const response = await axios.get(`api/user/file/all/${id}`);
        return response;
    } catch (error) {
        return error;
    }
}

export function submitFile(id, em, fl) {
    // const fileInput = document.getElementById('file');
    // const file = files;

    const ket = $('#fileket').val();

    // console.log('file', file);
    console.log('ket', ket);

    const formData = new FormData();
    formData.append('filename', fl);
    formData.append('fileinfo', ket);
    formData.append('id_user', id);
    formData.append('email', em);

    axios.post('api/user/file/store', formData)
        .then(response => {
            Swal.fire({
                title: 'Success!',
                icon: 'success',
                text: 'You have uploaded your file!',
                confirmButtonText: 'OK',
            }).then((result) => {
                console.log(response.data);
                // window.location.reload()
            });
        })
        .catch(err => {
            Swal.fire({
                title: 'Can Not Upload The File!',
                icon: 'error',
                confirmButtonText: 'OK',
            }).then((result) => {
                console.log(err);
            });
        });
}

export function deleteFile(em, id, fm) {
    Swal.fire({
        title: 'Are You Sure?',
        icon: 'warning',
        text: `You will delete this file (${fm})`,
        showCancelButton: true,
        confirmButtonText: 'Yes',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.isConfirmed) {
            axios.delete(`api/user/file/delete/${id}`).then(response => (
                Swal.fire({
                    title: 'Success!',
                    icon: 'success',
                    text: `You have deleted this file (${fm})!`,
                    confirmButtonText: 'OK',
                }).then((result) => {
                    // console.log(response.data);
                    window.location.reload();
                })
            ))
            .catch(err => (
                Swal.fire({
                    title: 'Can Not Remove This File!',
                    icon: 'error',
                    confirmButtonText: 'OK',
                }).then((result) => {
                    console.log('error', err)
                })
            ))
        } else if (
          /* Read more about handling dismissals below */
            result.dismiss === Swal.DismissReason.cancel
        ) {
            Swal.fire(
                'Cancelled',
                'Your file is safe :)',
                'error'
          )
        }
    })
}