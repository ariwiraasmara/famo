import axios from 'axios';
import Swal from 'sweetalert2';

export const images = [
    'https://source.unsplash.com/1200x800/?nature',
    'https://source.unsplash.com/1200x800/?landscape',
    'https://source.unsplash.com/1200x800/?ocean',
    'https://source.unsplash.com/1200x800/?mountain',
    // 'https://i.pinimg.com/originals/80/4f/de/804fde7d42dc4f41699abcd933174b8c.jpg',
    // 'https://c4.wallpaperflare.com/wallpaper/996/330/562/kono-subarashii-sekai-ni-shukufuku-wo-wiz-konosuba-hd-wallpaper-preview.jpg',
    // 'https://i.pinimg.com/originals/d6/6a/04/d66a048babd9f07f2a57151ba094be89.png',
    // 'https://i.pinimg.com/originals/36/19/34/36193487eaa81adfa3dca485019e3cd2.jpg',
    'https://source.unsplash.com/1200x800/?space'
];

export const captions = ["Nature", "Landscape", "Ocean", "Mountain", "Space"];

export function elementTrigger() {
    $('#login').click(function(){
        $('#modal-login').addClass('is-active');
    });

    $('.close-modal-login').click(function(){
        $('#modal-login').removeClass('is-active');
    });

    $('#register').click(function(){
        $('#modal-register').addClass('is-active');
    });

    $('.close-modal-register').click(function(){
        $('#modal-register').removeClass('is-active');
    });

}

export function submitLogin() {
    const userlogin = $('#user-login').val();
    const passlogin = $('#pass-login').val();

    axios.post('api/user/login', {
        user: userlogin,
        pass: passlogin
    }).then(response => (
        console.info(response),
        window.location.href = '/dashboard'
    ))
    .catch(err => (
        console.log(err),
        Swal.fire({
            title: 'User Not Found!',
            icon: 'error',
            text: 'This User is Not Registered!',
            confirmButtonText: 'OK',
        }).then((result) => {
            console.log('user:pass', `${userlogin}:${passlogin}`)
        })
    ))
    .finally(() => this.loading = false)
}

export function submitRegister() {
    const user = $('#user-register').val();
    const email = $('#email-register').val();
    const pass = $('#pass-register').val();
    const repass = $('#repass-register').val();

    if (user && email && pass && repass) {
        if (pass === repass) {
            axios.post('/api/user/create', {
                    name: user,
                    email: email,
                    pass: pass,
            })
            .then((response) => {
                Swal.fire({
                        title: 'Success Create User!',
                        icon: 'success',
                        confirmButtonText: 'OK',
                }).then((result) => {
                    $('#user-register').val(null);
                    $('#email-register').val(null);
                    $('#pass-register').val(null);
                    $('#repass-register').val(null);
                });
            })
            .catch((err) => console.log(err))
            .finally(() => (this.loading = false));
        } else {
            Swal.fire({
                title: 'Password and Repeat Password MUST BE THE SAME!',
                icon: 'warning',
            });
        }
    } else if (user && email && (!pass || !repass)) {
        Swal.fire({
            title: 'Password and Repeat Password must be filled!',
            icon: 'warning',
        });
    } else {
        Swal.fire({
            title: 'Username, Email, Password, and Repeat Password MUST BE FILLED!',
            icon: 'warning',
        });
    }
}
